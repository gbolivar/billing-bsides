<?php 

namespace App\Services\Response;

use App\Models\AppLogger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use \MongoDB\BSON\UTCDateTime as UTCMongo;
use App\Services\Logger\LoggerEventsServices;
use App\Services\Mapping\ParserDataUtcAndLocalServices;
use App\Services\Response\ResponseCodeServices as ResponseCode;

class ReturnResponseAuditServices extends Response
{
    protected $logger;
    protected $reports;
    protected $request;

    public function __construct(LoggerEventsServices $logger)
    {
        $this->logger = $logger;
        $this->request = [];
    } 

    /**
     * Load request in Singleton in val static 
     * @param Illuminate\Http\Request $request
     * @return $this
     */
    public function load(Request $request)
    {
         $this->request = $request;
         return $this;
    }

    public function main(Array $content, Int $code)
    {
        try {
            // Logger local Response
            ($this->logger)('info', __METHOD__, ['Response' => $content, 'code'=> $code]);

            // Prepare colection for SQS  
            $tmp = $content;
            $valueNeeds = [];
            $valueNeeds['tdx'] = $this->request->headers->get("TDX")??\Cache::get('TDX');
            $valueNeeds['type'] = 'Response';
            $valueNeeds['typeDescription'] = $code;
            $data = ParserDataUtcAndLocalServices::getInstance()->getDateUTC(); 
            $valueNeeds['date'] = new UTCMongo(strtotime($data) * 1000);
            // Add path in colection for SQS
            $tmp['PATH'] = $this->request->path();
            // get items Array only index 0
            $tmp['items'] = $tmp['items'][0]??[];
            $tmp['request'] = $this->request->all();
            unset($tmp['request']['password']);
            $valueNeeds['events'] = $tmp;

            // Notificate SQS for reports
            AppLogger::toRegister($valueNeeds);
            
            // Return Response
            return response()->json($content, $code);
        } catch (\Throwable $th) {
            \Log::error(__METHOD__ . ':Exceptions, type not found', [$th->getMessage()]);
            throw new \Exception($th->getMessage(), ResponseCode::ERROR_EXCEPTION);
        }
    }
}

        
<?php 
namespace App\Http\Domains;

use Illuminate\Http\Request;
use App\Models\AppLoggerIntercep;
use \MongoDB\BSON\UTCDateTime as UTCMongo;

class EventIntercepEventsDomains
{


    /**
     * Domain for register events
     * @param Illuminate\Http\Request $request
     * @param String $type
     * @param Array $catchMsg
     * @param String $method
     */
    public function __invoke(Request $request, String $type, Array $catchMsg, String $method, String $msg = null)
    {
        $pthRequest = ['PATH' => $request->path()];
        $valueNeeds = [];
        $valueNeeds = $request->all();
        $valueNeeds['tdx'] = $request->headers->get("TDX")??\Cache::get('TDX');
        $valueNeeds['validate'] = array_merge($catchMsg, $pthRequest);
        $valueNeeds['type'] = "{$type}";
        $msgLocal = $msg ?? 'Exceptions, type not found';
        $valueNeeds['typeDescription'] = $msgLocal;
        $date = new \DateTime('now');
        $valueNeeds['date'] = new UTCMongo(strtotime($date->format('Y-m-d H:i:s')) * 1000);
        // Add date in coleccion monfo
        AppLoggerIntercep::toRegister($valueNeeds);
        \Log::error($method . ':'. $msgLocal, [$catchMsg]);          
    }
}

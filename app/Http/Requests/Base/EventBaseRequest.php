<?php

namespace App\Http\Requests\Base;

use Illuminate\Http\Request;
use App\Http\Domains\EventIntercepEventsDomains as EventDealLetterDomains;
use App\Http\Requests\Validate\LoginUserRequest;
use \Illuminate\Http\Exceptions\HttpResponseException;
use App\Services\Validator\FilterFieldsRequestServices;
use App\Services\Response\ResponseCodeServices as ResponseCode;
use App\Services\Response\ReturnResponseAuditServices as ReturnResponse;


/**
 * Abstract class in charge of carrying out the principle of responsibility to delegate 
 * to an action in charge of making the validations of the request independently and 
 * I registered the log
 */
abstract class EventBaseRequest 
{
    protected $response;
    protected $request;
    protected $dealLetter;

    /**
     * App\Services\Response\ReturnResponseAuditServices $reports
     * Illuminate\Http\Request $request
     */
    public function __construct(ReturnResponse $response, EventDealLetterDomains $dealLetter, Request $request){
        $this->request = $request;
        $this->response = $response;
        $this->dealLetter = $dealLetter;
        $this->__invoke();
    }

	public function __invoke()
	{
        ($this->response)->load($this->request);
        $valueNeeds = [];
        $valueNeeds = $this->request->all();
        $valueNeeds['x-transaction-id'] = $this->request->headers->get("x-transaction-id");
        try {
            FilterFieldsRequestServices::main($this->request->all(), $this->rules($this->request));
        } catch (\Throwable $th) {
            // Setter events Deal Letter
            $msg = 'ERROR VALIDATE FIELD';
            ($this->dealLetter)($this->request, $this->getType(), (array)json_decode($th->getMessage()), __METHOD__,  $msg);
            throw new HttpResponseException(
                 ($this->response)->main((array) json_decode($th->getMessage()), ResponseCode::PRECONDITION_FAILED)
            );
        }
        return $this;
    }

    /** 
     * Response request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /** 
     * Response PreRequest
     */
    public function getPreResponse()
    {
        return $this->response;
    }
    
    /**
     * Method abstract
     */
    abstract public function rules($request);
}
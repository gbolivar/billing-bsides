<?php

namespace App\Http\Requests\Validate;

use App\Http\Requests\Base\EventBaseRequest;

class OkUserRequest extends EventBaseRequest
{
    /**
     * Get data 
     * @return String 
     */
    public function getType()
    {
        return 'OkJWT';
    }
    /**
     * Validate request 
     * @param Array @request 
     * @return Array $data
     */
	public function rules($request)
	{
        return [
           
        ];
	}
}
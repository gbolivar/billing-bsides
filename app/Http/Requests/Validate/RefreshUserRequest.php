<?php

namespace App\Http\Requests\Validate;

use App\Http\Requests\Base\EventBaseRequest;

class RefreshUserRequest extends EventBaseRequest
{
    /**
     * Get data 
     * @return String 
     */
    public function getType()
    {
        return 'refreshJWT';
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
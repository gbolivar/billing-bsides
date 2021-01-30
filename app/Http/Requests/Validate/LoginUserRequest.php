<?php

namespace App\Http\Requests\Validate;

use App\Http\Requests\Base\EventBaseRequest;

class LoginUserRequest extends EventBaseRequest
{
    /**
     * Get data 
     * @return String 
     */
    public function getType()
    {
        return 'loginUser';
    }
    /**
     * Validate request 
     * @param Array @request 
     * @return Array $data
     */
	public function rules($request)
	{
        $regexPassword = config('apps.regex.password');
        return [
            'login' => 'required|alpha|min:8|max:20',
            'password' => ['required', 'min:10','max:50', 'regex:/'.$regexPassword. '/'],
        ];
	}
}
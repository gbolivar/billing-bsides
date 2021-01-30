<?php

namespace App\Http\Requests;

use App\Http\Requests\Base\EventBaseRequest;

class EventBillingOKRequest extends EventBaseRequest
{
    public function getType()
    {
        return 'billingOk';
    }

	public function rules($request)
	{
        $codeUserRegex = $request->input('dataExtends')['extendsCredential']['country_code_phone'];
        return [
            'userId' => ['required','regex:/'.$codeUserRegex. '/'],
            'subscriptionId' => 'required|max:255',
            'paymentId' => 'required|alpha_dash|max:255',
            'serviceOfferKey' => 'required|max:255',
            'lastBillingSuccessDate' => 'required|date',
            'nextRenewalDate' => 'required|date',
            'price' => 'required',
            'typeDescription' => 'required|string',
            'currency'=> 'required|max:3',
            'serviceAllowedAccessUntilDate' => 'required|date',
            'serviceId' => 'required|alpha_dash|max:255',
            'isTest' => 'boolean'
        ];
	}
}
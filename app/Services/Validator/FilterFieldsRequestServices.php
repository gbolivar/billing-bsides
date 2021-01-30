<?php

namespace App\Services\Validator;

/**
 * Filter values return data
 */
class FilterFieldsRequestServices
{
    public static function main($request, $options = [])
    {
        $validator = \Validator::make($request, $options);
        if ($validator->fails()) {
            $msj = FilterFieldsRequestServices::createFormatMessage($validator->messages()->messages());
            (new \App\Services\Logger\LoggerEventsServices)('alert', __METHOD__, ['Validator' => $msj]);
            throw new \Exception(json_encode($msj), 1);
        }
    }

    private static function createFormatMessage($responseValidate)
    {
        $msj = [];
        foreach ($responseValidate as $key => $value) {
            $msj[$key] = \end($value);
        }
        return $msj;
    }
    
}

<?php

namespace App\Services\Response;

class ResponseCodeServices
{
    // Code Error Http
    const CREATED = 201;
    const OK = 200;
    const EXIST = 210;
    const NO_CONTENT = 204;
    const ALREADY = 209;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUNT = 404;
    const METHOD_NOT_ALLOWED = 405;
    const PRECONDITION_FAILED = 412;
    const UNPROCESSABLE_ENTITY = 422;
    const LOCKED = 423;
    const ERROR_EXCEPTION = 409;

    // Message Response http
    const CREATED_MESSAGE = 'The item was created successfully';
    const CREATED_UPDATE_MESSAGE = 'The item was updated successfully';
    const OK_MESSAGE = 'success';
    const ALREADY_MESSAGE = 'Already Reported, there are more records ';
    const OK_EXIST_MESSAGE = 'success, Registration already exists';
    const NO_CONTENT_MESSAGE = 'The server did not find the registry';
    const UNAUTHORIZED_MESSAGE = 'Provided token is expired.';
    const NOT_FOUNT_MESSAGE = 'Sorry request not found.';
    const PRECONDITION_FAILED_MESSAGE = 'Sorry request not found.';
    const LOCKED_MESSAGE = 'Sorry request locked.';
    const METHOD_NOT_ALLOWED_MESSAGE = 'Method not allowed.';
    const ERROR_EXCEPTION_MESSAGE = 'Validation errors in your request';
}

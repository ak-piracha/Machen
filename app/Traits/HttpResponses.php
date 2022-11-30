<?php

namespace App\Traits;

trait HttpResponses
{

    //Success Response
    protected function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'status'    => 'Request was succesful...',
            'message'   => $message,
            'data'      => $data,
        ], $code);
    }

    //Error Response
    protected function error($data, $message = null, $code)
    {
        return response()->json([
            'status'    => 'Error has occurred...',
            'message'   => $message,
            'data'      => $data,
        ], $code);
    }
}

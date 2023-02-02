<?php

namespace App\Exceptions;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class JsonExceptionResponse
{

    public static function error(string $message = '',int $httpCode = Response::HTTP_BAD_REQUEST, ?int $customCode = null, ?\Throwable $e = null){

        $data = [
            'error'=>[
                'message' => $message,
                'code' => $httpCode,
            ]
        ];
        if($e !== null && config('app.debug')){
            $data['debug'] =[
                'exceptionClass' => get_class($e),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ];
        };
        return new JsonResponse($data, $httpCode);


    }

}

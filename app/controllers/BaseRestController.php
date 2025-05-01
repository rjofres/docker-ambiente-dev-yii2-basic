<?php

namespace app\controllers;

class BaseRestController extends \yii\rest\ActiveController
{
    // 
    protected function returnResponse($code, $message, $data = [])
    {
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
    }
}

<?php

namespace app\controllers\api\v1;

use app\controllers\BaseRestController;
use yii\filters\auth\HttpBearerAuth;

class TestController extends BaseRestController
{

    public $modelClass = 'app\models\User';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items'
    ];

    public function init()
    {
        parent::init();
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class
        ];

        $behaviors['authenticator'] = $auth;
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => [
                'test'
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionTest()
    {
        $data = [
            'id' => 1,
            'name' => 'Camino del Dev'
        ];
        return self::returnResponse(200, 'Servicio ejecutado correctamente', $data);
    }
}

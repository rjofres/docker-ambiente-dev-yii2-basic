<?php

namespace app\controllers\api\v1;

use app\controllers\BaseRestController;
use yii\filters\auth\HttpBearerAuth;

class TestController extends BaseRestController
{
    /**
     * @var string El nombre de la clase del modelo que se utilizará en el controlador.
     */
    public $modelClass = 'app\models\User';

    /**
     * @var array Configuración del serializador para las respuestas de la API.
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items'
    ];

    /**
     * Inicializa el controlador, habilitando la sesión de usuario.
     */
    public function init()
    {
        // Llama al método `init()` del controlador base para asegurar la inicialización correcta
        parent::init();
        // Habilita la gestión de sesiones para el usuario en la aplicación
        \Yii::$app->user->enableSession = true;
    }

    /**
     * Configura los comportamientos del controlador, incluyendo CORS y autenticación.
     *
     * @return array Comportamientos configurados para el controlador, incluyendo CORS y autenticación.
     */
    public function behaviors()
    {
        // Obtiene los comportamientos predeterminados del controlador base
        $behaviors = parent::behaviors();
        // Elimina el filtro de autenticación para permitir solicitudes CORS
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        // Agrega el filtro CORS para permitir solicitudes de diferentes dominios
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];
        // Reagrega el filtro de autenticación
        $behaviors['authenticator'] = $auth;
        // Configura el filtro de autenticación para solicitudes preflight CORS (método HTTP OPTIONS)
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => [
                'test'
            ],
        ];
        // Devuelve el array de comportamientos actualizados
        return $behaviors;
    }

    /**
     * Configura las acciones disponibles para el controlador, excluyendo las acciones predeterminadas.
     *
     * @return array El array de acciones disponibles para el controlador, excluyendo las acciones deshabilitadas.
     */
    public function actions()
    {
        // Llama al método `actions()` del controlador padre para obtener las acciones predeterminadas
        $actions = parent::actions();
        // Elimina las acciones 'index', 'view', 'create', 'update' y 'delete' del array de acciones
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        // Devuelve el array de acciones actualizadas, sin las acciones deshabilitadas
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

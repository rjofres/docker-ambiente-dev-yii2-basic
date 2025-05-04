<?php

namespace app\controllers;

/**
 * Clase BaseRestController
 *
 * Controlador base para todos los controladores REST del sistema.
 */
class BaseRestController extends \yii\rest\ActiveController
{
    /**
     * Función returnResponse
     *
     * Genera una estructura de respuesta estandarizada para las respuestas de la API.
     *
     * @param string|int $code Código de estado de la respuesta (por ejemplo, 'ok', 'nok' o códigos numéricos).
     * @param string $message Mensaje descriptivo del resultado de la operación.
     * @param array $data (opcional) Datos adicionales que se incluirán en la respuesta.
     * @return array Arreglo con la estructura ['code', 'message', 'data'].
     */
    protected function returnResponse($code, $message, $data = [])
    {
        // Retorna la respuesta estructurada para la API
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
    }
}

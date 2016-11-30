<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/24/2016
 * Time: 12:14 AM
 */
namespace app\components;
use Yii;

class Helper
{
    public static function getBearer()
    {
        $authHeader = Yii::$app->request->getHeaders()->get('Authorization');
        if (!($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)))
        {
            return null;
        }
        return $matches[1];
    }
}
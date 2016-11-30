<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/21/2016
 * Time: 11:56 AM
 */

namespace app\api\modules\v1;

use \yii\base\Module;

class Api extends Module
{
    public $controllerNamespace = 'app\api\modules\v1\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
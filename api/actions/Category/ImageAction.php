<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\api\actions\Category;

use Yii;
use yii\rest\Action;
use yii\base\Model;
use yii\helpers\Url;
use \yiidreamteam\upload\ImageUploadBehavior;
use yii\web\ServerErrorHttpException;


class ImageAction extends Action
{
    public $scenario = Model::SCENARIO_DEFAULT;
    public $viewAction = 'view';

    public function run($id)
    {
        /* @var $model ActiveRecord */
        $model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if (empty($model))
        {
            throw new \yii\web\NotFoundHttpException('Board not found');
        }

        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->getRequest()->getBodyParams(), '');
            if ($model->save() === false && !$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
        }
        else
        {
            $imageBehav = ImageUploadBehavior::getInstance($model, 'image');
            $imageBehav->cleanFiles();
            $model->image = "";
            if ($model->save() === false) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
        }
        return $model;
    }
}

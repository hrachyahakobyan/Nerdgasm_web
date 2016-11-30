<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\api\actions\Comments;

use Yii;
use yii\rest\Action;
use yii\base\Model;
use app\models\Comment;

class ViewAction extends Action
{
    /**
     * Displays a model.
     * @param string $id the primary key of the model.
     * @return \yii\db\ActiveRecordInterface the model being displayed
     */
    public function run($id)
    {
        $model = $this->findModel($id);
        if ($this->checkAccess)
        {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        $content = Comment::findOne($model->id);
        if(!$content)
        {
            throw new \yii\web\NotFoundHttpException();
        }
        return $content;
    }
}

<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\api\actions\Board;

use Yii;
use yii\rest\Action;
use yii\web\ServerErrorHttpException;
use app\models\BoardContent;
use yii\helpers\Url;


/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DeleteContentAction extends Action
{
    public $viewAction = 'view';

    public function run($id)
    {
        $model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $get = Yii::$app->request->get();
        if (!isset($get['content_id']))
        {
            throw new \yii\web\UnprocessableEntityHttpException();
            return;
        }

        $content = BoardContent::findOne(['board_id' => $model->id,
                                            'content_id' => $get['content_id']]);
        if (empty($content))
        {
            throw new \yii\web\NotFoundHttpException('Content not found');
        }

        if ($content->delete() === false)
        {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
        $response = Yii::$app->getResponse();
        $response->setStatusCode(204);
    }
}

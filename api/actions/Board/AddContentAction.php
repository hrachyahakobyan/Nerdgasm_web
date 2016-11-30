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
class AddContentAction extends Action
{
    public $viewAction = 'view';

    public function run($id)
    {
        $model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $content = new BoardContent();
        $content->load(Yii::$app->getRequest()->getBodyParams(), '');
        $content->board_id = $model->id;

        if ($content->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($content->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$content->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $content;
    }
}

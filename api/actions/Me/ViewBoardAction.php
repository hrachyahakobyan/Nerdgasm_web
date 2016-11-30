<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\api\actions\Me;

use Yii;
use yii\rest\Action;
use yii\base\Model;
use app\models\Board;
use yii\web\MethodNotAllowedHttpException;

class ViewBoardAction extends Action
{
    public function run($id)
    {
        if ($this->checkAccess)
        {
            call_user_func($this->checkAccess, $this->id);
        }
        $user = Yii::$app->user->identity;
        $board = Board::findOne($id);
        if (empty($board))
        {
            throw new \yii\web\NotFoundHttpException('Board not found');
        }
        if($board->user_id !== $user->id)
        {
            throw new MethodNotAllowedHttpException();
        }

        return $board;
    }
}

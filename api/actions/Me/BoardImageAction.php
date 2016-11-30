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
use yii\helpers\Url;
use \yiidreamteam\upload\ImageUploadBehavior;
use app\models\Board;
use yii\web\MethodNotAllowedHttpException;


/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BoardImageAction extends Action
{
    public $scenario = Model::SCENARIO_DEFAULT;
    public $viewAction = 'view';

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
        if(Yii::$app->request->isPost)
        {
            $board->load(Yii::$app->getRequest()->getBodyParams(), '');
            if ($board->save() === false && !$board->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
        }
        else
        {
            $imageBehav = ImageUploadBehavior::getInstance($board, 'image');
            $imageBehav->cleanFiles();
            $board->image = "";
            if ($board->save() === false) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
        }
        return $board;
    }
}

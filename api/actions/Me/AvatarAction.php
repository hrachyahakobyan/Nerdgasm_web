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


/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AvatarAction extends Action
{
    public $scenario = Model::SCENARIO_DEFAULT;
    public $viewAction = 'view';

    public function run()
    {
        if ($this->checkAccess)
        {
            call_user_func($this->checkAccess, $this->id);
        }
        $user = Yii::$app->user->identity;
        if(Yii::$app->request->isPost)
        {
            $user->load(Yii::$app->getRequest()->getBodyParams(), '');
            if ($user->save() === false && !$user->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
        }
        else
        {
            $imageBehav = ImageUploadBehavior::getInstance($user, 'image');
            $imageBehav->cleanFiles();
            $user->image = "";
            if ($user->save() === false) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
        }
        return $user;
    }
}

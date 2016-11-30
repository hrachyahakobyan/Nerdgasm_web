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
use yii\data\ActiveDataProvider;
use yii\web\ServerErrorHttpException;
use app\models\Post;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */

/**
 * Class CreateThreadAction
 * @package app\api\actions\Me
 *
 *  Creates a thread and an associated, optional post
 *  Fails only if the creation of the thread fails
 */
class CreateThreadAction extends Action
{
    public $scenario = Model::SCENARIO_DEFAULT;
    public $viewAction = 'view';

    public function run()
    {
        if ($this->checkAccess)
        {
            call_user_func($this->checkAccess, $this->id);
        }
        $thread = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        $thread->load(Yii::$app->getRequest()->getBodyParams(), '');
        $thread->user_id = Yii::$app->user->identity->id;

        if ($thread->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($thread->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        }
        elseif($thread->hasErrors()){
            return $thread;
        }
        elseif (!$thread->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        $post = new Post([
            'scenario' => $this->scenario,
        ]);

        $post->user_id = Yii::$app->user->identity->id;
        $post->load(Yii::$app->getRequest()->getBodyParams(), '');
        $post->thread_id = $thread->id;
        $result = array();
        $result['thread'] = $thread;
        if ($post->save())
        {
            $result['post'] = $post;
        }
        return $result;
    }
}

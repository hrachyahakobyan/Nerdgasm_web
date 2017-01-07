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
use app\models\BoardContent;
use app\models\Board;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BoardContentAction extends Action
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

        // Create new content
        if(Yii::$app->request->isPost)
        {
            $content = new BoardContent();
            $content->load(Yii::$app->getRequest()->getBodyParams(), '');
            $content->board_id = $id;
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
        else if(Yii::$app->request->isGet)
        {
            $articles =  $board->getArticles()->all();
            return ['board' => $board,
                'articles' => $articles,];
        }
        // Delete content
        else
        {
            $post = Yii::$app->request->post();
            if (!isset($post['content_id']))
            {
                throw new \yii\web\UnprocessableEntityHttpException();
                return;
            }

            $content = BoardContent::findOne(['board_id' => $board->id,
                'content_id' => $post['content_id']]);
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
}

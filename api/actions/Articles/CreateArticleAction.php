<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\api\actions\Articles;

use Yii;
use yii\rest\Action;
use yii\base\Model;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\web\ServerErrorHttpException;
use yii\web\HttpException;
use app\models\Content;
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
class CreateArticleAction extends Action
{
    public $scenario = Model::SCENARIO_DEFAULT;
    public $viewAction = 'view';

    public function run()
    {
        if ($this->checkAccess)
        {
            call_user_func($this->checkAccess, $this->id);
        }

        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $content = new Content([
                'scenario' => $this->scenario,
            ]);
            $content->load(Yii::$app->getRequest()->getBodyParams(), '');
            if (!$content->save()){
                if ($content->hasErrors())
                {
                    $transaction->rollBack();
                    return $content;
                }
                else
                {
                    throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
                }
            }

            $article = new $this->modelClass([
                'scenario' => $this->scenario,
            ]);
            $article->id = $content->id;
            $article->load(Yii::$app->getRequest()->getBodyParams(), '');
            if (!$article->save()){
                if ($article->hasErrors())
                {
                    $transaction->rollBack();
                    return $article;
                }
                else
                {
                    throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
                }
            }
            $transaction->commit();
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($article->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
            return $content;

        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}

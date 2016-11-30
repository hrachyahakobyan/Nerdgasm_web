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
use app\models\Content;
use yii\data\ActiveDataProvider;

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
        $content = Content::findOne($model->id);
        if(!$content)
        {
            throw new \yii\web\NotFoundHttpException();
        }
        // Get the author
        $user = $content->getUser()->one();
        // Get the upvotes
        $upvotesProvider =  new ActiveDataProvider([
             'query' =>  $content->getContentUpvotes(),
         ]);
        $content = $content->attributes;
        $content['upvotes'] = $upvotesProvider->getTotalCount();
        $model = $model->merge($content);
        return [ 'article' => $model,
                'user' => $user,
        ];
    }
}

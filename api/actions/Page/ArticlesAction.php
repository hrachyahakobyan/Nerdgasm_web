<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\api\actions\Page;

use Yii;
use yii\rest\Action;
use yii\data\ActiveDataProvider;
use yii\db\Query;


class ArticlesAction extends Action
{
    /**
     * @return ActiveDataProvider
     */
    public function run($id)
    {
        $model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        $query = $model->getContents()->with('article');
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 1/7/2017
 * Time: 4:52 PM
 */

namespace app\api\actions\Page;

use Yii;
use yii\rest\Action;
use yii\db\Query;
use app\models\PageCategory;
use app\models\Page;

/**
 * Class AddCategoryAction
 * @package app\api\actions\Page
 * Action to remove page from category
 */


class DeleteCategoryAction extends Action
{
    public function run($id)
    {
        if ($this->checkAccess)
        {
            call_user_func($this->checkAccess, $this->id);
        }
        $page = Page::findOne($id);
        if (empty($page))
        {
            throw new \yii\web\NotFoundHttpException('Page not found');
        }

        $post = Yii::$app->request->post();
        if (!isset($post['category_id']))
        {
            throw new \yii\web\UnprocessableEntityHttpException();
            return;
        }

        $pageCategory = PageCategory::findOne(['page_id' => $page->id,
            'category_id' => $post['category_id']]);
        if (empty($content))
        {
            throw new \yii\web\NotFoundHttpException('Page Category not found');
        }

        if ($pageCategory->delete() === false)
        {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
        $response = Yii::$app->getResponse();
        $response->setStatusCode(204);

    }
}
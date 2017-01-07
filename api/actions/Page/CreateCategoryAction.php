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
 * Action to add the page to a category
 */


class CreateCategoryAction extends Action
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
        $pageCategory = new PageCategory();
        $pageCategory->page_id = $page->id;
        $pageCategory->category_id = $post['category_id'];

        if ($pageCategory->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($pageCategory->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$pageCategory->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $pageCategory;
    }
}
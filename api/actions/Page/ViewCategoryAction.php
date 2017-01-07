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
 * Action to view page's categories
 */


class ViewCategoryAction extends Action
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
        return $page->getCategories();
    }
}
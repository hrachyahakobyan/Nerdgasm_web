<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\api\actions\Threads;

use Yii;
use yii\rest\Action;
use yii\data\ActiveDataProvider;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class IndexAction extends Action
{
    public $prepareDataProvider;
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        return $this->prepareDataProvider();
    }

    /**
     * Prepares the data provider that should return the requested collection of the models.
     * @return ActiveDataProvider
     */
    protected function prepareDataProvider()
    {
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }

        $connection = Yii::$app->getDb();
        $result = $connection->createCommand('
        SELECT thread.id as thread_id, thread.title, thread.created_at, thread.views, thread.page_id, COUNT(post.id) as post_count,
               user.id as user_id, user.firstname, user.lastname, user.username, user.image
        FROM thread
        LEFT JOIN post ON thread.id=post.thread_id
        JOIN user ON thread.user_id=user.id
        GROUP BY thread.id
         ')->queryAll();

        foreach ($result as &$row) {
            $row['id'] = $row['thread_id'];
            $row['user'] = array();
            $row['user']['id'] = $row['user_id'];
            $row['user']['firstname'] = $row['firstname'];
            $row['user']['lastname'] = $row['lastname'];
            $row['user']['username'] = $row['username'];
            $row['user']['image'] = $row['image'];
            unset($row['user_id'], $row['firstname'], $row['lastname'], $row['username'], $row['thread_id'], $row['image']);
        }

        return $result;
    }
}

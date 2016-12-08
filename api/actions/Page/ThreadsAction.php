<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/8/2016
 * Time: 12:56 PM
 */

namespace app\api\actions\Page;

use Yii;
use yii\rest\Action;
use yii\data\ActiveDataProvider;
use yii\db\Query;


class ThreadsAction extends Action
{
    public function run($id)
    {
        $model = $this->findModel($id);
        if ($this->checkAccess)
        {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand('
        SELECT thread.id as thread_id, thread.title, thread.created_at,
        thread.views, thread.page_id, COUNT(post.id) as post_count,
        user.id as user_id, user.firstname, user.lastname, user.username, user.image
        FROM thread
        LEFT JOIN post ON thread.id=post.thread_id
        JOIN user ON thread.user_id=user.id
        WHERE thread.page_id = :page_id
        GROUP BY thread.id
         ');

        $command->bindValue(':page_id', $id);
        $result = $command->queryAll();

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
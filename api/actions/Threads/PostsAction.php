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
use yii\db\Query;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PostsAction extends Action
{
    /**
     * @var callable a PHP callable that will be called to prepare a data provider that
     * should return a collection of the models. If not set, [[prepareDataProvider()]] will be used instead.
     * The signature of the callable should be:
     *
     * ```php
     * function ($action) {
     *     // $action is the action object currently running
     * }
     * ```
     *
     * The callable should return an instance of [[ActiveDataProvider]].
     */

    /**
     * @return ActiveDataProvider
     */
    public function run($id)
    {
        $model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand('
            SELECT P.id, P.content, P.thread_id, P.created_at,
            P.parent_id, user.id AS user_id, user.username, user.firstname, user.lastname, user.image
            FROM (SELECT * FROM post WHERE post.thread_id = :id) AS P
            JOIN user ON P.user_id=user.id
         ');
        $command->bindValue(':id', $id);
        $result = $command->queryAll();

        foreach ($result as &$row) {
            $row['user'] = array();
            $row['user']['id'] = $row['user_id'];
            $row['user']['firstname'] = $row['firstname'];
            $row['user']['lastname'] = $row['lastname'];
            $row['user']['username'] = $row['username'];
            $row['user']['image'] = $row['image'];
            unset($row['user_id'], $row['firstname'], $row['lastname'], $row['username'], $row['image']);
        }
        return $result;
    }
}

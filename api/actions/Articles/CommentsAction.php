<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\api\actions\Articles;

use Yii;
use yii\rest\Action;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CommentsAction extends Action
{
    public function run($id)
    {
        $model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand('
           SELECT C.id, C.text, C.content_id, C.created_at, C.updated_at,
           C.parent_id, user.id as user_id, user.username, user.firstname, user.lastname, user.image,
           COUNT(comment_upvote.comment_id) as upvotes FROM
            (SELECT * FROM comment WHERE comment.content_id = :id) as C
            JOIN user ON C.user_id = user.id
            LEFT JOIN comment_upvote ON C.id = comment_upvote.comment_id
            GROUP BY C.id
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

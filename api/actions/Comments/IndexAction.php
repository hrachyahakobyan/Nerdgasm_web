<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\api\actions\Comments;

use Yii;
use yii\rest\Action;
use yii\data\ActiveDataProvider;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class IndexAction extends Action
{
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $connection = Yii::$app->getDb();
        $result = $connection->createCommand('
            SELECT comment.id, comment.text, comment.created_at, comment.content_id,
            comment.parent_id, user.id AS user_id, user.username, user.firstname, user.lastname, user.image,
            COUNT(comment_upvote.comment_id) AS upvotes
            FROM comment
            JOIN user ON comment.user_id=user.id
            LEFT JOIN comment_upvote ON comment_upvote.comment_id = comment.id
            GROUP BY comment.id
         ')->queryAll();


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

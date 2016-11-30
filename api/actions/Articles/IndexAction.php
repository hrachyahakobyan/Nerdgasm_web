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
            SELECT content.id, content.title, content.image, content.content, content.image,
            content.created_at, content.updated_at, content.page_id, user.id as user_id,
            user.username, user.firstname, user.lastname, user.image as user_image,
            COUNT(content_upvote.content_id) AS upvotes,
            COUNT(comment.id) AS comments
            FROM article
            JOIN content ON article.id=content.id
            JOIN user ON user.id=content.user_id
            LEFT JOIN content_upvote ON content_upvote.content_id = content.id
            LEFT JOIN comment ON comment.content_id = content.id
            GROUP BY content.id
         ')->queryAll();

        foreach ($result as &$row) {
            $row['user'] = array();
            $row['user']['id'] = $row['user_id'];
            $row['user']['firstname'] = $row['firstname'];
            $row['user']['lastname'] = $row['lastname'];
            $row['user']['username'] = $row['username'];
            $row['user']['image'] = $row['user_image'];
            unset($row['user_id'], $row['firstname'], $row['lastname'], $row['username'], $row['user_image']);
        }

        return $result;
    }
}

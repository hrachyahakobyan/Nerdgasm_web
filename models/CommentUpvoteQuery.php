<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CommentUpvote]].
 *
 * @see CommentUpvote
 */
class CommentUpvoteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CommentUpvote[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CommentUpvote|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

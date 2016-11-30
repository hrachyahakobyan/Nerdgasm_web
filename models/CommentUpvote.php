<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment_upvote".
 *
 * @property integer $comment_id
 * @property integer $user_id
 *
 * @property User $user
 * @property Comment $comment
 */
class CommentUpvote extends \app\models\Content
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment_upvote';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_id', 'user_id'], 'required'],
            [['comment_id', 'user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::className(), 'targetAttribute' => ['comment_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => 'Comment ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comment::className(), ['id' => 'comment_id']);
    }

    /**
     * @inheritdoc
     * @return CommentUpvoteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommentUpvoteQuery(get_called_class());
    }
}

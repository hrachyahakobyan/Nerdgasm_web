<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "board_content".
 *
 * @property integer $board_id
 * @property integer $content_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Board $board
 * @property Content $content
 */
class BoardContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'board_content';
    }

    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    public static function primaryKey()
    {
        return ['board_id', 'content_id'];
    }

    public function rules()
    {
        return [
            [['board_id', 'content_id'], 'required'],
            [['board_id', 'content_id', 'created_at', 'updated_at'], 'integer'],
            [['board_id', 'content_id'], 'unique', 'targetAttribute' => ['board_id', 'content_id'], 'message' => 'The combination of Board ID and Content ID has already been taken.'],
            [['board_id'], 'exist', 'skipOnError' => true, 'targetClass' => Board::className(), 'targetAttribute' => ['board_id' => 'id']],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'board_id' => 'Board ID',
            'content_id' => 'Content ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoard()
    {
        return $this->hasOne(Board::className(), ['id' => 'board_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    /**
     * @inheritdoc
     * @return BoardContentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BoardContentQuery(get_called_class());
    }
}

<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[BoardContent]].
 *
 * @see BoardContent
 */
class BoardContentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BoardContent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BoardContent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

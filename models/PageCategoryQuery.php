<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PageCategory]].
 *
 * @see PageCategory
 */
class PageCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PageCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PageCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

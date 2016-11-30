<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/21/2016
 * Time: 10:41 PM
 */

namespace app\models;
use Yii;
use yii\db\ActiveQuery;


class UserQuery extends  ActiveQuery
{
        public function matchFullname($query)
        {
            return $this->orWhere([
                'like', 'LOWER(CONCAT(firstname, \' \', lastname))', $query
            ]);
        }

        public function matchUsername($query)
        {
            return $this->orWhere([
                'like', 'LOWER(username)', $query
            ]);
        }

        public function matchFullnameOrUsername($query)
        {
            return $this->matchFullname($query)->matchUsername($query);
        }
}
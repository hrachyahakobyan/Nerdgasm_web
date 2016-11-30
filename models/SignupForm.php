<?php
namespace app\models;

use Yii;
use yii\base\Model;
use Yii\log\Logger;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;
    public $secret_key;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'app\models\Admin', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],
            ['secret_key', 'trim'],
            ['secret_key', 'required'],
            ['secret_key', 'string', 'min' => 2],
            ['secret_key', 'compare', 'compareValue' => 'secret', 'message' => 'Incorrect secret key']
        ];
    }
    /**
     * Signs user up.
     *
     * @return Admin|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new Admin();
        $user->username = $this->username;
        $user->setPassword($this->password);;
        return $user->save() ? $user : null;
    }
}
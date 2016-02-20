<?php
namespace backend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * RegisterForm form
 */
class RegisterForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $retypePassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('acp', 'This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['retypePassword', 'required'],
            ['retypePassword', 'string', 'min' => 6],
            ['retypePassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('acp', 'Passwords don\'t match')],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {

                return $user;
            }
        }

        return null;
    }
}

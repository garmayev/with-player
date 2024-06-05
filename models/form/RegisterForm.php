<?php

namespace app\models\form;

use app\models\User;

class RegisterForm extends \yii\base\Model
{
    public $username;
    public $email;
    public $password;
    public $confirm;

    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['username', 'email', 'password', 'confirm'], 'string'],
            ['email', 'email'],
            ['confirm', 'confirmationPassword'],
        ];
    }

    public function confirmationPassword($attribute) {
        if (!$this->hasErrors()) {
            if ( $this->password !== $this->confirm ) {
                $this->addError($attribute, 'Incorrect confirmation field');
            }
        }
    }

    public function register() {
        if ($this->validate()) {
            $user = new User([
                'username' => $this->username,
                'password_hash' => \Yii::$app->security->generatePasswordHash($this->password),
                'password_reset_token' => \Yii::$app->security->generateRandomString(32),
                'auth_key' => \Yii::$app->security->generateRandomString(16),
                'email' => $this->email,
                'status' => User::STATUS_ACTIVE,
                'last_login_at' => time(),
            ]);
            if ($user->validate() && $user->save()) {
                return true;
            }
        }
        return false;
    }
}

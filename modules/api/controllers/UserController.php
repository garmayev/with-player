<?php

namespace app\modules\api\controllers;

use app\models\User;
use yii\web\Response;

class UserController extends \yii\rest\Controller
{
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    public function actionLogin() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $data = json_decode(file_get_contents("php://input"), true);
        $user = User::findOne($data['username']);
        if ( $user ) {
            if ($user->validatePassword($data['password']) && $user->status === User::STATUS_ACTIVE) {
                return ["status" => true, "data" => $user];
            }
            return ["status" => false, "message" => "Wrong password"];
        }
        return ["status" => false, "message" => "Unknown username"];
    }

    public function actionIndex() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return User::find()->all();
    }
}

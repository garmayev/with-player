<?php

namespace app\modules\api\controllers;

use app\models\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\web\Response;

class UserController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionLogin() {
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
        return User::find()->all();
    }

    public function actionCheck() {
        echo json_encode(["status" => !\Yii::$app->user->isGuest, "data" => \Yii::$app->user->identity]);
    }
}

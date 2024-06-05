<?php

namespace app\controllers;

use app\models\form\LoginForm;
use app\models\form\RegisterForm;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class UserController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionLogin() {
        $model = new LoginForm();
        if (\Yii::$app->request->isPost) {
            if ( $model->load( \Yii::$app->request->post() ) && $model->login() ) {
                return \Yii::$app->response->redirect(['/site/index']);
            }
        }
        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionRegistration() {
        $model = new RegisterForm();
        if (\Yii::$app->request->isPost) {
            if ( $model->load( \Yii::$app->request->post() ) && $model->register() ) {
                return \Yii::$app->response->redirect(['/user/login']);
            }
        }
        return $this->render('register', [
            'model' => $model
        ]);
    }
}

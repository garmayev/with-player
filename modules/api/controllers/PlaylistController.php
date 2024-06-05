<?php

namespace app\modules\api\controllers;

use app\models\Playlist;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\web\Response;

class PlaylistController extends \yii\rest\ActiveController
{
    public $modelClass = Playlist::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBasicAuth::class,
                HttpBearerAuth::class,
                QueryParamAuth::class,
            ],
        ];
        $behaviors['authenticator']['except'] = ['options'];
        return $behaviors;
    }

    public function actionIndex() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return Playlist::find()->all();
    }
}

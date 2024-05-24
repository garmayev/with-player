<?php

namespace app\modules\api\controllers;

use app\models\Playlist;
use app\models\Track;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `appmodulesApi` module
 */
class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionWelcome()
    {
        if (\Yii::$app->user->isGuest) {
            return ["ok" => false, "code" => 401, "message" => "Unauthorized User"];
        }
        $user_id = \Yii::$app->user->id;
        $tracks = Track::find()
            ->joinWith('user', "track.id = track_user.track_id and track_user.user_id = $user_id}")
            ->where(['>', 'track_user.rating', 0])
            ->all();
        return [
            "ok" => !\Yii::$app->user->isGuest,
            "data" => [
                'allTracks' => Track::find()->all(),
                'myPlaylists' => array_merge([
                    ["title" => "My Collection", "tracks" => $tracks]
                ], Playlist::find()->where(['user_id' => \Yii::$app->user->id])->all()),
            ]
        ];
    }
}

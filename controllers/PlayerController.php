<?php

namespace app\controllers;

use app\models\Playlist;
use app\models\Track;

class PlayerController extends \yii\web\Controller
{
    public function actionIndex() {
        $user_id = \Yii::$app->user->id;
        $tracks = Track::find()
            ->joinWith('user', "track.id = track_user.track_id and track_user.user_id = $user_id}")
            ->where(['>', 'track_user.rating', 0])
            ->all();
        return $this->render("index", [
            'track' => Track::find()->all(),
            'playlists' => Playlist::find()->where(['user_id' => \Yii::$app->user->id])->all(),
            'collection' => $tracks
        ]);
    }
}

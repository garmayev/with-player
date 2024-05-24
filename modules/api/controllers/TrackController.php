<?php

namespace app\modules\api\controllers;

use app\models\Playlist;
use app\models\Track;
use app\models\TrackPlaylist;
use app\models\TrackUser;

class TrackController extends \yii\rest\Controller
{
    public function actionFavorite($id) {
        $model = Track::findOne($id);
        $ratingItem = TrackUser::find()->where(['and', ['user_id' => \Yii::$app->user->id], ['track_id' => $id]])->one();
        if ($model) {
            if (is_null($ratingItem)) {
                $ratingItem = new TrackUser([
                    'user_id' => \Yii::$app->user->id,
                    'track_id' => $id,
                    'rating' => 0,
                    'favorite' => 0
                ]);
                $ratingItem->save();
            }
            if ($ratingItem->favorite === 1) {
                if ( $ratingItem ) {
                    $ratingItem->rating -= 0.5;
                    $ratingItem->favorite = 0;
                } else {
                    $ratingItem = new TrackUser([
                        'user_id' => \Yii::$app->user->id,
                        'track_id' => $id,
                        'rating' => 0,
                        'favorite' => 0
                    ]);
                }
                $ratingItem->save();
            } else {
                if ( $ratingItem ) {
                    $ratingItem->rating += 0.5;
                    $ratingItem->favorite = 1;
                } else {
                    $ratingItem = new TrackUser([
                        'user_id' => \Yii::$app->user->id,
                        'track_id' => $id,
                        'rating' => 0.5,
                        'favorite' => 1
                    ]);
                }
                $ratingItem->save();
            }
            if ($model->save()) {
                return ["ok" => true, "data" => $model];
            } else {
                return ["ok" => false, "message" => $model->getErrorSummary(true)];
            }
        }
        return ["ok" => false, "message" => "Unknown track"];
    }
    public function actionAddToPlaylist($playlist_id, $track_id) {
        $playlist = Playlist::findOne($playlist_id);
        $track = Track::findOne($track_id);
        if (is_null($playlist)) {
            return ["ok" => false, "code" => 404, "message" => "Unknown Playlist"];
        }
        if (is_null($track)) {
            return ["ok" => false, "code" => 404, "message" => "Unknown Track"];
        }
        $playlist->link('tracks', $track);
        if ($playlist->save()) {
            $trackUser = TrackUser::find()->where(['and', 'track_id' => $track_id, 'user_id' => \Yii::$app->user->id])->one();
            if (is_null($trackUser)) {
                $trackUser = new TrackUser([
                    'track_id' => $track_id,
                    'user_id' => \Yii::$app->user->id,
                    'rating' => 0.2
                ]);
            } else {
                $trackUser->rating += 0.2;
            }
            $trackUser->save();
            return ["ok" => true, "playlistId" => $playlist_id, "trackId" => $track_id];
        } else {
            return ["ok" => false, "code" => 500, "message" => $playlist->getErrorSummary(true)];
        }
    }
    public function actionRemoveFromPlaylist($playlist_id, $track_id) {
        $playlist = Playlist::findOne($playlist_id);
        $track = Track::findOne($track_id);
        if (is_null($playlist)) {
            return ["ok" => false, "code" => 404, "message" => "Unknown Playlist"];
        }
        if (is_null($track)) {
            return ["ok" => false, "code" => 404, "message" => "Unknown Track"];
        }
        $record = TrackPlaylist::find()->where(['and', 'track_id' => $track_id, 'playlist_id' => $playlist_id])->one();
        if ($record->delete()) {
            $trackUser = TrackUser::find()->where(['and', 'track_id' => $track_id, 'user_id' => \Yii::$app->user->id])->one();
            if (is_null($trackUser)) {
                $trackUser = new TrackUser([
                    'track_id' => $track_id,
                    'user_id' => \Yii::$app->user->id,
                    'rating' => 0
                ]);
            } else {
                $trackUser->rating -= 0.2;
            }
            $trackUser->save();
            return ["ok" => true, "playlistId" => $playlist_id, "trackId" => $track_id];
        } else {
            return ["ok" => false, "code" => 500, "message" => $playlist->getErrorSummary(true)];
        }
    }
}

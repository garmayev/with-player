<?php

namespace app\modules\api\controllers;

use app\models\Playlist;
use app\models\Track;
use app\models\TrackPlaylist;
use app\models\TrackUser;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\web\Response;

class TrackController extends \yii\web\Controller
{
/*    public $modelClass = Track::class;

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
    } */

    public function beforeAction($action)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return Track::find()->all();
    }
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
                $user_id = \Yii::$app->user->id;
                $tracks = Track::find()
                    ->joinWith('user', "track.id = track_user.track_id and track_user.user_id = $user_id}")
                    ->where(['>', 'track_user.rating', 0])
                    ->all();
                return ["ok" => true, "data" => $model, "playlist" => ["title" => "My Collection", "tracks" => $tracks]];
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
        if ($playlist->getTracks()->exists()) {
            return ["ok" => true, "playlistId" => $playlist_id, "trackId" => $track_id, "playlist" => $playlist];
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
            return ["ok" => true, "playlistId" => $playlist_id, "trackId" => $track_id, "playlist" => $playlist];
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
            return ["ok" => true, "playlistId" => $playlist_id, "trackId" => $track_id, "playlist" => $playlist];
        } else {
            return ["ok" => false, "code" => 500, "message" => $playlist->getErrorSummary(true)];
        }
    }
}

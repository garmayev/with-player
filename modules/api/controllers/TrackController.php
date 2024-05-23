<?php

namespace app\modules\api\controllers;

use app\models\Track;
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
}

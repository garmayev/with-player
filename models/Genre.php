<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "genre".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $history
 * @property int|null $created_at
 *
 * @property TrackGenre[] $trackGenres
 * @property Track[] $tracks
 */
class Genre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'genre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['history'], 'string'],
            [['created_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'history' => Yii::t('app', 'History'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[TrackGenres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrackGenres()
    {
        return $this->hasMany(TrackGenre::class, ['genre_id' => 'id']);
    }

    /**
     * Gets query for [[Tracks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTracks()
    {
        return $this->hasMany(Track::class, ['id' => 'track_id'])->viaTable('track_genre', ['genre_id' => 'id']);
    }
}

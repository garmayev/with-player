<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "track_artist".
 *
 * @property int $track_id
 * @property int $artist_id
 *
 * @property Artist $artist
 * @property Track $track
 */
class TrackArtist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'track_artist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['track_id', 'artist_id'], 'required'],
            [['track_id', 'artist_id'], 'integer'],
            [['track_id', 'artist_id'], 'unique', 'targetAttribute' => ['track_id', 'artist_id']],
            [['artist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artist::class, 'targetAttribute' => ['artist_id' => 'id']],
            [['track_id'], 'exist', 'skipOnError' => true, 'targetClass' => Track::class, 'targetAttribute' => ['track_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'track_id' => 'Track ID',
            'artist_id' => 'Artist ID',
        ];
    }

    /**
     * Gets query for [[Artist]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtist()
    {
        return $this->hasOne(Artist::class, ['id' => 'artist_id']);
    }

    /**
     * Gets query for [[Track]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrack()
    {
        return $this->hasOne(Track::class, ['id' => 'track_id']);
    }
}

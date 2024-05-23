<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "track_playlist".
 *
 * @property int $track_id
 * @property int $playlist_id
 *
 * @property Playlist $playlist
 * @property Track $track
 */
class TrackPlaylist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'track_playlist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['track_id', 'playlist_id'], 'required'],
            [['track_id', 'playlist_id'], 'integer'],
            [['track_id', 'playlist_id'], 'unique', 'targetAttribute' => ['track_id', 'playlist_id']],
            [['playlist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Playlist::class, 'targetAttribute' => ['playlist_id' => 'id']],
            [['track_id'], 'exist', 'skipOnError' => true, 'targetClass' => Track::class, 'targetAttribute' => ['track_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'track_id' => Yii::t('app', 'Track ID'),
            'playlist_id' => Yii::t('app', 'Playlist ID'),
        ];
    }

    /**
     * Gets query for [[Playlist]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylist()
    {
        return $this->hasOne(Playlist::class, ['id' => 'playlist_id']);
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

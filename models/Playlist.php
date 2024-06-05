<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "playlist".
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $created_at
 * @property int|null $user_id
 *
 * @property TrackPlaylist[] $trackPlaylists
 * @property Track[] $tracks
 * @property User $user
 */
class Playlist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'playlist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'created_at' => Yii::t('app', 'Created At'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'created_at',
            'tracks'
        ];
    }

    /**
     * Gets query for [[TrackPlaylists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrackPlaylists()
    {
        return $this->hasMany(TrackPlaylist::class, ['playlist_id' => 'id']);
    }

    /**
     * Gets query for [[Tracks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTracks()
    {
        return $this->hasMany(Track::class, ['id' => 'track_id'])->viaTable('track_playlist', ['playlist_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "track".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $thumb
 * @property string|null $url
 * @property int|null $length
 * @property int|null $album_id
 *
 * @property Album $album
 * @property Artist[] $artists
 * @property Genre[] $genres
 * @property Playlist[] $playlists
 * @property TrackArtist[] $trackArtists
 * @property TrackGenre[] $trackGenres
 * @property TrackPlaylist[] $trackPlaylists
 * @property TrackUser[] $trackUsers
 */
class Track extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'track';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['length', 'album_id'], 'integer'],
            [['title', 'thumb', 'url'], 'string', 'max' => 255],
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => Album::class, 'targetAttribute' => ['album_id' => 'id']],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'thumb',
            'url',
            'length',
            'artists',
            'genres',
            'album',
            'favorite' => function (Track $model) {
                return $model->getFavorite();
            },
            'rating' => function (Track $model) {
                return $model->getRating();
            }
        ];
    }

    public function extraFields()
    {
        return [
            'favorite' => function (Track $model) {
                return $model->getFavorite();
            },
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
            'thumb' => Yii::t('app', 'Thumb'),
            'url' => Yii::t('app', 'Url'),
            'length' => Yii::t('app', 'Length'),
            'album_id' => Yii::t('app', 'Album ID'),
        ];
    }

    /**
     * Gets query for [[Album]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(Album::class, ['id' => 'album_id']);
    }

    /**
     * Gets query for [[Artists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtists()
    {
        return $this->hasMany(Artist::class, ['id' => 'artist_id'])->viaTable('track_artist', ['track_id' => 'id']);
    }

    /**
     * Gets query for [[Genres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenres()
    {
        return $this->hasMany(Genre::class, ['id' => 'genre_id'])->viaTable('track_genre', ['track_id' => 'id']);
    }

    /**
     * Gets query for [[Playlists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylists()
    {
        return $this->hasMany(Playlist::class, ['id' => 'playlist_id'])->viaTable('track_playlist', ['track_id' => 'id']);
    }

    /**
     * Gets query for [[TrackArtists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrackArtists()
    {
        return $this->hasMany(TrackArtist::class, ['track_id' => 'id']);
    }

    /**
     * Gets query for [[TrackGenres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrackGenres()
    {
        return $this->hasMany(TrackGenre::class, ['track_id' => 'id']);
    }

    /**
     * Gets query for [[TrackPlaylists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrackPlaylists()
    {
        return $this->hasMany(TrackPlaylist::class, ['track_id' => 'id']);
    }

    public function getTrackUsers() {
        return $this->hasMany(TrackUser::class, ['track_id' => 'id'])->where(['user_id' => \Yii::$app->user->id]);
    }

    public function getUser() {
        return $this->hasMany(TrackUser::class, ['track_id' => 'id']);
    }

    public function getFavorite() {
        $trackUser = $this->getTrackUsers()->andWhere(['track_id' => $this->id])->one();
        if ($trackUser) return $trackUser->favorite;
        return 0;
    }

    public function getRating() {
        $trackUser = $this->getTrackUsers()->andWhere(['track_id' => $this->id])->one();
//        \Yii::error($trackUser->attributes);
        if ($trackUser) return $trackUser->rating;
        return 0;
    }
}

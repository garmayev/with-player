<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "track_genre".
 *
 * @property int $track_id
 * @property int $genre_id
 *
 * @property Genre $genre
 * @property Track $track
 */
class TrackGenre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'track_genre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['track_id', 'genre_id'], 'required'],
            [['track_id', 'genre_id'], 'integer'],
            [['track_id', 'genre_id'], 'unique', 'targetAttribute' => ['track_id', 'genre_id']],
            [['genre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::class, 'targetAttribute' => ['genre_id' => 'id']],
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
            'genre_id' => Yii::t('app', 'Genre ID'),
        ];
    }

    /**
     * Gets query for [[Genre]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::class, ['id' => 'genre_id']);
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

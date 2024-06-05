<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "artist".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $bio
 * @property int|null $born_date
 * @property int|null $death_date
 * @property int|null $created_at
 *
 * @property TrackArtist[] $trackArtists
 * @property Track[] $tracks
 */
class Artist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'artist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bio'], 'string'],
            [['born_date', 'death_date', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'bio' => Yii::t('app', 'Bio'),
            'born_date' => Yii::t('app', 'Born Date'),
            'death_date' => Yii::t('app', 'Death Date'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[TrackArtists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrackArtists()
    {
        return $this->hasMany(TrackArtist::class, ['artist_id' => 'id']);
    }

    /**
     * Gets query for [[Tracks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTracks()
    {
        return $this->hasMany(Track::class, ['id' => 'track_id'])->viaTable('track_artist', ['artist_id' => 'id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "track_user".
 *
 * @property int $track_id
 * @property int $user_id
 * @property float|null $rating
 * @property int|null $favorite
 *
 * @property Track $track
 * @property User $user
 */
class TrackUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%track_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['track_id', 'user_id'], 'required'],
            [['track_id', 'user_id'], 'integer'],
            [['rating'], 'double'],
            [['favorite'], 'number'],
            [['rating'], 'default', 'value' => 0],
            [['track_id', 'user_id'], 'unique', 'targetAttribute' => ['track_id', 'user_id']],
            [['track_id'], 'exist', 'skipOnError' => true, 'targetClass' => Track::class, 'targetAttribute' => ['track_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'track_id' => Yii::t('app', 'Track ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'rating' => Yii::t('app', 'Rating'),
            'favorite' => Yii::t('app', 'Favorite')
        ];
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

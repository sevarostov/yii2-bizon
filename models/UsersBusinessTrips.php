<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_business_trips".
 *
 * @property int $user_id
 * @property int $business_trip_id
 * @property string|null $created_at
 *
 * @property BusinessTrips $businessTrip
 * @property Users $user
 */
class UsersBusinessTrips extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_business_trips';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'business_trip_id'], 'required'],
            [['user_id', 'business_trip_id'], 'integer'],
            [['created_at'], 'safe'],
            [['user_id', 'business_trip_id'], 'unique', 'targetAttribute' => ['user_id', 'business_trip_id']],
            [['business_trip_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessTrips::class, 'targetAttribute' => ['business_trip_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'business_trip_id' => 'Business Trip ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[BusinessTrip]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessTrip()
    {
        return $this->hasOne(BusinessTrips::class, ['id' => 'business_trip_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "business_trips".
 *
 * @property int $id
 * @property string $title
 * @property string|null $content
 * @property string|null $begin_at
 * @property string|null $end_at
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property BusinessTripService[] $businessTripsServices
 * @property Services[] $services
 * @property Users[] $users
 * @property UsersBusinessTrips[] $usersBusinessTrips
 */
class BusinessTrips extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'business_trips';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'begin_at', 'end_at', 'updated_at'], 'default', 'value' => null],
            [['title'], 'required'],
            [['content'], 'string'],
            [['begin_at', 'end_at', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'begin_at' => 'Begin At',
            'end_at' => 'End At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[BusinessTripsServices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessTripsServices()
    {
        return $this->hasMany(BusinessTripService::class, ['business_trip_id' => 'id']);
    }

    /**
     * Gets query for [[Services]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Services::class, ['id' => 'service_id'])->viaTable('business_trips_services', ['business_trip_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['id' => 'user_id'])->viaTable('users_business_trips', ['business_trip_id' => 'id']);
    }

    /**
     * Gets query for [[UsersBusinessTrips]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersBusinessTrips()
    {
        return $this->hasMany(UsersBusinessTrips::class, ['business_trip_id' => 'id']);
    }

}

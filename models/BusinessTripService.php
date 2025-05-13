<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "business_trips_services".
 *
 * @property int $service_id
 * @property int $business_trip_id
 * @property int|null $choosen
 * @property string|null $begin_at
 * @property string|null $end_at
 * @property string|null $created_at
 *
 * @property BusinessTrips $businessTrip
 * @property Services $service
 */
class BusinessTripService extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'business_trips_services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['begin_at', 'end_at'], 'default', 'value' => null],
            [['choosen'], 'default', 'value' => 0],
            [['service_id', 'business_trip_id'], 'required'],
            [['service_id', 'business_trip_id', 'choosen'], 'integer'],
            [['begin_at', 'end_at', 'created_at'], 'safe'],
            [['service_id', 'business_trip_id'], 'unique', 'targetAttribute' => ['service_id', 'business_trip_id']],
            [['business_trip_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessTrips::class, 'targetAttribute' => ['business_trip_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::class, 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'service_id' => 'Service ID',
            'business_trip_id' => 'Business Trip ID',
            'choosen' => 'Choosen',
            'begin_at' => 'Begin At',
            'end_at' => 'End At',
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
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Services::class, ['id' => 'service_id']);
    }

}

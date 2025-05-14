<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property BusinessTrips[] $businessTrips
 * @property BusinessTripsServices[] $businessTripsServices
 */
class Services extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['updated_at'], 'default', 'value' => null],
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[BusinessTrips]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessTrips()
    {
        return $this->hasMany(BusinessTrips::class, ['id' => 'business_trip_id'])->viaTable('business_trips_services', ['service_id' => 'id']);
    }

    /**
     * Gets query for [[BusinessTripsServices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessTripsServices()
    {
        return $this->hasMany(BusinessTripsServices::class, ['service_id' => 'id']);
    }

}

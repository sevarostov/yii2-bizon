<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property BusinessTrips[] $businessTrips
 * @property UsersBusinessTrips[] $usersBusinessTrips
 */
class Users extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['updated_at'], 'default', 'value' => null],
            [['username', 'password',], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'password'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
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
        return $this->hasMany(BusinessTrips::class, ['id' => 'business_trip_id'])->viaTable('users_business_trips', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersBusinessTrips]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersBusinessTrips()
    {
        return $this->hasMany(UsersBusinessTrips::class, ['user_id' => 'id']);
    }

	/**
	 * @return string
	 */
	public function __toString(): string {
		return $this->username;
	}
}

<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%business_trips}}`.
 */
class m250513_132119_create_business_trips_table extends Migration {
	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {

		$this->createTable('users', [
			'id' => $this->primaryKey(),
			'username' => Schema::TYPE_STRING . ' NOT NULL',
			'password' => Schema::TYPE_STRING . ' NOT NULL',
			'authKey' => Schema::TYPE_STRING . ' NOT NULL',
			'accessToken' => Schema::TYPE_TEXT . ' NOT NULL',
			'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
			'updated_at' => $this->dateTime()->defaultValue(NULL),
		]);

		$this->createTable('business_trips', [
			'id' => $this->primaryKey(),
			'title' => Schema::TYPE_STRING . ' NOT NULL',
			'content' => Schema::TYPE_TEXT,
			'begin_at' => $this->dateTime()->defaultValue(NULL),
			'end_at' => $this->dateTime()->defaultValue(NULL),
			'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
			'updated_at' => $this->dateTime()->defaultValue(NULL),
		]);

		$this->createTable('users_business_trips', [
			'user_id' => $this->integer(),
			'business_trip_id' => $this->integer(),
			'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
			'PRIMARY KEY(user_id, business_trip_id)',
		]);

		$this->createIndex(
			'idx-users_business_trips-user_id',
			'users_business_trips',
			'user_id',
		);

		$this->addForeignKey(
			'fk-users_business_trips-user_id',
			'users_business_trips',
			'user_id',
			'users',
			'id',
			'CASCADE',
		);

		$this->createIndex(
			'idx-users_business_trips-business_trip_id',
			'users_business_trips',
			'business_trip_id',
		);

		$this->addForeignKey(
			'fk-users_business_trips-business_trip_id',
			'users_business_trips',
			'business_trip_id',
			'business_trips',
			'id',
			'CASCADE',
		);

		$this->createTable('services', [
			'id' => $this->primaryKey(),
			'name' => Schema::TYPE_STRING . ' NOT NULL',
			'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
			'updated_at' => $this->dateTime()->defaultValue(NULL),
		]);

		foreach (['авиа', 'жд', 'гостиница'] as $service) {
			$this->insert('services', ['name' => $service,]);
		}

		$this->createTable('business_trips_services', [
			'service_id' => $this->integer(),
			'business_trip_id' => $this->integer(),
			'choosen' => $this->boolean()->defaultValue(false),
			'begin_at' => $this->dateTime(),
			'end_at' => $this->dateTime(),
			'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
			'PRIMARY KEY(business_trip_id,service_id)',
		]);

		$this->createIndex(
			'idx-business_trips_services-service_id',
			'business_trips_services',
			'service_id',
		);

		$this->addForeignKey(
			'fk-business_trips_services-service_id',
			'business_trips_services',
			'service_id',
			'services',
			'id',
			'CASCADE',
		);

		$this->createIndex(
			'idx-business_trips_services-business_trip_id',
			'business_trips_services',
			'business_trip_id',
		);

		$this->addForeignKey(
			'fk-business_trips_services-business_trip_id',
			'business_trips_services',
			'business_trip_id',
			'business_trips',
			'id',
			'CASCADE',
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable('business_trips_services');
		$this->dropTable('users_business_trips');
		$this->dropTable('services');
		$this->dropTable('business_trips');
		$this->dropTable('users');
	}
}

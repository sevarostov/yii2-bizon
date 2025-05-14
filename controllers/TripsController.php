<?php

namespace app\controllers;

use app\models\BusinessTrips;
use app\models\BusinessTripsServices;
use app\models\Services;
use app\models\Users;
use app\models\UsersBusinessTrips;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;

class TripsController extends Controller {
	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::class,
				'only' => ['logout'],
				'rules' => [
					[
						'actions' => ['index', 'save', 'delete'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex() {
		return $this->render('index', ['models' => BusinessTrips::find()->all()]);
	}

	/**
	 * @param $id
	 *
	 * @return array|\yii\db\ActiveRecord
	 * @throws HttpException
	 */
	private function loadModel($id) {
		$model = BusinessTrips::find()->where(['id' => $id])->one();
		if ($model == NULL) {
			throw new HttpException(404, 'Model not found.');
		}

		return $model;
	}

	public function actionDelete($id = NULL) {
		$model = $this->loadModel($id);

		if (!$model->delete())
			Yii::$app->session->setFlash('error', 'Unable to delete model');

		$this->redirect(\Yii::$app->urlManager->createUrl(['trips/index']));
	}

	/**
	 * @param $id
	 *
	 * @return string
	 * @throws HttpException
	 * @throws \yii\db\Exception
	 */
	public function actionSave($id = NULL): string {
		if ($id == NULL) {

			$model = new BusinessTrips();

		} else {
			/** @var BusinessTrips $model */
			$model = $this->loadModel($id);
			$model->updated_at = new Expression('NOW()');
		}
		$users = Users::find()->all();
		$services = Services::find()->all();

		$businesTripsServices = [];
		/** @var Services $service */
		foreach ($services as $service) {
			$businesTripsService = BusinessTripsServices::find()->where([
				'service_id' => $service->id,
				'business_trip_id' => $model->id
			])->one();
			if (!$businesTripsService) {
				$businesTripsService = new BusinessTripsServices();
			}
			$businesTripsService->service_id = $service->id;
			$businesTripsService->business_trip_id = $model->id;
			$businesTripsServices[] = $businesTripsService;
		}

		if (isset($_POST['BusinessTrips'])) {
			if (NULL === $id && (!is_array($_POST['BusinessTrips']['users']) || !count($_POST['BusinessTrips']['users']))) {
				Yii::$app->session->setFlash('error', 'Users should be added');
				$this->redirect(\Yii::$app->urlManager->createUrl([
					'trips/save',
				]));
			} else {
				$model->load($_POST);

				if ($model->save()) {

					if (NULL === $id && is_array($_POST['BusinessTrips']['users'])) {
						foreach ($_POST['BusinessTrips']['users'] as $userId) {
							$usersBusinessTrips = new UsersBusinessTrips();
							$usersBusinessTrips->user_id = $userId;
							$usersBusinessTrips->business_trip_id = $model->id;
							$usersBusinessTrips->save();
						}
					}

					$model->unlinkAll('businessTripsServices', true);
					$data = [];
					foreach ($_POST['BusinessTripsServices'] as $field => $items) {
						foreach ($items as $serviceId => $value) {
							if (!empty($value)) {
								$data[$serviceId][$field] = $value;
							}
						}
					}
					foreach ($data as $serviceId => $item) {
						$businesTripsService = new BusinessTripsServices();
						$businesTripsService->service_id = $serviceId;
						$businesTripsService->business_trip_id = $model->id;
						$businesTripsService->choosen = $item['choosen'];
						$businesTripsService->begin_at = $item['begin_at'];
						$businesTripsService->end_at = $item['end_at'];
						$businesTripsService->save();
					}

					$model->begin_at = $model->getCurrentBeginAt();
					$model->end_at = $model->getCurrentEndAt();
					$model->save();

					Yii::$app->session->setFlash('success', 'Model has been saved');
					$this->redirect(\Yii::$app->urlManager->createUrl([
						'trips/save',
						'id' => $model->id,
						'model' => $model,
						'users' => $users,
						'services' => $services,
						'businesTripsServices' => $businesTripsServices,
					]));
				} else
					Yii::$app->session->setFlash('error', 'Model could not be saved');
			}
		}

		return $this->render('save', [
			'model' => $model,
			'users' => $users,
			'services' => $services,
			'businesTripsServices' => $businesTripsServices,]);
	}
}

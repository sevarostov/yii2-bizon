<?php

namespace app\controllers;

use app\models\Users;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;

class SiteController extends Controller {
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
		return $this->render('index', ['models' => Users::find()->all()]);
	}

	/**
	 * @param $id
	 *
	 * @return ActiveRecord
	 * @throws HttpException
	 */
	private function loadModel($id): ActiveRecord {
		$model = Users::find()->where(['id' => $id])->one();
		if ($model == NULL) {
			throw new HttpException(404, 'Model not found.');
		}

		return $model;
	}

	/**
	 * @param $id
	 *
	 * @return void
	 * @throws HttpException
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 */
	public function actionDelete($id = NULL): void {
		$model = $this->loadModel($id);

		if (!$model->delete())
			Yii::$app->session->setFlash('error', 'Unable to delete model');

		$this->redirect(\Yii::$app->urlManager->createUrl(['site/index']));
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
			$model = new Users;
		} else {
			/** @var Users $model */
			$model = $this->loadModel($id);
			$model->updated_at = new Expression('NOW()');
		}

		if (isset($_POST['Users'])) {
			$model->load($_POST);

			if ($model->save()) {
				Yii::$app->session->setFlash('success', 'Model has been saved');
				$this->redirect(\Yii::$app->urlManager->createUrl(['site/save', 'id' => $model->id, 'model' => $model]));
			} else
				Yii::$app->session->setFlash('error', 'Model could not be saved');
		}

		return $this->render('save', ['model' => $model]);
	}
}

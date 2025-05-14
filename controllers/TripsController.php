<?php

namespace app\controllers;

use app\models\BusinessTrips;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;

class TripsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
    public function actions()
    {
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
    public function actionIndex()
    {
        return $this->render('index', ['models' => BusinessTrips::find()->all()]);
    }

	/**
	 * @param $id
	 *
	 * @return array|\yii\db\ActiveRecord
	 * @throws HttpException
	 */
	private function loadModel($id)
	{
		$model = BusinessTrips::find()->where(['id' => $id])->one();
		if ($model == NULL) {
			throw new HttpException(404, 'Model not found.');
		}

		return $model;
	}

	public function actionDelete($id=NULL)
	{
		$model = $this->loadModel($id);

		if (!$model->delete())
			Yii::$app->session->setFlash('error', 'Unable to delete model');

		$this->redirect($this->createUrl('trips/index'));
	}

	/**
	 * @param $id
	 *
	 * @return string
	 * @throws HttpException
	 * @throws \yii\db\Exception
	 */
	public function actionSave($id=NULL): string {
		if ($id == NULL){
			$model = new BusinessTrips();
		} else {
			$model = $this->loadModel($id);
		}

		if (isset($_POST['BusinessTrips']))
		{
			$model->load($_POST);

			if ($model->save())
			{
				Yii::$app->session->setFlash('success', 'Model has been saved');
				$this->redirect(\Yii::$app->urlManager->createUrl(['trips/save', 'id' => $model->id, 'model' => $model]));
			}
			else
				Yii::$app->session->setFlash('error', 'Model could not be saved');
		}

		return $this->render('save', ['model' => $model]);
	}
}

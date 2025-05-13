<?php

namespace app\controllers;

use app\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\filters\VerbFilter;

class SiteController extends Controller
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
        return $this->render('index', ['models' => Users::find()->all()]);
    }

	private function loadModel($id)
	{
		$model = Users::find($id);

		if ($model == NULL)
			throw new HttpException(404, 'Model not found.');

		return $model;
	}

	public function actionDelete($id=NULL)
	{
		$model = $this->loadModel($id);

		if (!$model->delete())
			Yii::$app->session->setFlash('error', 'Unable to delete model');

		$this->redirect($this->createUrl('site/index'));
	}

	public function actionSave($id=NULL)
	{
		if ($id == NULL)
			$model = new Users;
		else
			$model = $this->loadModel($id);
		if (isset($_POST['Users']))
		{
			$model->load($_POST);

			if ($model->save())
			{
				Yii::$app->session->setFlash('success', 'Model has been saved');
				$this->redirect(\Yii::$app->urlManager->createUrl(['site/save', ['id' => $model->id]]));
			}
			else
				Yii::$app->session->setFlash('error', 'Model could not be saved');
		}

		return $this->render('save', ['model' => $model]);
	}
}

<?php

namespace app\controllers;

use Yii;
use app\models\Tour;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TourController implements the CRUD actions for Tour model.
 */
class TourController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Tour models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tour::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Admin all Tour models.
     * @return mixed
     */
    public function actionAdmin()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tour::find(),
        ]);
    
        return $this->render('admin', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tour model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tour model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tour();
        $model->initFieldOrders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'enabledFields' => $this->loadFieldSortableItems($model->fieldsOrderStr),
                'availableFields' => $this->loadFieldSortableItems($model->fieldsOrderAvailableStr),
            ]);
        }
    }

    /**
     * Updates an existing Tour model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'enabledFields' => $this->loadFieldSortableItems($model->fieldsOrderStr),
                'availableFields' => $this->loadFieldSortableItems($model->fieldsOrderAvailableStr),
            ]);
        }
    }

    /**
     * Deletes an existing Tour model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['admin']);
    }

    /**
     * Finds the Tour model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tour the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tour::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function loadFieldSortableItems($fieldsString)
    {
        $booking = Yii::$app->get('booking');
        $namesList = $booking->fieldsOrderStringToNamesList($fieldsString);
        
        $sortableItems = [];
        foreach ($namesList as $name) {
            $config = $booking->getFieldByName($name);
            if (isset($config['id'])) {
                $key = $config['id'];
                $isInitial = 0;
            } else {
                $key = $name;
                $isInitial = 1;
            }
            $sortableItems[$key] = [
                'content' => $isInitial ? $config['label'] . ' (required)' : $config['label'],
                'options' => ['data-initial' => $isInitial]
            ];
        }
        
        return $sortableItems;
    }
}

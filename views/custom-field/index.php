<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Custom Fields';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custom-field-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Custom Field', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'label',
            [
                'header' => Yii::t('custom_field_index', 'Validator Type'),
                'value' => function($model) {
                    return Yii::$app->get('booking')->fieldValidatorTypes[$model->validatorType];
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>

</div>

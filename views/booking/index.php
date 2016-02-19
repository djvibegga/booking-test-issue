<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bookings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="booking-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'header' => Yii::t('booking_index', 'Tour'),
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a($model->tour->name, ['/tour/view', 'id' => $model->tourId]);
                }
            ],
            'fullName',
            'email',
            'date',
            'babyCount',
            'childCount',
            'adultCount',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}'
            ],
        ],
    ]); ?>

</div>

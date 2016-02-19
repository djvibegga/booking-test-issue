<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Booking */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="booking-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php
        $attributesConfig = [
            'id',
            'fullName',
            [
                'format' => 'raw',
                'label' => Yii::t('booking_view', 'Email Address'),
                'value' => Html::a($model->email, 'mailto:' . $model->email),
            ],
            [
                'format' => 'raw',
                'label' => Yii::t('booking_view', 'Tour'),
                'value' => Html::a($model->tour->name, ['/tour/view', 'id' => $model->tourId]),
            ],
            'date',
            'babyCount',
            'childCount',
            'adultCount',
            [
                'format' => 'raw',
                'label' => Yii::t('booking_view', 'Custom Fields'),
                'value' => var_export($model->getCustomFieldValues(), true),
            ],
        ];

        
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributesConfig,
    ]) ?>

</div>

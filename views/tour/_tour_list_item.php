<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $data app\models\Tour */

?>
<div class="tour-item">
    <span><?= Html::encode($model->name) ?></span> | 
    <?= Html::a(Yii::t('_tour_list_item', 'to book'), ['/booking/create', 'tourId' => $model->id]) ?>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('tour_index', 'Tours');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tour-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= ListView::widget([
        'id' => 'toursListView',
        'dataProvider' => $dataProvider,
        'itemView' => '_tour_list_item',
    ]); ?>

</div>

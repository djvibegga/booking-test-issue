<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tour */

$this->title = 'Update Tour: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tours', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tour-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'enabledFields' => $enabledFields,
        'availableFields' => $availableFields,
    ]) ?>

</div>

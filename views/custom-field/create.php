<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CustomField */

$this->title = 'Create Custom Field';
$this->params['breadcrumbs'][] = ['label' => 'Custom Fields', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custom-field-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'validatorTypes' => $validatorTypes,
    ]) ?>

</div>

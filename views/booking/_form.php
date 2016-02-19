<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

$isNewRecord = $model->getScenario() == 'create';
$booking = Yii::$app->get('booking');

/* @var $this yii\web\View */
/* @var $model app\models\BookingForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $booking app\components\BookingManager */
?>

<div class="booking-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'fullName')->textInput() ?>
    
    <?= $form->field($model, 'email')->textInput() ?>
    
    <?= $form->field($model, 'date')->widget(
        DatePicker::className(), [
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'dd-mm-yyyy'
            ]
    ]);?>
    
    <?php foreach ($model->getCustomFieldValues() as $name => $value) : ?>
    
        <?php 
            $renderMethod = $booking->getCustomFieldRenderMethodByFieldName($name);
            echo $form->field($model, $name)->$renderMethod();
        ?>
    
    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton($isNewRecord ? 'Create' : 'Update', ['class' => $isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

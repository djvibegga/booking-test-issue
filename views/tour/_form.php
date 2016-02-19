<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\sortinput\SortableInput;
use yii\web\JsExpression;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Tour */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tour-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
 
    <?= $form->field($model, 'fieldsOrderStr')->widget(
        SortableInput::className(), [
            'hideInput' => true,
            'delimiter' => ',',
            'items' => $enabledFields,
            'sortableOptions' => [
                'connected' => true,
            ]
        ]
    ) ?>
    
    <?= $form->field($model, 'fieldsOrderAvailableStr')->widget(
        SortableInput::className(), [
            'hideInput' => true,
            'delimiter' => ',',
            'items' => $availableFields,
            'sortableOptions' => [
                'connected' => true,
                'pluginOptions' => [
                ],
            ],
        ]
    ) ?>
    
    
    <?php
        $js = <<<JS
$.fn.fixSortableOrder = function(sortable) {
    var items = sortable.children();
    var keys = [];
    items.each(function(i, item) {
        keys[i] = $(item).attr('data-key');
    });
    var endInput = sortable.parent().find('input');
    endInput.attr('value', keys.join(','));
}
        
$('.sortable').sortable().bind('sortupdate', function( event, ui ) { //you can not disable initial fields
    if (ui.item.data('initial') == 1 && ui.startparent.attr('id') != ui.endparent.attr('id')) {
        $(ui.item).sortable('cancel');
        if (ui.oldindex == 0) {
            ui.startparent.prepend(ui.item);
        } else {
            ui.startparent.children(':eq(' + (ui.oldindex - 1) + ')').after(ui.item);
        }
        var endInput = ui.endparent.parent().find('input');
        var newValue = endInput.attr('value');
        var items = newValue.split(',');
        for (var key in items) {
            if (items[key] == ui.item.attr('data-key')) {
                items.splice(key, 1);
            }
        }
        endInput.attr('value', items.join(','));
    }
    $.fn.fixSortableOrder(ui.endparent);
    $.fn.fixSortableOrder(ui.startparent);
});
JS;
        $this->registerJs($js, View::POS_READY);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

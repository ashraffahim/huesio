<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\databaseObjects\Slot $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="slot-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'turf_id')->textInput() ?>

    <?= $form->field($model, 'day')->textInput() ?>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <?= $form->field($model, 'end_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\widgets\ActiveForm;

$this->title = 'Create blog';
?>
<div class="h-full flex items-center justify-center">
    <div class="w-3/12 p-3">
        <?php
        $form = ActiveForm::begin([
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'inputOptions' => ['class' => 'input-classic'],
                'labelOptions' => ['class' => 'input-label-classic'],
                'errorOptions' => ['class' => 'input-error-text-classic']
            ]
        ]);
        ?>
        <div class="mb-3">
            <?= $form->field($model, 'title'); ?>
        </div>
        <div class="mb-3">
            <?= $form->field($model, 'issue')->dropDownList(array_combine(app\models\Issue::ISSUE_ID_TO_NAME, app\models\Issue::ISSUE_ID_TO_NAME)); ?>
        </div>
        <div class="mb-3">
            <?= $form->field($model, 'description'); ?>
        </div>
        <div class="mb-3">
            <?= $form->field($model, 'keywords'); ?>
        </div>
        <div class="flex flex-1 justify-end">
            <button class="btn-classic">Create</button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

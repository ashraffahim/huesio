<?php

/** @var yii\web\View $this */

use yii\widgets\ActiveForm;

/** @var app\models\forms\LoginForm $model */

$this->title = 'Login';
?>
<main class="flex min-h-screen flex-col items-center justify-between px-24">
    <div class="flex min-h-full flex-1 flex-col justify-center sm:mx-auto sm:w-full sm:max-w-sm px-6 py-12 lg:px-8">
    <div class="flex flex-col sm:mx-auto sm:w-full sm:max-w-sm">
        <img
        class="mx-auto h-10 w-auto"
        src="https://huesio.ca/logo.png"
        alt="Your Company"
        />
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <?php
        $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => "{input}\n{error}",
                'errorOptions' => ['class' => 'text-red'],
            ],
            'options' => [
                'class' => 'space-y-6'
            ]
        ]);
        ?>
        <form class="space-y-6" method="POST">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>" />
        <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">
            Email address
            </label>
            <div class="mt-2">
                <?= $form->field($model, 'username')->textInput([
                    'class' => 'input-classic',
                    'autoComplete' => 'email',
                    'autofocus' => true,
                    'required' => true
                ]); ?>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">
                Password
            </label>
            <div class="text-sm">
                <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500" tabindex="-1">
                Forgot password?
                </a>
            </div>
            </div>
            <div class="mt-2">
                <?= $form->field($model, 'password')->passwordInput([
                    'class' => 'input-classic',
                    'autoComplete' => 'current-password',
                    'required' => true
                ]); ?>
            </div>
        </div>

        <div>
            <button
            type="submit"
            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 border-0"
            >
            Sign in
            </button>
        </div>
        <?php ActiveForm::end(); ?>
        </p>
    </div>
    </div>
</main>
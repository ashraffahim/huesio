<?php

/** @var yii\web\View $this */
/** @var app\models\databaseObjects\Blog $blog */
/** @var array $errors */

use app\components\StorageManager;
use yii\helpers\Html;


$this->title = 'Write blog content';
?>

<div class="h-full">
    <form method="post" class="h-full">
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
        <h1 class="text-3xl p-2"><?= $blog->title ?></h1>
        <hr>
        <textarea name="content" id="content" class="w-full h-3/4"><?php
            $path = StorageManager::getBlogContentFilePath($blog->uuid);
            if (StorageManager::fileExists($path)) {
                $file = StorageManager::getFileResource($path);

                while (!feof($file)) {
                    echo fread($file, StorageManager::READER_BUFFER_LENGTH);
                }

                StorageManager::closeFile($file);
            }
            ?></textarea>
        <span class="input-error-text-classic"><?= implode('<br>', $errors) ?></span>
        <hr>
        <br>
        <button class="btn-classic">Save</button>
    </form>
</div>
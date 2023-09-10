<?php

/** @var yii\web\View $this */
/** @var app\models\databaseObjects\Blog $blog */
/** @var array $errors */

use app\assets\WriteBlogContentAsset;
use app\components\StorageManager;
use yii\helpers\Html;

WriteBlogContentAsset::register($this);

$this->title = 'Write blog content';
?>

<div class="h-full">
    <form method="post" class="h-full">
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
        <h1 class="text-3xl p-2"><?= $blog->title ?></h1>
        <hr>
        <textarea class="text-content w-full h-3/4"></textarea>
        <textarea name="content" class="html-content w-full h-3/4" style="display: none;"><?php
            try {
                echo StorageManager::getBlogContent($blog->uuid);
            } catch(\Exception $e) {
                echo '';
            }
        ?></textarea>
        <hr>
        <br>
        <a class="btn-classic write-blog-back">Back</a>
        <a class="btn-classic write-blog-next">Next</a>
        <button class="btn-classic write-blog-save">Save</button>
    </form>
</div>
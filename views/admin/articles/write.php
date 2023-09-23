<?php

/** @var yii\web\View $this */
/** @var app\models\databaseObjects\Article $article */
/** @var array $errors */

use app\assets\WriteArticleContentAsset;
use app\components\StorageManager;
use yii\helpers\Html;

WriteArticleContentAsset::register($this);

$this->title = 'Write article content';
?>

<div class="h-full">
    <form method="post" class="h-full">
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
        <h1 class="text-3xl p-2"><?= $article->title ?></h1>
        <hr>
        <textarea class="text-content w-full h-3/4"></textarea>
        <textarea name="content" class="html-content w-full h-3/4" style="display: none;"><?php
            try {
                echo StorageManager::getArticleContent($article->uuid);
            } catch(\Exception $e) {
                echo '';
            }
        ?></textarea>
        <hr>
        <br>
        <a class="btn-classic write-article-back">Back</a>
        <a class="btn-classic write-article-next">Next</a>
        <button class="btn-classic write-article-save">Save</button>
    </form>
</div>
<?php

/** @var yii\web\View $this */

use app\components\StorageManager;

/** @var app\models\databaseObjects\Blog $blog */

$this->title = $blog->title;
?>

<div class="">
    <?= StorageManager::getBlogContent($blog->uuid) ?>
</div>
<?php

/** @var yii\web\View $this */

use app\components\StorageManager;

/** @var app\models\databaseObjects\Blog $blog */

$this->title = $blog->title;

$this->params = [
    'breadcrumbs' => [
        [
            'label' => 'Health',
            'url' => '/health',
        ],
        $this->title
    ],
    'creation_date' => $blog->creation_date,
    'updation_date' => $blog->updation_date,
];
?>

<div class="">
    <?= StorageManager::getBlogContent($blog->uuid) ?>
</div>
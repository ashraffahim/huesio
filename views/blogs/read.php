<?php

/** @var yii\web\View $this */

use app\components\StorageManager;

/** @var app\models\databaseObjects\Blog $blog */
/** @var strinf $urlSuffix */

$this->title = $blog->title;

$this->params = [
    'breadcrumbs' => [
        [
            'label' => 'Health',
            'url' => '/health',
        ],
        $this->title
    ],
    'meta_url' => Yii::$app->params['baseUrl'] . 'health/' . $urlSuffix,
    'meta_description' => $blog->description,
    'meta_keywords' => $blog->keywords,
    'meta_image' => Yii::$app->params['baseUrl'] . 'images/' . $blog->file->uuid . '.' . pathinfo($blog->file->name, PATHINFO_EXTENSION),
    'creation_date' => $blog->creation_date,
    'updation_date' => $blog->updation_date,
];
?>

<div class="blog-read">
    <?= StorageManager::getBlogContent($blog->uuid) ?>
</div>
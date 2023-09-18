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
    'meta_url' => Yii::$app->params['appBaseUrl'] . 'health/' . $urlSuffix,
    'meta_description' => $blog->description,
    'meta_keywords' => $blog->keywords,
    'creation_date' => $blog->creation_date,
    'updation_date' => $blog->updation_date,
];

if (!is_null($blog->image_id)) {
    $this->params['meta_image'] = Yii::$app->params['imgCdnBaseUrl'] . $blog->file->uuid . '.' . pathinfo($blog->file->name, PATHINFO_EXTENSION);
} else {
    $this->params['meta_image'] = Yii::$app->params['appBaseUrl'] . 'logo.png';
}
?>

<div class="blog-read">
    <?= StorageManager::getBlogContent($blog->uuid) ?>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1458829588848469"
     crossorigin="anonymous"></script>
    <ins class="adsbygoogle"
        style="display:block; text-align:center;"
        data-ad-layout="in-article"
        data-ad-format="fluid"
        data-ad-client="ca-pub-1458829588848469"
        data-ad-slot="9633669284"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
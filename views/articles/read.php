<?php

/** @var yii\web\View $this */

use app\components\StorageManager;

/** @var app\models\databaseObjects\Article $article */
/** @var string $urlSuffix */

$this->title = $article->title;

$this->params = [
    'breadcrumbs' => [
        $this->title
    ],
    'meta_url' => Yii::$app->params['appBaseUrl'] . $urlSuffix,
    'meta_description' => $article->description,
    'meta_keywords' => $article->keywords,
    'creation_date' => $article->creation_date,
    'updation_date' => $article->updation_date,
];

if (!is_null($article->image_id)) {
    $this->params['meta_image'] = Yii::$app->params['imgCdnBaseUrl'] . $article->file->uuid . '.' . pathinfo($article->file->name, PATHINFO_EXTENSION);
} else {
    $this->params['meta_image'] = Yii::$app->params['appBaseUrl'] . 'logo.png';
}
?>

<div class="article-read">
    <?= StorageManager::getArticleContent($article->uuid) ?>
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
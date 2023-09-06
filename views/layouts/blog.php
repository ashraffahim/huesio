<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\components\Util;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="min-h-full">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="min-h-full">
<?php $this->beginBody() ?>

<header id="header" class="flex justify-center bg-white border-b border-gray-200">
    <div class="xl:w-3/4 lg:w-3/4 md:w-5/6 sm:w-full mx-auto">
        <div class="grid grid-cols-3 justify-between py-3 px-4">
            <div class="brand relative">
                <img src="<?= Yii::getAlias('@web/logo.png') ?>" alt="Huesio" class="absolute -top-3 h-12 w-12">
            </div>
            <nav class="grid items-center justify-center">
                <ul class="list-none whitespace-nowrap child:inline-block child:px-2">
                    <li><a href="/health">Health</a></li>
                    <li><a href="/beauty">Beauty</a></li>
                </ul>
            </nav>
            <div class="account"></div>
        </div>
    </div>
</header>

<main id="main" class="min-h-full flex-shrink-0" role="main">
    <div class="xl:w-2/4 lg:w-2/3 md:w-4/5 w-11/12 min-h-full mx-auto pt-3">
        <div class="mb-3">
            <?= Breadcrumbs::widget([
                'itemTemplate' => "<li class=\"breadcrumb-item\">{link}</li><span class=\"inline-block mx-1\">/</span>\n",
                'links' => $this->params['breadcrumbs']
            ]) ?>
        </div>
        <h1 class="text-4xl font-black mb-3"><?= $this->title ?></h1>
        <div class="mb-3"><span class="text-gray-500"><?= Util::getUserFormattedDate($this->params['creation_date']) ?></span></div>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="flex py-3 px-5">
    <div class="container">
        <div class="text-gray-500">
            <div class="w-full text-end">&copy; <?= Util::getAppName() . ' ' . date('Y') ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

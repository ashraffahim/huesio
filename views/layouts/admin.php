<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-screen">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="h-full">
<?php $this->beginBody() ?>

<header id="header">
</header>

<main id="main" role="main" class="flex flex-auto h-full">
    <nav class="bg-black w-64 h-full">
        <div class="flex items-center justify-center h-14 text-white">
            <span class="text-xl font-semibold">Admin Panel</span>
        </div>
        <ul class="py-4">
            <li>
                <a href="/admin/blogs/list" class="block px-6 py-2 hover:bg-indigo-700 text-white">Blogs</a>
            </li>
            <li>
                <a href="/admin/blogs/create" class="block px-6 py-2 hover:bg-indigo-700 text-white">Create blog</a>
            </li>
            <li>
                <a href="/admin/blogs/files" class="block px-6 py-2 hover:bg-indigo-700 text-white">Files</a>
            </li>
            <li class="nav-item">
            <?=
                Html::beginForm(['/site/logout'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->email . ')',
                    ['class' => 'px-6 py-2 hover:bg-indigo-700 text-white']
                )
                . Html::endForm()
                ?>
            </li>
        </ul>
    </nav>
    <div class="container h-full p-4">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= $content ?>
    </div>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

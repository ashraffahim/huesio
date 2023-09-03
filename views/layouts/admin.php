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
            <li class="px-6 py-2 hover:bg-indigo-700 text-white">
                <a href="/posts/list" class="block">Posts</a>
            </li>
            <li class="px-6 py-2 hover:bg-indigo-700 text-white">
                <a href="/posts/create" class="block">Create post</a>
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
    <div class="container h-full">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

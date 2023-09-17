<?php

/** @var yii\web\View $this */
/** @var app\models\databaseObjects\Blog[] $blogs */

$this->title = 'Huesio - Home';
$hrefPrefix = Yii::$app->params['appBaseUrl'] . 'health/';
$blogIndex = 0;
?>

<div class="blog-home">
    <div class="flex px-1 lg:px-8 md:px-4">

        <div class="w-full lg:w-1/2 md:w-1/2 pr-0 lg:pr-2 md:pr-2">
            <div class="w-full">
                <a href="<?= $hrefPrefix . $blogs[$blogIndex]->handle ?>">
                    <h4 class="text-3xl text-center p-3"><?= $blogs[$blogIndex]->title ?></h4>
                    <img src="<?= Yii::$app->params['imgCdnBaseUrl'] . $blogs[$blogIndex]->file->uuid . '.' . pathinfo($blogs[$blogIndex]->file->name, PATHINFO_EXTENSION) ?>" alt="<?= $blogs[$blogIndex]->title ?>" loading="lazy">
                    <h6 class="text-base p-3"><?= $blogs[$blogIndex]->description ?></h6>
                    <?php $blogIndex++; ?>
                </a>
            </div>
            <div class="flex">
                <div class="w-1/2 px-1">
                    <a href="<?= $hrefPrefix . $blogs[$blogIndex]->handle ?>">
                        <img src="<?= Yii::$app->params['imgCdnBaseUrl'] . $blogs[$blogIndex]->file->uuid . '.' . pathinfo($blogs[$blogIndex]->file->name, PATHINFO_EXTENSION) ?>" alt="<?= $blogs[$blogIndex]->title ?>" loading="lazy">
                        <h4 class="text-xl px-3 pt-3"><?= $blogs[$blogIndex]->title ?></h4>
                        <h6 class="text-base px-3 pb-3"><?= $blogs[$blogIndex]->description ?></h6>
                        <?php $blogIndex++; ?>
                    </a>
                </div>
                <div class="w-1/2 px-1">
                    <a href="<?= $hrefPrefix . $blogs[$blogIndex]->handle ?>">
                        <img src="<?= Yii::$app->params['imgCdnBaseUrl'] . $blogs[$blogIndex]->file->uuid . '.' . pathinfo($blogs[$blogIndex]->file->name, PATHINFO_EXTENSION) ?>" alt="<?= $blogs[$blogIndex]->title ?>" loading="lazy">
                        <h4 class="text-xl px-3 pt-3"><?= $blogs[$blogIndex]->title ?></h4>
                        <h6 class="text-base px-3 pb-3"><?= $blogs[$blogIndex]->description ?></h6>
                        <?php $blogIndex++; ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="flex w-full lg:w-1/2 md:w-1/2 pl-0 lg:pl-2 md:pl-2">
            <div class="w-full lg:w-1/2 md:w-1/2">
                <div class="w-full px-0 lg:px-1 md:px-1">
                    <a href="<?= $hrefPrefix . $blogs[$blogIndex]->handle ?>">
                        <img src="<?= Yii::$app->params['imgCdnBaseUrl'] . $blogs[$blogIndex]->file->uuid . '.' . pathinfo($blogs[$blogIndex]->file->name, PATHINFO_EXTENSION) ?>" alt="<?= $blogs[$blogIndex]->title ?>" loading="lazy">
                        <h4 class="text-xl px-3 pt-3"><?= $blogs[$blogIndex]->title ?></h4>
                        <h6 class="text-base px-3 pb-3"><?= $blogs[$blogIndex]->description ?></h6>
                        <?php $blogIndex++; ?>
                    </a>
                </div>
                <div class="w-full px-0 lg:px-1 md:px-1">
                    <a href="<?= $hrefPrefix . $blogs[$blogIndex]->handle ?>">
                        <img src="<?= Yii::$app->params['imgCdnBaseUrl'] . $blogs[$blogIndex]->file->uuid . '.' . pathinfo($blogs[$blogIndex]->file->name, PATHINFO_EXTENSION) ?>" alt="<?= $blogs[$blogIndex]->title ?>" loading="lazy">
                        <h4 class="text-xl px-3 pt-3"><?= $blogs[$blogIndex]->title ?></h4>
                        <h6 class="text-base px-3 pb-3"><?= $blogs[$blogIndex]->description ?></h6>
                        <?php $blogIndex++; ?>
                    </a>
                </div>
            </div>
            <div class="w-full lg:w-1/2 md:w-1/2">
                <div class="w-full px-0 lg:px-1 md:px-1">
                    <a href="<?= $hrefPrefix . $blogs[$blogIndex]->handle ?>">
                        <img src="<?= Yii::$app->params['imgCdnBaseUrl'] . $blogs[$blogIndex]->file->uuid . '.' . pathinfo($blogs[$blogIndex]->file->name, PATHINFO_EXTENSION) ?>" alt="<?= $blogs[$blogIndex]->title ?>" loading="lazy">
                        <h4 class="text-xl px-3 pt-3"><?= $blogs[$blogIndex]->title ?></h4>
                        <h6 class="text-base px-3 pb-3"><?= $blogs[$blogIndex]->description ?></h6>
                        <?php $blogIndex++; ?>
                    </a>
                </div>
                <div class="w-full px-0 lg:px-1 md:px-1">
                    <a href="<?= $hrefPrefix . $blogs[$blogIndex]->handle ?>">
                        <img src="<?= Yii::$app->params['imgCdnBaseUrl'] . $blogs[$blogIndex]->file->uuid . '.' . pathinfo($blogs[$blogIndex]->file->name, PATHINFO_EXTENSION) ?>" alt="<?= $blogs[$blogIndex]->title ?>" loading="lazy">
                        <h4 class="text-xl px-3 pt-3"><?= $blogs[$blogIndex]->title ?></h4>
                        <h6 class="text-base px-3 pb-3"><?= $blogs[$blogIndex]->description ?></h6>
                        <?php $blogIndex++; ?>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
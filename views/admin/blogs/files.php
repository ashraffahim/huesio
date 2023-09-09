<?php

/**
 * @var app\models\databaseObjects\File[] $files
 * @var int $filesCount
 * @var string $page
 * @var array $errors
*/

use app\assets\MediaFilesAsset;

MediaFilesAsset::register($this);

$this->title = 'Files';

?>

<div class="h-screen">
    <div class="mb-3">
        <form  id="media-files-form" enctype="multipart/form-data" action="/admin/blogs/files" method="post">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfParam ?>">
            <div class="flex h-10 mb-3">
                <input type="file" id="media-file-input" accept="image/*" multiple>
            </div>
            <div id="uploaded-media-files">
            </div>
            <div class="flex">
                <button class="btn-classic">Upload</button>
            </div>
        </form>
    </div>
    <div>
        <?php
        foreach ($files as $file) {
        ?>
        <div class="p-1">
            <div><?= $file->name ?> / <?= $file->uuid ?></div>
        </div>
        <?php
        }
        ?>
    </div>
</div>
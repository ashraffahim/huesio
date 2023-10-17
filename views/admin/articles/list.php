<?php

/**
 * @var app\models\databaseObjects\Post[] $articles
 * @var int $articlesCount
 * @var string $page
*/

$this->title = 'Articles';

if (empty($articles)):
?>

<div>
    <h3>
        No posts yet
    </h3>
</div>

<?php else: ?>

<div class="h-screen">
    <?php foreach ($articles as $article): ?>
        <div class="p-1 border-2">
            <strong><?= $article->id . '. ' . $article->title ?></strong><br>
            <?= $article->creation_date . ' - ' . $article->updation_date ?>
            <a href="/admin/articles/edit/<?= $article->uuid ?>">Edit</a>
             • 
            <a href="/admin/articles/write/<?= $article->uuid ?>">Write</a>
             • 
            <a href="/<?= $article->handle ?>" target="_blank">Read</a>
        </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>
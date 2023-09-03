<?php

/**
 * @var app\models\databaseObjects\Post[] $posts
 * @var int $postsCount
 * @var string $page
*/

$this->title = 'Posts';

if (empty($posts)):
?>

<div>
    <h3>
        No posts yet
    </h3>
</div>

<?php else: ?>

<div class="h-screen">
    <?php foreach ($posts as $post): ?>
        <div class="p-1 border-2">
            <strong><?= $post->id . '. ' . $post->title ?></strong><br>
            <?= $post->creation_date . ' - ' . $post->updation_date ?>
        </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>
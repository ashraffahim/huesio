<?php

/**
 * @var app\models\databaseObjects\Post[] $blogs
 * @var int $blogsCount
 * @var string $page
*/

$this->title = 'Blogs';

if (empty($blogs)):
?>

<div>
    <h3>
        No posts yet
    </h3>
</div>

<?php else: ?>

<div class="h-screen">
    <?php foreach ($blogs as $blog): ?>
        <div class="p-1 border-2">
            <strong><?= $blog->id . '. ' . $blog->title ?></strong><br>
            <?= $blog->creation_date . ' - ' . $blog->updation_date ?>
            <a href="/admin/blogs/edit/<?= $blog->uuid ?>">Edit</a>
             • 
            <a href="/admin/blogs/write/<?= $blog->uuid ?>">Write</a>
             • 
            <a href="/health/<?= $blog->handle ?>" target="_blank">Read</a>
        </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>
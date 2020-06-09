<?php
/**
 * @var array $posts
 * @var \Framework\Template\php\TemplateRenderer $this
 * @var \App\ReadModel\View\PostView[] $posts
 */

$this->extend('layout/default');
$this->params['title'] = "Blog Index";
?>


<?php $this->beginBlock('meta'); ?>
    <meta name="description" content="Blog description" />
<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs'); ?>
    <ul class="breadcrumb">
        <li><a href="<?= $this->encode($this->path('home')) ?>">Home</a></li>
        <li class="active">Blog</li>
    </ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('content'); ?>

    <h1>Blog</h1>

    <?php foreach ($posts as $post): ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="pull-right"><?= $post->date->format('Y-m-d') ?></span>
                <a href="<?= $this->encode($this->path('blog-post', ['id' => $post->id])) ?>"><?= $this->encode($post->title) ?></a>
            </div>
            <div class="panel-body"><?= nl2br($this->encode($post->content)) ?></div>
        </div>

    <?php endforeach; ?>

<?php $this->endBlock(); ?>

<?php
/**
 * @var \Framework\Template\php\TemplateRenderer $this
 * @var \App\ReadModel\View\PostView $post
 */

$this->extend('layout/default');
$this->params['title'] = $this->encode($post->title);
?>

<?php $this->beginBlock('meta'); ?>
    <meta name="description" content="<?= $this->encode($post->title) ?>" />
<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs'); ?>
    <ul class="breadcrumb">
        <li><a href="<?= $this->encode($this->path('home')) ?>">Home</a></li>
        <li><a href="<?= $this->encode($this->path('blog-index')) ?>">Blog</a></li>
        <li class="active"><?= $this->encode($post->title) ?></li>
    </ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('content'); ?>

    <h1><?= $this->encode($post->title) ?></h1>

    <div class="panel panel-default">
        <div class="panel-heading">
            <?= $post->date->format('Y-m-d') ?>
        </div>
        <div class="panel-body"><?= nl2br($this->encode($post->content)) ?></div>
    </div>

<?php $this->endBlock(); ?>
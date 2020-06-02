<?php
/**
 * @var \Framework\Template\TemplateRenderer $this
 */
$this->extend("layout/col-9-3");
$this->params['title'] = "About";
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li class="active">About</li>
</ul>
<?php $this->endBlock('breadcrumbs'); ?>


<?php $this->beginBlock('main'); ?>
<div class="jumbotron">
    <h1>About this site!</h1>
    <p>
        This block will contain some information
    </p>
</div>
<?php $this->endBlock('content'); ?>

<?php $this->beginBlock('sidebar'); ?>
<div class="list-group">
    <a href="/cabinet" class="list-group-item list-group-item-action active">
        Some link 1
    </a>
    <a href="/cabinet/edit" class="list-group-item list-group-item-action">Some link 2</a>
    <a href="#" class="list-group-item list-group-item-action disabled">Some link 3</a>
</div>
<?php $this->endBlock('sidebar'); ?>

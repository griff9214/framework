<?php
/**
 * @var \Framework\Template\TemplateRenderer $this
 * @var string $name
 */
$this->extend("layout/col-9-3");
$this->params['title'] = "Cabinet";
?>

<?php $this->beginBlock('breadcrumbs'); ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Cabinet</li>
    </ul>
<?php $this->endBlock('breadcrumbs'); ?>


<?php $this->beginBlock('main'); ?>
<div class="jumbotron">
    <h1>Hello!</h1>
    <p>
        Hello! <?= htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE) ?>.
    </p>
</div>
<?php $this->endBlock('content'); ?>

<?php $this->beginBlock('sidebar'); ?>
<div class="list-group">
    <a href="/cabinet" class="list-group-item list-group-item-action active">
        Cabinet index
    </a>
    <a href="/cabinet/edit" class="list-group-item list-group-item-action">Cabinet Edit</a>
    <a href="#" class="list-group-item list-group-item-action disabled">Disabled link</a>
</div>
<?php $this->endBlock('sidebar'); ?>
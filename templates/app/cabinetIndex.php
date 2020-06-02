<?php
/**
 * @var \Framework\Template\TemplateRenderer $this
 * @var string $name
 */
$this->extend("layout/col-9-3");
$this->params['title'] = "Cabinet";
?>

<?php $this->beginBlock('sidebar'); ?>
<ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Cabinet navi</li>
</ol>
<div class="list-group">
    <a href="/cabinet" class="list-group-item list-group-item-action active">
        Cabinet index
    </a>
    <a href="/cabinet/edit" class="list-group-item list-group-item-action">Cabinet Edit</a>
    <a href="#" class="list-group-item list-group-item-action disabled">Disabled link</a>
</div>
<?php $this->endBlock('sidebar'); ?>

<ul class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li class="active">Cabinet</li>
</ul>
<div class="jumbotron">
    <h1>Hello!</h1>
    <p>
        Hello! <?= htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE) ?>.
    </p>
</div>

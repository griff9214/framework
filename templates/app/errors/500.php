<?php
/**
 * @var \Framework\Template\php\TemplateRenderer $this
 * @var Psr\Http\Message\ServerRequestInterface $request
 * @var array $params
 */

use Framework\Template\php\TemplateRenderer;

$this->params['title'] = "500 - Server Error";
$this->extend("layout/default");
?>

<?php $this->beginBlock('breadcrumbs'); ?>
<ul class="breadcrumb">
    <li><a href="<?= $this->encode($this->path('home')) ?>">Home</a></li>
    <li class="active">500 Error</li>
</ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("content"); ?>
<div class="jumbotron">
    <h1>500 Server ERROR</h1>
    <p>
        Something wrong. Sorry!
    </p>
</div>

<?php $this->endBlock("content");?>


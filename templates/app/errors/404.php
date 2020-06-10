<?php
/**
 * @var \Framework\Template\php\PhpRenderer $this
 * @var Psr\Http\Message\ServerRequestInterface $request
 * @var array $params
 */

use Framework\Template\php\PhpRenderer;

$this->params['title'] = "404 - Not Found";
$this->extend("layout/default");
?>

<?php $this->beginBlock('breadcrumbs'); ?>
    <ul class="breadcrumb">
        <li><a href="<?= $this->encode($this->path('home')) ?>">Home</a></li>
        <li class="active">404 Error</li>
    </ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("content"); ?>
<div class="jumbotron">
    <h1>404 ERROR</h1>
    <p>
        <?= $request->getUri()->getPath() ?> isn't found on this site!
    </p>
</div>

<?php $this->endBlock("content");?>


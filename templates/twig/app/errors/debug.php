<?php
/**
 * @var \Framework\Template\php\PhpRenderer $this
 * @var \Throwable $exception
 * @var array $params
 */

use Framework\Template\php\PhpRenderer;

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
    <h1><?= $exception->getMessage() ?></h1>
    <p>
        Code <?= $exception->getCode() ?>
    </p>
    <p>
         <?= $exception->getFile() ?> on line: <?= $exception->getLine() ?>
    </p>
    <table class="table table-striped table-hover">
        <tbody>
        <?php foreach ($exception->getTrace() as $trace) :?>
        <tr>
            <td><?= $trace['file'] ?></td>
            <td><?= $trace['line'] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $this->endBlock("content");?>


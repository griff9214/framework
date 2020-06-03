<?php
/**
 * @var \Framework\Template\TemplateRenderer $this
 * @var string $name
 *
 **/
$this->extend("layout/default");
$this->params['title'] = "Hello";
?>

<?php $this->beginBlock('content'); ?>
<div class="jumbotron">
    <h1>Hello, <?= $name ?>!</h1>
    <p>
        Congratulations! You have successfully created your application.
    </p>
</div>
<?php $this->endBlock('content'); ?>

<?php
/**
 * @var \Framework\Template\TemplateRenderer $this
**/
$this->extend("layout/default");
$this->params['title'] = "Hello";
?>

<?php $this->beginBlock('content'); ?>
<div class="jumbotron">
    <h1>Hello!</h1>
    <p>
        Congratulations! You have successfully created your application.
    </p>
</div>
<?php $this->endBlock('content'); ?>

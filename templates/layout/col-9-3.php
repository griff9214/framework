<?php
/**
 * @var \Framework\Template\TemplateRenderer $this
 */
$this->extend("layout/default");
?>
<div class="app-content">
    <main class="container">
        <div class="row">
            <div class="col-lg-9">
                <?= $content ?>
            </div>
            <div class="col-lg-3">
                <?= $this->renderBlock('sidebar') ?>
            </div>
        </div>
    </main>
</div>
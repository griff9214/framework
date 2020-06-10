<?php
/**
 * @var \Framework\Template\php\PhpRenderer $this
 */
$this->extend("layout/default");
?>
<?php $this->beginBlock('content'); ?>
<div class="row">
    <div class="col-lg-9">
        <?= $this->renderBlock('main') ?>
    </div>
    <div class="col-lg-3">
        <?php if ($this->ensureBlock('sidebar')): ?>
            <div class="list-group">
                <a href="/cabinet" class="list-group-item list-group-item-action active">
                    Default index
                </a>
                <a href="/cabinet/edit" class="list-group-item list-group-item-action">Cabinet Edit</a>
                <a href="#" class="list-group-item list-group-item-action disabled">Disabled link</a>
            </div>
            <?php $this->endBlock('sidebar'); endif; ?>
        <?= $this->renderBlock('sidebar') ?>
    </div>
</div>
<?php $this->endBlock('content'); ?>

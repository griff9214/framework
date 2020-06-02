<?php
/**
 * @var string $name
 */
?>
<main class="container">
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
</main>

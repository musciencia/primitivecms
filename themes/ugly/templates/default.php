<?php include( getThemeDir() . "/partials/header.php" ); ?>
<hr>
<main>
    <h1><?php echo $page->getTitle() ?></h1>
    <p><?php echo $page->getContent() ?></p>
</main>
<hr>
<?php include( getThemeDir() . "/partials/footer.php" ); ?>
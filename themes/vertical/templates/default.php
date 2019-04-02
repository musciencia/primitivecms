<?php include(getThemeDir() . "/partials/header.php"); ?>
<?php include( getThemeDir() . "/partials/navigation.php" ); ?>

<main>
    <h1><?php echo $page->getTitle() ?></h1>
    <p><?php echo $page->getContent() ?></p>
</main>

<?php include(getThemeDir() . "/partials/footer.php"); ?> 
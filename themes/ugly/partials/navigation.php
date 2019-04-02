<nav>

<?php
foreach ($menuItems as $item) {
?>
    <!-- TODO: add css class for active page -->
    <a href="<?php echo $item->getLink()?>"><?php echo $item->getTitle() ?></a>

<?php
}
?>

</nav>
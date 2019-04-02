<nav>
<div class="brand">
    <?php echo $settings['sitename'] ?>
</div>
    <div class="vertical-menu">
    <?php
    foreach ($menuItems as $item) {
        $active = $item->getLink() == ("?page=" . $page->getCode()) ? 'class="active"': "";
    ?>
    <a href="<?php echo $item->getLink()?> " <?php echo $active ?>><?php echo $item->getTitle() ?></a>

    <?php
    }
    ?>
</div>

</nav>
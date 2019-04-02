
<?php include('admin/partials/header.php') ?>
<?php include('admin/partials/adminNav.php') ?>

<main>

    <?php

    // Include code from the file with name in ?item=page
    // ej. ?item=edit   loads    edit.php
    $menuItem = isset($_GET['item']) ? $_GET['item'] : 'default';
    $filename = "admin/content/$menuItem.php";
    if (!file_exists($filename)) {
        $filename = 'admin/content/default.php';
    }
    include($filename);
    ?>

</main>

<?php include('admin/partials/footer.php') ?> 

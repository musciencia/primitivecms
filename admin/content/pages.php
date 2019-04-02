<?php 


if (isset($_GET['delete'])) {
    $itemId = intval($_GET['delete']);
    Page::deleteById($pdo, $itemId);
}

$pages = Page::loadAll($pdo);


// usort($pages, 'compareId');

?>

<h1>Pages</h1>
<p>Click the edit button to edit your pages.</p>


<table id="pages-table">
    <tr>
        <th>Page Id</th>
        <th>Page Code</th>
        <th>Page Title</th>
        <th class="edit-column">Click to Edit</th>
        <th class="preview-column">Click to Preview</th>
        <th class="delete-column">Delete</th>
    </tr>
    <?php 
    foreach ($pages as $page) {
        ?>
    <tr>
        <td><?php echo $page->getId(); ?></td>
        <td><?php echo $page->getCode(); ?></td>
        <td><?php echo $page->getTitle(); ?></td>
        <td class="edit-column"><a href="?item=edit&page=<?php echo $page->getId() ?>"><i class="fas fa-edit"></i></a></td>
        <td class="preview-column"><a href="../?page=<?php echo $page->getCode() ?>" target="_blank"><i class="fas fa-eye"></i></a></td>
        <td class="delete-column"><a href="?item=pages&delete=<?php echo $page->getId() ?>"><i class="fas fa-trash-alt"></i></a></td>    </tr>
    <?php
}
?>
</table>
<a href="?item=edit&page=new"><button class="submit-button">New Page</button></a>
<?php


?> 
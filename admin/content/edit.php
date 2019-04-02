<?php


$pageId = isset($_GET['page']) ? trim(strip_tags($_GET['page'])) : null;

$page = Page::loadById($pdo, $pageId);
if ( !$page ) {
    $page = new Page();
}

if (isset($_POST['submit'])) {
        if (isset($_POST['title'])) {
            $page->setTitle($_POST['title']);
        }
        if (isset($_POST['template'])) {
            $page->setTemplate($_POST['template']);
        }
        if (isset($_POST['content'])) {
            $page->setContent($_POST['content']);
        }
        if (isset($_POST['code'])) {
            $page->setCode($_POST['code']);
        }
        $page->save($pdo);
        echo 'Record Saved';
    }

?>

<?php 
if (empty($page->getId())) {
    $page->setTemplate('default');
    ?>
<h1>Create New Page</h1>
<p>Enter data for your new page, then click the save button.</p>
<?php

} else {
    ?>
<h1>Edit Mode</h1>
<p>Edit your page, then click the save button.</p>
<?php

}
?>

<script>
    var contentFromDB = '<?php echo $page->getContent() ?>';
</script>

<div id="page-editor">
    <form action="?item=edit&page=<?php echo $pageId; ?>" method="post">
        <input type="hidden" name="content" value="">
        <div class="form-group">
            <label for="title-box">Title</label>
            <input type="text" name="title" id="title-box" value="<?php echo $page->getTitle() ?>">
        </div>

        <div class="form-group">
            <label for="code-box">Page code</label>
            <input type="text" name="code" id="code-box" value="<?php echo $page->getCode() ?>">
        </div>

        <!-- TODO: Template should be a select built from database -->
        <!-- TODO: Currently there is only support for default template, disable when support for templates is provided -->
        <div class="form-group">
            <label for="template-box">Template</label>
            <input type="text" name="template" id="template-box" value="<?php echo $page->getTemplate() ?>" disabled>
        </div>

        <div class="form-group editor">
            <label for="editor">Content</label>
            <div id="editor">

            </div>
        </div>
        <button type="submit" name="submit" value="submit">Save</button>

    </form>

</div>


<?php

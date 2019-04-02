<?php 

if (isset($_GET['new'])) {
  $newItem = new MenuItem();
  $newItem->save($pdo);
} else if (isset($_GET['delete'])) {
  $itemId = intval($_GET['delete']);
  MenuItem::delete($pdo, $itemId);
} else if (isset($_POST['submit'])) { 
  $menuItems = MenuItem::loadAll($pdo);
  foreach ($menuItems as $menuItem) {
    $title = empty($_POST['title' . $menuItem->getId()]) ? '' : trim(strip_tags($_POST['title' . $menuItem->getId()]));
    $link = empty($_POST['link' . $menuItem->getId()]) ? '' : trim(strip_tags($_POST['link' . $menuItem->getId()]));
    $order = empty($_POST['order'. $menuItem->getId()]) ? '' : trim(strip_tags($_POST['order' . $menuItem->getId()]));
    $menuItem->set($title, $link, $order);
    $menuItem->save($pdo);
  }
  echo 'Data saved';
}



$menuItems = MenuItem::loadAll($pdo);
// usort($menuItems, 'compareOrder');

?>


<h1>Menu Items</h1>
<p>Edit your menu items here.</p>

<div>
    <a href="?item=menus&new"><button class="add-button">Add</button></a>
</div>

<form action="?item=menus" method="post">
    <!-- TODO: Change id an add classes to have consitent tables across the admin section -->
    <!-- Using id="pages-table" for now, will change later -->
    <table id="pages-table">
        <tr>
            <th>Menu Item Id</th>
            <th>Menu Title</th>
            <th>Link</th>
            <th class="order-column">Order</th>
            <th class="delete-column">Delete</th>
            <!-- <th class="edit-column">Click to Edit</th> -->
        </tr>
        <?php 
        foreach ($menuItems as $item) {
          ?>
        <tr>
            <td><?php echo $item->getId(); ?></td>
            <td><input type="text" name="title<?php echo $item->getId(); ?>" value="<?php echo $item->getTitle(); ?>"></td>
            <td><input type="text" name="link<?php echo $item->getId(); ?>" value="<?php echo $item->getLink(); ?>"></td>
            <td class="order-column"><input type="number" name="order<?php echo $item->getId(); ?>" value="<?php echo $item->getOrder(); ?>"></td>
            <td class="delete-column"><a href="?item=menus&delete=<?php echo $item->getId() ?>"><i class="fas fa-trash-alt"></i></a></td>
        </tr>
        <?php

      }
      ?>
    </table>

    <button class="submit-button" type="submit" name="submit" value="submit">Save</button>

</form>


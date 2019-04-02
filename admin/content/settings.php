<?php
$settings = Settings::load($pdo);
$themes = getThemeNames();
$pages = Page::loadAll($pdo);


if (
    isset($_POST['home']) && 
    isset($_POST['theme']) &&
    isset($_POST['sitename']) 
) {
    $sitename = trim(strip_tags($_POST['sitename']));
    $home = trim(strip_tags($_POST['home']));
    $theme = trim(strip_tags($_POST['theme']));
    $settings['sitename'] = $sitename;
    $settings['home'] = $home;
    $settings['theme'] = $theme;
    $result = Settings::save($pdo, $settings);
    if ($result == 'success') {
        echo "Settings succesfully saved";
    } else {
        echo "Failed to save settings and click save";
    }
}

?>

<h1>Settings</h1>
<p>Change your settings and save.</p>
<div>
</div>


<div id="settings-editor" class="edit-item">
    <!-- <form action="edit.php" method="post"> -->
    <form action="?item=settings" method="post">
        <div class="form-group">
            <label for="website-name-box">Website Name</label>
            <input type="text" name="sitename" id="website-name-box" value="<?php echo $settings['sitename'] ?>">
        </div>
        <div class="form-group">
            <label for="home-select">Home Page</label>
            <select name="home" id="home-select">
                <?php
                foreach ($pages as $page) {
                    $selected = $settings['home'] == $page->getCode() ? 'selected' : '';
                    echo '<option value="' . $page->getCode() . '" ' . $selected . ' >' .  $page->getCode() . ' - ' . $page->getTitle() . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="theme-select">Theme</label>
            <select name="theme" id="theme-select">
                <?php
                foreach ($themes as $theme) {
                    $selected = $settings['theme'] == $theme ? 'selected' : '';
                    echo '<option value="' . $theme . '" ' . $selected . ' >' . $theme . '</option>';
                }
                ?>
            </select>
        </div>

        <button type="submit" name="save" value="save" class="submit-button">Save</button>

    </form>

</div> 
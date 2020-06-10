<?php 
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

if (!isset($_GET["act"])) {
    ?>
    <p>Would you like to keep the options configured by this plugin?</p>
    <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
        <select name="act">
            <option>Select choice..</option>
            <option value="keep">Keep options</option>
            <option value="delete">Delete options</option>
        </select>
        <input type="submit" value="Go" />
    </form>
    <?php
} else {
        // if the "act" variable has been set, see if the user wants to delete the options..
    if ($_GET["act"] == "delete") {
        delete_option( 'my_options' );
        echo "Options deleted; uninstallation successful.";
        return;
    } else {
            // .. or keep them
        echo "Options kept; uninstallation successful.";
        return;
    }
}
?>
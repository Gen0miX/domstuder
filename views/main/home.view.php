<?php
ob_start() ?>

ICI LA PAGE HOME

<?php
$content = ob_get_clean();
$title = "Home";
require "template-home.php";
?>
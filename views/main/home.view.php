<?php
ob_start() ?>

ICI LA PAGE HOME

<?php
$content = ob_get_clean();
$titre = "Home";
require "template-home.php";
?>
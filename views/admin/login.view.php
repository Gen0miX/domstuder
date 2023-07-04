<?php
ob_start() ?>

ICI LE LOGIN

<?php
$content = ob_get_clean();
$titre = "Login";
require "template-admin.php";
?>
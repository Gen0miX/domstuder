<?php
ob_start() ?>

LOGIN OK !
<?= $_SESSION['Username'] ?>

<button class="btn-login" onclick="window.location.href='<?= URL ?>admin/dc'">Déconecter</button>

<?php
$content = ob_get_clean();
$title = "Panneau de contrôle";
require "template-admin.php";
?>
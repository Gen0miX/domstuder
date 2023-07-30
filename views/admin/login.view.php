<?php
$pass = "Alcoyotte6210";
ob_start() ?>


<div class="login-container center">
    <img class="logo" src="<?= URL ?>public/images/logo_rond.png" alt="Logo Domstuder">

    <form method="POST" action="<?= URL ?>admin/lv" enctype="multipart/form-data" class="form-container">
        <div class="input">
            <span class="material-symbols-outlined icon">
                person
            </span>
            <input class="login" type="text" placeholder="Nom d'utilisateur" name="uname" required>
        </div>

        <div class="input">
            <span class="material-symbols-outlined icon">
                vpn_key
            </span>
            <input class="login" type="password" placeholder="Mot de passe" name="psw" required>
        </div>

        <button type="submit" class="btn-login" href>Login</button>
    </form>

</div>

<?php
$content = ob_get_clean();
$title = "Login";
require "template-admin.php";
?>
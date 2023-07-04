<?php
ob_start() ?>


<div class="main-container center">
    <img src="<?= URL ?>public/images/logo_rond.png" alt="Logo Domstuder">

    <div class="form-container">
        <div class="input">
            <span class="material-symbols-outlined icon">
                account_circle
            </span>
            <input class="login" type="text" placeholder="Nom d'utilisateur" name="uname" required>
        </div>

        <div class="input">
            <span class="material-symbols-outlined icon">
                key
            </span>
            <input class="login" type="password" placeholder="Mot de passe" name="psw" required>
        </div>

        <button type="submit" class="btn-login">Login</button>
    </div>

</div>

<?php
$content = ob_get_clean();
$title = "Login";
require "template-admin.php";
?>
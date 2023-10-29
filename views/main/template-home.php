<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link rel="icon" href="<?= URL ?>/public/images/logos/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rokkitt:wght@400;500;600;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= URL ?>public/css/home.css">
</head>

<div class="link-abso">
    <a href="<?= URL ?>home" class="logo-txt">
        <img src="public/images/logos/logo_petit_b.png" alt="petit logo Domstuder" class="s-logo" id="logo-changer">
        <h2 class="logoH2">Domstuder</h2>
        &nbsp;
    </a>
</div>

<body>
    <?= $content ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
    <script src="<?=URL?>public/js/home.js"></script>
</body>

</html>
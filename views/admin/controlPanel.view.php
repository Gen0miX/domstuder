<?php
//require_once "models/articles/ArticlesManager.class.php";
//$articlesManager = new ArticlesManager();
//$articlesManager->loadArticles();
//echo "<pre>";
//print_r($articles);
//echo "</pre>";
ob_start() ?>

<div class="container text-bg-primary p-3">
    <button class="btn-login" onclick="window.location.href='<?= URL ?>admin/dc'">Déconnecter</button>
    <table class="table text-center table-primary">
        <tr class="table-dark">
            <th>Image</th>
            <th>Titre</th>
            <th>Catégorie</th>
            <th colspan="2">Actions</th>
        </tr>

        <?php
        for ($i = 0; $i < count($articles); $i++):
            $artId = $articles[$i]->getId();
            /*<?= URL ?>public/images/img-art/<?= ?>*/
        ?>
        <tr>
            <td class="align-middle"><img
                    src="<?= URL ?>public/images/img-art/<?= $articles[$i]->getImageMain()->getPath() ?>" width="80px;">
            </td>
            <td class="align-middle">
                <a href="">
                    <?= $articles[$i]->getTitle() ?>
                </a>
            </td>
            <td class="align-middle">
                <?= $articles[$i]->getCategory()->getCategory() ?>
            </td>
            <td class="align-middle"><a href="<?= URL ?>admin/cp/m/<?=$articles[$i]->getId(); ?>"
                    class="btn btn-warning">Modifier</a></td>
            <td class="align-middle">
                <form action="" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet article ?')">
                    <button class="btn btn-danger" type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endfor; ?>
        <form method="POST" action="<?= URL ?>admin/cp/a">
            <button class="btn btn-success fixed" type="submit">
                Ajouter
            </button>
        </form>
    </table>
</div>



<?php
$content = ob_get_clean();
$title = "Panneau de contrôle";
require "template-admin.php";
?>
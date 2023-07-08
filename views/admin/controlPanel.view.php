<?php
require_once "models/categories/CategoriesManager.class.php";
require_once "models/articles/ArticlesManager.class.php";
$articlesManager = new ArticlesManager();
$articlesManager->loadArticles();
echo "<pre>";
print_r($articles);
echo "</pre>";
ob_start() ?>

<div class="control-panel-container">
    <table class="articles">
        <tr class="art-header">
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
                <td class="col img"><img
                        src="<?= URL ?>/public/images/img-art/<?= $articles[$i]->getImageMain()->getPath() ?>"></td>
                <td class="col title">
                    <?= $articles[$i]->getTitle() ?>
                </td>
                <td class="col cat"></td>
                <td class="col btn modify"></td>
                <td class="col btn delete"></td>
            </tr>
        <?php endfor; ?>

    </table>
</div>

<button class="btn-login" onclick="window.location.href='<?= URL ?>admin/dc'">Déconnecter</button>

<?php
$content = ob_get_clean();
$title = "Panneau de contrôle";
require "template-admin.php";
?>
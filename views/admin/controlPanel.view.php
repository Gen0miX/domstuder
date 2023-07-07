<?php
require_once "models/categories/CategoriesManager.class.php";
require_once "models/articles/ArticlesManager.class.php";
$articlesManager = new ArticlesManager();
$articlesManager->loadArticles();
echo "<pre>";
print_r($articlesManager->getArticles());
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
    </table>
</div>

<button class="btn-login" onclick="window.location.href='<?= URL ?>admin/dc'">Déconnecter</button>

<?php
$content = ob_get_clean();
$title = "Panneau de contrôle";
require "template-admin.php";
?>
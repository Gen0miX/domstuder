<?php
$images = $article->getImages();
$modifyUrl = URL."admin/cp/m/".$article->getId();
ob_start() ?>
<div class="container text-bg-primary p-3">
    <div class="mb-3">
        <table class="table text-center table-primary">
            <thead>
                <tr class="table-dark">
                    <th scope="col" class="align-middle">Image</th>
                    <th scope="col">Chemin</th>
                    <th scope="col">Principale</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($images as $img):?>
                <tr>
                    <td class="align-middle">
                        <img src="<?= URL ?>public/images/img-art/<?= $img->getPath() ?>" width="80px;">
                    </td>
                    <td class="align-middle">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                            data-img-path="<?= URL ?>public/images/img-art/<?= $img->getPath() ?>">
                            public/images/img-art/<?=$img->getPath()?>
                        </a>
                    </td>
                    <td class="align-middle"><input type="checkbox" class="form-check-input"
                            <?php if($img->getIsMain() == true){echo "checked";} ?>>
                    </td>
                    <td class="align-middle">
                        <form action="<?=$modifyUrl?>/d/<?= $img->getId() ?>" method="POST"
                            onsubmit="return confirm('Voulez-vous vraiment supprimer cet image ?')">
                            <button class="btn btn-outline-danger round" type="submit">
                                <div class="center-icon">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </div>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <form action="">
            <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Ajouter des images :</label>
                <div class="d-flex">
                    <input class="form-control" type="file" id="formFileMultiple" multiple>
                    <button class="btn btn-primary">Validation</button>
                </div>
            </div>
        </form>
    </div>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Titre : </label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $article->getTitle() ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description : </label>
            <textarea type="text" class="form-control" id="description"
                name="description"><?= $article->getDescription() ?></textarea>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Catégorie : </label>
            <select class="form-select" aria-label="Default select example" name="category" id="category">
                <?php foreach($categories as $cat) {
            echo "<option ";
            if($cat->getId() == $article->getCategory()->getId()){
                echo "selected ";
            }
            $id = $cat->getId();
            $categoryName = $cat->getCategory();
            echo "value='$id'>$categoryName</option>";
        } ?>
            </select>
        </div>
        <input type="hidden" name="identifiant" value="<?= $article->getId() ?>">
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
    <div id="testAjax"></div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img id="imageModalElement" class="imageModalElement" src="" alt="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = "Modifier";
require "template-admin.php";
?>
<?php
//echo "<pre>";
//print_r($graphics);
//echo "</pre>";
ob_start() ?>

<section class="home" id="section1">
    <div class="parallax-container">
        <div class="parallax-row">
            <div class="parallax-image">
                <img src="<?= URL ?>public/images/home/parallax/Amazones.jpg" alt="Affiche Lettres aux Amazones">
            </div>
            <div class="parallax-image">
                <img src="<?= URL ?>public/images/home/parallax/LDS2.jpg" alt="Flyer Lettre de Soie 2">
            </div>

        </div>
        <div class="parallax-row">
            <div class="parallax-image">
                <img src="<?= URL ?>public/images/home/parallax/LDS1.jpg" alt="Flyer Lettre de Soie 1">
            </div>
            <div class="parallax-image">
                <img src="<?= URL ?>public/images/home/parallax/NewYork.jpg" alt="Affiche Cendrars à New York">
            </div>
        </div>
        <div class="parallax-row">
            <div class="parallax-image">
                <img src="<?= URL ?>public/images/home/parallax/Heidi.jpg" alt="Affiche Heidi">
            </div>
            <div class="parallax-image">
                <img src="<?= URL ?>public/images/home/parallax/Castagnier.jpg" alt="Affiche Abbaye de Castagnier">
            </div>
        </div>
    </div>
    <h1>Graphisme <br /> <span class="orange">Design</span> <br /> Illustration</h1>
</section>


<section class="sec-showcase" id="section2">
    <div class="section-content">
        <h2 class="sec-title">Graphisme</h2>
        <div class="showcase">
            <div class="col-1">
                <?php for($i = 1; $i <= 2; $i++) :?>
                <div class="cont-img-showcase graph" art-id="<?= $graphics[$i]->getId() ?>" cat="g">
                    <img src="<?= URL ?>public/images/img-art/<?= $graphics[$i]->getImageMain()->getPath()?>" alt=""
                        class="img-showcase">
                </div>
                <?php  endfor; ?>
            </div>
            <div class="col-2">
                <?php for($i = 3; $i <= 4; $i++):?>
                <div class="cont-img-showcase graph" art-id="<?= $graphics[$i]->getId() ?>" cat="g">
                    <img src="<?= URL ?>public/images/img-art/<?= $graphics[$i]->getImageMain()->getPath()?>" alt=""
                        class="img-showcase">
                </div>
                <?php  endfor; ?>
            </div>
        </div>
        <div class="details">
            <div class="text-animation graph">
                <h2 class="details-title graph">Détails Graphisme</h2>
                <p class="details-summary graph">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur
                    doloremque dolor, odit voluptatum
                    reprehenderit sunt earum.</p>
            </div>
            <div class="show-more">
                <a href="" class="a-shm">
                    Voir plus <span class="material-symbols-outlined">
                        arrow_forward
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="sec-showcase w" id="section3">
    <div class="section-content">
        <h2 class="sec-title">Illustration</h2>
        <div class="showcase">
            <div class="col-1">
                <?php for($i = 1; $i <= 2; $i++) :?>
                <div class="cont-img-showcase illu w" art-id="<?= $illustrations[$i]->getId() ?>" cat="i">
                    <img src="<?= URL ?>public/images/img-art/<?= $illustrations[$i]->getImageMain()->getPath()?>"
                        alt="" class="img-showcase">
                </div>
                <?php  endfor; ?>
            </div>
            <div class="col-2">
                <?php for($i = 3; $i <= 4; $i++):?>
                <div class="cont-img-showcase illu w" art-id="<?= $illustrations[$i]->getId() ?>" cat="i">
                    <img src="<?= URL ?>public/images/img-art/<?= $illustrations[$i]->getImageMain()->getPath()?>"
                        alt="" class="img-showcase">
                </div>
                <?php  endfor; ?>
            </div>
        </div>
        <div class="details">
            <div class="text-animation illu">
                <h2 class="details-title illu">Détails Illustration</h2>
                <p class="details-summary illu">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur
                    doloremque
                    dolor, odit voluptatum
                    reprehenderit sunt earum.</p>
            </div>
            <div class="show-more">
                <a href="" class="a-shm aw">
                    Voir plus <span class="material-symbols-outlined">
                        arrow_forward
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="sec-showcase" id="section4">
    <div class="section-content">
        <h2 class="sec-title">Peinture</h2>
        <div class="showcase">
            <div class="col-1">
                <?php for($i = 1; $i <= 2; $i++) :?>
                <div class="cont-img-showcase paints" art-id="<?= $paintings[$i]->getId() ?>" cat="p">
                    <img src="<?= URL ?>public/images/img-art/<?= $paintings[$i]->getImageMain()->getPath()?>" alt=""
                        class="img-showcase">
                </div>
                <?php  endfor; ?>
            </div>
            <div class="col-2">
                <?php for($i = 3; $i <= 4; $i++):?>
                <div class="cont-img-showcase paints" art-id="<?= $paintings[$i]->getId() ?>" cat="p">
                    <img src="<?= URL ?>public/images/img-art/<?= $paintings[$i]->getImageMain()->getPath()?>" alt=""
                        class="img-showcase">
                </div>
                <?php  endfor; ?>
            </div>
        </div>
        <div class="details">
            <div class="text-animation paints">
                <h2 class="details-title paints">Détails Peinture</h2>
                <p class="details-summary paints">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur
                    doloremque dolor, odit voluptatum
                    reprehenderit sunt earum.</p>
            </div>
            <div class="show-more">
                <a href="" class="a-shm">
                    Voir plus <span class="material-symbols-outlined">
                        arrow_forward
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="presentation" id="section5">
    <div class="pres-content">
        <div class="img">
            <img src="<?= URL ?>public/images/home/dom.jpg" alt="Portrait de Dominique Studer" class="dom-img">
        </div>
        <div class="text-pres">
            <h2 class="section-title">Dominique Studer</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores odio rerum error similique voluptatem
                at
                voluptas qui tempora incidunt, necessitatibus debitis inventore quae sit consequuntur eaque iste quos
                suscipit ipsum sequi commodi deserunt doloremque sunt recusandae sint. Est dolor eligendi amet hic,
                voluptatum ratione? Vel nulla laboriosam, dolorum repudiandae ab repellendus doloribus quae quos,
                officiis
                distinctio voluptate hic? Sint esse atque nihil ipsum. Aut sequi odit quae tenetur harum illo?</p>
            <div class="media">
                <a class="icon-link" href="https://www.linkedin.com/in/dominique-studer-3a7a6b20/" target="_blank">
                    <svg class="icon-media" xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                        viewBox="0 0 24 24">
                        <path
                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                    </svg>
                </a>
                <a class="icon-link" href="https://www.instagram.com/domstuder/" target="_blank">
                    <svg class="icon-media" xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                        viewBox="0 0 24 24">
                        <path
                            d="M15.233 5.488c-.843-.038-1.097-.046-3.233-.046s-2.389.008-3.232.046c-2.17.099-3.181 1.127-3.279 3.279-.039.844-.048 1.097-.048 3.233s.009 2.389.047 3.233c.099 2.148 1.106 3.18 3.279 3.279.843.038 1.097.047 3.233.047 2.137 0 2.39-.008 3.233-.046 2.17-.099 3.18-1.129 3.279-3.279.038-.844.046-1.097.046-3.233s-.008-2.389-.046-3.232c-.099-2.153-1.111-3.182-3.279-3.281zm-3.233 10.62c-2.269 0-4.108-1.839-4.108-4.108 0-2.269 1.84-4.108 4.108-4.108s4.108 1.839 4.108 4.108c0 2.269-1.839 4.108-4.108 4.108zm4.271-7.418c-.53 0-.96-.43-.96-.96s.43-.96.96-.96.96.43.96.96-.43.96-.96.96zm-1.604 3.31c0 1.473-1.194 2.667-2.667 2.667s-2.667-1.194-2.667-2.667c0-1.473 1.194-2.667 2.667-2.667s2.667 1.194 2.667 2.667zm4.333-12h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm.952 15.298c-.132 2.909-1.751 4.521-4.653 4.654-.854.039-1.126.048-3.299.048s-2.444-.009-3.298-.048c-2.908-.133-4.52-1.748-4.654-4.654-.039-.853-.048-1.125-.048-3.298 0-2.172.009-2.445.048-3.298.134-2.908 1.748-4.521 4.654-4.653.854-.04 1.125-.049 3.298-.049s2.445.009 3.299.048c2.908.133 4.523 1.751 4.653 4.653.039.854.048 1.127.048 3.299 0 2.173-.009 2.445-.048 3.298z" />
                    </svg>
                </a>
                <a class="icon-link" href="https://www.facebook.com/domstuder" target="_blank">
                    <svg class="icon-media" xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                        viewBox="0 0 24 24">
                        <path
                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-3 7h-1.924c-.615 0-1.076.252-1.076.889v1.111h3l-.238 3h-2.762v8h-3v-8h-2v-3h2v-1.923c0-2.022 1.064-3.077 3.461-3.077h2.539v3z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean();
$title = "Home";
require "template-home.php";
?>
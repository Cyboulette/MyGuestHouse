<div class="jumbotron text-center">
    <div id="carousel-accueil" class="carousel slideAccueil slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carousel-accueil" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-accueil" data-slide-to="1"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="assets/images/slides/1.jpg" alt="">
            <div class="carousel-caption">
                <div class="full-width text-center">
                    <p>Le meilleur endroit de la région Occitanie !<br/>
                    Profitez de nos chambres rénovées et luxueuses !</p>
                </div>
            </div>
        </div>

        <div class="item">
            <img src="assets/images/slides/2.jpg" alt="">
            <div class="carousel-caption">
                <div class="full-width text-center">
                    <p>Des hôtes au grand ♥</p>
                </div>
            </div>
        </div>
      </div>

      <!-- Controls -->
      <a class="left carousel-control" href="#carousel-accueil" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-accueil" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
</div>

<div class="container">
    <div class="row rooms">
        <div class="col-lg-12 titleRoom">
            <h1 class="colorCustom">Nos chambres</h1>
            <em>Découvrez quelques-unes de nos chambres et leurs tarifs !</em>
        </div>

        <div class="col-lg-12">
            <div class="col-md-3 room">
                <div class="room-img"><img src="assets/images/chambre/photo1.png" class="img-responsive" alt=""></div>
                <div class="room-text">
                    <h2 class="colorCustom">Deluxe Room</h2>
                    <p>Lorem ipsum dolor sit amet, consect etur adipisicing elit, sed do eiusmod ipsum dolor sit amet</p>
                    <div class="room-buttons">
                        <a href="single-room.html" class="btn btn-lg btn-red bgCustom">Détails</a>
                        <p class="colorCustom">50 € <span>Par nuit</span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 room">
                <div class="room-img"><img src="assets/images/chambre/photo2.png" class="img-responsive" alt=""></div>
                <div class="room-text">
                    <h2 class="colorCustom">Deluxe Room</h2>
                    <p>Lorem ipsum dolor sit amet, consect etur adipisicing elit, sed do eiusmod ipsum dolor sit amet</p>
                    <div class="room-buttons">
                        <a href="single-room.html" class="btn btn-lg btn-red bgCustom">Détails</a>
                        <p class="colorCustom">50 € <span>Par nuit</span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 room">
                <div class="room-img"><img src="assets/images/chambre/photo3.png" class="img-responsive" alt=""></div>
                <div class="room-text">
                    <h2 class="colorCustom">Deluxe Room</h2>
                    <p>Lorem ipsum dolor sit amet, consect etur adipisicing elit, sed do eiusmod ipsum dolor sit amet</p>
                    <div class="room-buttons">
                        <a href="single-room.html" class="btn btn-lg btn-red bgCustom">Détails</a>
                        <p class="colorCustom">50 € <span>Par nuit</span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 room">
                <div class="room-img"><img src="assets/images/chambre/photo1.png" class="img-responsive" alt=""></div>
                <div class="room-text">
                    <h2 class="colorCustom">Deluxe Room</h2>
                    <p>Lorem ipsum dolor sit amet, consect etur adipisicing elit, sed do eiusmod ipsum dolor sit amet</p>
                    <div class="room-buttons">
                        <a href="single-room.html" class="btn btn-lg btn-red bgCustom">Détails</a>
                        <p class="colorCustom">50 € <span>Par nuit</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row rooms">
        <div class="col-lg-12 titleRoom">
            <h1 class="colorCustom">Nos Prestations</h1>
            <em>Vous ne louez pas seulement une chambre ! Mais aussi des prestations</em>
        </div>

        <div class="col-lg-12">
            <div class="col-lg-6">
                <p>
                    Découvrez au sein de notre chambre d'hôtes des prestations qui pourront accompagner votre séjour chez nous !<br/>
                    Ces prestations peuvent-être directement comprises dans la formule d'hébergement, afin de correspondre au mieux à <b>vos besoins</b><br/><br/>
                    Retrouvez donc un service amélioré dans nos chambres d'hôtes !
                </p>
                <btn class="btn btn-red bgCustom">En savoir +</btn>
            </div>
            <div class="col-lg-6 text-center">
                <div class="col-md-5">
                    <div class="service">
                        <h2><i class="fa fa-cutlery" aria-hidden="true"></i></h2>
                        <b>Restaurant</b>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="service">
                        <h2><i class="fa fa-tint" aria-hidden="true"></i></h2>
                        <b>Piscine</b>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        if($display_news == 'true') { 
    ?>
    <div class="row rooms">
        <div class="col-lg-12 titleRoom">
            <h1 class="colorCustom">Notre actualité</h1>
            <em>Découvrez les dernières nouveautés de notre chambre d'hôtes !</em>
        </div>

        <div class="col-lg-12">
            <?php
                setlocale(LC_ALL, 'fr_FR');
                foreach ($listNews as $news) {
                if($news->get('publie') == 1) {
                $date = date_create($news->get('dateNews'));
                $dateDisplay = date_format($date, 'd M');
            ?>
                <div class="col-lg-6 news">
                    <div class="col-md-2 text-center">
                        <div class="calendar bgCustom">
                            <?=$dateDisplay?>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <b><?=$news->get('titreNews')?></b><br/>
                        <a href="index.php?controller=news&action=read&idNews=1" class="btn btn-red btn-xs bgCustom">Lire la news</a>
                    </div>
                    <hr/>
                </div>
            <?php } } ?>
        </div>
    </div>
    <?php } ?>
</div>







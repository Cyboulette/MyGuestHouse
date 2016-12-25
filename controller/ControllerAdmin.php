<?php
/*
RENDU INUTILE GRÂCE A L'AUTOLOADER :)
require_once File::build_path(array('model', 'ModelUtilisateur.php'));
require_once File::build_path(array('model', 'ModelChambre.php'));
require_once File::build_path(array('model', 'ModelOption.php'));
require_once File::build_path(array('model', 'ModelReservation.php'));
require_once File::build_path(array('model', 'ModelPrestation.php'));
require_once File::build_path(array('model', 'ModelNews.php'));
require_once File::build_path(array('model', 'ModelSlides.php'));
*/

class ControllerAdmin {
    protected static $object = 'admin';

    public static function isAdmin() {
        if(ControllerUtilisateur::isConnected()) {
            $currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
            if($currentUser->getPower() != Conf::$power['admin']) {
                ControllerDefault::error('Vous ne possédez pas les droits pour accéder à cette page !');
                exit();
            } else {
                return true;
            }
        } else {
            ControllerDefault::error('Vous devez être connecté pour accéder à l\'administration');
            exit();
        }
    }

    // Charge l'index de l'administration
    public static function index() {
        $powerNeeded = self::isAdmin();
        $view = 'index';
        $pagetitle = 'Administration';
        $template = 'admin';
        require File::build_path(array('view', 'main_view.php'));
    }


    // OPTIONS -----------------------------------------------
    public static function options($message = NULL) {
        $powerNeeded = self::isAdmin();
        $view = 'listOptions';
        $pagetitle = 'Administration - Options du site';
        $template = 'admin';
        $tab_options = ModelOption::selectAll();
        require_once File::build_path(array("view","main_view.php"));
    }
    public static function updateOptions() {
        $powerNeeded = self::isAdmin();
        if(isset($_POST['name_site'],$_POST['display_news'],$_POST['mainColor'])) {
            $name_site = strip_tags($_POST['name_site']);
            $display_news = strip_tags($_POST['display_news']);
            $mainColor = strip_tags($_POST['mainColor']);
            if(!preg_match('/^#[a-f0-9]{6}$/i', $mainColor)) // Vérifie que la couleur est la bonne.
            {
                $mainColor = "#ad1717";
            }
            $vars = array(
                'nom_site' => $name_site,
                'display_news' => $display_news,
                'main_color_site' => $mainColor
            );
            foreach ($vars as $var => $value) {
                $data = array(
                    'valueOption' => $value,
                    'nameOption' => $var
                );
                $update = ModelOption::update_gen($data, 'nameOption');
            }
            if($update != false) {
                $message = '<div class="alert alert-success">Options modifiées avec succès !</div>';
            } else {
                $message = '<div class="alert alert-danger">Impossible de modifier l\'option !</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Merci d\'envoyer toutes les données du formulaire !</div>';
        }
        self::options($message);
    }


    // UTILISATEURS -----------------------------------------------
    // Gestion des utilisateurs : view/admin/viewAllUtilisateur.php
    public static function utilisateur(){// il faut mettre utilisateurs ... avec un s /!\
        if(ControllerUtilisateur::isConnected()) {
            $currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
            $powerNeeded = ($currentUser->getPower() == Conf::$power['admin']);
            $view = 'utilisateur';
            $pagetitle = 'Administration - Gestion des utilisateurs';
            $template = 'admin';
            $tab_v = ModelUtilisateur::selectAll();
            require_once File::build_path(array("view", "main_view.php"));
        } else {
            ControllerDefault::error('Vous ne pouvez pas accéder à cette page sans être connecté !');
        }
    }


    // CHAMBRES -----------------------------------------------
    // Affiche la liste des chambres : view/amin/listChambres.php
    public static function chambres($message = null) {
        $powerNeeded = self::isAdmin();
        //----------
        $view = 'listChambres';
        $pagetitle = 'Administration - Liste des chambres';
        $template = 'admin';
        $tab_chambres = ModelChambre::selectAll();
        require_once File::build_path(array("view","main_view.php"));
    }
    public static function addChambre(){
        $powerNeeded = self::isAdmin();
        //----------
        $view = 'addChambre';
        $pagetitle = 'Administration - Ajouter une chambre';
        $template = 'admin';

        require_once File::build_path(array("view","main_view.php"));
    }
    public static function addedChambre(){
        // TODO :
        $powerNeeded = self::isAdmin();
        //----------
        if(isset($_POST['nom']) && isset($_POST['prix']) && isset($_POST['superficie']) && isset($_POST['description'])){

            if($_POST['nom']!=null && $_POST['prix']!=null && $_POST['superficie']!=null && $_POST['description']!=null){

                if($_POST['prix']>=0 && $_POST['superficie']>=0){
                    // TODO : --------
                    $laChambre = array(
                        'idChambre' => NULL,
                        'nomChambre' => $_POST['nom'],
                        'descriptionChambre' => $_POST['description'],
                        'prixChambre' => $_POST['prix'],
                        'superficieChambre' => $_POST['superficie'],
                    );
                    $save = ModelChambre::save($laChambre);
                    if($save!=false){
                        $message = '<div class="alert alert-success">Chambre ajoutée avec succès !</div>';
                    }else{
                        $message = '<div class="alert alert-danger">Nous n\'avons pas pu procéder à la creation de la chambre !</div>';
                    
                    }
                }else{
                    $message = '<div class="alert alert-danger">Vous ne pouvez pas avoir un prix ou une seperficie inferieur a zero !</div>';
                }
            }else{
                $message = '<div class="alert alert-danger">Vous ne pouvez pas laisser de champ vide avoir un prix ou une seperficie inferieur a zero !</div>';
            }   
        }else{
            $message = '<div class="alert alert-danger">Vous ne pouvez pas acceder à la modification sans passer par la vue de modification !</div>';
        }
        self::chambres($message);
    }
    public static function editChambre(){
        $powerNeeded = self::isAdmin();
        //----------
        $view = 'editChambre';
        $pagetitle = 'Administration - Editeur de chambre';
        $template = 'admin';
        
        if(isset($_GET['idChambre'])){
            $chambre = ModelChambre::select($_GET['idChambre']);

            if($chambre!=false){
                require_once File::build_path(array("view","main_view.php"));
            }else{
                $message = '<div class="alert alert-danger">Cette chambre n\'existe plus !</div>';
                self::chambres($message);
            }
        }else{
            $message = '<div class="alert alert-danger">Vous ne pouvez pas modifier une chambre sans connaitre son ID !</div>';
            self::chambres($message);
        }
    }  
    public static function editedChambre(){
        $powerNeeded = self::isAdmin();
        //----------
        if(isset($_POST['nom']) && isset($_POST['prix']) && isset($_POST['superficie']) && isset($_POST['description'])){

            if($_POST['nom']!=null && $_POST['prix']!=null && $_POST['superficie']!=null && $_POST['description']!=null){

                if($_POST['prix']>=0 && $_POST['superficie']>=0){
                    // TODO : --------
                    $laChambre = array(
                        'idChambre' => $_POST['id'],
                        'nomChambre' => $_POST['nom'],
                        'descriptionChambre' => $_POST['description'],
                        'prixChambre' => $_POST['prix'],
                        'superficieChambre' => $_POST['superficie'],
                    );
                    $update = ModelChambre::update_gen($laChambre, 'idChambre');
                    if($update!=false){
                        $message = '<div class="alert alert-success">Chambre modifiées avec succès !</div>';
                    }else{
                        $message = '<div class="alert alert-danger">Nous n\'avons pas pu procéder à la mise a jour de la chambre !</div>';
                    }
                }else{
                    $message = '<div class="alert alert-danger">Vous ne pouvez pas avoir un prix ou une seperficie inferieur a zero !</div>';
                }
            }else{
                $message = '<div class="alert alert-danger">Vous ne pouvez pas laisser de champ vide avoir un prix ou une seperficie inferieur a zero !</div>';
            }   
        }else{
            $message = '<div class="alert alert-danger">Vous ne pouvez pas acceder à la modification sans passer par la vue de modification !</div>';
        }
        self::chambres($message);
    }
    public static function deleteChambre() {
        $powerNeeded = self::isAdmin();
        //----------
        // Attend un $_GET['idChambre']
        if (isset($_GET['idChambre']) && $_GET['idChambre']!=null) {
            $idChambre = $_GET['idChambre'];
            if(ModelChambre::select($idChambre)!=null){
                if(ModelChambre::delete($idChambre)){
                    $message = '<div class="alert alert-success">La suppresion de la chambre a été effectuée avec succes !</div>';
                }else{
                    $message = '<div class="alert alert-danger">Un probleme est survenue lors de la suppression de la chambre !</div>';
                }
            }else{
                $message = '<div class="alert alert-danger">Cette chambre n\'existe deja plus !</div>';
            }
        }else{
            $message = '<div class="alert alert-danger">Vous ne pouvez pas supprimer une chambre sans connaitre son ID !</div>';
        }
        self::chambres($message);
    }


    // DETAILS ----------------------------------------------- //---FINISHED CRUD---// 
    public static function details($message = null){
        $powerNeeded = self::isAdmin();
        //----------
        $view = 'listDetails';
        $pagetitle = 'Administration - Options du site';
        $template = 'admin';
        $tab_allDetails = ModelDetail::selectAll();
        require_once File::build_path(array("view","main_view.php"));
    }
    public static function addDetail(){
        $powerNeeded = self::isAdmin();
        //----------
        $view = 'addDetail';
        $pagetitle = 'Administration - Ajout de détail';
        $template = 'admin';
        require_once File::build_path(array("view","main_view.php"));
    }
    public static function addedDetail(){
        $powerNeeded = self::isAdmin();
        //----------
        if(isset($_POST['nomDetail'])){
            if($_POST['nomDetail']!=null){
                $leDetail = array(
                    'idDetail' => null,
                    'nomDetail' => $_POST['nomDetail'],
                );
                $save = ModelDetail::save($leDetail);
                if($save != false) {
                    $message = '<div class="alert alert-success">Détail ajoutée avec succès !</div>';
                }else{
                    $message = '<div class="alert alert-danger">Echec de l\'ajout du détail !</div>';
                }
            }else{
                $message = '<div class="alert alert-danger">vous ne pouvez pas laisser un champ vide !</div>';
            }
        }else{
            $message = '<div class="alert alert-danger">Nous navons pas pu recuperer vos choix !</div>';
        }
        self::details($message);
    }
    public static function editDetail(){
        $powerNeeded = self::isAdmin();
        //----------
        if(isset($_GET['idDetail']) && $_GET['idDetail']!=null){
            $detail = ModelDetail::select($_GET['idDetail']);
            if($detail!=false){
                $view = 'editDetail';
                $pagetitle = 'Administration - modifier un détail';
                $template = 'admin';
                require_once File::build_path(array("view", "main_view.php"));
            }else{
                $message = '<div class="alert alert-danger">Ce détail n\'existe plus !</div>';
                self::details($message);
            }
        }else{
            $message = '<div class="alert alert-danger">Nous navons pas pu recuperer vos choix !</div>';
            self::details($message);
        }
    }
    public static function editedDetail(){
        $powerNeeded = self::isAdmin();
        //----------
        if(isset($_POST['idDetail']) && $_POST['idDetail']!=null) {
            $detail = ModelDetail::select($_POST['idDetail']);
            if($detail!=false){
                if(isset($_POST['nomDetail']) && $_POST['nomDetail']!=null){
                        $id = $_POST['idDetail'];
                        $nom = $_POST['nomDetail'];
                        $dataDetail = array(
                            'nomDetail' => $nom,
                            'idDetail' => $id,
                        );
                        $update = ModelDetail::update_gen($dataDetail, 'idDetail');
                        if($update != false) {
                            $message = '<div class="alert alert-success">Détail modifiée avec succès !</div>';
                        } else {
                            $message = '<div class="alert alert-danger">Echec de la modification du détail !</div>';
                        }
                }else{
                    $message = '<div class="alert alert-danger">Vous ne pouvez pas laisser un champ vide !</div>';
                }
            }else{
                $message = '<div class="alert alert-danger">Ce détail n\'existe plus !</div>';
            }
        }else{
            $message = '<div class="alert alert-danger">Nous navons pas pu recuperer vos choix !</div>';
        }
        self::details($message);
    }
    public static function manageDetails() {
        $powerNeeded = self::isAdmin();
        //----------
        if(isset($_GET['idChambre']) && $_GET['idChambre']!=NULL){
            $chambre = ModelChambre::select($_GET['idChambre']);
            if($chambre!=null){
                $view = 'detailFor';
                $pagetitle = 'Administration - Editeur de chambre';
                $template = 'admin';
                $idChambre = $_GET['idChambre'];
                $tab_detail = ModelDetail::selectAllByChambre($_GET['idChambre']);
                $tab_allDetails = ModelDetail::selectAll();
                require_once File::build_path(array("view", "main_view.php"));
            }else{
                $message = '<div class="alert alert-danger">Cette chambre n\'existe plus !</div>';
                self::chambres($message);
            }
        }else{
            $message = '<div class="alert alert-danger">Vous ne pouvez modifier les détails d\'une chambre sans connaître son ID !</div>';
            self::chambres($message);
        }
    }
    public static function managedDetail(){
        $powerNeeded = self::isAdmin();
        //----------
        if(isset($_POST['idChambre']) && $_POST['idChambre']!=null){
            $idChambre = $_POST['idChambre'];

            $update = ModelDetail::deleteAllByChambre($idChambre); //TODO vérifier si true
            if($update){
                foreach ($_POST as $key => $value){
                    $valeur = substr($key, 0, 7);

                    if($valeur!="valeur_"){
                        $todo = false;
                    }else{
                        $todo = true;
                    }

                    if($todo){
                        $idDetail = str_replace("valeur_", "", $key);
                        $update = ModelDetail::saveByChambre($idChambre, $idDetail, $value);
                    }

                    if($update == false){
                        $message = '<div class="alert alert-danger">Echec de la modification de la prestation !</div>';
                        self::chambres($message);
                        exit();
                    }
                }
            }
            if($update != false){
                $message = '<div class="alert alert-success">Détail modifiée avec succès !</div>';
            }else{
                $message = '<div class="alert alert-danger">Echec de la modification de du détail !</div>';
            }
        }else{
            $message = '<div class="alert alert-danger">Vous ne pouvez modifier les détails d\'une chambre sans connaître son ID !</div>';
        }
        self::chambres($message);
    }


    // PRESTATIONS ----------------------------------------------- //---FINISHED CRUD---// 
    public static function prestations($message = null){
        $powerNeeded = self::isAdmin();
        //----------
        $view = 'listPrestations';
        $pagetitle = 'Administration - Options du site';
        $template = 'admin';
        $tab_allPrestation = ModelPrestation::selectAll();
        require_once File::build_path(array("view","main_view.php"));
    }
    public static function addPrestation(){
        $powerNeeded = self::isAdmin();
        //----------
        $view = 'addPrestation';
        $pagetitle = 'Administration - Ajout prestation';
        $template = 'admin';
        require_once File::build_path(array("view","main_view.php"));
    }
    public static function addedPrestation(){
        $powerNeeded = self::isAdmin();
        //----------
        if(isset($_POST['nomPrestation']) && isset($_POST['prix'])){
            if($_POST['nomPrestation']!=null && $_POST['prix']!=null){
                if($_POST['prix']>= 0){
                    $laPrestation = array(
                        'idPrestation' => null,
                        'nomPrestation' => $_POST['nomPrestation'],
                        'prix' => $_POST['prix'],
                    );
                    $save = ModelPrestation::save($laPrestation);
                    if($save != false) {
                        $message = '<div class="alert alert-success">Prestation ajoutée avec succès !</div>';
                    }else{
                        $message = '<div class="alert alert-danger">Echec de l\'ajout de la prestation !</div>';
                    }
                }else{
                    $message = '<div class="alert alert-danger">Vous ne pouvez pas proposer un prix negatif !</div>';
                }
            }else{
                $message = '<div class="alert alert-danger">vous ne pouvez pas laisser un champ vide !</div>';
            }
        }else{
            $message = '<div class="alert alert-danger">Nous navons pas pu recuperer vos choix !</div>';
        }
        self::prestations($message);
    }
    public static function editPrestation(){
        $powerNeeded = self::isAdmin();
        //----------
        if(isset($_GET['idPrestation']) && $_GET['idPrestation']!=null){
            $prestation = ModelPrestation::select($_GET['idPrestation']);
            if($prestation!=false){
                $view = 'editPrestation';
                $pagetitle = 'Administration - modifier ue prestation';
                $template = 'admin';
                require_once File::build_path(array("view", "main_view.php"));
            }else{
                $message = '<div class="alert alert-danger">cette prestation n\'existe plus !</div>';
                self::prestations($message);
            }
        }else{
            $message = '<div class="alert alert-danger">vous ne pouvez pas modifier une prestation sans connaitre son ID !</div>';
            self::prestations($message);
        }
    }
    public static function editedPrestation(){
        $powerNeeded = self::isAdmin();
        //----------
        if(isset($_POST['idPrestation']) && $_POST['idPrestation']!=null) {
            $prestation = ModelPrestation::select($_POST['idPrestation']);
            if($prestation!=false){
                if(isset($_POST['nomPrestation']) && isset($_POST['prix'])
                    && $_POST['nomPrestation']!=null && $_POST['prix']!=null){
                    if($_POST['prix']>= 0){
                        $id = $_POST['idPrestation'];
                        $nom = $_POST['nomPrestation'];
                        $prix = $_POST['prix'];
                        $dataPrestation = array(
                            'nomPrestation' => $nom,
                            'prix' => $prix,
                            'idPrestation' => $id,
                        );
                        $update = ModelPrestation::update_gen($dataPrestation, 'idPrestation');
                        if($update != false) {
                            $message = '<div class="alert alert-success">Prestation modifiée avec succès !</div>';
                        } else {
                            $message = '<div class="alert alert-danger">Echec de la modification de la prestation !</div>';
                        }
                    }else{
                        $message = '<div class="alert alert-danger">Vous ne pouvez pas proposer un prix negatif !</div>';
                    }
                }else{
                    $message = '<div class="alert alert-danger">vous ne pouvez pas laisser un champ vide !</div>';
                }
            }else{
                $message = '<div class="alert alert-danger">cette prestation n\'existe plus !</div>';
            }
        }else{
            $message = '<div class="alert alert-danger">vous ne pouvez pas modifier une prestation sans connaître son ID !</div>';
        }
        self::prestations($message);
    }
    public static function managePrestations(){
        $powerNeeded = self::isAdmin();
        //----------
        if(isset($_GET['idChambre']) && $_GET['idChambre']!=NULL){
            $chambre = ModelChambre::select($_GET['idChambre']);
            if($chambre!=null){
                $view = 'prestationFor';
                $pagetitle = 'Administration - Editeur de chambre';
                $template = 'admin';
                $idChambre = $_GET['idChambre'];
                $tab_prestation = ModelPrestation::selectAllByChambre($_GET['idChambre']);
                $tab_allPrestation = ModelPrestation::selectAll();
                require_once File::build_path(array("view", "main_view.php"));
            }else{
                $message = '<div class="alert alert-danger">Cette chambre n\'existe plus !</div>';
                self::chambres($message);
            }
        }else{
            $message = '<div class="alert alert-danger">Vous ne pouvez modifier les prestations d\'une chambre sans connaître son ID !</div>';
            self::chambres($message);
        }
    }
    public static function managedPrestation(){
        $powerNeeded = self::isAdmin();
        //----------
        if(isset($_POST['idChambre']) && $_POST['idChambre']!=null){
            $idChambre = $_POST['idChambre'];
            $prestation = $_POST['prestations'];
            $update = true;
            $update = ModelPrestation::deleteAllByChambre($idChambre); //TODO vérifier si true
            if ($prestation!=null) {
                foreach ($prestation as $key => $value) {
                    $update = ModelPrestation::saveByChambre($idChambre, $prestation[$key]);
                }
            }
            if($update != false) {
                $message = '<div class="alert alert-success">Prestation modifiée avec succès !</div>';
            } else {
                $message = '<div class="alert alert-danger">Echec de la modification de la prestation !</div>';
            }
        }else{
            $message = '<div class="alert alert-danger">Vous ne pouvez modifier les prestations d\'une chambre sans connaître son ID !</div>';
        }
        self::chambres($message);
    }


    // THEMES --------------------------------------
    // Fonction qui permet de lister les thèmes
    public static function themes($message = NULL) {
        $powerNeeded = self::isAdmin();
        $view = 'listThemes';
        $pagetitle = 'Administration - Gestion des thèmes de votre site';
        $template = 'admin';
        $folders = scandir(File::build_path(array("view", "themes")));
        require_once File::build_path(array("view", "main_view.php"));
    }
    // Fonction qui gère le formulaire de confirmation de changement de theme
    public static function changeThemeForm() {
        self::isAdmin();
        $retour = array(); //Tableau de retour
        if(isset($_POST['nameTheme'])) {
            $nameTheme = htmlspecialchars($_POST['nameTheme']);
            $filePath = File::build_path(array('view', 'themes', $nameTheme, 'template.json'));
            if(file_exists($filePath)) {
                $form = '<form method="POST" role="form" action="index.php?controller=admin&action=changeTheme">
                    <div class="alert alert-info text-center">
                        Confirmez vous le changement de thème vers le thème <b>'.$nameTheme.'</b> ?
                    </div>
                    <input type="hidden" name="nameTheme" value="'.$nameTheme.'">
                    <input type="hidden" name="confirm" value="true">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Confirmer</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Annuler">Annuler</button>
                    </div>
                </form>';
                $retour['result'] = true;
                $retour['message'] = $form;
            } else {
                $retour['result'] = false;
                $retour['message'] = '<div class="alert alert-danger">Le thème demandé n\'existe pas !</div>';
            }
        } else {
            $retour['result'] = false;
            $retour['message'] = '<div class="alert alert-danger">Vous n\'avez pas envoyé correctement les données !</div>';
        }
        echo json_encode($retour);      
    }
    // Fonction qui effectue le changement de thème dans la BDD
    public static function changeTheme() {
        self::isAdmin();
        if(isset($_POST['nameTheme'], $_POST['confirm'])) {
            $nameTheme = htmlspecialchars($_POST['nameTheme']);
            $confirm = htmlspecialchars($_POST['confirm']);
            $filePath = File::build_path(array('view', 'themes', $nameTheme, 'template.json'));
            if(file_exists($filePath)) {
                if($confirm == true) {
                    $data = array(
                        'nameOption' => 'theme_site',
                        'valueOption' => $nameTheme
                    );
                    $checkUpdateOption = ModelOption::update_gen($data, 'nameOption');
                    if($checkUpdateOption) {
                        $message = '<div class="alert alert-success">Le thème a bien été changé !</div>';
                    } else {
                        $message = '<div class="alert alert-danger">Impossible d\'enregistrer le changement de thème !</div>';
                    }
                } else {
                    $message = '<div class="alert alert-danger">Vous devez confirmer le changement de thème !</div>';
                }
            } else {
                $message = '<div class="alert alert-danger">Ce thème n\'existe pas !</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Merci de remplir correctement le formulaire de changement de thème !</div>';
        }
        self::themes($message);
    }

    // SLIDER ------------------------------------------------
    // Fonction qui permet de lister les news
    public static function slides($message = NULL) {
        $powerNeeded = self::isAdmin();
        $view = 'listSlides';
        $pagetitle = 'Administration - Gestion des images défilantes';
        $template = 'admin';
        $tab_slides = ModelSlides::selectAll();
        require_once File::build_path(array("view", "main_view.php"));
    }
    // Fonction qui permet de gérer les slides (ajout ou modification)
    public static function manageSlides($message = NULL) {
        if(isset($_GET['type'])) {
            $type = $_GET['type'];
            if($type == "add" || $type == "edit") {
                if($type == "add") {
                    $titreAction = 'Ajouter une image défilante';
                } elseif($type == "edit") {
                    $titreAction = 'Modifier une image défilante';
                    if(isset($_GET['idSlide']) && !empty($_GET['idSlide'])) {
                        $idSlide = htmlspecialchars($_GET['idSlide']);
                        $readSlide = ModelSlides::select($idSlide);
                        if(!$readSlide) {
                            self::news('<div class="alert alert-danger">Impossible de modifier cette image, elle n\'existe pas !</div>');
                        }
                    } else {
                        self::news('<div class="alert alert-danger">Pour pouvoir modifier une image il faut son ID</div>');
                    }
                }
                $powerNeeded = self::isAdmin();
                $view = 'manageSlides';
                $template = 'admin';
                $tab_slides = ModelSlides::selectAll();
                $pagetitle = 'Administration - '.$titreAction;
                require_once File::build_path(array("view", "main_view.php"));
            } else {
                ControllerDefault::error('Vous devez préciser si vous souhaitez modifier ou ajouter une image !', 'admin');
            }
        } else {
            ControllerDefault::error('Il faut préciser un paramètre de type de gestion des images !', 'admin');
        }
    }
    // Fonction qui ajoute une slide
    public static function addSlide() {
        self::isAdmin();
        if(isset($_POST['urlSlide']) || isset($_FILES['urlSlide'])) {
            if(isset($_FILES['urlSlide']) && !empty($_FILES['urlSlide']['name'])) {
                $image = $_FILES['urlSlide'];
                $extensionsOK = array('jpg', 'jpeg', 'gif', 'png');
                $extensionUpload = strtolower(substr(strrchr($image['name'], '.'), 1));
                if (in_array($extensionUpload, $extensionsOK)) {
                    $dir = "assets/images/slides/image_upload_" . time() . ".png";
                    $resultat = move_uploaded_file($image['tmp_name'], $dir);
                    if($resultat) {
                        $urlSlide = $dir;
                    } else {
                        $message = '<div class="alert alert-danger">Impossible d\'ajouter l\'image, veuillez réessayer</div>';
                    }
                } else {
                    $message = '<div class="alert alert-danger">Assurez-vous d\'envoyer une image au format : jpg ou png ou gif</div>';
                }
            } else {
                $urlSlide = htmlspecialchars($_POST['urlSlide']);
            }
            if(!isset($message) && empty($message) && isset($urlSlide) && !empty($urlSlide) && !ctype_space($urlSlide)) {
                if(isset($_POST['textSlide']) && !empty($_POST['textSlide']) && !ctype_space($_POST['textSlide'])) {
                    $textSlide = htmlspecialchars($_POST['textSlide']);
                } else {
                    $textSlide = NULL;
                }
                $nameImage = str_replace("assets/images/slides/", "", $urlSlide);

                $data = array(
                    'idSlide' => NULL,
                    'urlSlide' => $urlSlide,
                    'textSlide' => $textSlide
                );
                $testSaveSlide = ModelSlides::save($data);
                if($testSaveSlide) {
                    $message = '<div class="alert alert-success">L\'image a bien été ajoutée !</div>';
                    self::slides($message);
                    exit(); // On ne veut pas que le code self::manageNews s'exécute :)
                } else {
                    $urlVerify = File::build_path(array('assets', 'images', 'slides', $nameImage));
                    if(file_exists($urlVerify)) {
                        unlink($urlVerify);
                    }
                    $message = '<div class="alert alert-danger">Merci de contacter le support de MyGuestHouse !</div>';
                }
            }
        } else {
            $message = '<div class="alert alert-danger">Aucune donnée transmise</div>';
        }
        self::manageSlides($message);
    }
    // Fonction qui édite une slide
    public static function editSlide() {
        self::isAdmin();
        if(isset($_POST['urlSlide']) || isset($_FILES['urlSlide']) && isset($_POST['idSlide'])) {
            $idSlide = htmlspecialchars($_POST['idSlide']);
            $getSlide = ModelSlides::select($idSlide);
            if($getSlide != false) {
                if(isset($_FILES['urlSlide']) && !empty($_FILES['urlSlide']['name'])) {
                    $image = $_FILES['urlSlide'];
                    $extensionsOK = array('jpg', 'jpeg', 'gif', 'png');
                    $extensionUpload = strtolower(substr(strrchr($image['name'], '.'), 1));
                    if (in_array($extensionUpload, $extensionsOK)) {
                        $dir = "assets/images/slides/image_upload_" . time() . ".png";
                        $resultat = move_uploaded_file($image['tmp_name'], $dir);
                        if($resultat) {
                            $urlSlide = $dir;
                        } else {
                            $message = '<div class="alert alert-danger">Impossible d\'ajouter l\'image, veuillez réessayer</div>';
                        }
                    } else {
                        $message = '<div class="alert alert-danger">Assurez-vous d\'envoyer une image au format : jpg ou png ou gif</div>';
                    }
                } else {
                    $urlSlide = htmlspecialchars($_POST['urlSlide']);
                }
                if(!isset($message) && empty($message) && isset($urlSlide) && !empty($urlSlide) && !ctype_space($urlSlide)) {
                    if(isset($_POST['textSlide']) && !empty($_POST['textSlide']) && !ctype_space($_POST['textSlide'])) {
                        $textSlide = htmlspecialchars($_POST['textSlide']);
                    } else {
                        $textSlide = NULL;
                    }
                    $nameImage = str_replace("assets/images/slides/", "", $urlSlide);

                    $data = array(
                        'idSlide' => $idSlide,
                        'urlSlide' => $urlSlide,
                        'textSlide' => $textSlide
                    );
                    $testUpdateSlide = ModelSlides::update_gen($data, 'idSlide');
                    if($testUpdateSlide) {
                        $message = '<div class="alert alert-success">L\'image a bien été modifiée !</div>';
                        self::slides($message);
                        exit(); // On ne veut pas que le code self::manageNews s'exécute :)
                    } else {
                        $urlVerify = File::build_path(array('assets', 'images', 'slides', $nameImage));
                        if(file_exists($urlVerify)) {
                            unlink($urlVerify);
                        }
                        $message = '<div class="alert alert-danger">Merci de contacter le support de MyGuestHouse !</div>';
                    }
                }
            } else {
                $message = '<div class="alert alert-danger">Cette image défilante n\'existe pas !</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Vous devez transmettre l\'id de l\'image à éditer</div>';
        }
        self::manageSlides($message);
    }
    // Fonction qui permet de générer le formulaire final de suppression d'une news
    public static function deleteSlideForm() {
        self::isAdmin();
        $retour = array(); //Tableau de retour
        if(isset($_POST['idSlide'])) {
            $idSlide = htmlspecialchars($_POST['idSlide']);
            $slide = ModelSlides::select($idSlide);
            if($slide != false) {
                $form = '<form method="POST" role="form" action="index.php?controller=admin&action=deleteSlide">
                    <div class="alert alert-info text-center">
                        Confirmez vous la suppression de l\'image <b><a href="'.$slide->get('urlSlide').'" target="_blank">'.htmlspecialchars($slide->get('urlSlide')).'</a></b> ?
                    </div>
                    <input type="hidden" name="idSlide" value="'.$slide->get('idSlide').'">
                    <input type="hidden" name="confirm" value="true">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Confirmer</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Annuler">Annuler</button>
                    </div>
                </form>';
                $retour['result'] = true;
                $retour['message'] = $form;
            } else {
                $retour['result'] = false;
                $retour['message'] = '<div class="alert alert-danger">L\'image demandée n\'existe pas !</div>';
            }
        } else {
            $retour['result'] = false;
            $retour['message'] = '<div class="alert alert-danger">Vous n\'avez pas envoyé correctement les données !</div>';
        }
        echo json_encode($retour);
    }
    // Fonction qui supprime une slide
    public static function deleteSlide() {
        self::isAdmin();
        if(isset($_POST['idSlide'], $_POST['confirm'])) {
            $idSlide = htmlspecialchars($_POST['idSlide']);
            $confirm = htmlspecialchars($_POST['confirm']);
            $slide = ModelSlides::select($idSlide);
            if($slide != false) {
                if($confirm == true) {
                    $checkDeleteSlide = ModelSlides::delete($slide->get('idSlide'));
                    if($checkDeleteSlide) {
                        $urlImage = $slide->get('urlSlide');
                        $firstChars = substr($urlImage, 0, 6);
                        $nameImage = str_replace("assets/images/slides/", "", $urlImage);
                        if($firstChars == "assets") {
                            $fileUrl = File::build_path(array('assets', 'images', 'slides', $nameImage));
                            if(file_exists($fileUrl)) {
                                unlink($fileUrl);
                            }
                        }
                        $message = '<div class="alert alert-success">L\'image a bien été supprimé !</div>';
                    } else {
                        $message = '<div class="alert alert-danger">Impossible de supprimer cette image !</div>';
                    }
                } else {
                    $message = '<div class="alert alert-danger">Vous devez confirmer la suppression !</div>';
                }
            } else {
                $message = '<div class="alert alert-danger">Cette image n\'existe pas</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Merci de remplir correctement le formulaire de suppression !</div>';
        }
        self::slides($message);
    }

    // NEWS --------------------------------------------------
    // Fonction qui permet de lister les news
    public static function news($message = NULL) {
        $powerNeeded = self::isAdmin();
        $view = 'listNews';
        $pagetitle = 'Administration - Gestion des news';
        $template = 'admin';
        $tab_news = ModelNews::selectAll();
        require_once File::build_path(array("view", "main_view.php"));
    }
    // Fonction qui permet de gérer les news (ajout ou modification)
    public static function manageNews($message = NULL) {
        if(isset($_GET['type'])) {
            $type = $_GET['type'];
            if($type == "add" || $type == "edit") {
                if($type == "add") {
                    $titreAction = 'Ajouter une actualité';
                } elseif($type == "edit") {
                    $titreAction = 'Modifier une actualité';
                    if(isset($_GET['idNews']) && !empty($_GET['idNews'])) {
                        $idNews = htmlspecialchars($_GET['idNews']);
                        $readNews = ModelNews::select($idNews);
                        if(!$readNews) {
                            self::news('<div class="alert alert-danger">Impossible de modifier cette actualité, elle n\'existe pas !</div>');
                        }
                    } else {
                        self::news('<div class="alert alert-danger">Pour pouvoir modifier une actualité il faut son ID</div>');
                    }
                }
                $powerNeeded = self::isAdmin();
                $view = 'manageNews';
                $template = 'admin';
                $tab_news = ModelNews::selectAll();
                $pagetitle = 'Administration - '.$titreAction;
                require_once File::build_path(array("view", "main_view.php"));
            } else {
                ControllerDefault::error('Vous devez préciser si vous souhaitez modifier ou ajouter une news !', 'admin');
            }
        } else {
            ControllerDefault::error('Il faut préciser un paramètre de type de gestion de news !', 'admin');
        }
    }
    // Fonction qui permet de générer le formulaire final de suppression d'une news
    public static function deleteNewsForm() {
        self::isAdmin();
        $retour = array(); //Tableau de retour
        if(isset($_POST['idNews'])) {
            $idNews = htmlspecialchars($_POST['idNews']);
            $news = ModelNews::select($idNews);
            if($news != false) {
                $form = '<form method="POST" role="form" action="index.php?controller=admin&action=deleteNews">
					<div class="alert alert-info text-center">
						Confirmez vous la suppression de l\'actualité <b>'.htmlspecialchars($news->get('titreNews')).'</b> ?
					</div>
					<input type="hidden" name="idNews" value="'.$news->get('idNews').'">
					<input type="hidden" name="confirm" value="true">
					<div class="form-group">
						<button type="submit" class="btn btn-success">Confirmer</button>
						<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Annuler">Annuler</button>
					</div>
				</form>';
                $retour['result'] = true;
                $retour['message'] = $form;
            } else {
                $retour['result'] = false;
                $retour['message'] = '<div class="alert alert-danger">L\'actualité demandée n\'existe pas !</div>';
            }
        } else {
            $retour['result'] = false;
            $retour['message'] = '<div class="alert alert-danger">Vous n\'avez pas envoyé correctement les données !</div>';
        }
        echo json_encode($retour);
    }
    // Fonction qui supprime une news
    public static function deleteNews() {
        self::isAdmin();
        if(isset($_POST['idNews'], $_POST['confirm'])) {
            $idNews = htmlspecialchars($_POST['idNews']);
            $confirm = htmlspecialchars($_POST['confirm']);
            $news = ModelNews::select($idNews);
            if($news != false) {
                if($confirm == true) {
                    $checkDeleteNews = ModelNews::delete($news->get('idNews'));
                    if($checkDeleteNews) {
                        $message = '<div class="alert alert-success">L\'actualité a bien été supprimé !</div>';
                    } else {
                        $message = '<div class="alert alert-danger">Impossible de supprimer cette actualité !</div>';
                    }
                } else {
                    $message = '<div class="alert alert-danger">Vous devez confirmer la suppression !</div>';
                }
            } else {
                $message = '<div class="alert alert-danger">Cette actualité n\'existe pas</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Merci de remplir correctement le formulaire de suppression !</div>';
        }
        self::news($message);
    }
    // Fonction qui ajoute une news
    public static function addNews() {
        self::isAdmin();
        if(isset($_POST['titreNews'],$_POST['contenuNews'],$_POST['dateNews'],$_POST['etatNews'])) {
            $titreNews = htmlspecialchars($_POST['titreNews']);
            $contenuNews = htmlspecialchars($_POST['contenuNews']);
            $dateNews = htmlspecialchars($_POST['dateNews']);
            $etatNews = htmlspecialchars($_POST['etatNews']);
            if(!empty($titreNews) && !ctype_space($titreNews)) {
                if(!empty($contenuNews) && !ctype_space($contenuNews)) {
                    if(!empty($dateNews) && !ctype_space($dateNews)) {
                        if(DateTime::createFromFormat('Y-m-d', $dateNews) !== false) {
                            if($etatNews != 0 && $etatNews != 1) {
                                $etatNews = 0; // On force la non-publication.
                            }
                            $data = array(
                                'idNews' => NULL,
                                'titreNews' => $titreNews,
                                'contenuNews' => $contenuNews,
                                'dateNews' => $dateNews,
                                'etatNews' => $etatNews
                            );
                            $testSaveNews = ModelNews::save($data);
                            if($testSaveNews) {
                                $message = '<div class="alert alert-success">L\'actualité a bien été ajoutée !</div>';
                                self::news($message);
                                exit(); // On ne veut pas que le code self::manageNews s'exécute :)
                            } else {
                                $message = '<div class="alert alert-danger">Merci de contacter le support de MyGuestHouse !</div>';
                            }
                        } else {
                            $message = '<div class="alert alert-danger">Vous devez saisir un date d\'actualité au format jj/mm/aaaa</div>';
                        }
                    } else {
                        $message = '<div class="alert alert-danger">Vous devez saisir une date d\'actualité non vide</div>';
                    }
                } else {
                    $message = '<div class="alert alert-danger">Vous devez saisir un contenu d\'actualité non vide</div>';
                }
            } else {
                $message = '<div class="alert alert-danger">Vous devez saisir un titre d\'actualité non vide</div>';
            }
        }
        self::manageNews($message);
    }
    public static function editNews() {
        self::isAdmin();
        if(isset($_POST['idNews'], $_POST['titreNews'],$_POST['contenuNews'],$_POST['dateNews'],$_POST['etatNews'])) {
            $idNews = htmlspecialchars($_POST['idNews']);
            $titreNews = htmlspecialchars($_POST['titreNews']);
            $contenuNews = htmlspecialchars($_POST['contenuNews']);
            $dateNews = htmlspecialchars($_POST['dateNews']);
            $etatNews = htmlspecialchars($_POST['etatNews']);
            $checkNews = ModelNews::select($idNews);
            if($checkNews) {
                if(!empty($titreNews) && !ctype_space($titreNews)) {
                    if(!empty($contenuNews) && !ctype_space($contenuNews)) {
                        if(!empty($dateNews) && !ctype_space($dateNews)) {
                            if(DateTime::createFromFormat('Y-m-d', $dateNews) !== false) {
                                $etatNews = intval($etatNews);
                                if($etatNews != 0 && $etatNews != 1) {
                                    $etatNews = 0; // On force la non-publication.
                                }
                                $data = array(
                                    'idNews' => $idNews,
                                    'titreNews' => $titreNews,
                                    'contenuNews' => $contenuNews,
                                    'dateNews' => $dateNews,
                                    'publie' => $etatNews
                                );
                                $testSaveNews = ModelNews::update_gen($data, 'idNews');
                                if($testSaveNews) {
                                    $message = '<div class="alert alert-success">L\'actualité a bien été modifiée !</div>';
                                    self::news($message);
                                    exit(); // On ne veut pas que le code self::manageNews s'exécute :)
                                } else {
                                    $message = '<div class="alert alert-danger">Merci de contacter le support de MyGuestHouse !</div>';
                                }
                            } else {
                                $message = '<div class="alert alert-danger">Vous devez saisir un date d\'actualité au format jj/mm/aaaa</div>';
                            }
                        } else {
                            $message = '<div class="alert alert-danger">Vous devez saisir une date d\'actualité non vide</div>';
                        }
                    } else {
                        $message = '<div class="alert alert-danger">Vous devez saisir un contenu d\'actualité non vide</div>';
                    }
                } else {
                    $message = '<div class="alert alert-danger">Vous devez saisir un titre d\'actualité non vide</div>';
                }
            } else {
                $message = '<div class="alert alert-danger">L\'actualité que vous tentez de modifier n\'existe pas</div>';
            }
        }
        self::manageNews($message);
    }


    // RESERVATION ------------------------------------------------ //---IN PROGRESS---//
    // Gestion des réservations : view/amin/viewAllReservation.php
    public static function reservations($message = null){
        $powerNeeded = self::isAdmin();
        $view = 'viewAllReservation';
        $pagetitle = 'Administration - Gestion des réservations';
        $template = 'admin';
        // appel des methodes de selection
        if(!isset($_GET['mode'])){ $_GET['mode'] = 'enAttente'; }
        switch ($_GET['mode']){
            case 'encours':
                $tab_reservations=ModelReservation::getReservationsEnCours();
                break;
            case 'enattentes':
                $tab_reservations=ModelReservation::getReservationsEnAttente();
                break;
            case 'finis':
                $tab_reservations=ModelReservation::getReservationsFinis();
                break;
            case 'annulees':
                $tab_reservations=ModelReservation::getReservationsAnnulee();
                break;
        }
        require_once File::build_path(array("view", "main_view.php"));
    }
    public static function addReservation(){ // IN PROGRESS
        self::isAdmin();
        if(isset($_POST['idReservation'])){
            if($_POST['idUtilisateur']!=null && $_POST['dateDebut']!=null && $_POST['dateFin']!=null && $_POST['idChambre']!=null ){
                $idUtilisateur = htmlspecialchars($_POST['idUtilisateur']);
                $dateDebut = htmlspecialchars($_POST['dateDebut']);
                $dateFin = htmlspecialchars($_POST['dateFin']);
                $idChambre = htmlspecialchars($_POST['idChambre']);
                $data = array(
                    'idReservation' => null,
                    'idUtilisateur' => $idUtilisateur,
                    'dateDebut' => $dateDebut,
                    'dateFin' => $dateFin,
                    'idChambre' => $idChambre,
                    'annulee' => null
                );
                $save = ModelPrestation::save($data);
                if($save) {
                    $message = '<div class="alert alert-success">Reservation ajoutée avec succès !</div>';
                    self::news($message);
                } else {
                    $message = '<div class="alert alert-danger">Echec de l\'ajout de la reservation !</div>';
                }
            } else {
                $message = '<div class="alert alert-danger">Vous ne pouvez pas laisser un champ vide !</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Nous navons pas pu recuperer vos choix !</div>';
        }
        self::manageReservation($message);
    }
    public static function editReservation(){
        self::isAdmin();
        if(isset($_POST['idReservation']) && isset($_POST['idUtilisateur']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['dateDebut']) && isset($_POSTT['dateFin']) && isset($_POST['idChambre'])) {
            $idReservation = htmlspecialchars($_POST['idReservation']);
            $idUtilisateur = htmlspecialchars($_POST['idUtilisateur']);
            $dateDebut = htmlspecialchars($_POST['dateNews']);
            $dateFin = htmlspecialchars($_POST['etatNews']);
            $idChambre = htmlspecialchars($_POST['idChambre']);
            $checkReservation = ModelReservation::select($idReservation);
            if ($checkReservation) {
                if (!empty($idUtilisateur) && !ctype_space($idUtilisateur)) {
                    if (!empty($idChambre) && !ctype_space($idChambre)) {
                        if (!empty($dateDebut) && !ctype_space($dateDebut)) {
                            if(!empty($dateFin) && !ctype_space($dateFin)){
                                if (DateTime::createFromFormat('Y-m-d', $dateDebut) !== false && DateTime::createFromFormat('Y-m-d', $dateFin) !== false) {
                                    $data = array(
                                        'idReservation' => $idReservation,
                                        'idUtilisateur' => $idUtilisateur,
                                        'idChambre'     => $idChambre,
                                        'dateDebut'     => $dateDebut,
                                        'dateFin'       => $dateFin,
                                        'annulee'       => null
                                    );
                                    $testSaveReservation= ModelReservation::update_gen($data, 'idReservation');
                                    if ($testSaveReservation) {
                                        $message = '<div class="alert alert-success">La réservation a bien été modifiée !</div>';
                                        self::news($message);
                                        exit(); // On ne veut pas que le code self::manageReservation s'exécute :)
                                    } else {
                                        $message = '<div class="alert alert-danger">Merci de contacter le support de MyGuestHouse !</div>';
                                    }
                                } else {
                                    $message = '<div class="alert alert-danger">Vous devez saisir un date d\'actualité au format jj/mm/aaaa</div>';
                                }
                            } else {
                                $message = '<div class="alert alert-danger">Vous devez saisir une date de fin non vide</div>';
                            }
                        } else {
                            $message = '<div class="alert alert-danger">Vous devez saisir une date de début non vide</div>';
                        }
                    } else {
                        $message = '<div class="alert alert-danger">Vous devez saisir identifiant de chambre non vide</div>';
                    }
                } else {
                    $message = '<div class="alert alert-danger">Vous devez saisir identifiant client non vide</div>';
                }
            } else {
                $message = '<div class="alert alert-danger">La réservation que vous tentez de modifier n\'existe pas</div>';
            }
        }
    self::manageReservation($message);
    }
    public static function manageReservation($message = NULL){ // IN PROGRESS
        if(isset($_GET['type'])) {
            $type = $_GET['type'];
            if($type == "add" || $type == "edit") {
                if($type == "add") {
                    $titreAction = 'Ajouter une reservation';
                } elseif($type == "edit") {
                    $titreAction = 'Modifier une reservation';
                    if(isset($_GET['idReservation']) && !empty($_GET['idReservation'])) {
                        $idReservation = htmlspecialchars($_GET['idReservation']);
                        $readReservation = ModelReservation::select($idReservation);
                        if(!$readReservation) {
                            self::reservations('<div class="alert alert-danger">Impossible de modifier cette reservation, elle n\'existe pas !</div>');
                        }
                    } else {
                        self::reservations('<div class="alert alert-danger">Pour pouvoir modifier une reservation il faut son ID</div>');
                    }
                }
                $powerNeeded = self::isAdmin();
                $view = 'manageReservation';
                $template = 'admin';
                $tab_news = ModelReservation::selectAll();
                $pagetitle = 'Administration - '.$titreAction;
                require_once File::build_path(array("view", "main_view.php"));
            } else {
                ControllerDefault::error('Vous devez préciser si vous souhaitez modifier ou ajouter une reservation !', 'admin');
            }
        } else {
            ControllerDefault::error('Il faut préciser un paramètre de type de gestion de reservations !', 'admin');
        }
    }

}
?>
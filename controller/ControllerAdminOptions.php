<?php 
	class ControllerAdminOptions extends ControllerAdmin {

	    public static function list($message = NULL) {
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
	        self::list($message);
	    }
	}
?>
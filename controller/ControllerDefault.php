<?php

    /**
     * This generic class contains all functions that a controller can use
    */
    class ControllerDefault {
        protected static $object = 'default';

        public static function index() {
            $view = 'index';
            $pagetitle = 'MyGuestHouse';
            $powerNeeded = true;

            $imagesSlides = ModelSlides::selectAll();
            $dataSlides = array();
            if(!empty($imagesSlides)) {
                foreach ($imagesSlides as $slide) {
                    $dataSlides[$slide->get('idSlide')] = array(
                        'order' => $order,
                        'url' => $slide->get('urlSlide'),
                        'texte' => htmlspecialchars($slide->get('textSlide'))
                    );
                    $order++;
                }
            }

            $display_news = ModelOption::selectCustom('nameOption', 'display_news')[0]->get('valueOption');
            if(empty($display_news) && ($display_news != 'true' || $display_news != 'false')) {
                $display_news = 'true';
            }

            if($display_news == 'true') {
                $listNews = ModelNews::getNews(4);
            }

            require File::build_path(array('view', 'main_view.php'));
        }

        /**
         * Active ...
         * Control if the part of the URL who called the controller ask the good controller with the good action
         *
         * @param string current controller
         * @param string current action
         * @param string current mode (for nav liste with mode)
         * @return boolean
        */
        public static function active($currentController, $currentAction = null, $currentMode = null){
            $queryString = $_SERVER['QUERY_STRING'];
            if($currentMode != null){
                if(strpos($queryString, 'controller='.$currentController.'&action='.$currentAction.'&mode='.$currentMode) !== false) {
                    echo 'class="active"';
                }
            } elseif(!empty($currentAction) && $currentAction != null) {
                if(strpos($queryString, 'controller='.$currentController.'&action='.$currentAction) !== false) {
                    echo 'class="active"';
                }
            } else {
                if($currentAction == NULL && $currentMode == NULL) {
                    if(isset($_GET['controller']) && $_GET['controller'] == $currentController) {
                        echo 'class="active"';
                    }
                } else {
                    if(strpos($queryString, 'controller='.$currentController !== false)) {
                        echo 'class="active"';
                    }
                    if ($currentController == 'index' && empty($queryString)) {
                        echo 'class="active"';
                    }
                }
            }
        }

        public static function ColorDarken($color, $dif=20){
            $color = str_replace('#', '', $color);
            if (strlen($color) != 6){ return '000000'; }
            $rgb = '';

            for ($x=0;$x<3;$x++){
                $c = hexdec(substr($color,(2*$x),2)) - $dif;
                $c = ($c < 0) ? 0 : dechex($c);
                $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
            }

            return '#'.$rgb;
        }

        public static function checked($a, $b) {
            if($a == $b) {
                return 'checked';
            }
        }

        /**
         *
        */
        public static function error($error, $template = NULL) {
            $displayError = $error;
            $view = 'error';
            $pagetitle= 'MyGuestHouse - Erreur';
            $powerNeeded = true;
            require File::build_path(array('view', 'main_view.php'));
        }
    }
?>
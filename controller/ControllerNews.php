<?php
/*require_once File::build_path(array('model', 'ModelOption.php'));
require_once File::build_path(array('model', 'ModelNews.php'));*/


class ControllerNews {
    private static $object = 'news';

    public static function bbcode($string) {
        // Souligné [i][/i]
        $string = preg_replace('`\[u\](.+)\[/u\]`isU', '<u>$1</u>', $string);
        // Italique [i][/i]
        $string = preg_replace('`\[i\](.+)\[/i\]`isU', '<em>$1</em>', $string);
        // Gras [b][/b]
        $string = preg_replace('`\[b\](.+)\[/b\]`isU', '<strong>$1</strong>', $string);

        // Tailles de police
        $string = preg_replace('`\[grand\](.+)\[/grand\]`isU', '<h2 class="noMargin">$1</h2>', $string);
        $string = preg_replace('`\[moyen\](.+)\[/moyen\]`isU', '<h4 class="noMargin">$1</h4>', $string);
        $string = preg_replace('`\[petit\](.+)\[/petit\]`isU', '<h6 class="noMargin">$1</h6>', $string);

        // Gestion des listes
        $string = preg_replace('`\[liste titre=(.+)\](.+)\[/liste\]`isU', '$1 :<ul>$2</ul>', $string);
        $string = preg_replace('`\[li\](.+)\[/li\]`isU', '<li>$1</li>', $string);

        // Lien [url=lien]titrelien[/url]
        $string = preg_replace('`\[lien url=(.+)\](.+)\[/lien\]`isU', '<a target="_blank" href="$1">$2</a>', $string);

        return nl2br($string);
    }

    public static function read() {
        if(isset($_GET['idNews'])) {
            $idNews = htmlspecialchars($_GET['idNews']);

            $news = ModelNews::select($idNews);
            if($news != false) {
                // Récupérer l'utilisateur courant
                if(ControllerUtilisateur::isConnected()) {
                    $currentUser = ModelUtilisateur::selectCustom('idUtilisateur', $_SESSION['idUser'])[0];
                    $isAdmin = $currentUser->getPower() == Conf::$power['admin'];
                } else {
                    $isAdmin = false;
                }
                
                if($news->get('publie') == 1 || $isAdmin) {
                    $powerNeeded = true;
                    $view = 'read';
                    $pagetitle = 'Lire une actualité';
                    $titreNews = htmlspecialchars($news->get('titreNews'));
                    $dateNews = htmlspecialchars($news->get('dateNews'));
                    $contenuNews = self::bbcode($news->get('contenuNews'));
                    require_once File::build_path(array("view","main_view.php"));
                } else {
                    ControllerDefault::error('Impossible de lire cette actualité !');
                }
            } else {
                ControllerDefault::error('Cette actualité n\'existe pas !');
            }
        } else {
            ControllerDefault::error('Cette actualité n\'existe pas !');
        }
    }
}
?>
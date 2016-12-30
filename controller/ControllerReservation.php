<?php

    class ControllerReservation {
        protected static $object = 'reservation';

        /**
         * Provide to the user to choose a room with and the date to reserve it
         **/
        public static function reservation(){
            $view = 'reservation';
            $pagetitle = 'Faire une reservation';
            $powerNeeded = !self::isConnected();

            require File::build_path(array('view', 'main_view.php'));
        }
    }
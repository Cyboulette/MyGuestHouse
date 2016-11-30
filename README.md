# MyGuestHouse

- 30/11
    *       Move templates/themes to the good folder into view/themes and create (temp) Conf::$theme by default

- 29/11
    *       Change static::$object to static::$tableName int the select of the Model.php (for the $table_name)
    *       Create a function count() one the Model.php 
    *       Conf.php updated with all our configurations
    *       Models updated with the good prefix
    *       Views admin & site linked with the good css file
    *       Remove save() not-generic in some Models

- 25/11 **User utilites**
     *      Update MyGuestHouse.sql
     *      Implementation of the ModelChambre.php 
     *      Implementation of the ControllerChambre.php (basics)
     *      Implementation of the save() and delete() methods in Model.php
     *      Implementation of the connexion and inscription view


- 15/11 **Architecture MVC**
     *      Implementation of ControllerAdmin.php (example of this controller)
     *      Implementation of main_view.php (for managing views/templates/themes)
     *      Update MyGuestHouse.sql (renaming tables)
     *      Implementation of the ModelUtilisteurs.php
     *      Implementation of the ControllerUtilisateur.php   
     *      Implementation of the presentation page (default index)        
     

- 06/11 **Initial commit**
     *      Implementation of the elements non relative to the database
     *      Implementation of the database
     *      Implementation of the router.php file
     *      Implementation of the File.php file
     *      Implementation of the main view (basics)
     *      Implementation of the generic model
     *      Implementation of the Default controller
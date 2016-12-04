# MyGuestHouse
The smartest CMS for guest house owner

# Commits

- 04/11 **Back-office**
    *       Problem in listChambre.php when call Modal for deleting ($id is constant)
    *       Set default value $powerNeeded=true in ControllerAdmin.php file
    *       Implementation of back-office view displayAllUtilisateurs.php
    *       Implementation of back-office view displayAllReservation.php
    *       Implementation of ModelReservation.php file
    *       Update front-office view displayAllChambre.php (enlarge pictures)
    *       Remove the update_url method in ModelVisuelChambre to ModelChambre (delete ModelVisuelChambre)

<br>
- 03/12 **Admin Pages**
    *        Implementation of "lister les chambres" in the Administration
    *        Need to have an account and be admin for have the power to enter into the Administration
    *        Security of views/controllers, read the wiki for more information (french)

<br>
- 30/11 **Front-office**
    *       Implementation of ModelVisuelChambre.php file
    *       update_url method in ModelVisuelChambre
    *       Move templates/themes to the good folder into view/themes and create (temp) Conf::$theme by default
    *       Insertion `gh_rang` values into the .sql file
    *       Implementation of view displayChambre

<br>
- 29/11 **User utilites**
    *       Change static::$object to static::$tableName int the select of the Model.php (for the $table_name)
    *       Create a function count() one the Model.php 
    *       Conf.php updated with all our configurations
    *       Models updated with the good prefix
    *       Views admin & site linked with the good css file
    *       Remove save() not-generic in some Models

<br>
- 25/11 **User utilites**
     *      Update MyGuestHouse.sql
     *      Implementation of ModelChambre.php file
     *      Implementation of ControllerChambre.php file (basics)
     *      Implementation of save() and delete() methods in Model.php
     *      Implementation of connexion and inscription view

<br>
- 15/11 **Architecture MVC**
     *      Implementation of ControllerAdmin.php (example of this controller)
     *      Implementation of main_view.php (for managing views/templates/themes)
     *      Update MyGuestHouse.sql (renaming tables)
     *      Implementation of ModelUtilisteurs.php file
     *      Implementation of ControllerUtilisateur.php file
     *      Implementation of presentation page (default index)        
     
<br>
- 06/11 **Initial commit**
     *      Implementation of elements non relative to the database
     *      Implementation of database
     *      Implementation of router.php file
     *      Implementation of File.php file
     *      Implementation of main view (basics)
     *      Implementation of generic model
     *      Implementation of ControllerDefault.php file

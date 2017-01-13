# MyGuestHouse

A smartest CMS for a smartest guest house.
<br>
You can add, read and comment some future functionality in [`FUTURE.md`](https://github.com/Cyboulette/MyGuestHouse/blob/master/FUTURE.md).
<br>
To install it, please read the file [`INSTALL.md`](https://github.com/Cyboulette/MyGuestHouse/blob/master/INSTALL.md).

# Demo

A demo is available here : https://myguesthouse.cyboulette.fr/
<br>
**Credencials for demo are : demo@yopmail.fr/demo**

# TODO

- Allow to select some prestations when add reservations on user side
- Validate the reservation on user side
- Provide to cancel a reservation for user

# Commits


- 13/01 
    *       Corrections on the list of reservations on user side       
    *       Verification for the reservation addition in DB on user side (see the 11/01's commits)
    *       Details for reservations on user profil page

<br>
- 11/01
    *       Insert date format fixed
    *       Display the current date for input default value
    *       Display the name of chambre and user for input value
    *       Bug fixed on function ModelReservation::getPrixTotal() and ModelReservation::getNombreNuits() 
    *       Verification dates disabled for reservations 
    
<br>
- 09/01
    *       Datepicker for datesDisabled
    *       Add and delete reservations for users
    *       Correction on adminReservation form
   
<br>
- 30/12
    *       Display reservations for user

<br>
- 29/12
    *       New release is OUT, you can see [here](https://github.com/Cyboulette/MyGuestHouse/releases/tag/v0.2), so you can test our CMS and report bug if you want !
    *       Install script is out ! It's now possible to "INSTALL" our CMS automatically. No needed to edit config and put default values into phpmyadmin manually, our script do it for us ! It was a MAJOR request of our "client".
    *       Manage prestations for reservations
    *       Detail reservation on user's detail
    *       Helper documentation

<br>
- 20/12
   *       Manage of Themes directly in the Administration : we can now change the theme of the website through the admin. (Note : The admin theme can't be changed !!)
   *       Update CSS of the admin and the index page
   *       Release the first demo version [here](https://github.com/Cyboulette/MyGuestHouse/releases/tag/v0.1), and updated the `.sql` files
   *       Update autoload function of the routeur for now require_once automatically Controller(s) and Model(s). When we use Controller:: or Model:: we don't need to have included the file before, the auto_loader do it for us.
   
<br>
- 19/12
   *       Migrated templates for default template
   *       You can now manage "sliders/caroussel" images from the administration
   *       Implementation of ControllerNews for read news, we can now read news on the website by clicking on the button `Lire la news`
   *       BBCODE for news, you can now edit news and use BBCODE for beautiful style
   *       New option : `main_color_site` which allow to modify the main color of templates, you can manage this option directly into the Administration and you can use a "ColorPicker" (Thank's to [Bootstrap Colorpicker](https://itsjavi.com/bootstrap-colorpicker/))

<br>
- 16/12 
    *       Add `FUTURE.md` to think about the future of myguesthouse
    *       Add new attribut annulee on `GH_Reservations`

<br>
- 13/12 **Reservations**
    *       CRUD for reservations completed
    
<br>
- 09/12 **News**
    *       We can now create/update or delete a news. (Only 1 view for update and add)
    *       `Script.sql` for creating the table "GH_News"
    *       Loader css for design
    *       Ajax for deleting a news into a modal (it's a good example for the future)
    *       CRUD for "Prestations" of "Chambres"

<br>
- 06/12 **Back-office**
    *       Implementation of view admin viewAllReservation.php
    *       Some content in GH_Reservations in `.sql`

<br>
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

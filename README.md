##Symfony-Forum
This is an exercise project to get used to the features of Symfony2 (Controllers, Routing, Templating, Forms, Validation, Doctrine, Security).
It is based on the Symfony Standard Edition.

##Possible so far
* Registration
* Form-Login
* creating threads
* creating posts in threads
* users can edit their own posts
* different roles
    * the user-role is by default 'ROLE_USER'
    * to create a user with the user-role 'ROLE_ADMIN' register with the username 'admin'
    * admins may access the admin-panel


##Demo-Link
Demo-Link: http://symfony-forum.jan-mueller.org/web/app_dev.php/secured/show-categories

##Installation
* setup database connection in the parameters.yml
* app/console doctrine:database:create
* app/console doctrine:schema:create
* assets:install
* register with the username 'admin' to create categories on the admin panel

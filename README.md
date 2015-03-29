##Symfony-Forum
This is an exercise project to get used to the features of Symfony2 (Controllers, Routing, Templating, Forms, Validation, Doctrine, Security).
It is based on the Symfony Standard Edition.

##Possible so far
* Registration
* Form-Login
* creating threads
* creating posts in threads
* users can edit their own posts
* pagination for threads and posts (KnpPaginatorBundle)
* private messages
* different roles
    * the user-role is by default 'ROLE_USER'
    * to create a user with the user-role 'ROLE_ADMIN' register with the username 'admin'
    * admins may access the admin-panel
    * admins can create categories
    * admins can delete posts, threads and categories


##Demo-Link
Demo-Link: http://symfony-forum.jan-mueller.org/web/app_dev.php/secured/show-categories

##Installation
* setup database connection in the parameters.yml
* composer install
* app/console doctrine:database:create
* app/console doctrine:schema:update --force
* assets:install
* register with the username 'admin' to create categories on the admin panel

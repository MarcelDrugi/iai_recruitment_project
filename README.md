## Invoice management
Rrecruitment task for IAI.

#### Live demo: [piotr-mazur.epizy.com](http://piotr-mazur.epizy.com)


## To start the app, follow the steps below.

###### 1. Clone repo:

    git clone https://github.com/MarcelDrugi/iai_recruitment_project

###### 2. Go to root directory:

    cd iai_recruitment_project

###### 3. Create database for the project on your local device.
You can use any SQL management system.
If you use MySQL, then:

    mysql -u [your_username] -p

###### 4. The project does not contain a vendor directory, you need to install dependencies.
Using composer, in project-root directory:

    composer install


###### 5. Create an .env file in the project-root directory and copy the content of the .env.example file to it.

###### 6. In your new .env file insert the settings of the database created in step 3.
(Optionally, you can also change the other settings if you do not intend to use the default.)

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=

###### 7. Generate an application key by artisan:

    php artisan key:generate

The key should be automatically inserted into the .env file as 'APP_KEY='. Check it out.

###### 8. Run migrations and seeders:

    php artisan migrate && php artisan db:seed

###### 12. Run the server:

    php artisan serve

If you haven't changed the settings, the application should start at: http://127.0.0.1:8000

Of course you can use another server (e.g. Apache 2).
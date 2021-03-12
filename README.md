# wp-ffbs-training-importer
WordPress plugin for easy import of the exercise plan of the volunteer fire department Bad Schönborn

## Prerequisites
* [My Calendar](https://de.wordpress.org/plugins/my-calendar/)
* Exercise plan in csv

## How to develop

* Start Docker Wordpress Installation

    `docker-compose up`
* Shutdown Docker

    `docker-compose down -v`
* Shutdown Docker and remove database

    `docker-compose down -v && rm -rf .db_data`
* Execute Bash commands inside Docker wordpress container

    `docker-compose exec wordpress bash`

* Debugg Settings in wp-config.php
    ```php
    define( 'WP_DEBUG', true );
    define( 'SCRIPT_DEBUG', true );
    define( 'SAVEQUERIES', true );
    ```

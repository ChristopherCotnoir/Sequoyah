# Sequoyah Installation

#### Database Setup

Ensure that MySQL is installed. Once installed, log in to the database server and run the following commands.

    CREATE USER sequoyah@localhost IDENTIFIED BY 'hayouqes';
    CREATE DATABASE sequoyah;
    GRANT ALL ON sequoyah.* TO sequoyah@localhost;
    
Once this is done, your database will be ready.

#### Vendor File Downloading

Laravel relies on other PHP libraries to function. To get these libraries, you must use the PHP package management system Composer. In the terminal, type the following commands to get it. You should run these commands inside the root source directory of Sequoyah, wherever you 'git clone'd it to.

    wget http://www.getcomposer.org/installer
    ./installer
    composer.phar install
    
Once this command completes, your dependencies will be up to date, and your vendor directory will be correctly set up.

### Storage Directory Permissions

Laravel will won't work if it cannot write to the app/storage directory. In this directory are cache files as well as log files. Because the directory is normally owned by your user account, the default user account a the web server uses can't write to the directory. To quickly fix that, run the following command in the root of the Sequoyah source directory.

    chmod -R 777 app/storage

# ukpk
App Uji Kompetensi Penerimaan Karyawan
Stack : JQuery,PHP, Boostrap


## How to run application


### 1. Create New Config
The config.secret.inc.php file is used to store sensitive configuration information for PHPMyAdmin, such as database login credentials or session encryption keys. This file should be kept secret and not shared publicly.

Here's an example of what a config.secret.inc.php file might contain:

config.secret.inc.php
```sh
<?php
/**
 * phpMyAdmin configuration file for Docker Compose setup
 */

// Server configuration
$i = 0;
$cfg['Servers'][$i]['host'] = 'mysql-docker-host'; // MySQL hostname - this should match the service name in your Docker Compose file
$cfg['Servers'][$i]['port'] = '3306'; // MySQL port number
$cfg['Servers'][$i]['socket'] = ''; // Path to the MySQL socket file
$cfg['Servers'][$i]['ssl'] = false; // Use SSL for the MySQL connection
$cfg['Servers'][$i]['auth_type'] = 'cookie'; // Authentication method
$cfg['Servers'][$i]['user'] = 'myuser'; // MySQL user
$cfg['Servers'][$i]['password'] = 'mypassword'; // MySQL password - this should match the password set in your Docker Compose file
$cfg['Servers'][$i]['AllowNoPassword'] = false; // Allow login without a password
$cfg['Servers'][$i]['compress'] = false; // Use compression for the MySQL connection

// Blowfish secret
$cfg['blowfish_secret'] = 'mysecretkey'; // Change this to a random string of your own

// Directories for saving/loading files from server
$cfg['UploadDir'] = '';
$cfg['SaveDir'] = '';

// Language settings
$cfg['DefaultLang'] = 'en';
$cfg['ServerDefault'] = 1;
$cfg['Lang'] = '';

// Other settings
$cfg['ShowPhpInfo'] = false;

```

### 2. Create Dockerfile
We need extention for pdo_mysql

Dockerfile
```sh
FROM phpmyadmin/phpmyadmin:latest
RUN docker-php-ext-install pdo_mysql
```

### 3. Create docker-compose.yml

DockerCompose
```sh
version: '3'
services:
  db:
    image: mysql:5.7
    volumes:
      - db_data:/var/lib/mysql
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: mysecretpassword
      MYSQL_DATABASE: mydatabase
      MYSQL_USER: myuser
      MYSQL_PASSWORD: mypassword
    hostname: mysql-docker-host
  phpmyadmin:
    image: my-phpmyadminDocker
    ports:
      - 8080:80
    depends_on:
      - db
    environment:
      PMA_HOST: db
      MYSQL_ROOT_PASSWORD: mysecretpassword
      MYSQL_USER: myuser
      MYSQL_PASSWORD: mypassword
    volumes:
      - ./ukpk:/var/www/html/ukpk
      - ./config.secret.inc.php:/etc/phpmyadmin/config.secret.inc.php
    command: >
      /bin/sh -c "chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html && apache2-foreground"
volumes:
  db_data:
```

### 4. Run Docker
please going to parent folder

```sh
docker build -t my-phpmyadmin
docker compose up -d
```



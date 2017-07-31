Symfony 3 test project
========================

Welcome to the Symfony 3 test project


Installation
--------------
1. git clone git@github.com:VladTr/oss.git

2. composer install

3. create database ("oss")
 php bin/console doctrine:database:create
 
4. create tables ("product", "user")
php bin/console doctrine:schema:update --force

5. create user (username="admin", password="010601")
php bin/console doctrine:fixtures:load

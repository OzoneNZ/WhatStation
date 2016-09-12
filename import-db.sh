#!/bin/sh
read -p "Enter MySQL password: " sqlpass
php dump-sql.php > freqs.sql
mysql -u whatstation -p$sqlpass -e "drop database whatstation; create database whatstation;"
php artisan migrate
mysql -u whatstation -p$sqlpass -D whatstation < freqs.sql

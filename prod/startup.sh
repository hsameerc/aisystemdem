#!/bin/sh

sed -i "s,LISTEN_PORT,8000,g" /etc/nginx/nginx.conf

php-fpm -D
#if node timeout, scan for listening demons without sending data and sleep
while ! nc -w 1 -z 127.0.0.1 9000; do sleep 0.1; done;

nginx

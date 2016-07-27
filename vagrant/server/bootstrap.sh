#!/usr/bin/env bash

add-apt-repository -y ppa:ondrej/apache2
add-apt-repository -y ppa:ondrej/php

curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash -

apt-get update

apt-get upgrade -y --force-yes
apt-get install -y --force-yes \
	git \
	htop \
	apache2 \
	php \
	libapache2-mod-php7.0 \
	php-zip \
	php-curl \
	php-xdebug \
	nodejs

a2enmod rewrite

php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
php -r "unlink('composer-setup.php');"

npm install -g grunt

if ! [ -L "/var/www" ]; then
	rm -rf "/var/www"
	ln -fs "/vagrant" "/var/www"
fi

rm -rf /etc/apache2/sites-enabled/*
if ! [ -L "/etc/apache2/sites-available" ]; then
	if ! [ -L "/etc/apache2/sites-available/delejcoumis.conf" ]; then
		ln -s "/vagrant/vagrant/server/apache/sites-available/delejcoumis.conf" "/etc/apache2/sites-available/delejcoumis.conf"
	fi
	a2ensite -q delejcoumis.conf
fi

if ! [ -L "/etc/apache2/conf-available/delejcoumis.conf" ]; then
	rm -f "/etc/apache2/conf-available/delejcoumis.conf"
	ln -s "/vagrant/vagrant/server/apache/conf-available/delejcoumis.conf" "/etc/apache2/conf-available/delejcoumis.conf"
fi
a2enconf -q delejcoumis.conf

if ! [ -L "/etc/php/7.0/cli/conf.d/delejcoumis.ini" ]; then
	rm -f "/etc/php/7.0/cli/conf.d/delejcoumis.ini"
	ln -s "/vagrant/vagrant/server/php/cli.ini" "/etc/php/7.0/cli/conf.d/delejcoumis.ini"
fi

if ! [ -L "/etc/php/7.0/apache2/conf.d/delejcoumis.ini" ]; then
	rm -f "/etc/php/7.0/apache2/conf.d/delejcoumis.ini"
	ln -s "/vagrant/vagrant/server/php/apache2.ini" "/etc/php/7.0/apache2/conf.d/delejcoumis.ini"
fi

if [ -f "/etc/php/7.0/mods-available/xdebug.ini" ]; then
	rm -f "/etc/php/7.0/mods-available/xdebug.ini"
	ln -s "/vagrant/vagrant/server/php/xdebug.ini" "/etc/php/7.0/mods-available/xdebug.ini"
fi

chmod -R 0777 "/vagrant/temp" "/vagrant/log"

hackathon
=========

Front
=====
## Instalar RVM
	$ curl -L https://get.rvm.io | bash -s stable --ruby

## Crear una seccion de ruby para el proyecto
	$ cd /var/www/bigbrother
	$ rvm --rvmrc --create 1.9.3@bigbrother

## Instalar Sinatra
	$ gem install sinatra
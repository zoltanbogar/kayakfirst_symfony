export SYMFONY_ENV=prod
cd "/home/site/wwwroot"

cp ./parameters.prod.yml ./app/config/parameters.yml
/usr/local/bin/php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

/usr/local/bin/php composer-setup.php --quiet
/usr/local/bin/php composer.phar install --no-dev --optimize-autoloader
/usr/local/bin/php app/console cache:clear --env=prod --no-debug


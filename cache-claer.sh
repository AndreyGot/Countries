sudo chmod 0777 -R app/cache
php app/console cache:clear -e=dev
php app/console cache:clear -e=prod
php app/console assets:install


#otorgar permisos a storage
RUN chmod -R gu+w storage/
RUN chmod -R guo+w storage/
RUN chmod -R gu+w bootstrap/cache/
RUN chmod -R guo+w bootstrap/cache/
#ejecutar composer install
composer install
#ejecutar app key
php artisan key:generate
#ejecutar a creacion de jwt_secret
php artisan jwt:secret

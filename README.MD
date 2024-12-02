cp .env.example .env

sudo chmod -R 777 storage/ bootstrap/ .env

sudo docker-compose up -d

sudo docker exec -it app bash 
    composer install --ignore-platform-reqs

sudo docker exec php artisan key:generate
Steps:
git clone https://github.com/Nazarii1996/testCAse.git
composer install
cp .env.example .env
НАстройте связь с БД
php artisan migrate:fresh --seed
 php artisan key:generate
php artisan serve

http://127.0.0.1:8000/login

admin@admin.com
password

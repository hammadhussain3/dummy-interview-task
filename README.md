## Setup Instructions

### Environment Setup
cp .env.example .env
php artisan key:generate

Update database credentials in .env:
DB_DATABASE=demo_task
DB_USERNAME=root
DB_PASSWORD=

### Install Dependencies
composer install

### Run Migrations
php artisan migrate

### Seeding (Admin User)
php artisan db:seed

Admin credentials:
Email: admin@test.com
Password: password

### Authentication Token
Login to get API token:
POST /api/login

Use token in request headers:
Authorization: Bearer YOUR_TOKEN
Accept: application/json

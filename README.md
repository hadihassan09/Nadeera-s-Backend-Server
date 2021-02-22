# Application Backend
## Configuration
  - Create a new account at https://imagga.com/
  - Copy `.env.example` to `.env`
  - Add Imagga API_KEY and API_SECRET in .env
  - Change your database configuration
  - Run Migration `[user@machine ~]$ php artisan migrate`
  - Run Seeder `[user@machine ~]$ php artisan db:seed --class=UserSeeder`
## Install Required Packages  
`[user@machine ~]$ composer install && npm install && npm run dev`
## Start server
`[user@machine ~]$ php artisan serve --host 'YOUR IP ADDRESS' --port 'YOUR PORT'`

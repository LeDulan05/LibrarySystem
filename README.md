# Install PHP dependencies
composer install

# Install NPM dependencies
npm install

# Configure environment
cp .env.example .env
# Edit .env file with these credentials

set:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iskolib
DB_USERNAME=root
DB_PASSWORD=(your password)

SESSION_DRIVER=file
QUEUE_CONNECTION=sync
CACHE_STORE=file

# Generate application key
php artisan key:generate

# Create storage link for images
php artisan storage:link

# Setup database with seeders
php artisan migrate:fresh --seed

# Create Admin User
php artisan db:seed --class=AdminUserSeeder

# Scrape using Laravel command 
php artisan app:scrape-books --count=5

# Start Application
Terminal 1 - Laravel Server:
php artisan serve

Terminal 2 - Vite (Frontend Assets):
npm run dev


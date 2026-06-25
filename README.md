# Install PHP dependencies
composer install

# Install NPM dependencies
npm install

# Configure environment
cp .env.example .env
# Edit .env file with your database credentials

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

Terminal 1 - Laravel Server:
php artisan serve

Terminal 2 - Vite (Frontend Assets):
npm run dev


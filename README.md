> ### Dynamic party Queueing using Spotify. Built with Laravel, Tailwind, and Vue.

# Getting Started
## Installation
Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/10.x/installation)

Install PHP Dependencies
```
composer install
```

Install Node Dependencies
```
npm install
```

Copy example env file and make changes as needed (Database, Spotify Tokens)
```
cp .env.example .env
```

Generate a new application key
```
php artisan key:generate
```

Run database migrations (ensure connection is setup in .env)
```
php artisan migrate
```

Run development server as you choose, serve vite
```
npm run dev
```

For deployment or production instances
```
npm run build
```
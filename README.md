# Blog API Project

This project is a simple CRUD Blog/Posts API built with PHP Laravel. It includes endpoints for managing blogs, posts, likes, and comments, and it uses token-based authentication for securing the routes.

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL or any other supported database
- Postman (for testing the API endpoints)

## Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/segun-aderinola/Voyatek-Blog-APi.git
cd Voyatek-Blog-APi
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Environment Setup

Copy the `.env.example` file to `.env` and update the database configuration.

```bash
cp .env.example .env
```

Update your `.env` file with your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=voyatek_blog
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

### Step 5: Run Migrations

```bash
php artisan migrate
```

### Step 6: Seed the Database

```bash
php artisan db:seed
```

### Step 7: Run the Application

```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`.

## API Endpoints

### Authentication

All API routes are protected using a simple token-based authentication. The token to be used is `vg@123`.

### Blog Routes

- **View All Blogs**: `GET /api/blogs`
- **Create Blog**: `POST /api/blogs`
- **Show Blog**: `GET /api/blogs/{blog}`
- **Update Blog**: `PUT /api/blogs/{blog}`
- **Delete Blog**: `DELETE /api/blogs/{blog}`

### Post Routes

- **View All Posts**: `GET /api/blogs/{blog}/posts`
- **Create Post**: `POST /api/blogs/{blog}/posts`
- **Show Post**: `GET /api/blogs/{blog}/posts/{post}`
- **Update Post**: `PUT /api/blogs/{blog}/posts/{post}`
- **Delete Post**: `DELETE /api/blogs/{blog}/posts/{post}`

### Interaction Routes

- **Like Post**: `POST /api/posts/{post}/like`
- **Comment on Post**: `POST /api/posts/{post}/comment`

## Testing with Postman

1. **Import Postman Collection**:
   - https://documenter.getpostman.com/view/20769634/2sA3kSo3ZE
   - Open Postman.
   - Click on `Import` button.
   - Select the provided Postman collection JSON file.

2. **Set Environment Variables**:
   - Ensure that the base URL (`{{boyatek_baseurl}}`) is set correctly in the Postman environment.
   - Set the `Authorization` header with the value `vg@123` for all requests.
   - Set the `Authorization` header with the value `vg@123` for all requests.

## Additional Notes

### Middleware

- The project uses a custom middleware (`TokenMiddleware`) to handle token-based authentication.

### Disabling CSRF for API Routes

- CSRF protection is disabled for API routes in `app/Http/Middleware/VerifyCsrfToken.php`.

```php
protected $except = [
    'web/*',
];
```

### Clearing Cache

After making changes to the environment or configuration, make sure to clear the cache:

```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan config:cache
```

## Troubleshooting

- If you encounter issues with middleware or route resolution, ensure that the configuration cache is cleared and rebuilt.
- Check `storage/logs/laravel.log` for detailed error messages.
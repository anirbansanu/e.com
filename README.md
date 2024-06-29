### e.com - Documentation

**Repository Overview:**
The e.com repository is a Laravel-based eCommerce web application. It includes various components essential for an eCommerce platform, such as user authentication, product management, and order processing.

**Project Setup:**
1. **Clone the Repository:**
   ```sh
   git clone https://github.com/anirbansanu/e.com.git
   ```
2. **Install Dependencies:**
   ```sh
   cd e.com
   composer install
   npm install
   ```
3. **Environment Configuration:**
   Copy `.env.example` to `.env` and configure your environment variables.
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

**Database Setup:**
1. **Migration:**
   ```sh
   php artisan migrate
   ```
2. **Seeding:**
   ```sh
   php artisan db:seed
   ```

**Running the Application:**
1. **Development Server:**
   ```sh
   php artisan serve
   ```
2. **Compiling Assets:**
   ```sh
   npm run dev
   ```

**Folder Structure:**
- **app/**: Application logic
- **bootstrap/**: Bootstrap files
- **config/**: Configuration files
- **database/**: Migrations and seeders
- **public/**: Public assets
- **resources/**: Views and assets
- **routes/**: Route definitions
- **storage/**: Logs and cached files
- **tests/**: Test cases

**Key Features:**
- **User Authentication**: Registration and login functionality.
- **Product Management**: CRUD operations for products.
- **Order Management**: Handling customer orders and transactions.

**Admin UI:**
The admin UI is built using the `jeroennoten/laravel-adminlte` package. To install and configure it, follow these steps:

1. **Install the Package:**
   ```sh
   composer require jeroennoten/laravel-adminlte
   ```
2. **Publish the Configuration:**
   ```sh
   php artisan adminlte:install
   ```
3. **Customize the Admin Panel:**
   Edit the configuration file `config/adminlte.php` to customize the admin panel according to your requirements.

**Contributing:**
To contribute, fork the repository, create a new branch, and submit a pull request with detailed information on the changes.

**License:**
This project is licensed under the MIT License.

For more details, visit the [GitHub repository](https://github.com/anirbansanu/e.com).
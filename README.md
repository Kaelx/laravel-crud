# Laravel CRUD Application

A full-featured Laravel 12 application with complete CRUD operations for products and categories, featuring both web interface and RESTful API with API key authentication.

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Usage](#usage)
- [API Documentation](#api-documentation)
- [Authentication](#authentication)
- [Project Structure](#project-structure)
- [License](#license)

## ✨ Features

### Web Application

- **User Authentication** - Login, registration, and profile management using Laravel Breeze
- **Role-Based Access Control** - Three user roles: Admin, Staff, and User
- **Product Management** - Full CRUD operations with image upload support
- **Category Management** - Organize products into categories
- **Advanced Filtering** - Search products by name, filter by price range, and sort options
- **Pagination** - Efficient data browsing with pagination
- **Admin Dashboard** - Protected admin routes for management operations

### RESTful API

- **API Key Authentication** - Secure API access with custom API keys
- **Product API** - Complete REST endpoints for product operations
- **JSON Responses** - Standardized JSON response format
- **Validation** - Request validation with detailed error messages
- **Rate Limiting** - API throttling to prevent abuse

## 🛠️ Tech Stack

- **Framework**: Laravel 12.x
- **PHP**: ^8.2
- **Authentication**: Laravel Breeze
- **API**: Laravel Sanctum
- **Frontend**: Blade Templates
- **Database**: MySQL

## 📦 Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd laravel-crud
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file with your database credentials:

```env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_crud
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Migrations and Seeders

```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

**Default Users Created:**

- Admin: `admin@example.com` / `password`
- Staff: `staff@example.com` / `password`

### 6. Create Storage Link

```bash
php artisan storage:link
```

### 7. Build Assets

```bash
# For development
npm run dev

# For production
npm run build
```

### 8. Start Development Server

```bash
# Simple server
php artisan serve

# Or use the advanced dev script
composer dev
```

Visit: `http://localhost:8000`

## 💾 Database Setup

### Database Schema

**Users Table**

- `id`, `name`, `email`, `password`, `role` (admin/staff/user), `email_verified_at`, timestamps

**Products Table**

- `id`, `name`, `description`, `price`, `stock`, `category_id`, `user_id`, `image`, timestamps

**Categories Table**

- `id`, `name`, `description`, timestamps

**API Keys Table**

- `id`, `user_id`, `key`, `name`, `last_used_at`, timestamps

### Relationships

- Products belong to Category and User
- Categories have many Products
- Users have many Products and API Keys

## 📖 Usage

### Web Interface (No css/design yet)

#### For All Authenticated Users

- View products with search and filter
- Create new products
- Edit products
- View product details
- View categories
- Create/edit categories

#### For Admin Users Only

- Delete products
- Full category management (create, update, delete)
- Access admin dashboard

### Product Features

- **Image Upload**: Upload product images (jpeg, png, jpg, max 2MB)
- **Search**: Search products by name
- **Filter**: Filter by price range (min_price, max_price)
- **Sort**: Sort by various fields (name, price, created_at)
- **Pagination**: Browse products with simple pagination

## 🔌 API Documentation

Base URL: `http://localhost:8000/api`

### Authentication

All API endpoints (except key generation) require an API key in the header:

```
api_key: your-api-key-here
```

### Generate API Key

**Endpoint:** `POST /api/keys/generate`

**Request Body:**

```json
{
    "email": "admin@example.com",
    "password": "password",
    "name": "My API Key"
}
```

**Response:**

```json
{
    "success": true,
    "message": "API key generated successfully",
    "data": {
        "api_key": "sk...",
        "name": "My API Key",
        "created_at": "2026-01-18T10:30:00.000000Z"
    }
}
```

### Product Endpoints

#### List All Products

**Endpoint:** `GET /api/products`

**Query Parameters:**

- `search` - Search by product name
- `min_price` - Filter by minimum price
- `max_price` - Filter by maximum price
- `sort_by` - Sort field (default: created_at)
- `sort_order` - Sort order: asc/desc (default: desc)

**Example:**

```bash
curl -X GET "http://localhost:8000/api/products?search=phone&min_price=100" \
  -H "api_key: your-api-key"
```

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Product Name",
            "description": "Product description",
            "price": "99.99",
            "stock": 50,
            "category_id": 1,
            "user_id": 1,
            "image": "products/image.jpg",
            "created_at": "2026-01-18T10:30:00.000000Z",
            "updated_at": "2026-01-18T10:30:00.000000Z"
        }
    ]
}
```

#### Get Single Product

**Endpoint:** `GET /api/products/{id}`

**Response:**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Product Name",
        "description": "Product description",
        "price": "99.99",
        "stock": 50,
        "category": {
            "id": 1,
            "name": "Electronics"
        },
        "user": {
            "id": 1,
            "name": "Admin"
        }
    }
}
```

#### Create Product

**Endpoint:** `POST /api/products`

**Request Body (multipart/form-data):**

```
name: Product Name (required)
description: Product description (optional)
price: 99.99 (required, numeric, min:0)
stock: 50 (required, integer, min:0)
category_id: 1 (required, exists in categories)
image: file (optional, jpeg/png/jpg, max:2048KB)
```

**Response:**

```json
{
    "success": true,
    "message": "Product created successfully",
    "data": {
        "id": 1,
        "name": "Product Name",
        ...
    }
}
```

#### Update Product

**Endpoint:** `PUT /api/products/{id}`

**Request Body:** Same as create

**Response:**

```json
{
    "success": true,
    "message": "Product updated successfully",
    "data": { ... }
}
```

#### Delete Product

**Endpoint:** `DELETE /api/products/{id}`

**Response:**

```json
{
    "success": true,
    "message": "Product deleted successfully"
}
```

### Error Responses

#### Validation Error (422)

```json
{
    "success": false,
    "message": "Validation error",
    "errors": {
        "name": ["The name field is required."],
        "price": ["The price must be a number."]
    }
}
```

#### Unauthorized (401)

```json
{
    "success": false,
    "message": "API key is required"
}
```

#### Not Found (404)

```json
{
    "success": false,
    "message": "Product not found"
}
```

## 🔐 Authentication

### Web Authentication

- Uses Laravel Breeze for authentication
- Session-based authentication
- Protected routes with `auth` middleware
- Admin routes protected with `admin` middleware

### API Authentication

- Custom API key authentication
- API keys stored in database with `sk` prefix
- Keys are 62 characters long
- Tracks last used timestamp
- Middleware: `AuthenticateWithApiKey`

### User Roles

- **Admin**: Full access to all features including delete operations
- **Staff**: Can create and edit products/categories
- **User**: Can view and create products

## 📁 Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── ApiKeyController.php
│   │   │   │   └── ProductController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── ProductController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   │   ├── AuthenticateWithApiKey.php
│   │   │   └── isAdmin.php
│   │   └── Requests/
│   ├── Models/
│   │   ├── ApiKey.php
│   │   ├── Category.php
│   │   ├── Product.php
│   │   └── User.php
│   └── Providers/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── products/
│   │   ├── categories/
│   │   └── auth/
│   ├── css/
│   └── js/
├── routes/
│   ├── api.php          # API routes
│   ├── web.php          # Web routes
│   └── auth.php         # Authentication routes
├── public/
│   └── storage/         # Public storage link
├── storage/
│   └── app/
│       └── public/
│           └── products/  # Product images
└── tests/
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter TestName
```

## 🎯 Key Features Explained

### Image Upload

- Images stored in `storage/app/public/products/`
- Automatic old image deletion on update
- Validation: jpeg, png, jpg formats, max 2MB
- Accessible via public storage link

### Middleware

- `api.key`: Validates API key authentication
- `admin`: Restricts access to admin users only
- `auth`: Requires user authentication
- `throttle:api`: Rate limiting for API endpoints

### Request Validation

- Server-side validation for all inputs
- Custom error messages
- Returns 422 status code for validation errors

## 📝 Scripts

Composer scripts available:

```bash
# Full project setup
composer setup

# Start development environment
composer dev

# Run tests
composer test
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🐛 Troubleshooting

### Storage Link Issues

```bash
php artisan storage:link
```

### Permission Issues

```bash
chmod -R 775 storage bootstrap/cache
```

### Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Migration Issues

```bash
php artisan migrate:fresh --seed
```

## 📧 Contact

For questions or support, please open an issue on the repository.

---

**Built with ❤️ using Laravel**

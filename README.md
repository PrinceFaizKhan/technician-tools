# 🛠️ Technician Toolkit

A modern, high-performance platform for home appliance and HVAC (AC, Refrigerator, Washing Machine, Microwave, etc.) technicians. Built with **Laravel 13**, **FilamentPHP v3**, and **MySQL**, utilizing **Singleton Design Patterns** and a clean service architecture.

---

## 🌟 Key Features

* **Error Code Finder (795+ Fault Codes)**: Searchable fault database with causes, step-by-step troubleshooting, and downloadable technical PDFs.
* **Appliance & Brand Master**: Organized across 7 core appliances and 298 equipment brands.
* **Gas Charging & Pressure Charts (11 Refrigerants)**: Standing, suction, and discharge pressure specifications.
* **Compressor Directory (80+ Compressors)**: Model specifications, HP capacity, and wiring diagrams.
* **Spare Parts & Product Catalog (68+ Products)**: Categories, sub-categories, pricing, and purchase links.
* **Video Tutorials & Courses**: Training course modules and video lessons for skill growth.
* **Technical Articles**: Service blogs and troubleshooting guides.
* **Modern Filament v3 Admin Panel**: Fast, responsive management dashboard with real-time statistics.
* **Dual API Support**: Modern RESTful API v1 with Laravel Sanctum tokens + legacy compatible routes.

---

## 💻 Tech Stack & Requirements

* **PHP**: `>= 8.2` (PHP 8.3 recommended)
* **Framework**: Laravel 13.x
* **Database**: MySQL 8.0+ / 9.x
* **Admin Dashboard**: FilamentPHP v3
* **API Auth**: Laravel Sanctum
* **Composer**: `>= 2.0`
* **Node.js & NPM**: `>= 18.0`

---

## 🚀 Step-by-Step Setup Guide

### 1. Clone & Navigate to Project

```bash
git clone <repository-url> technician_toolkit
cd technician_toolkit
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the example environment file:

```bash
cp .env.example .env
```

Generate the application encryption key:

```bash
php artisan key:generate
```

### 4. Configure Database Credentials

Open `.env` and set your MySQL database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=technician_toolkit
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

> **Note**: Make sure the database exists in MySQL before running migrations:
> ```sql
> CREATE DATABASE IF NOT EXISTS technician_toolkit CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
> ```

---

### 5. Run Migrations & Seed Default Data

Run the database migrations and seed the super admin user along with default application settings:

```bash
php artisan migrate --seed
```

This will automatically create:
* All relational tables (`appliances`, `brands`, `error_codes`, `compressors`, `refrigerants`, `products`, `courses`, `articles`, `banners`, `app_settings`, etc.)
* **Super Admin User**:
  * **Email**: `admin@gmail.com`
  * **Password**: `nasruddin@#321@#`
  * **Role**: `admin`

---

### 6. (Optional) Import Legacy Live Data

If you want to populate your local MySQL database with all live data from the existing system (795 error codes, 298 brands, 80 compressors, 68 products, 11 refrigerants, etc.):

```bash
php artisan toolkit:import-live
```

---

### 7. Link Public Storage

Create the symbolic link from `public/storage` to `storage/app/public` for file uploads:

```bash
php artisan storage:link
```

---

### 8. Start the Local Server

```bash
php artisan serve
```

The application is now accessible at:
* **Landing Page**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
* **Filament Admin Panel**: [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)

---

## 🔐 Admin Panel Access

1. Open your browser and navigate to: **`http://127.0.0.1:8000/admin`**
2. Log in with your admin credentials:
   * **Email**: `admin@gmail.com`
   * **Password**: `nasruddin@#321@#`

Features inside the Admin Panel:
* Real-time Overview Dashboard with stats
* Appliances & Brands Manager
* Error Codes CRUD with PDF upload and multi-filters
* Compressor & Refrigerant specs management
* Product catalog and categories
* Course and video playlist management
* Article CMS with rich-text editor
* Banner management

---

## 📡 REST API Reference

All modern API endpoints are available under the `/api/v1` prefix:

### Authentication
* `POST /api/v1/auth/login` - Obtain Sanctum bearer token
* `GET  /api/v1/auth/me` - Authenticated user profile *(Requires Bearer Token)*
* `POST /api/v1/auth/logout` - Revoke current token *(Requires Bearer Token)*

### Content & Reference
* `GET /api/v1/appliances` - List all appliances
* `GET /api/v1/brands` - List brands (supports `?appliance_id=`)
* `GET /api/v1/error-codes` - Search error codes (supports `?search=E1&appliance_id=&brand_id=`)
* `GET /api/v1/refrigerants` - Refrigerant pressure & specifications
* `GET /api/v1/compressors` - Compressor catalog & specs
* `GET /api/v1/products` - Spares & equipment catalog (supports `?trending=1&category_id=`)
* `GET /api/v1/courses` - Training courses & video tutorials
* `GET /api/v1/articles` - Technical service guides
* `GET /api/v1/banners` - Active promotional banners
* `GET /api/v1/settings` - Global configurations & WhatsApp support contacts

### Legacy Mobile App Aliases (Backwards Compatible)
* `POST /api/login-admin`
* `GET  /api/get-all-appliance-error-code-list`
* `GET  /api/get-all-brand-name-error-code-list`
* `GET  /api/get-all-error-codes-list`
* `GET  /api/get-all-compressor`
* `GET  /api/get-all-refrigerant`
* `GET  /api/get-all-products`
* `GET  /api/get-all-course-list`
* `GET  /api/get-all-articals`
* `GET  /api/get-all-banner`

---

## 🏗️ Architecture & Design Patterns

* **Singleton Pattern**:
  * `AppSettingsService`: In-memory cached settings and configuration manager.
  * `MediaStorageService`: Unified asset storage abstraction (Local / S3 / Cloudflare R2).
  * `ErrorCodeSearchService`: Optimized multi-criteria error code search provider.
* **Service-Repository Pattern**: Clean separation between HTTP presentation layer, business services, and Eloquent data models.

---

## 🧪 Testing & Code Quality

Run the PHPUnit test suite:

```bash
php artisan test
```

Format code according to Laravel coding standards using Pint:

```bash
vendor/bin/pint --format agent
```

---

## 👤 Credits

* **Author**: Faizan Khan
* **Copyright**: © 2026 Technician Toolkit

# PHP_Laravel12_Livewire_PowerGrid

## Project Overview

Laravel 12 PowerGrid Product Management is a complete Laravel + Livewire + PowerGrid project that demonstrates how to build advanced data tables with sorting, filtering, pagination, and CRUD actions using a Product model.

This project shows how to integrate Livewire PowerGrid into a Laravel 12 application to create dynamic, responsive, and feature‑rich admin tables for managing products efficiently.

---

## Features

* Livewire Data Table
* Sorting Columns
* Global Search
* Column Filters
* Pagination
* Toggle Column Visibility
* Row Actions (Edit / Delete)
* Responsive UI
* Seeder with Fake Data
* Tailwind CSS Styling

---

## Technology Stack

* Laravel 12
* Livewire
* PowerGrid
* MySQL
* Tailwind CSS
* Faker

---

## Installation Guide

### Step 1 — Create New Laravel Project

```bash
composer create-project laravel/laravel powergrid-demo
cd powergrid-demo
```

### Step 2 — Install Livewire

```bash
composer require livewire/livewire
```

### Step 3 — Install PowerGrid

```bash
composer require power-components/livewire-powergrid
```

### Step 4 — Publish PowerGrid Assets

```bash
php artisan powergrid:publish
```

---

## Database Configuration

Edit `.env` file:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=powergrid_demo
DB_USERNAME=root
DB_PASSWORD=
```

---

## Create Product Model and Migration

```bash
php artisan make:model Product -m
php artisan migrate
```

### Products Table Fields

* id
* name
* description
* price
* stock
* category
* is_active
* timestamps

---

## Factory and Seeder

### Create Factory

```bash
php artisan make:factory ProductFactory
```

### Create Seeder

```bash
php artisan make:seeder ProductSeeder
```

### Run Seeder

```bash
php artisan db:seed --class=ProductSeeder
```

---

## Generate PowerGrid Table

```bash
php artisan powergrid:create ProductTable
```

### Options

* Model: App\Models\Product
* Use Model: Yes
* Fillable: No
* Include Views: No

---

## Livewire PowerGrid Component

File:

```
app/Livewire/ProductTable.php
```

### Capabilities

* Search Input
* Toggle Columns
* Per Page Selector
* Record Count
* Filters
* Custom Actions
* Date Formatting
* Boolean Display

---

## Layout and Views

### Layout File

```
resources/views/layouts/app.blade.php
```

Includes:

* Tailwind CDN
* Livewire Styles and Scripts
* PowerGrid CSS and JavaScript
* Navigation Bar
* Slot Content Area

### Product View

```
resources/views/products/index.blade.php
```

Displays:

* Product Table
* Edit Event Listener
* Delete Confirmation
* Livewire Component

---

## Controller

```bash
php artisan make:controller ProductController
```

### Method

* `index()` — Loads product table view

---

## Routes

File: `routes/web.php`

```
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
```

---

## Delete Functionality

Add `deleteProduct()` method inside PowerGrid component.

### Behavior

* Find Product
* Delete Record
* Dispatch Success or Error Toast

---

## Run Application

```bash
php artisan serve
```

Visit:

```
http://localhost:8000/products

```
<img width="1662" height="970" alt="image" src="https://github.com/user-attachments/assets/9a1621e7-070a-4b10-af0c-1bdf81e4e09f" />

---

## Table Capabilities

* Column Sorting
* Global Search
* Individual Filters
* Pagination
* Toggle Column Visibility
* Edit and Delete Row Actions
* Responsive Layout

---

## Suggested Enhancements

* Add Create Product Modal
* Add Edit Product Modal
* Export CSV or Excel
* Advanced Category Filters
* Dark Mode Theme
* Role‑Based Permissions

---

## Use Cases

* Admin Dashboards
* Inventory Systems
* Product Management Panels
* CRM Data Tables
* ERP Interfaces

---

## Requirements

* PHP 8.2 or Higher
* Composer
* MySQL
* Node.js (Optional)
* Laravel 12

---

## License

MIT License

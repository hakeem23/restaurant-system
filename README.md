# Restaurant System

A Laravel 11-based system for managing restaurant orders, tracking ingredient stock levels, and automating low-stock alerts.

## Features

- Order placement with stock deduction
- Ingredient stock management
- Automatic low-stock email alerts
- Unit tests for repositories and core functionality

---

## 🚀 Getting Started

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/hakeem23/restaurant-system.git
cd restaurant-system
```

### 2️⃣ Install Dependencies

```bash
composer install
```

### 3️⃣ Set Up Environment Variables

Copy the example environment file:

```bash
cp .env.example .env
```

Then update `.env` with your database credentials.

### 4️⃣ Set Up Docker (Optional, Recommended)

To use Docker for MySQL and Laravel services, run:

```bash
docker-compose up -d
```

This will create `restaurant_system` and `restaurant_system_test` databases.

### 5️⃣ Create the Databases

If not using Docker, manually create the databases:

```sql
CREATE DATABASE restaurant_system;
CREATE DATABASE restaurant_system_test;
```

### 6️⃣ Run Migrations & Seed Data

```bash
php artisan migrate --seed
```

### 7️⃣ Start the Development Server

```bash
php artisan serve
```

---

## 🛠 API Endpoints

### ✅ Place an Order

```http
POST /api/orders
```

**Request Body:**

```json
{
    "products": [
        {
            "product_id": 1,
            "quantity": 2
        }
    ]
}
```

---

## 🧪 Running Tests

To run unit tests, execute:

```bash
php artisan test
```

To run tests using the testing database:

```bash
php artisan test --env=testing
```

---

## 📌 Notes

- Ensure the `.env` file is correctly configured for both local and testing environments.
- If using Docker, confirm the database containers are running.
- Debug logs can be found in `storage/logs/laravel.log`.



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

## 📌 Notes

- Ensure the `.env` file is correctly configured for both local and testing environments.
- If using Docker, confirm the database containers are running.
- Debug logs can be found in `storage/logs/laravel.log`.
---

# Technical Overview of Restaurant System

## Design Patterns Used

### Repository Pattern
- The **Repository Pattern** is used to abstract database queries and promote separation of concerns.
- Each model has its corresponding repository handling data interactions (e.g., `OrderRepository`, `ProductRepository`, `IngredientRepository`).
- Benefits:
    - Keeps controllers clean and focused on business logic.
    - Improves testability by allowing dependency injection.
    - Encapsulates complex queries in dedicated classes.

### Service Layer
- A **Service Layer** is introduced to handle business logic, making controllers lightweight.
- Example: `OrderService` processes order creation, stock deduction, and low-stock alerts.

### Dependency Injection
- Dependencies such as repositories and services are injected into controllers, improving modularity and testability.

## SOLID Principles Applied

### **S**ingle Responsibility Principle (SRP)
- Each class has a single responsibility:
    - **Repositories** handle database interactions.
    - **Services** handle business logic.
    - **Controllers** handle request validation and response formatting.

### **O**pen-Closed Principle (OCP)
- The system is open for extension but closed for modification.
- Example: New notification methods (e.g., SMS, Slack) can be added without modifying existing email alerts.

## Additional Technical Details

### Database Design
- Uses a **normalized relational schema**:
    - `products` table stores product information.
    - `ingredients` table tracks stock levels.
    - `orders` table records customer orders.
    - `order_product` pivot table maintains many-to-many relationships between orders and products.

### Event-Driven Architecture
- **Events and Listeners** are used for handling asynchronous tasks like sending email notifications.
- Example: When an order is placed, an event triggers an email alert if stock is low.

### Testing Strategy
- Unit and feature tests are written for repositories, services, and controllers.
- Mocks and fakes are used to isolate dependencies.

## Conclusion
This project follows best practices in design patterns, SOLID principles, and software architecture to ensure maintainability, scalability, and testability.




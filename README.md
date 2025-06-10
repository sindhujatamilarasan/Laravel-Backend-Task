# Laravel Backend Interview Task

A Laravel-based backend system implementing user authentication, product management, and a stubbed payment initiation using stripe. It also includes a basic Blade UI interface for product CRUD and user login/register functionality.

---

## ✅ Features Implemented

### 1. Authentication & Authorization
- User registration and login using email and password.
- Token-based authentication using Laravel Sanctum.
- Only authenticated users can access product and payment routes.

### 2. Product Management
- Authenticated users can create, update, list, and delete their own products.
- Ownership checks ensure no user can modify another user's products.
- Includes Blade-based UI for product CRUD.

### 3. Payment Initiation Stub
- `POST /payments` API initiates a payment stub.
- Accepts `product_id` and `payment_method`.
- Ensures quantity is available and reduces it inside a DB transaction.
- Designed for future plug-and-play payment method integration.

- In Current implementation i reduced quantity on intiating a payment itself actually after success payment we need to reduce quantity.

---

## 🗂 API Endpoints

| Method | Endpoint                   | Description                     |
|--------|----------------------------|---------------------------------|
| POST   | /api/users                 | Register a new user             |
| POST   | /api/login                 | Login user and receive token    |
| POST   | /api/logout                | Logout authenticated user       |
| GET    | /api/products              | List all products (user owned)  |
| POST   | /api/products              | Create product                  |
| PUT    | /api/products/{id}         | Update product (owned only)     |
| POST   | /api/products/delete/{id}  | Delete product (owned only)     |
| POST   | /api/payments              | Initiate payment for a product  |

All product/payment routes are protected with `auth:sanctum` middleware.

---

## 🧪 Postman Collection

A Postman collection is included in the `/postman/` folder (or exported separately) to test all API endpoints.

---

## 🖥 Interface (Optional Bonus)

A Blade-based interface is included at `/resources/views/home.blade.php` for demo purposes:
- Register/Login UI 
- Product crud
- Added Basic structure ui

Access it via:http://127.0.0.1:8000/

# API Testing Guide

This guide explains how to test the REST API for the UMKM Inventory application.

## 1. Automated Testing (Recommended)

The application comes with a suite of automated tests using PHPUnit. This is the fastest way to verify that all API endpoints are working correctly.

### Running Tests
Open your terminal and run:

```bash
php artisan test
```

This command will:
- Create a temporary in-memory database.
- Run all migrations.
- Execute tests for Authentication, Products, Customers, Categories, and Suppliers.
- Report pass/fail status.

### Test Files Location
- `tests/Feature/CategoryApiTest.php`
- `tests/Feature/SupplierApiTest.php`
- `tests/Feature/ProductApiTest.php`
- `tests/Feature/CustomerApiTest.php`
- `tests/Feature/AuthTest.php`

---

## 2. Manual Testing with cURL

You can manually test the API using `curl` in your terminal. Ensure your server is running (`php artisan serve`).

### Step 1: Get Access Token
First, you need to login to get a Bearer token.

```bash
# Login (using default seeder credentials)
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com", "password":"password"}'
```

Copy the `access_token` from the response.

### Step 2: Test Categories

**Create Category:**
```bash
curl -X POST http://127.0.0.1:8000/api/categories \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"New Category", "code":"NEW-001", "description":"Test desc", "is_active":true}'
```

**List Categories:**
```bash
curl http://127.0.0.1:8000/api/categories \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

**Search Categories:**
```bash
curl "http://127.0.0.1:8000/api/categories?q=New" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### Step 3: Test Suppliers

**Create Supplier:**
```bash
curl -X POST http://127.0.0.1:8000/api/suppliers \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"New Supplier", "email":"new@supplier.com", "phone":"08123456789", "status":"active"}'
```

**List Suppliers:**
```bash
curl http://127.0.0.1:8000/api/suppliers \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

**Filter Suppliers:**
```bash
curl "http://127.0.0.1:8000/api/suppliers?status=active" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

---

## 3. Manual Testing with Postman

1.  **Import Collection**: You can create a new collection in Postman.
2.  **Set Environment Variable**: Create a variable `base_url` = `http://127.0.0.1:8000/api`.
3.  **Login Request**:
    *   POST `{{base_url}}/login`
    *   Body (JSON): `{"email": "admin@example.com", "password": "password"}`
    *   Save the token from response.
4.  **Authenticated Requests**:
    *   For other requests (GET/POST/PUT/DELETE), go to the **Authorization** tab.
    *   Select Type: **Bearer Token**.
    *   Paste your token.
5.  **Send Requests**:
    *   GET `{{base_url}}/categories`
    *   POST `{{base_url}}/categories` (with JSON body)
    *   etc.

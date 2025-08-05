# API Documentation - Etukang

## Base URL
```
https://your-domain.com/api
```

## Authentication
API menggunakan Laravel Sanctum untuk authentication. Semua endpoint (kecuali yang disebutkan sebagai public) memerlukan Bearer token.

### Headers
```
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
```

---

## 🔐 Authentication Endpoints

### 1. Register User
**POST** `/register`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response Success (201):**
```json
{
    "message": "User berhasil didaftarkan",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "token": "1|abc123...",
        "token_type": "Bearer"
    }
}
```

### 2. Login User
**POST** `/login`

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response Success (200):**
```json
{
    "message": "Login berhasil",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "token": "1|abc123...",
        "token_type": "Bearer"
    }
}
```

### 3. Logout User
**POST** `/logout`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "message": "Logout berhasil"
}
```

### 4. Refresh Token
**POST** `/refresh-token`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "message": "Token berhasil diperbarui",
    "data": {
        "token": "2|def456...",
        "token_type": "Bearer"
    }
}
```

---

## 👤 Profile Endpoints

### 1. Get User Profile
**GET** `/profile`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "email_verified_at": "2024-01-01T00:00:00.000000Z",
        "created_at": "01/01/2024 00:00",
        "updated_at": "01/01/2024 00:00"
    }
}
```

### 2. Update User Profile
**PUT** `/profile`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "John Updated",
    "email": "john.updated@example.com"
}
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Profile berhasil diperbarui",
    "data": {
        "id": 1,
        "name": "John Updated",
        "email": "john.updated@example.com"
    }
}
```

### 3. Change Password
**PUT** `/profile/password`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "current_password": "oldpassword123",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Password berhasil diubah"
}
```

---

## 🛒 Cart Endpoints

### 1. Get All Carts
**GET** `/carts`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Data cart berhasil diambil",
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "product_id": 1,
            "merchant_id": 1,
            "quantity": 2,
            "price": 50000,
            "status": "active",
            "product": {
                "id": 1,
                "name": "Product Name",
                "description": "Product Description",
                "price": 25000
            }
        }
    ]
}
```

### 2. Add Item to Cart
**POST** `/carts`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "product_id": 1,
    "merchant_id": 1,
    "quantity": 2
}
```

**Response Success (201):**
```json
{
    "success": true,
    "message": "Item berhasil ditambahkan ke cart",
    "data": {
        "id": 1,
        "user_id": 1,
        "product_id": 1,
        "merchant_id": 1,
        "quantity": 2,
        "price": 50000,
        "status": "active"
    }
}
```

### 3. Update Cart Item
**PUT** `/carts/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "quantity": 3
}
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Cart berhasil diupdate",
    "data": {
        "id": 1,
        "quantity": 3,
        "price": 75000
    }
}
```

### 4. Remove Item from Cart
**DELETE** `/carts/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Item berhasil dihapus dari cart"
}
```

---

## 💳 Transaction Endpoints

### 1. Create Transaction from Cart
**POST** `/transactions`

**Headers:** `Authorization: Bearer {token}`

**Request Body:** `{}` (tidak ada body, menggunakan cart yang aktif)

**Response Success (201):**
```json
{
    "success": true,
    "message": "Transaksi berhasil dibuat",
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "merchant_id": 1,
            "total_price": 50000,
            "status": "pending",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "transaction_detail": [
                {
                    "id": 1,
                    "transaction_id": 1,
                    "product_id": 1,
                    "quantity": 2,
                    "price": 50000,
                    "status": "pending"
                }
            ],
            "payment": {
                "id": 1,
                "transaction_id": 1,
                "payment_code": "EDUPAY-123456",
                "payment_method": "cash",
                "payment_status": "pending"
            }
        }
    ]
}
```

### 2. Update Transaction Status
**PUT** `/transactions/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "status": "paid"
}
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Transaksi berhasil diupdate",
    "data": {
        "id": 1,
        "status": "paid",
        "transaction_detail": [...],
        "payment": {...}
    }
}
```

### 3. Cancel Transaction
**DELETE** `/transactions/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Transaksi berhasil dibatalkan"
}
```

---

## 🏪 Merchant Endpoints

### 1. Get All Merchants
**GET** `/merchants`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Data merchant berhasil diambil",
    "data": [
        {
            "id": 1,
            "name": "Merchant Name",
            "description": "Merchant Description",
            "address": "Merchant Address",
            "phone": "08123456789",
            "email": "merchant@example.com",
            "status": "active"
        }
    ]
}
```

### 2. Create Merchant
**POST** `/merchants`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "New Merchant",
    "description": "Merchant Description",
    "address": "Merchant Address",
    "phone": "08123456789",
    "email": "merchant@example.com"
}
```

**Response Success (201):**
```json
{
    "success": true,
    "message": "Merchant berhasil dibuat",
    "data": {
        "id": 1,
        "name": "New Merchant",
        "description": "Merchant Description",
        "address": "Merchant Address",
        "phone": "08123456789",
        "email": "merchant@example.com",
        "status": "active"
    }
}
```

### 3. Update Merchant
**PUT** `/merchants/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "Updated Merchant",
    "description": "Updated Description"
}
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Merchant berhasil diupdate",
    "data": {
        "id": 1,
        "name": "Updated Merchant",
        "description": "Updated Description"
    }
}
```

### 4. Delete Merchant
**DELETE** `/merchants/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Merchant berhasil dihapus"
}
```

---

## 📦 Product Endpoints

### 1. Get All Products
**GET** `/products`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Data product berhasil diambil",
    "data": [
        {
            "id": 1,
            "merchant_id": 1,
            "name": "Product Name",
            "description": "Product Description",
            "price": 25000,
            "stock": 100,
            "status": "active",
            "merchant": {
                "id": 1,
                "name": "Merchant Name"
            }
        }
    ]
}
```

### 2. Create Product
**POST** `/products`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "merchant_id": 1,
    "name": "New Product",
    "description": "Product Description",
    "price": 25000,
    "stock": 100
}
```

**Response Success (201):**
```json
{
    "success": true,
    "message": "Product berhasil dibuat",
    "data": {
        "id": 1,
        "merchant_id": 1,
        "name": "New Product",
        "description": "Product Description",
        "price": 25000,
        "stock": 100,
        "status": "active"
    }
}
```

### 3. Update Product
**PUT** `/products/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "Updated Product",
    "price": 30000,
    "stock": 50
}
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Product berhasil diupdate",
    "data": {
        "id": 1,
        "name": "Updated Product",
        "price": 30000,
        "stock": 50
    }
}
```

### 4. Delete Product
**DELETE** `/products/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Product berhasil dihapus"
}
```

---

## 💰 Payment Notification (Public)

### Payment Notification Callback
**POST** `/payment-notification/{code}`

**Request Body:**
```json
{
    "status": "paid",
    "amount": 50000,
    "payment_method": "cash"
}
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Payment notification received"
}
```

---

## 📋 Error Responses

### Validation Error (422)
```json
{
    "message": "Validation error",
    "errors": {
        "email": ["Email sudah digunakan."],
        "password": ["Password minimal 8 karakter."]
    }
}
```

### Unauthorized (401)
```json
{
    "message": "Akses ditolak: Anda belum login atau token tidak valid.",
    "error": "UNAUTHENTICATED",
    "hint": "Pastikan sudah login dan mengirimkan Authorization: Bearer <token>"
}
```

### Not Found (404)
```json
{
    "success": false,
    "message": "Data tidak ditemukan"
}
```

### Server Error (500)
```json
{
    "success": false,
    "message": "Terjadi kesalahan pada server",
    "error": "INTERNAL_SERVER_ERROR"
}
```

---

## 🔧 Testing dengan Postman

### Setup Postman Collection:
1. Buat collection baru dengan nama "Etukang API"
2. Set environment variable:
   - `base_url`: `https://your-domain.com/api`
   - `token`: (akan diisi setelah login)

### Authentication Flow:
1. **Register/Login** → Dapatkan token
2. Set token ke environment variable
3. Gunakan token di header Authorization untuk request lainnya

### Contoh Request di Postman:
```
POST {{base_url}}/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password123"
}
```

---

## 📝 Notes

- Semua endpoint memerlukan authentication kecuali `/register`, `/login`, dan `/payment-notification/{code}`
- Token harus dikirim dalam header `Authorization: Bearer {token}`
- Response selalu dalam format JSON
- Error handling konsisten di semua endpoint
- Database transaction digunakan untuk operasi yang melibatkan multiple table 

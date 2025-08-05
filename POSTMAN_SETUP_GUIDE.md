# 🚀 Panduan Setup Postman untuk Etukang API

## 📋 Prerequisites
- Postman Desktop App atau Postman Web
- API server Etukang sudah running
- File collection dan environment yang sudah dibuat

## 📥 Cara Import Collection & Environment

### 1. Import Collection
1. Buka Postman
2. Klik tombol **"Import"** di pojok kiri atas
3. Drag & drop file `Etukang_API_Collection.json` atau klik **"Upload Files"**
4. Klik **"Import"**

### 2. Import Environment
1. Klik **"Import"** lagi
2. Drag & drop file `Etukang_API_Environment.json`
3. Klik **"Import"**

### 3. Setup Environment
1. Di dropdown environment (pojok kanan atas), pilih **"Etukang API Environment"**
2. Klik icon gear ⚙️ untuk edit environment
3. Update `base_url` sesuai dengan server Anda:
   - **Development**: `http://localhost:8000/api`
   - **Staging**: `https://staging.etukang.com/api`
   - **Production**: `https://api.etukang.com/api`

## 🔐 Cara Mendapatkan Token

### Step 1: Register User
1. Buka request **"Register User"** di folder **"🔐 Authentication"**
2. Update body request dengan data user baru:
```json
{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```
3. Klik **"Send"**
4. Copy token dari response

### Step 2: Set Token ke Environment
1. Klik icon gear ⚙️ environment
2. Update field `token` dengan token yang didapat
3. Klik **"Save"**

### Step 3: Test Authentication
1. Buka request **"Get User Profile"** di folder **"👤 Profile"**
2. Klik **"Send"**
3. Jika berhasil, akan muncul data profile user

## 🧪 Testing Flow

### 1. Authentication Flow
```
Register → Login → Get Profile → Update Profile → Change Password → Logout
```

### 2. Cart Flow
```
Add Item to Cart → Get All Carts → Update Cart Item → Remove Item from Cart
```

### 3. Transaction Flow
```
Create Transaction → Update Transaction Status → Cancel Transaction
```

### 4. Merchant Flow
```
Create Merchant → Get All Merchants → Update Merchant → Delete Merchant
```

### 5. Product Flow
```
Create Product → Get All Products → Update Product → Delete Product
```

## 🔧 Tips & Tricks

### 1. Auto-save Response Data
Untuk request yang menghasilkan ID, Anda bisa menambahkan test script:

**Untuk Login Response:**
```javascript
if (pm.response.code === 200) {
    const response = pm.response.json();
    pm.environment.set("user_id", response.data.user.id);
    pm.environment.set("token", response.data.token);
}
```

**Untuk Create Product Response:**
```javascript
if (pm.response.code === 201) {
    const response = pm.response.json();
    pm.environment.set("product_id", response.data.id);
}
```

### 2. Dynamic Variables
Gunakan variable di URL untuk request yang memerlukan ID:
- `{{base_url}}/products/{{product_id}}`
- `{{base_url}}/merchants/{{merchant_id}}`
- `{{base_url}}/transactions/{{transaction_id}}`

### 3. Pre-request Scripts
Untuk request yang memerlukan data dari request sebelumnya, gunakan pre-request script:

```javascript
// Contoh: Set merchant_id dari environment
pm.request.url.path[1] = pm.environment.get("merchant_id");
```

## 📊 Testing Checklist

### ✅ Authentication
- [ ] Register user baru
- [ ] Login dengan credentials yang benar
- [ ] Login dengan credentials yang salah
- [ ] Get profile dengan token valid
- [ ] Get profile tanpa token
- [ ] Update profile
- [ ] Change password
- [ ] Logout

### ✅ Cart Management
- [ ] Add item ke cart
- [ ] Get all carts
- [ ] Update quantity cart
- [ ] Remove item dari cart
- [ ] Add item dengan merchant berbeda

### ✅ Transaction
- [ ] Create transaction dari cart
- [ ] Update transaction status
- [ ] Cancel transaction
- [ ] Create transaction dengan multiple merchants

### ✅ Merchant Management
- [ ] Create merchant
- [ ] Get all merchants
- [ ] Update merchant
- [ ] Delete merchant

### ✅ Product Management
- [ ] Create product
- [ ] Get all products
- [ ] Update product
- [ ] Delete product

### ✅ Payment Notification
- [ ] Payment notification callback
- [ ] Test dengan berbagai status payment

## 🚨 Common Issues & Solutions

### Issue 1: "Unauthorized" Error
**Solution:**
- Pastikan token sudah diset di environment
- Cek apakah token masih valid
- Login ulang untuk mendapatkan token baru

### Issue 2: "Not Found" Error
**Solution:**
- Pastikan ID yang digunakan ada di database
- Cek apakah data sudah dibuat sebelumnya
- Gunakan ID yang valid dari response sebelumnya

### Issue 3: "Validation Error"
**Solution:**
- Cek format data yang dikirim
- Pastikan semua field required terisi
- Cek tipe data (string, integer, dll)

### Issue 4: "Server Error"
**Solution:**
- Cek apakah server running
- Cek log error di server
- Pastikan database connection OK

## 📝 Notes

1. **Environment Variables**: Selalu gunakan environment variables untuk data yang dinamis
2. **Token Management**: Token akan expire, jadi perlu refresh secara berkala
3. **Data Consistency**: Pastikan data yang dibuat untuk testing dihapus setelah selesai
4. **Error Handling**: Test juga error cases, bukan hanya success cases
5. **Performance**: Monitor response time untuk setiap request

## 🔗 Useful Links

- [Postman Documentation](https://learning.postman.com/)
- [Laravel Sanctum Documentation](https://laravel.com/docs/sanctum)
- [API Testing Best Practices](https://www.postman.com/company/blog/)

---

**Happy Testing! 🎉** 

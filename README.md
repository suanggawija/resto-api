# Resto API Documentation

## Authentication

### POST : Login

```json
"http://127.0.0.1:8000/api/auth/login"
```

**Headers**:

-   `Accept: application/json`

**Body** (JSON):

```json
{
    "email": "email@email.com",
    "password": "password"
}
```

---

### GET : Logout

```json
"http://127.0.0.1:8000/api/auth/logout"
```

**Headers**:

-   `Accept: application/json`
-   `Authorization: Bearer <token>`

---

## User

### POST : Create User

```json
"http://127.0.0.1:8000/api/user"
```

**Headers**:

-   `Accept: application/json`

**Body** (JSON):

```json
{
    "name": "name",
    "email": "email@email.com",
    "password": "password",
    "role_id": 1
}
```

---

### GET Get User

```json
"http://127.0.0.1:8000/api/user"
```

---

## Order

### POST : Create Order

```json
"http://127.0.0.1:8000/api/order"
```

**Headers**:

-   `Accept: application/json`
-   `Authorization: Bearer <token>`

**Body** (JSON):

```json
{
    "customer_name": "name",
    "table_no": 1,
    "items": [1, 2, 3]
}
```

---

### GET : Get Order

```json
"http://127.0.0.1:8000/api/order"
```

**Headers**:

-   `Accept: application/json`
-   `Authorization: Bearer <token>`

---

### GET : Show Order

```json
"http://127.0.0.1:8000/api/order/{id}"
```

**Headers**:

-   `Accept: application/json`
-   `Authorization: Bearer <token>`

---

### GET : Set As Done

```json
"http://127.0.0.1:8000/api/order/{id}/set-as-done"
```

**Headers**:

-   `Accept: application/json`
-   `Authorization: Bearer <token>`

---

### GET : Payment

```json
"http://127.0.0.1:8000/api/order/{id}/payment"
```

-   `Accept: application/json`
-   `Authorization: Bearer <token>`

---

## Item

### POST : Create Item

```json
"http://127.0.0.1:8000/api/item"
```

**Headers**:

-   `Accept: application/json`
-   `Authorization: Bearer <token>`

**Body** (JSON):

```json
{
    "name": "name",
    "price": 10000,
    "image_file": "_File upload_"
}
```

### PATCH : Update Item

```json
"http://127.0.0.1:8000/api/item/1"
```

**Headers**:

-   `Accept: application/json`
-   `Authorization: Bearer <token>`

**Body** (JSON):

```json
{
    "name": "name",
    "price": 10000,
    "image_file": "_File upload_"
}
```

### GET : Get Items

```json
"http://127.0.0.1:8000/api/item"
```

---

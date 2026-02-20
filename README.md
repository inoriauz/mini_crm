# Mini CRM

CRM-система на основе Laravel. Предназначена для администраторов и менеджеров для управления заказами, списком клиентов и системой логирования заказов.

---

## Технологии

- **Laravel 12** — backend-фреймворк  
- **Filament 5** — админ-панель  
- **Laravel Sanctum** — API-аутентификация  
- **PostgreSQL** — база данных  
- **Laravel Queues** — фоновые задачи  

---

## Запуск проекта

### 1. Клонирование репозитория

```bash
git clone <repo-url>
cd mini_crm
```

### 2. Установка зависимостей

```bash
composer install
```

### 3. Настройка файла `.env`

```bash
cp .env.example .env
```

Откройте файл `.env` и укажите настройки базы данных и другие параметры.

### 4. Генерация ключа приложения

```bash
php artisan key:generate
```

### 5. Миграции базы данных

```bash
php artisan migrate
```

### 6. Запуск сидеров

```bash
php artisan db:seed
```

Будут созданы следующие пользователи:

| Роль     | Email               | Пароль      |
|----------|---------------------|------------|
| Admin    | admin@gmail.com     | password123 |
| Manager  | manager@gmail.com   | password123 |
| Manager  | manager2@gmail.com  | password123 |
| Manager  | manager3@gmail.com  | password123 |

### 7. Запуск очереди (опционально)

```bash
php artisan queue:work
```

### 8. Запуск сервера

```bash
php artisan serve
```

---

## Админ-панель

```
http://127.0.0.1:8000/admin
```

---

## API Endpoints

Base URL: `http://127.0.0.1:8000/api`

---

### Аутентификация

| Метод | Endpoint  | Описание                      | Auth |
|-------|----------|--------------------------------|------|
| POST  | /login   | Вход в систему                | Нет  |
| POST  | /logout  | Выход из системы              | Да   |
| GET   | /user    | Данные текущего пользователя  | Да   |

#### Пример запроса на вход

```json
POST /api/login
{
    "email": "admin@gmail.com",
    "password": "password123"
}
```

#### Пример ответа

```json
{
    "success": true,
    "data": {
        "token": "1|xxxx...",
        "user": {
            "id": 1,
            "name": "Admin",
            "email": "admin@gmail.com",
            "role": "admin"
        }
    },
    "message": "Logged in successfully"
}
```

---

### Заказы

| Метод | Endpoint           | Описание                 | Auth |
|-------|-------------------|--------------------------|------|
| GET   | /orders           | Список заказов          | Да   |
| GET   | /orders?status=new| Фильтр по статусу       | Да   |

> **Примечание:**  
> Администратор видит все заказы.  
> Менеджер видит только заказы, назначенные ему.

#### Заголовок запроса

```
Authorization: Bearer <token>
```

---

## Запуск тестов

```bash
php artisan test
```

---

## Структура проекта

```
app/
├── Http/Controllers/
│   ├── AuthController.php
│   └── OrderController.php
├── Models/
│   ├── User.php
│   ├── Client.php
│   ├── Order.php
│   └── OrderLog.php
├── Services/
│   └── OrderService.php
├── Repositories/
│   └── OrderRepository.php
├── Interfaces/
│   └── OrderInterface.php
├── Observers/
│   └── OrderObserver.php
├── Jobs/
│   └── NewOrderCreatedJob.php
└── Policies/
    ├── OrderPolicy.php
    ├── ClientPolicy.php
    ├── UserPolicy.php
    └── OrderLogPolicy.php
```

---

© Mini CRM — Laravel based project

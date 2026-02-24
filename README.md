# Fourfront Assessment

This repository contains two parts of the Fourfront assessment:

1. **Backend** — Money Tracker API (PHP Laravel) in `moneytracker/`
2. **Frontend** — Investment Knowledge Club UI (HTML, CSS, JavaScript, Bootstrap) in `frontend/`

---

## Repository structure

```
fourfront-assesment/
├── moneytracker/          # Laravel API (Money Tracker)
│   ├── app/
│   ├── database/
│   ├── routes/
│   │   ├── api.php        # API routes
│   │   └── web.php        # Web UI routes
│   ├── .env
│   └── ...
├── frontend/              # Investment Knowledge Club (static)
│   ├── index.html
│   ├── css/
│   ├── js/
│   └── img/
└── README.md
```

---

## Prerequisites

- **PHP** 8.2+ (for the backend)
- **Composer** (for the backend)
- **Node.js** (optional; for Laravel frontend assets and/or serving the static frontend)
- **MySQL** or **SQLite** (for the Laravel database)

---

## How to run the project

### 1. Backend (Money Tracker API & web UI)

The backend is a Laravel app that provides a **REST API** and optional **web views** for the Money Tracker.

1. **Go into the Laravel project and install dependencies:**

   ```bash
   cd moneytracker
   composer install
   ```

2. **Configure the environment:**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Edit `.env` and set your database (e.g. `DB_CONNECTION=mysql`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, or use SQLite).

3. **Run migrations:**

   ```bash
   php artisan migrate
   ```

4. **Start the development server:**

   ```bash
   php artisan serve
   ```

   - **API base URL:** `http://127.0.0.1:8000/api`
   - **Web UI:** `http://127.0.0.1:8000`

**API endpoints (all under `/api`):**

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST   | `/api/users` | Create user |
| GET    | `/api/users/{id}` | User profile (wallets, balances, total) |
| POST   | `/api/wallets` | Create wallet |
| GET    | `/api/wallets/{id}` | Wallet with balance and transactions |
| POST   | `/api/transactions` | Add income/expense transaction |

---

### 2. Frontend (Investment Knowledge Club)

Static, mobile-first page. No build step required.

**Option A — Open in browser**

- Open `frontend/index.html` in your browser (double-click or “Open with” browser).

**Option B — Local server (recommended if you use assets from `img/`)**

From the project root:

```bash
cd frontend
npx serve .
```

Then open the URL shown (e.g. `http://localhost:3000`).

Or with PHP:

```bash
cd frontend
php -S 8080
```

Then open `http://localhost:8080`.

---

## Tech stack

| Part      | Technologies |
|-----------|----------------|
| Backend   | PHP 8.2, Laravel 12, MySQL/SQLite, Eloquent |
| Frontend  | HTML5, CSS3, JavaScript, Bootstrap 5, Bootstrap Icons |

---

## License

MIT (or as specified per subproject).

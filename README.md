# Mini Trading API (RESTful)

A RESTful API built with Laravel 11 to simulate the backend engine of a basic trading platform.

I built this project mainly to practice and implement backend architectures suitable for financial applications, focusing on data consistency, performance, and keeping the controllers clean.

---

## Under the Hood (Architecture & Concepts)

Instead of dumping everything into the controllers, I tried to structure this similar to how larger enterprise apps are built:

### Service-Repository Pattern
Business logic (like checking user balance) lives in the Services, while database queries are isolated in Repositories.

### Database Transactions
Used during the **Buy Order** process to ensure that if something fails mid-execution, the user's balance is rolled back safely.

### Redis Caching
Market prices change rapidly. To prevent database overload, the `/market-prices` endpoint retrieves simulated data directly from Redis cache.

### Background Jobs (Queues)
Email/transaction notifications are pushed to a Redis-backed queue so the API can respond instantly without waiting for the email to send.

---

# Getting Started

You can run this project locally using your own setup (Laragon/XAMPP) or via Docker.

---

## The Docker Way (Recommended)

If you have Docker and Docker Compose installed, simply run:

```bash
# 1. Clone the repository
git clone https://github.com/YOUR_GITHUB_USERNAME/mini-trading-api.git
cd mini-trading-api

# 2. Setup environment
cp .env.example .env

# 3. Start containers (Nginx, PHP, MySQL, Redis)
docker-compose up -d

# 4. Install dependencies & run migration
docker exec -it mifx_app composer install
docker exec -it mifx_app php artisan key:generate
docker exec -it mifx_app php artisan migrate
```

---

## Manual Installation (Laragon / Valet / XAMPP)

```bash
# Clone repository
git clone https://github.com/yov54/mini-trading.git

# Enter project directory
cd mini-trading

# Install dependencies
composer install

# Setup environment
cp .env.example .env

# Generate app key
php artisan key:generate

# Run migration
php artisan migrate

# Start local server
php artisan serve
```

### Optional

Run queue worker for testing background jobs:

```bash
php artisan queue:work
```

---

# API Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/ping` | Health check & timestamp | No |
| POST | `/api/register` | Create a new account | No |
| POST | `/api/login` | Authenticate & get Sanctum token | No |
| GET | `/api/market-prices` | Get simulated prices (from Redis Cache) | No |
| GET | `/api/user` | Get current user profile & balance | Yes |
| POST | `/api/trade/buy` | Place buy order (DB Transaction & Queue Job) | Yes |

---

# TODO / Future Improvements

- [ ] Add Feature Tests (PHPUnit/Pest) for the Order Service
- [ ] Add API Rate Limiting to prevent spam on trade endpoints
- [ ] Implement Swagger/Scribe for interactive API documentation

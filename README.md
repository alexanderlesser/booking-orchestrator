# booking-orchestrator

## Setup

#### 1. CD into the server and start it

```bash
  cd server
  composer install
  php -S localhost:8000 -t public
```

Don't forget to add localhost in the .env file for frontend. 

**Run unit test**
```bash
  vendor/bin/phpunit
```

#### 2. CD into frontend and install the dependencies
```bash
  cd frontend
  npm install
```

#### 3. create .env file and add base url
```bash
  VITE_BASE_URL=http://localhost:8000
```

If you chose another port don't forget to update base_url

#### 4. Start Vue app
```bash
  npm run dev
```

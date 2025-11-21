# 🚀 Heroku + Vercel Deployment Guide

## Part 1: Deploy Backend ke Heroku

### Step 1: Setup Heroku
1. Buka https://heroku.com dan sign up/login
2. Install Heroku CLI:
   ```bash
   brew tap heroku/brew && brew install heroku
   # atau download dari: https://devcenter.heroku.com/articles/heroku-cli
   ```

3. Login via CLI:
   ```bash
   heroku login
   ```

### Step 2: Create Heroku App
```bash
cd /Users/fayyadh/Documents/UGM/uts_Kepl
heroku create uts-kepl-backend
# atau biarkan Heroku generate nama random
```

### Step 3: Add PHP Buildpack
```bash
heroku buildpacks:set heroku/php
```

### Step 4: Set Environment Variables
```bash
heroku config:set APP_NAME="UMKM Inventory"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY=base64:vFXGJoxHUpN7ThsG8eGu9/SxR96o8MMYMsn2Y5YMeFI=
heroku config:set DB_CONNECTION=sqlite
heroku config:set SESSION_DRIVER=file
heroku config:set CACHE_DRIVER=file
```

**IMPORTANT:** Setelah deploy, update dengan domain:
```bash
heroku config:set APP_URL=https://your-app.herokuapp.com
heroku config:set SANCTUM_STATEFUL_DOMAINS=your-frontend.vercel.app
```

### Step 5: Deploy ke Heroku
```bash
git push heroku main
```

Tunggu sampai deployment selesai.

### Step 6: Run Migrations
```bash
heroku run php artisan migrate --force
heroku run php artisan db:seed --force
```

### Step 7: Test Backend
```bash
heroku open
# Atau buka manual: https://your-app.herokuapp.com/api/login
```

Response error 405 = SUCCESS (karena butuh POST method)

---

## Part 2: Deploy Frontend ke Vercel

### Step 1: Get Heroku URL
```bash
heroku info
# Atau lihat di: https://dashboard.heroku.com
```

Copy URL (contoh: `https://uts-kepl-backend.herokuapp.com`)

### Step 2: Deploy ke Vercel

1. Buka https://vercel.com dan login
2. **Add New Project** → Import dari GitLab: `fayyadhgitlab/uts_kepl`
3. Configure:
   - **Framework Preset:** Other
   - **Build Command:** `npm run build`
   - **Output Directory:** `public`
   - **Install Command:** `npm install`

4. **Environment Variables** (CRITICAL):
   ```
   VITE_API_URL = https://your-app.herokuapp.com/api
   ```
   Ganti dengan URL Heroku yang sebenarnya

5. Click **Deploy**

### Step 3: Update Heroku CORS
Setelah Vercel deploy, update Heroku:

```bash
heroku config:set SANCTUM_STATEFUL_DOMAINS=your-app.vercel.app
```

Ganti dengan domain Vercel Anda.

### Step 4: Test Application
1. Buka Vercel URL
2. Login: `admin@umkm.test` / `password123`
3. Test CRUD operations

---

## Troubleshooting

### SQLite di Heroku (File System Read-Only)
Heroku's ephemeral filesystem dapat reset setiap deploy. Solusi:

**Option A: PostgreSQL (Recommended)**
```bash
heroku addons:create heroku-postgresql:essential-0
# Gratis untuk limited rows

# Update config
heroku config:set DB_CONNECTION=pgsql
```

**Option B: External Database**
Gunakan database cloud seperti PlanetScale (MySQL) atau Supabase (PostgreSQL)

### CORS Errors
Update `config/cors.php`:
```php
'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:5173')],
'supports_credentials' => true,
```

Set environment:
```bash
heroku config:set FRONTEND_URL=https://your-app.vercel.app
```

### 500 Errors
Check logs:
```bash
heroku logs --tail
```

### Build Errors
Ensure `composer.lock` is committed:
```bash
git add composer.lock
git commit -m "Add composer.lock"
git push heroku main
```

---

## Heroku CLI Commands Reference

```bash
# View logs
heroku logs --tail

# Run artisan commands
heroku run php artisan migrate
heroku run php artisan db:seed
heroku run php artisan cache:clear

# View app info
heroku info

# Open app in browser
heroku open

# Restart app
heroku restart

# View config
heroku config

# Set config
heroku config:set KEY=value
```

---

## Files untuk Heroku

✅ **Procfile** - Heroku process definition
```
web: vendor/bin/heroku-php-apache2 public/
```

✅ **composer.json** - Already configured
✅ **.env.production.example** - Template untuk production

---

## Deployment Checklist

**Heroku (Backend):**
- [ ] Create Heroku app
- [ ] Set buildpack: `heroku/php`
- [ ] Configure environment variables
- [ ] Push to Heroku: `git push heroku main`
- [ ] Run migrations: `heroku run php artisan migrate --force`
- [ ] Seed database: `heroku run php artisan db:seed --force`
- [ ] Test API endpoint
- [ ] Update SANCTUM_STATEFUL_DOMAINS

**Vercel (Frontend):**
- [ ] Import project from GitLab
- [ ] Set VITE_API_URL to Heroku URL
- [ ] Deploy
- [ ] Test full application

**Post-Deployment:**
- [ ] Update Heroku SANCTUM_STATEFUL_DOMAINS with Vercel URL
- [ ] Test login flow
- [ ] Test CRUD operations
- [ ] Check CORS configuration

---

## Production URLs

**Backend (Heroku):**
- App: `https://your-app.herokuapp.com`
- API: `https://your-app.herokuapp.com/api`

**Frontend (Vercel):**
- App: `https://your-app.vercel.app`

**Environment Variables:**
- Heroku: Set via `heroku config:set` or dashboard
- Vercel: Set via dashboard → Settings → Environment Variables

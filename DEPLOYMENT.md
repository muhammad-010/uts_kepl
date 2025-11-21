# 🚂 Railway + Vercel Deployment Guide

## Part 1: Deploy Backend ke Railway

### Step 1: Setup Railway Account
1. Buka https://railway.app
2. Sign up dengan GitHub/GitLab account Anda
3. Klik **"New Project"**

### Step 2: Connect Repository
1. Pilih **"Deploy from GitHub/GitLab repo"**
2. Authorize Railway untuk akses GitLab
3. Pilih repository: `fayyadhgitlab/uts_kepl`
4. Railway akan otomatis detect Laravel

### Step 3: Configure Environment Variables
Di Railway dashboard, klik project → **Variables** tab, tambahkan:

```
APP_NAME=UMKM Inventory
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:vFXGJoxHUpN7ThsG8eGu9/SxR96o8MMYMsn2Y5YMeFI=
DB_CONNECTION=sqlite
SESSION_DRIVER=file
CACHE_DRIVER=file
```

**IMPORTANT:** Tambahkan variable ini setelah domain Railway tersedia:
```
APP_URL=https://your-app.railway.app
SANCTUM_STATEFUL_DOMAINS=your-frontend.vercel.app
SESSION_DOMAIN=.railway.app
```

### Step 4: Deploy
1. Railway akan otomatis build dan deploy
2. Tunggu sampai status **"Success"**
3. Klik **"Generate Domain"** untuk dapat public URL
4. Copy URL (contoh: `https://uts-kepl-production.up.railway.app`)

### Step 5: Test Backend API
Buka URL Railway Anda + `/api/login`:
```
https://your-app.railway.app/api/login
```

Harusnya return error method not allowed (karena butuh POST), ini berarti API jalan!

### Step 6: Setup Database (Opsional)
Railway sudah include SQLite secara default. Jika perlu PostgreSQL:
1. Di Railway dashboard, klik **"New"** → **"Database"** → **"PostgreSQL"**
2. Update environment variables dengan DB credentials otomatis dari Railway

---

## Part 2: Deploy Frontend ke Vercel

### Step 1: Update Environment Variable
Buat file `.env.production` di project Anda:

```env
VITE_API_URL=https://your-app.railway.app/api
```

Ganti `your-app.railway.app` dengan URL Railway yang sebenarnya.

### Step 2: Test Build Lokal
```bash
npm run build
```

Pastikan berhasil tanpa error.

### Step 3: Deploy ke Vercel

**Option A: Via Vercel Dashboard (Recommended)**

1. Buka https://vercel.com
2. Sign up/login dengan GitLab account
3. Klik **"Add New Project"**
4. Import repository: `fayyadhgitlab/uts_kepl`
5. Configure project:
   - **Framework Preset:** Other
   - **Build Command:** `npm run build`
   - **Output Directory:** `public`
   - **Install Command:** `npm install`

6. **Environment Variables** (IMPORTANT):
   - Key: `VITE_API_URL`
   - Value: `https://your-app.railway.app/api` (URL Railway)

7. Klik **"Deploy"**

**Option B: Via Vercel CLI**

```bash
npm i -g vercel
vercel login
vercel
```

Ikuti prompts, set environment variable di dashboard setelahnya.

### Step 4: Configure Domain (Opsional)
1. Di Vercel dashboard → **Settings** → **Domains**
2. Add custom domain jika punya

### Step 5: Test Full Application
1. Buka URL Vercel (contoh: `https://uts-kepl.vercel.app`)
2. Login dengan: `admin@umkm.test` / `password123`
3. Test CRUD customers dan products

---

## Troubleshooting

### CORS Error
Jika ada error CORS, update di Railway environment variables:
```
SANCTUM_STATEFUL_DOMAINS=your-frontend.vercel.app
```

Dan di `config/cors.php`, pastikan:
```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_origins' => ['https://your-frontend.vercel.app'],
'supports_credentials' => true,
```

### 401 Unauthorized
- Pastikan VITE_API_URL di Vercel sudah benar
- Check Railway logs untuk error
- Verify APP_KEY di Railway sudah di-set

### Database Error di Railway
- Railway auto-provision SQLite
- Check migrations dengan: Railway dashboard → **Logs**
- Jika perlu reset: Redeploy project

---

## Quick Reference

**Railway (Backend):**
- URL: https://your-app.railway.app
- API Endpoints: `/api/login`, `/api/customers`, `/api/products`
- Logs: Railway dashboard → Deployments → View logs

**Vercel (Frontend):**
- URL: https://your-app.vercel.app
- Build logs: Vercel dashboard → Deployments
- Environment: Vercel dashboard → Settings → Environment Variables

---

## Next Steps After Deployment

1. ✅ Update `.env.production` dengan URL Railway yang real
2. ✅ Commit dan push ke GitLab
3. ✅ Vercel auto-redeploy dengan env variable baru
4. ✅ Test full flow: login → CRUD → logout
5. ✅ Update Railway SANCTUM_STATEFUL_DOMAINS dengan Vercel URL

**File yang sudah dibuat:**
- `Procfile` - Railway process definition
- `railway.json` - Railway configuration
- `railway-deploy.sh` - Post-deployment script
- `.env.production.example` - Production env template
- `resources/js/services/api.js` - Updated dengan env variable support

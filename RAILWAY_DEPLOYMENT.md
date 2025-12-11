# Railway Deployment Guide

## 🚀 Quick Deploy

### Step 1: Create Railway Account
1. Go to https://railway.app
2. Sign up with GitHub (or email)
3. No credit card required!

### Step 2: Create New Project
1. Click **"New Project"**
2. Select **"Deploy from GitHub repo"**
3. Connect your GitHub account if not connected
4. Select repository: `uts_kepl`

### Step 3: Add PostgreSQL Database
1. In your project, click **"+ New"**
2. Select **"Database"** → **"Add PostgreSQL"**
3. Railway auto-generates connection variables

### Step 4: Configure Environment Variables
Click on your web service, go to **Variables** tab, and add:

```
APP_NAME=UMKM Inventory
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_KEY_HERE
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}

DB_CONNECTION=pgsql
DATABASE_URL=${{Postgres.DATABASE_URL}}

SESSION_DRIVER=cookie
CACHE_STORE=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr

SANCTUM_STATEFUL_DOMAINS=${{RAILWAY_PUBLIC_DOMAIN}}
```

### Step 5: Generate APP_KEY
Run locally:
```bash
php artisan key:generate --show
```
Copy the output and set as `APP_KEY` in Railway.

### Step 6: Deploy
Railway auto-deploys on every push to your connected branch.

---

## 📁 Configuration Files

| File | Purpose |
|------|---------|
| `railway.json` | Railway build/deploy config |
| `railway.toml` | Nixpacks configuration |

---

## 🔧 Useful Commands

### View Logs
- Go to Railway Dashboard → Your Service → **Logs** tab

### Run Commands (Shell)
- Railway Dashboard → Your Service → **Settings** → **Railway CLI**
- Or use Railway CLI locally:
```bash
npm install -g @railway/cli
railway login
railway run php artisan db:seed
```

---

## 🌐 URLs After Deployment

Your app will be available at:
- `https://your-project.up.railway.app`

Or set a custom domain in Railway Dashboard → **Settings** → **Domains**

---

## 🛠️ Troubleshooting

### Build Failed
- Check build logs in Railway Dashboard
- Ensure `composer.json` and `package.json` are valid

### Database Connection Error
- Verify PostgreSQL service is running
- Check `DATABASE_URL` is linked correctly

### 500 Error
- Enable `APP_DEBUG=true` temporarily
- Check logs in Railway Dashboard

### Assets Not Loading
- Ensure `npm run build` completed successfully
- Check `dist/` folder was created during build

---

## 💰 Pricing

Railway Free Tier includes:
- $5 of usage per month
- ~500 hours of runtime
- No credit card required to start

For hobby projects, this is usually enough!

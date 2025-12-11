# Render Deployment Guide

## 🚀 Quick Deploy

### Option 1: Blueprint (Recommended)
1. Push code to GitHub
2. Go to [Render Dashboard](https://dashboard.render.com/)
3. Click **New** → **Blueprint**
4. Connect your GitHub repo
5. Render will auto-detect `render.yaml` and create:
   - Web Service (Laravel + Vue)
   - PostgreSQL Database

### Option 2: Manual Setup

#### Step 1: Create PostgreSQL Database
1. Go to Render Dashboard
2. Click **New** → **PostgreSQL**
3. Name: `umkm-db`
4. Plan: Free
5. Create and copy the **Internal Connection String**

#### Step 2: Create Web Service
1. Click **New** → **Web Service**
2. Connect your GitHub repository
3. Configure:
   - **Name**: `umkm-inventory`
   - **Environment**: Docker
   - **Dockerfile Path**: `./Dockerfile.render`
   - **Plan**: Free

4. Add Environment Variables:
   ```
   APP_NAME=UMKM Inventory
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:YOUR_KEY_HERE
   APP_URL=https://your-app.onrender.com
   
   DB_CONNECTION=pgsql
   DATABASE_URL=postgres://user:pass@host:port/db
   
   SESSION_DRIVER=cookie
   SESSION_SECURE_COOKIE=true
   CACHE_STORE=file
   QUEUE_CONNECTION=sync
   LOG_CHANNEL=stderr
   
   SANCTUM_STATEFUL_DOMAINS=your-app.onrender.com
   ```

5. Click **Create Web Service**

---

## 🔑 Generate APP_KEY

Run locally:
```bash
php artisan key:generate --show
```
Copy the output (starts with `base64:`) and set as `APP_KEY` in Render.

---

## 📁 Files Created

| File | Purpose |
|------|---------|
| `render.yaml` | Infrastructure as Code (Blueprint) |
| `Dockerfile.render` | Production Docker image |
| `docker/nginx.conf` | Nginx configuration |
| `docker/supervisord.conf` | Process manager config |
| `docker/start.sh` | Startup script |

---

## 🔧 Troubleshooting

### Build Failed
- Check Render build logs
- Ensure `composer.json` and `package.json` are valid

### Database Connection Error
- Verify `DATABASE_URL` is correct
- Check PostgreSQL is running on Render

### 500 Error
- Check `APP_KEY` is set
- Enable `APP_DEBUG=true` temporarily to see error

### Assets Not Loading
- Ensure `npm run build` completed
- Check `dist/` folder exists

---

## 🌐 URLs After Deployment

- **Application**: `https://umkm-inventory.onrender.com`
- **API**: `https://umkm-inventory.onrender.com/api`

---

## 📝 First Time Setup

After first deploy, you may want to seed the database:

1. Go to Render Dashboard → Your Web Service → **Shell**
2. Run:
   ```bash
   php artisan db:seed
   ```

Or uncomment the seed line in `docker/start.sh` before deploying.

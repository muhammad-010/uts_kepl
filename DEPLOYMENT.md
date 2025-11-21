# Vercel Deployment Guide

## ⚠️ Important: Vercel Limitation

Vercel **tidak support PHP/Laravel backend**. Ada 2 pendekatan:

### Pendekatan 1: Frontend di Vercel + Backend di Railway (RECOMMENDED)

**Frontend (Vercel):**
1. Deploy Vue.js SPA ke Vercel
2. Backend API tetap berjalan di tempat lain (Railway/Heroku/VPS)

**Backend (Railway/lain):**
1. Deploy Laravel API ke Railway.app atau platform PHP lain
2. Update `API_BASE_URL` di frontend

### Pendekatan 2: Full Deploy ke Platform PHP

Deploy seluruh aplikasi (frontend + backend) ke platform yang support PHP:
- **Railway.app** (paling mudah, free tier)
- **Laravel Forge** + DigitalOcean
- **Shared Hosting** (Niagahoster, Hostinger)

---

## Configuration Files Created

### 1. `vercel.json`
- Build configuration untuk Vercel
- Output directory: `public`
- Routes untuk SPA fallback

### 2. `.vercelignore`
- Exclude vendor, node_modules, dll dari deployment

### 3. `public/index.html`
- Static entry point untuk production
- Loads built Vue.js assets

### 4. `package.json`
- Added `vercel-build` script

---

## Deployment Steps untuk Vercel (Frontend Only)

### Step 1: Update API Base URL

Jika backend ada di server lain, update `resources/js/services/api.js`:

```javascript
const api = axios.create({
  baseURL: process.env.VITE_API_URL || '/api', // Gunakan environment variable
  // ...
});
```

Tambahkan di Vercel dashboard:
- Environment Variable: `VITE_API_URL`
- Value: `https://your-backend-url.com/api`

### Step 2: Build dan Test Lokal

```bash
npm run build
# Check public/build/ directory
```

### Step 3: Deploy ke Vercel

**Via Vercel CLI:**
```bash
npm i -g vercel
vercel login
vercel
```

**Via Vercel Dashboard:**
1. Import dari GitLab
2. Framework Preset: **Other**
3. Build Command: `npm run build`
4. Output Directory: `public`
5. Install Command: `npm install`

### Step 4: Configure Environment Variables

Di Vercel Project Settings → Environment Variables:
- `VITE_API_URL`: URL backend API anda

---

## Current Limitation

⚠️ **Dengan setup saat ini, Vercel tidak akan work karena:**
- Backend Laravel butuh PHP server
- Database SQLite butuh file system yang writeable
- Vercel adalah platform untuk frontend static/serverless

**Solusi:**
1. Deploy backend ke Railway: https://railway.app
2. Deploy frontend ke Vercel dengan update API_URL ke Railway

Apakah Anda mau saya bantu setup Railway untuk backend?

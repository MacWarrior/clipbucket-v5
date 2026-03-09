# ClipBucket v5 - Docker Build Options

Ce Dockerfile supporte de multiples configurations pour répondre à différents besoins de développement et production.

## 🐳 Arguments de Build

| Argument | Description | Valeurs possibles | Défaut |
|----------|-------------|-------------------|--------|
| `PHP_VERSION` | Version de PHP | `8.1`, `8.2`, `8.3`, `8.4`, `8.5` | `8.5` |
| `DOMAIN_NAME` | Domaine pour ClipBucket | string | `clipbucket.local` |
| `PHPMYADMIN_DOMAIN` | Domaine pour phpMyAdmin | string | `phpmyadmin.local` |
| `LITE` | Mode sans MariaDB | `true`, `false` | `false` |
| `INSTALL_PHPMYADMIN` | Installer phpMyAdmin | `true`, `false` | `false` |
| `INSTALL_XDEBUG` | Installer Xdebug | `true`, `false` | `false` |
| `INSTALL_REDIS` | Installer Redis Server | `true`, `false` | `false` |

## 🚀 Exemples de Build

### Build de base avec PHP 8.5
```bash
docker build -t clipbucket-v5:php8.5 .
```

### Build avec PHP 8.3 + phpMyAdmin
```bash
docker build -t clipbucket-v5:php8.3-pma \
  --build-arg PHP_VERSION=8.3 \
  --build-arg INSTALL_PHPMYADMIN=true .
```

### Build mode développeur (tous les outils)
```bash
docker build -t clipbucket-v5:dev \
  --build-arg PHP_VERSION=8.5 \
  --build-arg INSTALL_PHPMYADMIN=true \
  --build-arg INSTALL_XDEBUG=true \
  --build-arg INSTALL_REDIS=true .
```

### Build mode lite (sans MariaDB)
```bash
docker build -t clipbucket-v5:lite \
  --build-arg INSTALL_MARIADB=false .
```

### Build avec domaines personnalisés
```bash
docker build -t clipbucket-v5:custom \
  --build-arg DOMAIN_NAME=myvideo.local \
  --build-arg PHPMYADMIN_DOMAIN=dbadmin.myvideo.local \
  --build-arg INSTALL_PHPMYADMIN=true .
```

### Build production avec Redis
```bash
docker build -t clipbucket-v5:production \
  --build-arg PHP_VERSION=8.5 \
  --build-arg INSTALL_REDIS=true .
```

## 🏷️ Tags Docker Hub (Build Automatique)

Les images sont automatiquement buildées et publiées lors des releases :

| Tag | Description | PHP | MariaDB | Redis | phpMyAdmin | Xdebug |
|-----|-------------|-----|---------|-------|------------|--------|
| `latest` | Version stable recommandée | 8.5 | ✅ | ✅ | ❌ | ❌ |
| `lite` | Version légère sans base de données | 8.5 | ❌ | ❌ | ❌ | ❌ |
| `dev-php8.1` | Environnement développement | 8.1 | ✅ | ✅ | ✅ | ❌ |
| `dev-php8.2` | Environnement développement | 8.2 | ✅ | ✅ | ✅ | ❌ |
| `dev-php8.3` | Environnement développement | 8.3 | ✅ | ✅ | ✅ | ❌ |
| `dev-php8.4` | Environnement développement | 8.4 | ✅ | ✅ | ✅ | ❌ |
| `dev-php8.5` | Environnement développement | 8.5 | ✅ | ✅ | ✅ | ❌ |
| `dev-php8.1-xdebug` | Dev avec débogage | 8.1 | ✅ | ✅ | ✅ | ✅ |
| `dev-php8.2-xdebug` | Dev avec débogage | 8.2 | ✅ | ✅ | ✅ | ✅ |
| `dev-php8.3-xdebug` | Dev avec débogage | 8.3 | ✅ | ✅ | ✅ | ✅ |
| `dev-php8.4-xdebug` | Dev avec débogage | 8.4 | ✅ | ✅ | ✅ | ✅ |
| `dev-php8.5-xdebug` | Dev avec débogage | 8.5 | ✅ | ✅ | ✅ | ✅ |

## 🌐 Ports Exposés

| Port | Service | Condition |
|------|---------|-----------|
| `80` | Nginx + ClipBucket | Toujours |
| `80` | phpMyAdmin | Si `INSTALL_PHPMYADMIN=true` |
| `6379` | Redis Server | Si `INSTALL_REDIS=true` |

## 📁 Volumes

| Chemin | Description |
|--------|-------------|
| `/srv/http/clipbucket` | Sources de ClipBucket |
| `/var/lib/mysql` | Données MariaDB (mode full) |

## 🔧 Variables d'Environnement

| Variable | Description | Défaut |
|----------|-------------|--------|
| `DOMAIN_NAME` | Domaine pour ClipBucket | `clipbucket.local` |
| `PHPMYADMIN_DOMAIN` | Domaine pour phpMyAdmin | `phpmyadmin.local` |
| `MYSQL_PASSWORD` | Mot de passe MySQL | `clipbucket_password` |
| `UID` | UID utilisateur | `1000` |
| `GID` | GID utilisateur | `1000` |

## 🐛 Débogage avec Xdebug

Quand `INSTALL_XDEBUG=true`, Xdebug est configuré pour :
- Mode debug + coverage
- Port client : `9003`
- Host client : `host.docker.internal`

Configuration IDE recommandée :
- Port : `9003`
- Path mapping : `/srv/http/clipbucket` → `/chemin/local/clipbucket`

## 📝 Notes

- phpMyAdmin est installé via `git clone` depuis la branche STABLE
- Redis est configuré avec une limite de mémoire de 256MB et une politique `allkeys-lru`
- Les versions PHP 8.1 à 8.5 sont validées lors du build

# ClipBucket v5 - Docker Build Options

Ce Dockerfile supporte de multiples configurations pour répondre à différents besoins de développement et production.

## 🐳 Arguments de Build

| Argument | Description | Valeurs possibles | Défaut |
|----------|-------------|-------------------|--------|
| `PHP_VERSION` | Version de PHP | `8.1`, `8.2`, `8.3`, `8.4`, `8.5` | `8.4` |
| `DOMAIN_NAME` | Domaine pour ClipBucket | string | `clipbucket.local` |
| `PHPMYADMIN_DOMAIN` | Domaine pour phpMyAdmin | string | `phpmyadmin.local` |
| `LITE` | Mode sans MariaDB | `true`, `false` | `false` |
| `INSTALL_PHPMYADMIN` | Installer phpMyAdmin | `true`, `false` | `false` |
| `INSTALL_XDEBUG` | Installer Xdebug | `true`, `false` | `false` |
| `INSTALL_REDIS` | Installer Redis Server | `true`, `false` | `false` |

## 🚀 Exemples de Build

### Build de base avec PHP 8.4
```bash
docker build -t clipbucket-v5:php8.4 .
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
  --build-arg PHP_VERSION=8.4 \
  --build-arg INSTALL_PHPMYADMIN=true \
  --build-arg INSTALL_XDEBUG=true \
  --build-arg INSTALL_REDIS=true .
```

### Build mode lite (sans MariaDB)
```bash
docker build -t clipbucket-v5:lite \
  --build-arg LITE=true .
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
  --build-arg PHP_VERSION=8.4 \
  --build-arg INSTALL_REDIS=true .
```

## 🏷️ Tags Docker Hub

Les images sont automatiquement buildées et publiées avec les tags suivants :

| Tag | Description |
|-----|-------------|
| `latest` | PHP 8.4, full mode |
| `php{X.Y}` | Version spécifique de PHP |
| `php{X.Y}-lite` | Version lite (sans MariaDB) |
| `php{X.Y}-pma` | Avec phpMyAdmin (port 8080) |
| `php{X.Y}-xdebug` | Avec Xdebug activé |
| `php{X.Y}-redis` | Avec Redis Server |
| `php{X.Y}-pma-xdebug-redis` | Version complète dev |

## 🌐 Ports Exposés

| Port | Service | Condition |
|------|---------|-----------|
| `80` | Nginx + ClipBucket | Toujours |
| `8080` | phpMyAdmin | Si `INSTALL_PHPMYADMIN=true` |
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
- XHProf est toujours installé pour le profiling des performances
- Les versions PHP 8.1 à 8.5 sont validées lors du build

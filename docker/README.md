# ClipBucket v5 - Docker Build Options

This Dockerfile supports multiple configurations to meet different development and production needs.

## 🐳 Build Arguments

| Argument | Description | Possible Values | Default |
|----------|-------------|-----------------|--------|
| `PHP_VERSION` | PHP version | `8.1`, `8.2`, `8.3`, `8.4`, `8.5` | `8.5` |
| `DOMAIN_NAME` | Domain for ClipBucket | string | `clipbucket.local` |
| `PHPMYADMIN_DOMAIN` | Domain for phpMyAdmin | string | `phpmyadmin.local` |
| `INSTALL_MARIADB` | Install MariaDB | `true`, `false` | `false` |
| `INSTALL_PHPMYADMIN` | Install phpMyAdmin | `true`, `false` | `false` |
| `INSTALL_XDEBUG` | Install Xdebug | `true`, `false` | `false` |
| `INSTALL_REDIS` | Install Redis Server | `true`, `false` | `false` |

## 🚀 Build Examples

### Basic build with PHP 8.5
```bash
docker build -t clipbucket-v5:php8.5 .
```

### Build with PHP 8.3 + phpMyAdmin
```bash
docker build -t clipbucket-v5:php8.3-pma \\
  --build-arg PHP_VERSION=8.3 \\
  --build-arg INSTALL_PHPMYADMIN=true .
```

### Developer mode build (all tools)
```bash
docker build -t clipbucket-v5:dev \\
  --build-arg PHP_VERSION=8.5 \\
  --build-arg INSTALL_PHPMYADMIN=true \\
  --build-arg INSTALL_XDEBUG=true \\
  --build-arg INSTALL_MARIADB=true \\
  --build-arg INSTALL_REDIS=true .
```

### Lite mode build (without MariaDB)
```bash
docker build -t clipbucket-v5:lite \\
  --build-arg INSTALL_MARIADB=false .
```

### Build with custom domains
```bash
docker build -t clipbucket-v5:custom \\
  --build-arg DOMAIN_NAME=myvideo.local \\
  --build-arg PHPMYADMIN_DOMAIN=dbadmin.myvideo.local \\
  --build-arg INSTALL_PHPMYADMIN=true .
```

### Production build with Redis
```bash
docker build -t clipbucket-v5:production \\
  --build-arg PHP_VERSION=8.5 \\
  --build-arg INSTALL_REDIS=true .
```

## 🏷️ Docker Hub Tags (Automatic Build)

Images are automatically built and published during releases:

| Tag | Description | PHP | MariaDB | Redis | phpMyAdmin | Xdebug |
|-----|-------------|-----|---------|-------|------------|--------|
| `latest` | Recommended stable version | 8.5 | ✅ | ✅ | ❌ | ❌ |
| `lite` | Lightweight version without database | 8.5 | ❌ | ❌ | ❌ | ❌ |
| `dev-php8.1` | Development environment | 8.1 | ✅ | ✅ | ✅ | ❌ |
| `dev-php8.2` | Development environment | 8.2 | ✅ | ✅ | ✅ | ❌ |
| `dev-php8.3` | Development environment | 8.3 | ✅ | ✅ | ✅ | ❌ |
| `dev-php8.4` | Development environment | 8.4 | ✅ | ✅ | ✅ | ❌ |
| `dev-php8.5` | Development environment | 8.5 | ✅ | ✅ | ✅ | ❌ |
| `dev-php8.1-xdebug` | Dev with debugging | 8.1 | ✅ | ✅ | ✅ | ✅ |
| `dev-php8.2-xdebug` | Dev with debugging | 8.2 | ✅ | ✅ | ✅ | ✅ |
| `dev-php8.3-xdebug` | Dev with debugging | 8.3 | ✅ | ✅ | ✅ | ✅ |
| `dev-php8.4-xdebug` | Dev with debugging | 8.4 | ✅ | ✅ | ✅ | ✅ |
| `dev-php8.5-xdebug` | Dev with debugging | 8.5 | ✅ | ✅ | ✅ | ✅ |

## 🌐 Exposed Ports

| Port | Service | Condition |
|------|---------|-----------|
| `80` | Nginx + ClipBucket | Always |
| `80` | phpMyAdmin | If `INSTALL_PHPMYADMIN=true` |
| `6379` | Redis Server | If `INSTALL_REDIS=true` |

## 📁 Volumes

| Path | Description |
|--------|-------------|
| `/srv/http/clipbucket` | ClipBucket sources |
| `/var/lib/mysql` | MariaDB data (full mode) |

## 🔧 Environment Variables

| Variable | Description | Default |
|----------|-------------|--------|
| `DOMAIN_NAME` | Domain for ClipBucket | `clipbucket.local` |
| `PHPMYADMIN_DOMAIN` | Domain for phpMyAdmin | `phpmyadmin.local` |
| `MYSQL_PASSWORD` | MySQL password | `clipbucket_password` |
| `UID` | User UID | `1000` |
| `GID` | User GID | `1000` |

## 🐛 Debugging with Xdebug

When `INSTALL_XDEBUG=true`, Xdebug is configured for:
- Debug + coverage mode
- Client port: `9003`
- Client host: `host.docker.internal`

Recommended IDE configuration:
- Port: `9003`
- Path mapping: `/srv/http/clipbucket` → `/local/path/clipbucket`

## 📝 Notes

- phpMyAdmin is installed via `git clone` from the STABLE branch
- Redis is configured with a 256MB memory limit and `allkeys-lru` policy
- PHP versions 8.1 to 8.5 are validated during build

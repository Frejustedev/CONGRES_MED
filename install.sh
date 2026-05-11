#!/bin/bash
# Script d'installation Congresia sur un nouvel hébergement.
# Usage : bash install.sh

set -e

echo "==========================================="
echo "  Installation Congresia"
echo "==========================================="

# 1. Vérifier prérequis
echo "→ Vérification des prérequis…"
command -v php >/dev/null 2>&1 || { echo "✗ PHP non trouvé. Installez PHP 8.3+"; exit 1; }
command -v composer >/dev/null 2>&1 || { echo "✗ Composer non trouvé"; exit 1; }
command -v npm >/dev/null 2>&1 || { echo "✗ npm non trouvé"; exit 1; }

PHP_VERSION=$(php -r 'echo PHP_VERSION;')
echo "  PHP : $PHP_VERSION"
echo "  Composer : $(composer --version | head -1)"
echo "  npm : $(npm --version)"

# 2. Installer dépendances
echo "→ Installation des dépendances PHP…"
composer install --no-dev --optimize-autoloader --no-interaction

echo "→ Installation des dépendances Node…"
npm ci --omit=dev

# 3. Configuration
if [ ! -f .env ]; then
    echo "→ Création du fichier .env…"
    cp .env.example .env
    php artisan key:generate
    echo "⚠ Configurez maintenant .env (DB, mail, paiements) puis relancez ce script."
    exit 0
fi

# 4. Build des assets
echo "→ Compilation des assets frontend…"
php artisan wayfinder:generate --with-form
npm run build

# 5. Migrations + seed initial
echo "→ Migrations base de données…"
php artisan migrate --force

echo "→ Seed initial (rôles, permissions, super-admin)…"
php artisan db:seed --class=RolesAndPermissionsSeeder --force
php artisan db:seed --class=SuperAdminSeeder --force

# 6. Optimisations production
echo "→ Optimisations production…"
php artisan storage:link 2>/dev/null || true
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 7. Permissions
echo "→ Permissions fichiers…"
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/framework storage/logs storage/app

echo ""
echo "==========================================="
echo "  ✓ Installation terminée !"
echo "==========================================="
echo ""
echo "Prochaines étapes :"
echo "  1. Connectez-vous en tant que super-admin (voir SUPER_ADMIN_EMAIL dans .env)"
echo "  2. Allez sur /admin pour configurer le congrès"
echo "  3. Configurez le cron : * * * * * cd $(pwd) && php artisan schedule:run >> /dev/null 2>&1"
echo ""

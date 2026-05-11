# Guide d'installation Congresia sur o2switch

## 1. Préparer l'hébergement (côté client)

### Sous-domaine
Dans cPanel o2switch :
1. **Domaines → Sous-domaines** → créer `congres.votredomaine.com`
2. Document root : `/home/cpanel-user/congres` (au lieu de `public_html/congres`)

### Base de données MySQL
1. **Bases de données → MySQL** → créer une base, ex : `votredomaine_congresia`
2. Créer un utilisateur MySQL avec mot de passe fort
3. Lui attribuer **tous les privilèges** sur cette base
4. **Noter** : nom DB, user, password

### PHP 8.3+
1. **MultiPHP Manager** → sélectionner **PHP 8.3** ou plus récent pour le sous-domaine
2. **Extensions** (déjà actives par défaut chez o2switch) : `pdo_mysql`, `mbstring`, `gd`, `xml`, `curl`, `intl`, `bcmath`, `zip`, `fileinfo`

### SSH (optionnel mais recommandé)
1. **Sécurité → SSH** → activer + générer une clé
2. Connexion : `ssh cpanel-user@ssh.o2switch.fr -p 2222`

## 2. Déployer le code

### Option A — Via cPanel Git Version Control
1. **Git Version Control** → Create
2. Repository : `https://github.com/Frejustedev/CONGRES_MED.git`
3. Branch : `main`
4. Path : `/home/cpanel-user/congres-app`

### Option B — Via SSH + git
```bash
ssh cpanel-user@ssh.o2switch.fr -p 2222
cd ~
git clone https://github.com/Frejustedev/CONGRES_MED.git congres-app
cd congres-app
```

### Option C — Upload manuel via FTP (déconseillé)
Uploader tous les fichiers du repo dans `/home/cpanel-user/congres-app/` (sauf `node_modules/` et `vendor/`).

## 3. Pointer le sous-domaine vers `public/`

Dans cPanel **File Manager**, modifier le document root du sous-domaine pour pointer sur :
```
/home/cpanel-user/congres-app/public
```

Ou créer un symlink :
```bash
cd /home/cpanel-user
ln -s congres-app/public congres
```

## 4. Configurer `.env`

```bash
cd ~/congres-app
cp .env.example .env
nano .env
```

Renseigner :
```
APP_NAME="Nom du congrès"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://congres.votredomaine.com
APP_LOCALE=fr
APP_TIMEZONE=Africa/Porto-Novo

DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=votredomaine_congresia
DB_USERNAME=votredomaine_user
DB_PASSWORD=••••••••

# SMTP o2switch (inclus dans abonnement)
MAIL_MAILER=smtp
MAIL_HOST=mail.votredomaine.com
MAIL_PORT=465
MAIL_USERNAME=noreply@votredomaine.com
MAIL_PASSWORD=••••••••
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="noreply@votredomaine.com"
MAIL_FROM_NAME="${APP_NAME}"

# Paiements
PAYMENT_MODE=live
KKIAPAY_PUBLIC_KEY=••••••••
KKIAPAY_PRIVATE_KEY=••••••••
KKIAPAY_SECRET=••••••••
KKIAPAY_SANDBOX=false

STRIPE_KEY=pk_live_••••••••
STRIPE_SECRET=sk_live_••••••••
STRIPE_WEBHOOK_SECRET=whsec_••••••••

# Super admin initial
SUPER_ADMIN_NAME="Administrateur"
SUPER_ADMIN_EMAIL=admin@votredomaine.com
SUPER_ADMIN_PASSWORD=••••••••  # À CHANGER IMMÉDIATEMENT
```

## 5. Lancer l'installation

```bash
cd ~/congres-app
bash install.sh
```

Le script va :
1. ✓ Installer les dépendances Composer en mode production
2. ✓ Installer les dépendances Node
3. ✓ Compiler les assets frontend (`npm run build`)
4. ✓ Lancer les migrations Laravel (création de toutes les tables)
5. ✓ Seeder rôles + permissions + super-admin
6. ✓ Lier `public/storage` → `storage/app/public`
7. ✓ Optimiser les caches (config, routes, views)
8. ✓ Configurer les permissions fichiers

## 6. Configurer le cron Laravel

Dans cPanel **Cron Jobs**, ajouter :
```
* * * * * cd /home/cpanel-user/congres-app && /usr/local/bin/php artisan schedule:run >> /dev/null 2>&1
```

Ce cron déclenche :
- Le worker de queue (emails async)
- Les rappels automatiques
- Les nettoyages logs
- L'attribution batch CME

## 7. Webhooks Kkiapay / Stripe

### Kkiapay
1. Dashboard Kkiapay → Configurer webhook
2. URL : `https://congres.votredomaine.com/webhooks/payments/kkiapay`

### Stripe
1. Dashboard Stripe → Developers → Webhooks → Add endpoint
2. URL : `https://congres.votredomaine.com/webhooks/payments/stripe`
3. Événement : `checkout.session.completed`
4. Copier le **Signing secret** dans `.env` → `STRIPE_WEBHOOK_SECRET`

## 8. Première connexion

1. Aller sur https://congres.votredomaine.com/login
2. Login : `admin@votredomaine.com` (valeur de `SUPER_ADMIN_EMAIL`)
3. Password : valeur de `SUPER_ADMIN_PASSWORD`
4. **Changer immédiatement le mot de passe** dans Settings
5. Activer la 2FA TOTP

## 9. Configurer le congrès

Aller sur https://congres.votredomaine.com/admin

- **Dashboard** : KPIs en temps réel
- **Content / Sponsors** : créer les sponsors (logo, niveau, site web)
- **Content / Speakers** : créer les intervenants
- **Content / Sessions** : créer le programme scientifique
- **Content / Rooms** : créer les salles
- **Registrations** : suivre les inscriptions
- **Abstracts** : assigner reviewers + décisions
- **Visa Letters** : générer les lettres d'invitation

## 10. Mises à jour

Pour mettre à jour Congresia avec une nouvelle version :
```bash
cd ~/congres-app
git pull origin main
composer install --no-dev --optimize-autoloader
npm ci --omit=dev
npm run build
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Sauvegardes

- o2switch inclut **JetBackup** quotidien (30 jours) — déjà actif
- Pour une sauvegarde externe additionnelle, ajouter dans le cron :
```
0 3 * * * cd /home/cpanel-user/congres-app && /usr/local/bin/php artisan backup:run --only-db
```

## Dépannage

### Page blanche
- Vérifier `APP_DEBUG=true` temporairement
- Vérifier `storage/logs/laravel.log`
- Vérifier permissions : `chmod -R 775 storage bootstrap/cache`

### Email non envoyés
- Vérifier config SMTP dans `.env`
- Tester : `php artisan tinker` puis `Mail::raw('test', fn ($m) => $m->to('vous@email.com')->subject('Test'))`

### Erreur "Class not found"
- `composer dump-autoload`
- `php artisan optimize:clear`

### Migration échoue
- Vérifier que MariaDB est ≥ 10.3 (recommandé 10.6+)
- Vérifier les privilèges DB

## Support

- **GitHub Issues** : https://github.com/Frejustedev/CONGRES_MED/issues
- **Email** : agbotonfrejuste@gmail.com

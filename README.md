# Congresia — Plateforme de gestion de congrès médicaux

> Solution Laravel 13 + Inertia + Vue 3 + Tailwind 4 + MariaDB, déployable en standalone pour chaque client.

## Stack

- **Backend** : Laravel 13.8 + PHP 8.3+ + MariaDB 10.x
- **Frontend** : Inertia.js + Vue 3 + TypeScript + Vite + Tailwind 4 + shadcn-vue
- **Auth** : Fortify (2FA TOTP + magic link + passkeys)
- **RBAC** : spatie/laravel-permission (10 rôles, 58 permissions)
- **PDF** : dompdf (badges, factures, attestations, lettres visa)
- **QR Codes** : endroid/qr-code (signature HMAC anti-falsification)
- **Paiements** : Kkiapay (Mobile Money UEMOA) + Stripe (international) + cash
- **Stockage config** : spatie/laravel-settings (5 groupes : event, branding, modules, payment, mail)

## Modules

- **Portail public** : home + countdown, programme, intervenants, sponsors, exposants, FAQ, contact, infos pratiques
- **Inscriptions** : wizard 3 étapes + tarifs early-bird/standard/late + codes promo + inscriptions groupées
- **Paiements** : Kkiapay/Stripe/cash + factures PDF auto + webhooks signés + mode mock pour dev
- **Abstracts** : soumission IMRAD + co-auteurs + COI + peer review double-blind + scoring multicritères pondéré
- **Jour J** : scanner QR caméra + offline-first localStorage + check-in + scan par session
- **CME** : attribution auto crédits selon présences + attestation PDF
- **Visa** : génération lettre d'invitation officielle PDF
- **Admin** : dashboard temps réel + CRUD content (sponsors/exposants/sessions/speakers/symposiums) + assignation reviewers + décisions + exports CSV

## Développement local

```bash
# Prérequis : Laravel Herd (Windows) ou environnement PHP 8.3 + Composer + Node 20+ + MariaDB

# 1. Cloner
git clone https://github.com/Frejustedev/CONGRES_MED.git congresia
cd congresia

# 2. Installer
composer install
npm install
cp .env.example .env
php artisan key:generate

# 3. Base de données (MariaDB / MySQL)
# Créer une base 'congresia' puis dans .env :
# DB_CONNECTION=mariadb
# DB_DATABASE=congresia
# DB_USERNAME=root
# DB_PASSWORD=root

php artisan migrate --seed

# 4. Lancer
npm run dev          # watch assets
# Herd sert automatiquement http://congresia.test
```

Super-admin créé par le seed : `admin@congresia.test` / `password` (à changer immédiatement).

## Déploiement client (o2switch ou similaire)

Voir [INSTALL_O2SWITCH.md](./INSTALL_O2SWITCH.md) pour le guide complet.

Résumé :
1. Créer un sous-domaine (`congres.client.com`) avec PHP 8.3+
2. Créer une base MySQL/MariaDB
3. Cloner ou uploader le code
4. `bash install.sh`
5. Configurer le cron Laravel : `* * * * * php artisan schedule:run`

## Mode mock (paiements)

Par défaut, `PAYMENT_MODE=mock` dans `.env` simule les paiements (utile en dev). En prod, passer à `live` et renseigner les clés Kkiapay/Stripe.

## Architecture

```
app/
├── Http/Controllers/
│   ├── Admin/        # Back-office (DashboardController, RegistrationManagementController, AbstractManagementController, ContentController, GroupRegistrationController, VisaLetterController)
│   ├── Public/       # Frontoffice (Home, Programme, Speakers, Sponsors, Exhibitors, Infos, Faq, Contact, Registration, Payment, Abstract, Verify, ParticipantDownload)
│   ├── Reviewer/     # Espace peer review (ReviewController)
│   ├── Staff/        # Scanner Jour J (ScanController)
│   └── Webhooks/     # Webhooks paiements (PaymentWebhookController)
├── Models/           # 31 modèles Eloquent (User, Event, Participant, Registration, Payment, Invoice, Abstrakt, ProgramSession, Speaker, Sponsor, Exhibitor, Symposium, Attendance, CmeCredit, Attestation, etc.)
├── Services/
│   ├── Payments/     # Kkiapay, Stripe, Cash + PaymentService orchestrateur
│   ├── Pdf/          # BadgePdf, InvoicePdf, AttestationPdf, VisaLetterPdf
│   ├── Abstracts/    # SubmissionService
│   ├── Attendance/   # AttendanceService
│   ├── Cme/          # CmeService (attribution automatique)
│   └── Registrations/# PricingService (tier + promo)
├── Settings/         # 5 classes Spatie Settings (Event, Branding, Modules, Payment, Mail)
└── Mail/             # Mailables (RegistrationConfirmed, PaymentReceived)

resources/js/pages/   # Pages Vue Inertia (Public/*, Admin/*, Reviewer/*, Staff/*, auth/*, settings/*)
resources/views/
├── pdfs/             # Templates Blade : badge, invoice, attestation, visa-letter
└── emails/           # Templates emails HTML

database/
├── migrations/       # 33 migrations
├── seeders/          # RolesAndPermissions, SuperAdmin, DemoEvent, DemoFaqs
├── settings/         # 5 migrations Spatie Settings
└── factories/        # Factories pour les tests
```

## Tests

```bash
php artisan test
```

Tests Pest critiques inclus :
- `PricingServiceTest` : calcul tarifs early-bird/standard/late + codes promo
- `BadgeQrSignatureTest` : signature HMAC et anti-tamper QR

## Configuration personnalisée (par client)

Toute la personnalisation se fait depuis l'admin (`/admin`) sans toucher au code :
- **Event** : nom, dates, lieu, thème, président
- **Branding** : couleurs, logo, polices, dark mode
- **Modules** : activer/désactiver chaque fonctionnalité (abstracts, sponsors, CME, streaming…)
- **Payment** : clés Kkiapay/Stripe, devise, TVA, mentions légales
- **Mail** : SMTP, expéditeur, signature

## Licence

Propriétaire — © 2026 Dr Frejuste AGBOTON. Tous droits réservés.

## Contact

- **Lead** : Dr Frejuste AGBOTON — agbotonfrejuste@gmail.com

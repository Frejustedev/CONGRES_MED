<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Permission groups organized by domain.
     */
    public const PERMISSIONS = [
        // Configuration & système
        'settings.manage',
        'audit.view',
        'media.upload',
        'media.delete',

        // Utilisateurs & rôles
        'users.view',
        'users.create',
        'users.update',
        'users.delete',
        'users.assign-roles',
        'users.impersonate',

        // Événement (config globale du congrès)
        'event.view',
        'event.manage',

        // Inscriptions
        'registrations.view',
        'registrations.create',
        'registrations.update',
        'registrations.delete',
        'registrations.refund',
        'registrations.export',
        'registrations.invite-groups',
        'registrations.issue-visa-letter',

        // Paiements
        'payments.view',
        'payments.refund',
        'payments.export',
        'payments.reconcile',
        'invoices.view',
        'invoices.generate',
        'invoices.export',

        // Abstracts (résumés scientifiques)
        'abstracts.submit',
        'abstracts.view-own',
        'abstracts.view-all',
        'abstracts.assign-reviewers',
        'abstracts.review',
        'abstracts.decide',
        'abstracts.publish',
        'abstracts.export',
        'abstracts.compile-booklet',

        // Programme scientifique
        'sessions.view',
        'sessions.manage',
        'speakers.view',
        'speakers.manage',

        // Sponsors / Exposants / Symposiums
        'sponsors.view',
        'sponsors.manage',
        'sponsors.contact-leads',
        'exhibitors.view',
        'exhibitors.manage',
        'exhibitors.scan-leads',
        'symposiums.view',
        'symposiums.manage',

        // Jour J
        'scans.perform',
        'scans.view',
        'badges.generate',
        'badges.reissue',

        // CME / Attestations
        'cme.manage',
        'cme.export',
        'attestations.generate',
        'attestations.verify',

        // Reports / BI
        'reports.view',
        'reports.export',
    ];

    /**
     * Role → permissions mapping.
     */
    public const ROLES = [
        'super-admin' => '*', // wildcard, toutes permissions

        'admin-orga' => [
            'settings.manage', 'audit.view', 'media.upload', 'media.delete',
            'users.view', 'users.create', 'users.update', 'users.assign-roles',
            'event.view', 'event.manage',
            'registrations.view', 'registrations.create', 'registrations.update', 'registrations.delete',
            'registrations.refund', 'registrations.export', 'registrations.invite-groups',
            'registrations.issue-visa-letter',
            'payments.view', 'payments.refund', 'payments.export', 'payments.reconcile',
            'invoices.view', 'invoices.generate', 'invoices.export',
            'abstracts.view-all', 'abstracts.publish', 'abstracts.export', 'abstracts.compile-booklet',
            'sessions.view', 'sessions.manage',
            'speakers.view', 'speakers.manage',
            'sponsors.view', 'sponsors.manage', 'sponsors.contact-leads',
            'exhibitors.view', 'exhibitors.manage',
            'symposiums.view', 'symposiums.manage',
            'scans.view',
            'badges.generate', 'badges.reissue',
            'cme.manage', 'cme.export',
            'attestations.generate', 'attestations.verify',
            'reports.view', 'reports.export',
        ],

        'admin-scientifique' => [
            'audit.view',
            'event.view',
            'abstracts.view-all', 'abstracts.assign-reviewers', 'abstracts.decide',
            'abstracts.publish', 'abstracts.export', 'abstracts.compile-booklet',
            'sessions.view', 'sessions.manage',
            'speakers.view', 'speakers.manage',
            'symposiums.view',
            'reports.view',
        ],

        'tresorier' => [
            'event.view',
            'registrations.view', 'registrations.export',
            'payments.view', 'payments.refund', 'payments.export', 'payments.reconcile',
            'invoices.view', 'invoices.generate', 'invoices.export',
            'reports.view', 'reports.export',
        ],

        'regisseur' => [
            'event.view',
            'registrations.view',
            'scans.perform', 'scans.view',
            'badges.generate', 'badges.reissue',
            'attestations.generate', 'attestations.verify',
        ],

        'reviewer' => [
            'event.view',
            'abstracts.review',
        ],

        'speaker' => [
            'event.view',
            'abstracts.view-own', 'abstracts.submit',
            'sessions.view',
        ],

        'sponsor' => [
            'event.view',
            'sponsors.view',
        ],

        'exhibitor' => [
            'event.view',
            'exhibitors.view',
            'exhibitors.scan-leads',
        ],

        'participant' => [
            'event.view',
            'abstracts.submit', 'abstracts.view-own',
            'sessions.view',
            'speakers.view',
            'sponsors.view',
            'exhibitors.view',
            'symposiums.view',
        ],
    ];

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Création des permissions
        foreach (self::PERMISSIONS as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Création des rôles + assignation des permissions
        foreach (self::ROLES as $roleName => $permissions) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            if ($permissions === '*') {
                $role->syncPermissions(Permission::all());
            } else {
                $role->syncPermissions($permissions);
            }
        }

        $this->command->info(sprintf(
            '✓ %d permissions et %d rôles créés/synchronisés',
            count(self::PERMISSIONS),
            count(self::ROLES),
        ));
    }
}

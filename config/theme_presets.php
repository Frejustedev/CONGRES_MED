<?php

/**
 * Presets de thèmes visuels pour différencier chaque déploiement client.
 * L'admin choisit un preset qui pré-remplit toutes les couleurs et polices.
 */

return [
    'medical-sky' => [
        'name' => 'Medical Sky',
        'description' => 'Bleu médical classique, professionnel et apaisant.',
        'preview_gradient' => 'linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%)',
        'colors' => [
            'color_primary' => '#0ea5e9',
            'color_primary_foreground' => '#ffffff',
            'color_secondary' => '#64748b',
            'color_secondary_foreground' => '#ffffff',
            'color_accent' => '#f59e0b',
            'color_accent_foreground' => '#0f172a',
            'color_background' => '#ffffff',
            'color_foreground' => '#0f172a',
            'color_muted' => '#f1f5f9',
            'color_muted_foreground' => '#64748b',
            'color_destructive' => '#ef4444',
        ],
        'fonts' => [
            'font_heading' => 'Inter',
            'font_body' => 'Inter',
        ],
    ],

    'academic-purple' => [
        'name' => 'Academic Purple',
        'description' => 'Violet académique sérieux et prestigieux, idéal universités.',
        'preview_gradient' => 'linear-gradient(135deg, #7c3aed 0%, #a855f7 100%)',
        'colors' => [
            'color_primary' => '#7c3aed',
            'color_primary_foreground' => '#ffffff',
            'color_secondary' => '#475569',
            'color_secondary_foreground' => '#ffffff',
            'color_accent' => '#facc15',
            'color_accent_foreground' => '#0f172a',
            'color_background' => '#fafaf9',
            'color_foreground' => '#1c1917',
            'color_muted' => '#f5f5f4',
            'color_muted_foreground' => '#78716c',
            'color_destructive' => '#dc2626',
        ],
        'fonts' => [
            'font_heading' => 'Playfair Display',
            'font_body' => 'Source Sans 3',
        ],
    ],

    'clinical-emerald' => [
        'name' => 'Clinical Emerald',
        'description' => 'Vert clinique frais, parfait pour santé publique et bien-être.',
        'preview_gradient' => 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
        'colors' => [
            'color_primary' => '#059669',
            'color_primary_foreground' => '#ffffff',
            'color_secondary' => '#475569',
            'color_secondary_foreground' => '#ffffff',
            'color_accent' => '#06b6d4',
            'color_accent_foreground' => '#ffffff',
            'color_background' => '#ffffff',
            'color_foreground' => '#064e3b',
            'color_muted' => '#ecfdf5',
            'color_muted_foreground' => '#047857',
            'color_destructive' => '#dc2626',
        ],
        'fonts' => [
            'font_heading' => 'Plus Jakarta Sans',
            'font_body' => 'Plus Jakarta Sans',
        ],
    ],

    'bold-crimson' => [
        'name' => 'Bold Crimson',
        'description' => 'Rouge bordeaux puissant pour congrès à fort impact.',
        'preview_gradient' => 'linear-gradient(135deg, #9f1239 0%, #be123c 100%)',
        'colors' => [
            'color_primary' => '#be123c',
            'color_primary_foreground' => '#ffffff',
            'color_secondary' => '#44403c',
            'color_secondary_foreground' => '#ffffff',
            'color_accent' => '#f59e0b',
            'color_accent_foreground' => '#1c1917',
            'color_background' => '#fafaf9',
            'color_foreground' => '#1c1917',
            'color_muted' => '#f5f5f4',
            'color_muted_foreground' => '#78716c',
            'color_destructive' => '#7f1d1d',
        ],
        'fonts' => [
            'font_heading' => 'Bricolage Grotesque',
            'font_body' => 'Inter',
        ],
    ],

    'modern-slate' => [
        'name' => 'Modern Slate',
        'description' => 'Gris ardoise moderne et minimaliste, esprit tech.',
        'preview_gradient' => 'linear-gradient(135deg, #1e293b 0%, #475569 100%)',
        'colors' => [
            'color_primary' => '#1e293b',
            'color_primary_foreground' => '#f8fafc',
            'color_secondary' => '#475569',
            'color_secondary_foreground' => '#ffffff',
            'color_accent' => '#22d3ee',
            'color_accent_foreground' => '#0f172a',
            'color_background' => '#ffffff',
            'color_foreground' => '#0f172a',
            'color_muted' => '#f8fafc',
            'color_muted_foreground' => '#64748b',
            'color_destructive' => '#ef4444',
        ],
        'fonts' => [
            'font_heading' => 'Geist',
            'font_body' => 'Geist',
        ],
    ],

    'warm-amber' => [
        'name' => 'Warm Amber',
        'description' => 'Jaune ambré chaleureux et convivial, esprit panafricain.',
        'preview_gradient' => 'linear-gradient(135deg, #d97706 0%, #f59e0b 100%)',
        'colors' => [
            'color_primary' => '#d97706',
            'color_primary_foreground' => '#ffffff',
            'color_secondary' => '#78350f',
            'color_secondary_foreground' => '#ffffff',
            'color_accent' => '#16a34a',
            'color_accent_foreground' => '#ffffff',
            'color_background' => '#fffbeb',
            'color_foreground' => '#451a03',
            'color_muted' => '#fef3c7',
            'color_muted_foreground' => '#92400e',
            'color_destructive' => '#dc2626',
        ],
        'fonts' => [
            'font_heading' => 'DM Serif Display',
            'font_body' => 'DM Sans',
        ],
    ],

    'royal-navy' => [
        'name' => 'Royal Navy',
        'description' => 'Bleu marine prestigieux, élégance institutionnelle.',
        'preview_gradient' => 'linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%)',
        'colors' => [
            'color_primary' => '#1e3a8a',
            'color_primary_foreground' => '#ffffff',
            'color_secondary' => '#1e40af',
            'color_secondary_foreground' => '#ffffff',
            'color_accent' => '#fbbf24',
            'color_accent_foreground' => '#1e3a8a',
            'color_background' => '#ffffff',
            'color_foreground' => '#0f172a',
            'color_muted' => '#eff6ff',
            'color_muted_foreground' => '#3730a3',
            'color_destructive' => '#dc2626',
        ],
        'fonts' => [
            'font_heading' => 'Cormorant Garamond',
            'font_body' => 'Lato',
        ],
    ],

    'fresh-teal' => [
        'name' => 'Fresh Teal',
        'description' => 'Sarcelle moderne et innovant, parfait e-santé / IA.',
        'preview_gradient' => 'linear-gradient(135deg, #0d9488 0%, #14b8a6 100%)',
        'colors' => [
            'color_primary' => '#0d9488',
            'color_primary_foreground' => '#ffffff',
            'color_secondary' => '#475569',
            'color_secondary_foreground' => '#ffffff',
            'color_accent' => '#ec4899',
            'color_accent_foreground' => '#ffffff',
            'color_background' => '#ffffff',
            'color_foreground' => '#0f172a',
            'color_muted' => '#f0fdfa',
            'color_muted_foreground' => '#0f766e',
            'color_destructive' => '#ef4444',
        ],
        'fonts' => [
            'font_heading' => 'Space Grotesk',
            'font_body' => 'Inter',
        ],
    ],
];

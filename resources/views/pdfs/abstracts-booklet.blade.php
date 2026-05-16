<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Livret des résumés — {{ $event->name }}</title>
    <style>
        @page { margin: 18mm; size: A4 portrait; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            color: #0f172a;
            line-height: 1.5;
        }
        .cover {
            height: 240mm;
            page-break-after: always;
            text-align: center;
            padding-top: 80mm;
        }
        .cover h1 {
            font-size: 28pt;
            color: {{ $branding->color_primary ?? '#0ea5e9' }};
            margin: 0 0 10mm 0;
        }
        .cover .subtitle { font-size: 14pt; color: #475569; }
        .cover .meta { margin-top: 30mm; font-size: 10pt; color: #64748b; }
        .toc { page-break-after: always; }
        .toc h2 { color: {{ $branding->color_primary ?? '#0ea5e9' }}; border-bottom: 2px solid; padding-bottom: 3mm; }
        .toc-item { padding: 1mm 0; border-bottom: 1px dotted #cbd5e1; font-size: 9pt; }
        .toc-section { margin-top: 6mm; font-weight: bold; color: {{ $branding->color_primary ?? '#0ea5e9' }}; }
        .abstract { page-break-inside: avoid; margin-bottom: 12mm; padding-bottom: 8mm; border-bottom: 1px solid #e2e8f0; }
        .abstract-ref { font-family: monospace; font-size: 8pt; color: #94a3b8; }
        .abstract-title { font-size: 13pt; font-weight: bold; color: #0f172a; margin: 1mm 0; }
        .abstract-authors { font-size: 9pt; color: #475569; margin: 1mm 0; font-style: italic; }
        .abstract-type { display: inline-block; background: {{ $branding->color_primary ?? '#0ea5e9' }}; color: white; padding: 0.5mm 2mm; border-radius: 1mm; font-size: 7pt; text-transform: uppercase; }
        .abstract-keywords { font-size: 8pt; color: #64748b; margin: 2mm 0; }
        .imrad-section { margin-top: 2mm; }
        .imrad-section h4 { font-size: 9pt; margin: 2mm 0 1mm; color: {{ $branding->color_primary ?? '#0ea5e9' }}; }
        .imrad-section p { font-size: 9pt; margin: 0; text-align: justify; }
        .theme-header { background: {{ $branding->color_primary ?? '#0ea5e9' }}; color: white; padding: 4mm 6mm; margin: 0 -18mm 6mm; font-size: 12pt; font-weight: bold; page-break-before: always; }
    </style>
</head>
<body>
    <!-- COUVERTURE -->
    <div class="cover">
        <h1>Livret des résumés scientifiques</h1>
        <p class="subtitle">{{ $event->name }}</p>
        @if($event->theme)
            <p class="subtitle"><em>{{ $event->theme }}</em></p>
        @endif
        <p class="meta">
            {{ $totalCount }} résumé{{ $totalCount > 1 ? 's' : '' }} publié{{ $totalCount > 1 ? 's' : '' }}<br>
            Édité le {{ $generatedAt->format('d/m/Y') }}<br>
            @if($event->venue_city){{ $event->venue_city }}@endif
        </p>
    </div>

    <!-- SOMMAIRE -->
    <div class="toc">
        <h2>Sommaire</h2>
        @foreach($byTheme as $theme => $abstracts)
            <div class="toc-section">{{ $theme }} ({{ $abstracts->count() }})</div>
            @foreach($abstracts as $a)
                <div class="toc-item">{{ $a->reference }} — {{ $a->title }}</div>
            @endforeach
        @endforeach
    </div>

    <!-- ABSTRACTS PAR THÈME -->
    @foreach($byTheme as $theme => $abstracts)
        <div class="theme-header">{{ $theme }}</div>

        @foreach($abstracts as $a)
            <div class="abstract">
                <p class="abstract-ref">{{ $a->reference }} <span class="abstract-type">{{ $a->submission_type }}</span></p>
                <h3 class="abstract-title">{{ $a->title }}</h3>
                <p class="abstract-authors">
                    @foreach($a->authors as $author)
                        @if(!$loop->first), @endif{{ trim($author->salutation.' '.$author->first_name.' '.$author->last_name) }}<sup>{{ $loop->iteration }}</sup>
                    @endforeach
                </p>
                <p class="abstract-authors">
                    @foreach($a->authors as $author)
                        @if(!$loop->first); @endif<sup>{{ $loop->iteration }}</sup>{{ $author->affiliation }}
                    @endforeach
                </p>

                @if($a->keywords)
                    <p class="abstract-keywords"><strong>Mots-clés :</strong> {{ implode(' · ', $a->keywords) }}</p>
                @endif

                @if($a->is_case_report)
                    <div class="imrad-section">
                        <h4>Description du cas</h4>
                        <p>{{ Str::limit($a->case_description, 1500) }}</p>
                    </div>
                @else
                    @foreach([
                        'introduction' => 'Introduction',
                        'methods' => 'Méthodes',
                        'results' => 'Résultats',
                        'discussion' => 'Discussion',
                        'conclusion' => 'Conclusion',
                    ] as $field => $label)
                        @if($a->$field)
                            <div class="imrad-section">
                                <h4>{{ $label }}</h4>
                                <p>{{ $a->$field }}</p>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        @endforeach
    @endforeach
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Badge — {{ $registration->reference }}</title>
    <style>
        @page { margin: 0; size: A6 portrait; }
        * { box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #0f172a;
        }
        .badge {
            width: 105mm;
            height: 148mm;
            padding: 8mm;
            position: relative;
        }
        .header {
            border-bottom: 2px solid {{ $branding->color_primary ?? '#0ea5e9' }};
            padding-bottom: 6mm;
            text-align: center;
        }
        .event-name {
            font-size: 11pt;
            font-weight: bold;
            margin: 0;
            line-height: 1.2;
        }
        .event-theme {
            font-size: 8pt;
            color: #64748b;
            margin-top: 2mm;
        }
        .name-block {
            margin-top: 8mm;
            text-align: center;
        }
        .name {
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
            line-height: 1.1;
        }
        .role {
            font-size: 10pt;
            color: #475569;
            margin-top: 2mm;
        }
        .org {
            font-size: 8pt;
            color: #64748b;
            margin-top: 1mm;
        }
        .qr {
            position: absolute;
            bottom: 18mm;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }
        .qr img {
            width: 38mm;
            height: 38mm;
            display: block;
            margin: 0 auto;
        }
        .reference {
            font-family: 'DejaVu Sans Mono', monospace;
            font-size: 7pt;
            color: #64748b;
            margin-top: 2mm;
        }
        .category-badge {
            position: absolute;
            top: 8mm;
            right: 8mm;
            background: {{ $branding->color_primary ?? '#0ea5e9' }};
            color: white;
            padding: 1mm 3mm;
            border-radius: 3mm;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .footer {
            position: absolute;
            bottom: 4mm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 6pt;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="badge">
        <div class="category-badge">{{ $category->name }}</div>

        <div class="header">
            <p class="event-name">{{ $event->name }}</p>
            @if($event->theme)
                <p class="event-theme">{{ $event->theme }}</p>
            @endif
        </div>

        <div class="name-block">
            <p class="name">
                {{ trim(($participant->salutation ? $participant->salutation.' ' : '').$participant->first_name.' '.$participant->last_name) }}
            </p>
            @if($participant->job_title)
                <p class="role">{{ $participant->job_title }}</p>
            @endif
            @if($participant->organization)
                <p class="org">{{ $participant->organization }}</p>
            @endif
            @if($participant->city)
                <p class="org">{{ $participant->city }}{{ $participant->country ? ', '.$participant->country : '' }}</p>
            @endif
        </div>

        <div class="qr">
            <img src="{{ $qrDataUri }}" alt="QR Code" />
            <p class="reference">{{ $registration->reference }}</p>
        </div>

        <div class="footer">
            Présentez ce badge à l'entrée — Conservez-le pendant tout le congrès
        </div>
    </div>
</body>
</html>

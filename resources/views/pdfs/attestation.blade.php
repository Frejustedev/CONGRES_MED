<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Attestation {{ $attestation->reference }}</title>
    <style>
        @page { margin: 0; size: A4 landscape; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #0f172a;
            margin: 0;
            background: white;
        }
        .certificate {
            width: 297mm;
            height: 210mm;
            padding: 20mm;
            box-sizing: border-box;
            position: relative;
            border: 8px double {{ $branding->color_primary ?? '#0ea5e9' }};
        }
        .ornament-tl, .ornament-tr, .ornament-bl, .ornament-br {
            position: absolute;
            width: 30mm;
            height: 30mm;
            border: 2px solid {{ $branding->color_primary ?? '#0ea5e9' }};
        }
        .ornament-tl { top: 10mm; left: 10mm; border-right:none; border-bottom:none; }
        .ornament-tr { top: 10mm; right: 10mm; border-left:none; border-bottom:none; }
        .ornament-bl { bottom: 10mm; left: 10mm; border-right:none; border-top:none; }
        .ornament-br { bottom: 10mm; right: 10mm; border-left:none; border-top:none; }
        .content { text-align: center; padding-top: 15mm; }
        .pre-title {
            font-size: 11pt;
            letter-spacing: 8px;
            text-transform: uppercase;
            color: #64748b;
        }
        .title {
            font-size: 36pt;
            font-weight: bold;
            color: {{ $branding->color_primary ?? '#0ea5e9' }};
            margin: 6mm 0;
        }
        .subtitle {
            font-size: 14pt;
            color: #475569;
            margin-bottom: 12mm;
        }
        .recipient {
            font-size: 28pt;
            font-weight: bold;
            color: #0f172a;
            margin: 8mm 0;
            font-style: italic;
        }
        .body-text {
            font-size: 14pt;
            line-height: 1.6;
            max-width: 220mm;
            margin: 0 auto;
            color: #334155;
        }
        .body-text strong { color: #0f172a; }
        .credits {
            margin-top: 10mm;
            font-size: 14pt;
            font-weight: bold;
            color: {{ $branding->color_primary ?? '#0ea5e9' }};
        }
        .footer {
            position: absolute;
            bottom: 22mm;
            left: 20mm;
            right: 20mm;
            display: table;
            width: calc(100% - 40mm);
        }
        .footer-left, .footer-right {
            display: table-cell;
            width: 50%;
            vertical-align: bottom;
        }
        .footer-left { text-align: left; font-size: 9pt; color: #64748b; }
        .footer-right { text-align: right; }
        .signature-line {
            border-top: 1px solid #94a3b8;
            width: 70mm;
            margin: 0 0 1mm auto;
        }
        .verification {
            position: absolute;
            bottom: 8mm;
            left: 20mm;
            font-size: 7pt;
            color: #94a3b8;
            font-family: 'DejaVu Sans Mono', monospace;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="ornament-tl"></div>
        <div class="ornament-tr"></div>
        <div class="ornament-bl"></div>
        <div class="ornament-br"></div>

        <div class="content">
            <p class="pre-title">Certifie que</p>
            <h1 class="title">Attestation {{ $attestation->type === 'cme' ? 'CME' : 'de présence' }}</h1>
            <p class="subtitle">{{ $event->name ?? 'Congrès' }}{{ $event->venue_city ? ' · '.$event->venue_city : '' }}</p>

            <p style="font-size:12pt;">il est attesté que</p>
            <p class="recipient">{{ $attestation->recipient_name }}</p>

            <p class="body-text">
                a effectivement participé au <strong>{{ $event->name }}</strong>
                @if($event->start_date && $event->end_date)
                    du <strong>{{ \Carbon\Carbon::parse($event->start_date)->locale('fr')->isoFormat('D MMMM YYYY') }}</strong>
                    au <strong>{{ \Carbon\Carbon::parse($event->end_date)->locale('fr')->isoFormat('D MMMM YYYY') }}</strong>
                @endif
                @if($event->venue_city)
                    , {{ $event->venue_city }}{{ $event->venue_country ? ' ('.$event->venue_country.')' : '' }}
                @endif.
            </p>

            @if($attestation->total_credits > 0)
                <p class="credits">
                    Total : {{ number_format($attestation->total_credits, 1, ',', ' ') }} crédits {{ strtoupper($attestation->type) }}
                </p>
            @endif
        </div>

        <div class="footer">
            <div class="footer-left">
                Délivré le {{ $attestation->issued_at->locale('fr')->isoFormat('D MMMM YYYY') }}<br>
                {{ $event->venue_city ?? 'Cotonou' }}
            </div>
            <div class="footer-right">
                <div class="signature-line"></div>
                <p style="font-size:9pt; margin:0;">{{ $event->president_name ?? 'Le Président du comité d\'organisation' }}</p>
            </div>
        </div>

        <div class="verification">
            Réf : {{ $attestation->reference }} · Code de vérification : {{ $attestation->verification_code }} · {{ $verifyUrl }}
        </div>
    </div>
</body>
</html>

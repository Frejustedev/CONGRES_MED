<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Lettre d'invitation — {{ $registration->reference }}</title>
    <style>
        @page { margin: 20mm; size: A4; }
        body {
            font-family: 'DejaVu Sans', serif;
            font-size: 11pt;
            color: #0f172a;
            line-height: 1.6;
        }
        .header { text-align: right; margin-bottom: 10mm; font-size: 10pt; }
        .recipient { margin: 12mm 0; }
        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 12mm 0;
            padding: 4mm 0;
            border-top: 1px solid #0f172a;
            border-bottom: 1px solid #0f172a;
        }
        .body p { text-align: justify; margin-bottom: 5mm; }
        .body strong { font-weight: bold; }
        .signature { margin-top: 20mm; }
        .footer-meta {
            margin-top: 30mm;
            padding-top: 5mm;
            border-top: 1px dashed #94a3b8;
            font-size: 8pt;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>
            {{ $event->name ?? 'Congrès' }}<br>
            {{ $event->venue_city ?? 'Cotonou' }}, {{ \Carbon\Carbon::now()->locale('fr')->isoFormat('D MMMM YYYY') }}
        </p>
    </div>

    <div class="recipient">
        <p>
            À l'attention de l'Officier consulaire,<br>
            Ambassade compétente pour la délivrance de visas
        </p>
    </div>

    <div class="title">Lettre d'invitation officielle</div>

    <div class="body">
        <p>Madame, Monsieur,</p>

        <p>
            Nous avons l'honneur, par la présente, de confirmer que
            <strong>{{ trim(($participant->salutation ? $participant->salutation.' ' : '').$participant->first_name.' '.$participant->last_name) }}</strong>,
            @if($participant->job_title){{ $participant->job_title }}, @endif
            @if($participant->organization)de l'institution <strong>{{ $participant->organization }}</strong>, @endif
            est officiellement invité(e) à participer à notre congrès scientifique :
        </p>

        <p style="text-align: center; padding: 4mm; background:#f1f5f9; border-radius:3mm;">
            <strong>{{ $event->name }}</strong>
            @if($event->theme)<br><em>Thème : {{ $event->theme }}</em>@endif
            @if($event->start_date && $event->end_date)
                <br>Du {{ \Carbon\Carbon::parse($event->start_date)->locale('fr')->isoFormat('D MMMM YYYY') }}
                au {{ \Carbon\Carbon::parse($event->end_date)->locale('fr')->isoFormat('D MMMM YYYY') }}
            @endif
            @if($event->venue_name)<br>{{ $event->venue_name }}@endif
            @if($event->venue_city), {{ $event->venue_city }}@endif
            @if($event->venue_country) ({{ $event->venue_country }})@endif
        </p>

        <p>
            L'intéressé(e) a procédé à son inscription sous la référence
            <strong>{{ $registration->reference }}</strong>
            et a réglé sa participation pour un montant de
            <strong>{{ number_format($registration->amount_paid, 0, ',', ' ') }} {{ $registration->currency }}</strong>.
        </p>

        <p>
            Sa participation à ce congrès est essentielle dans le cadre de ses activités professionnelles.
            Tous les frais relatifs à son séjour (transport, hébergement, repas) seront pris en charge
            soit par l'intéressé(e), soit par son institution.
        </p>

        <p>
            Nous vous serions reconnaissants de bien vouloir lui faciliter l'obtention d'un visa pour la
            République du {{ $event->venue_country === 'BJ' ? 'Bénin' : ($event->venue_country ?? 'pays d\'accueil') }}
            durant la période susmentionnée.
        </p>

        <p>
            Vous remerciant par avance pour votre bienveillante attention, nous vous prions d'agréer, Madame,
            Monsieur, l'expression de nos salutations distinguées.
        </p>
    </div>

    <div class="signature">
        <p>
            {{ $event->president_name ?? 'Le Président du comité d\'organisation' }}<br>
            <em>{{ $event->president_title ?? '' }}</em>
        </p>
    </div>

    <div class="footer-meta">
        Document généré le {{ now()->format('d/m/Y H:i') }} · Réf. inscription : {{ $registration->reference }}<br>
        @if($event->support_email)Contact : {{ $event->support_email }}@endif
    </div>
</body>
</html>

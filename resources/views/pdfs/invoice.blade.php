<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Facture {{ $invoice->number }}</title>
    <style>
        @page { margin: 18mm; size: A4 portrait; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            color: #0f172a;
            margin: 0;
        }
        .header {
            display: table;
            width: 100%;
            margin-bottom: 10mm;
        }
        .header-left, .header-right {
            display: table-cell;
            vertical-align: top;
        }
        .header-right { text-align: right; }
        h1 {
            font-size: 22pt;
            color: #0ea5e9;
            margin: 0;
        }
        .meta {
            font-size: 9pt;
            color: #64748b;
            margin-top: 2mm;
        }
        .meta strong { color: #0f172a; }
        .parties {
            display: table;
            width: 100%;
            margin-top: 10mm;
        }
        .party {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 5mm;
        }
        .party-label {
            font-size: 8pt;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 2mm;
        }
        .party-name { font-weight: bold; font-size: 11pt; }
        table.lines {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12mm;
        }
        table.lines th {
            background: #f1f5f9;
            text-align: left;
            padding: 3mm 2mm;
            font-size: 9pt;
            border-bottom: 1px solid #e2e8f0;
        }
        table.lines th.right, table.lines td.right { text-align: right; }
        table.lines td {
            padding: 3mm 2mm;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10pt;
        }
        .totals {
            margin-top: 6mm;
            width: 60mm;
            margin-left: auto;
        }
        .totals .row {
            display: table;
            width: 100%;
            padding: 1.5mm 0;
        }
        .totals .label { display: table-cell; width: 50%; text-align: right; padding-right: 4mm; color: #64748b; }
        .totals .value { display: table-cell; width: 50%; text-align: right; font-weight: bold; }
        .totals .row.total {
            border-top: 2px solid #0f172a;
            padding-top: 3mm;
            font-size: 12pt;
        }
        .footer {
            margin-top: 18mm;
            padding-top: 6mm;
            border-top: 1px solid #e2e8f0;
            font-size: 8pt;
            color: #64748b;
            line-height: 1.6;
        }
        .status-badge {
            display: inline-block;
            padding: 1mm 3mm;
            border-radius: 2mm;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-paid { background: #d1fae5; color: #065f46; }
        .status-issued { background: #fef3c7; color: #92400e; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <h1>{{ $invoice->type === 'invoice' ? 'FACTURE' : ($invoice->type === 'proforma' ? 'FACTURE PROFORMA' : 'AVOIR') }}</h1>
            <div class="meta">N° <strong>{{ $invoice->number }}</strong></div>
            <div class="meta">Émise le {{ $invoice->issued_at->format('d/m/Y') }}</div>
            <div class="meta" style="margin-top:3mm;">
                <span class="status-badge {{ $invoice->status === 'paid' ? 'status-paid' : 'status-issued' }}">
                    {{ $invoice->status === 'paid' ? 'Payée' : 'À régler' }}
                </span>
            </div>
        </div>
        <div class="header-right">
            <div style="font-weight:bold; font-size:11pt;">{{ $invoice->issuer_name }}</div>
            @if($invoice->issuer_address)
                <div class="meta">{{ $invoice->issuer_address }}</div>
            @endif
            @if($invoice->issuer_email)
                <div class="meta">{{ $invoice->issuer_email }}</div>
            @endif
            @if($invoice->issuer_vat_number)
                <div class="meta">TVA : {{ $invoice->issuer_vat_number }}</div>
            @endif
        </div>
    </div>

    <div class="parties">
        <div class="party">
            <div class="party-label">Émetteur</div>
            <div class="party-name">{{ $invoice->issuer_name }}</div>
            @if($event->venue_city)
                <div>{{ $event->venue_city }}</div>
            @endif
        </div>
        <div class="party">
            <div class="party-label">Destinataire</div>
            <div class="party-name">{{ $invoice->buyer_name }}</div>
            @if($invoice->buyer_organization)
                <div>{{ $invoice->buyer_organization }}</div>
            @endif
            @if($invoice->buyer_address)
                <div>{{ $invoice->buyer_address }}</div>
            @endif
            @if($invoice->buyer_country)
                <div>{{ $invoice->buyer_country }}</div>
            @endif
            @if($invoice->buyer_email)
                <div class="meta">{{ $invoice->buyer_email }}</div>
            @endif
            @if($invoice->buyer_vat_number)
                <div class="meta">TVA : {{ $invoice->buyer_vat_number }}</div>
            @endif
        </div>
    </div>

    <table class="lines">
        <thead>
            <tr>
                <th style="width:50%">Désignation</th>
                <th class="right" style="width:10%">Qté</th>
                <th class="right" style="width:20%">PU</th>
                <th class="right" style="width:20%">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->lines as $line)
                <tr>
                    <td>{{ $line['description'] }}</td>
                    <td class="right">{{ $line['quantity'] ?? 1 }}</td>
                    <td class="right">{{ number_format($line['unit_price'] ?? 0, 0, ',', ' ') }} {{ $invoice->currency }}</td>
                    <td class="right">{{ number_format($line['total'] ?? 0, 0, ',', ' ') }} {{ $invoice->currency }}</td>
                </tr>
                @if(($line['discount'] ?? 0) > 0)
                    <tr>
                        <td colspan="3" style="text-align:right; color:#10b981; font-style:italic;">Dont remise appliquée</td>
                        <td class="right" style="color:#10b981;">-{{ number_format($line['discount'], 0, ',', ' ') }} {{ $invoice->currency }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        @if($invoice->vat_rate > 0)
            <div class="row">
                <div class="label">Sous-total HT</div>
                <div class="value">{{ number_format($invoice->subtotal_ht, 2, ',', ' ') }} {{ $invoice->currency }}</div>
            </div>
            <div class="row">
                <div class="label">TVA ({{ $invoice->vat_rate }}%)</div>
                <div class="value">{{ number_format($invoice->vat_amount, 2, ',', ' ') }} {{ $invoice->currency }}</div>
            </div>
        @endif
        <div class="row total">
            <div class="label">Total {{ $invoice->vat_rate > 0 ? 'TTC' : '' }}</div>
            <div class="value">{{ number_format($invoice->total_ttc, 0, ',', ' ') }} {{ $invoice->currency }}</div>
        </div>
    </div>

    @if($invoice->legal_mentions)
        <div class="footer">
            {!! nl2br(e($invoice->legal_mentions)) !!}
        </div>
    @else
        <div class="footer">
            Facture éditée par {{ $invoice->issuer_name }} dans le cadre de l'inscription au {{ $event->name }}.<br>
            Document à conserver. Tout réclamation doit être adressée dans un délai de 8 jours suivant la réception.
        </div>
    @endif
</body>
</html>

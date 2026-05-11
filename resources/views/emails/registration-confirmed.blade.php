<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Confirmation d'inscription</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; background:#f8fafc; margin:0; padding:24px; color:#0f172a;">
    <table cellpadding="0" cellspacing="0" border="0" align="center" style="max-width:600px; width:100%; background:#ffffff; border-radius:8px; overflow:hidden;">
        <tr>
            <td style="background:#0ea5e9; color:#ffffff; padding:24px 32px;">
                <h1 style="margin:0; font-size:20px;">Inscription enregistrée</h1>
                <p style="margin:4px 0 0; font-size:13px; opacity:0.9;">{{ config('app.name') }}</p>
            </td>
        </tr>
        <tr>
            <td style="padding:32px;">
                <p style="margin:0 0 16px; font-size:15px;">Bonjour <strong>{{ $participant->fullName() }}</strong>,</p>

                <p style="margin:0 0 16px; font-size:14px; line-height:1.6;">
                    Nous avons bien reçu votre demande d'inscription. Voici votre référence :
                </p>

                <div style="background:#f1f5f9; border-radius:6px; padding:16px; text-align:center; font-family:monospace; font-size:18px; font-weight:bold; letter-spacing:1px; margin:16px 0;">
                    {{ $registration->reference }}
                </div>

                <table cellpadding="6" cellspacing="0" border="0" style="width:100%; font-size:14px; margin:24px 0;">
                    <tr>
                        <td style="color:#64748b; width:40%;">Catégorie</td>
                        <td><strong>{{ $category->name }}</strong></td>
                    </tr>
                    <tr>
                        <td style="color:#64748b;">Montant dû</td>
                        <td><strong>{{ number_format($registration->amount_due, 0, ',', ' ') }} {{ $registration->currency }}</strong></td>
                    </tr>
                    @if($registration->amount_discount > 0)
                    <tr>
                        <td style="color:#64748b;">Remise</td>
                        <td style="color:#10b981;">-{{ number_format($registration->amount_discount, 0, ',', ' ') }} {{ $registration->currency }}</td>
                    </tr>
                    @endif
                    @if($remaining > 0)
                    <tr>
                        <td style="color:#64748b;">Reste à régler</td>
                        <td style="color:#f59e0b;"><strong>{{ number_format($remaining, 0, ',', ' ') }} {{ $registration->currency }}</strong></td>
                    </tr>
                    @endif
                </table>

                @if($remaining > 0)
                    <p style="margin:24px 0; text-align:center;">
                        <a href="{{ $paymentUrl }}" style="display:inline-block; background:#0ea5e9; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:6px; font-weight:bold; font-size:14px;">
                            Procéder au paiement
                        </a>
                    </p>
                @endif

                <p style="margin:24px 0 0; font-size:13px; color:#64748b; line-height:1.6;">
                    Conservez cette référence : elle vous sera demandée à l'accueil. Si vous avez réservé une lettre d'invitation visa, elle vous sera envoyée séparément.
                </p>
            </td>
        </tr>
        <tr>
            <td style="background:#f8fafc; padding:20px 32px; text-align:center; font-size:12px; color:#94a3b8;">
                Vous recevez cet e-mail suite à votre inscription au {{ config('app.name') }}.
            </td>
        </tr>
    </table>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Paiement confirmé</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; background:#f8fafc; margin:0; padding:24px; color:#0f172a;">
    <table cellpadding="0" cellspacing="0" border="0" align="center" style="max-width:600px; width:100%; background:#ffffff; border-radius:8px; overflow:hidden;">
        <tr>
            <td style="background:#10b981; color:#ffffff; padding:24px 32px;">
                <h1 style="margin:0; font-size:20px;">✓ Paiement confirmé</h1>
                <p style="margin:4px 0 0; font-size:13px; opacity:0.9;">Votre inscription au {{ config('app.name') }} est validée.</p>
            </td>
        </tr>
        <tr>
            <td style="padding:32px;">
                <p style="margin:0 0 16px; font-size:15px;">Bonjour <strong>{{ $participant->fullName() }}</strong>,</p>

                <p style="margin:0 0 16px; font-size:14px; line-height:1.6;">
                    Bonne nouvelle : votre paiement a bien été reçu. Vous trouverez ci-joint votre <strong>badge avec QR code</strong> et votre <strong>facture</strong>.
                </p>

                <div style="background:#d1fae5; border-radius:6px; padding:16px; margin:16px 0; font-size:14px;">
                    <strong style="color:#065f46;">Référence :</strong>
                    <span style="font-family:monospace; font-size:16px; margin-left:8px;">{{ $registration->reference }}</span>
                </div>

                <h3 style="margin:24px 0 12px; font-size:15px;">Prochaines étapes</h3>
                <ol style="margin:0; padding-left:20px; font-size:14px; line-height:1.7; color:#475569;">
                    <li>Téléchargez et imprimez votre badge (ou conservez-le sur smartphone)</li>
                    <li>Présentez-vous le jour J à l'accueil avec votre badge</li>
                    <li>Scannez-le à l'entrée pour valider votre présence</li>
                </ol>

                <table cellpadding="0" cellspacing="0" border="0" style="margin:24px auto;">
                    <tr>
                        <td style="padding-right:8px;">
                            <a href="{{ $downloadBadgeUrl }}" style="display:inline-block; background:#0ea5e9; color:#ffffff; text-decoration:none; padding:12px 20px; border-radius:6px; font-weight:bold; font-size:14px;">
                                Télécharger mon badge
                            </a>
                        </td>
                        <td>
                            <a href="{{ $downloadInvoiceUrl }}" style="display:inline-block; background:#ffffff; color:#0ea5e9; border:2px solid #0ea5e9; text-decoration:none; padding:10px 20px; border-radius:6px; font-weight:bold; font-size:14px;">
                                Télécharger ma facture
                            </a>
                        </td>
                    </tr>
                </table>

                <p style="margin:24px 0 0; font-size:13px; color:#64748b; line-height:1.6;">
                    À très bientôt au {{ config('app.name') }} !
                </p>
            </td>
        </tr>
        <tr>
            <td style="background:#f8fafc; padding:20px 32px; text-align:center; font-size:12px; color:#94a3b8;">
                Conservez ce mail : les liens restent valables pendant 90 jours.
            </td>
        </tr>
    </table>
</body>
</html>

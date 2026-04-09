<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
</head>

<body style="font-family: Inter, sans-serif; background: #F9F6F0; padding: 2rem;">

    <div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 16px; padding: 2rem; border: 1px solid #E8D5B7;">

        <h1 style="font-size: 1.5rem; color: #3D3530; margin-bottom: .5rem;">
            Nuovo messaggio di contatto
        </h1>
        <p style="color: #6B5C52; margin-bottom: 2rem;">
            Hai ricevuto un nuovo messaggio dal modulo contatti di Presto.it.
        </p>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px 0; color: #6B5C52; font-size: .875rem; width: 140px;">Nome</td>
                <td style="padding: 10px 0; color: #3D3530; font-weight: 500;">{{ $userName }}</td>
            </tr>
            <tr style="border-top: 1px solid #E8D5B7;">
                <td style="padding: 10px 0; color: #6B5C52; font-size: .875rem;">Email</td>
                <td style="padding: 10px 0; color: #B5622E; font-weight: 500;">{{ $userEmail }}</td>
            </tr>
            <tr style="border-top: 1px solid #E8D5B7;">
                <td style="padding: 10px 0; color: #6B5C52; font-size: .875rem; vertical-align: top;">Messaggio</td>
                <td style="padding: 10px 0; color: #3D3530;">{{ $motivation }}</td>
            </tr>
        </table>

        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #E8D5B7;">
            <p style="color: #6B5C52; font-size: .8rem; margin: 0;">
                Puoi rispondere direttamente a questa email per metterti in contatto con l'utente.
            </p>
        </div>

    </div>

</body>

</html>
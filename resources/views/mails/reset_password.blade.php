<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #F9F6F0;
            color: #3D3530;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #E8D5B7;
            padding: 30px;
            text-align: center;
        }

        h1 {
            color: #B5622E;
        }

        .btn {
            display: inline-block;
            background: #B5622E;
            color: #fff;
            padding: 12px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }

        .footer {
            margin-top: 40px;
            font-size: 0.85rem;
            color: #6B5C52;
            text-align: left;
            background: #F5EFE6;
            padding: 15px;
            border-radius: 8px;
        }

        .footer a {
            color: #B5622E;
            word-break: break-all;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🔐 Recupero Password</h1>

        <p>Ciao <strong>{{ $user->name }}</strong>,</p>
        <p>Hai richiesto di reimpostare la password per il tuo account su Presto.it.</p>
        <p>Clicca sul pulsante qui sotto per scegliere una nuova password in totale sicurezza:</p>

        {{-- Questo è il link generato dinamicamente da Laravel --}}
        <a href="{{ $url }}" class="btn">Reimposta Password</a>

        <p style="margin-top: 25px; font-size: 0.9rem;">Questo link scadrà tra 60 minuti.</p>
        <p style="font-size: 0.9rem;">Se non hai richiesto tu il cambio password, puoi tranquillamente ignorare questa
            email.</p>

        <div class="footer">
            <p style="margin: 0;">Se hai problemi a cliccare sul pulsante "Reimposta Password", copia e incolla questo
                indirizzo web nel tuo browser web:</p>
            <br>
            <a href="{{ $url }}">{{ $url }}</a>
        </div>
    </div>
</body>

</html>

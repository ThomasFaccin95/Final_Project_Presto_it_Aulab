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
    </style>
</head>

<body>
    <div class="container">
        <h1>🔑 Password Aggiornata!</h1>
        <p>Ciao <strong>{{ $user->name }}</strong>,</p>
        <p>Ti confermiamo che la password del tuo account su Presto.it è stata modificata con successo.</p>
        <p>Se non sei stato tu a effettuare questa modifica, ti preghiamo di contattare subito l'assistenza.</p>

        <a href="{{ route('homepage') }}" class="btn">Torna a Presto.it</a>
    </div>
</body>

</html>

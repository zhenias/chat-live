<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} - Autoryzacja</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .authorize-container {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }
        p, ul {
            color: #555;
            font-size: 0.95rem;
        }
        ul {
            padding-left: 20px;
        }
        .buttons {
            margin-top: 25px;
            text-align: center;
        }
        .btn {
            padding: 0.6rem 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95rem;
            margin: 0 0.5rem;
            transition: background 0.2s;
        }
        .btn-approve {
            background: #28a745;
            color: #fff;
        }
        .btn-approve:hover {
            background: #218838;
        }
        .btn-deny {
            background: #dc3545;
            color: #fff;
        }
        .btn-deny:hover {
            background: #c82333;
        }
        form {
            display: inline-block;
        }
    </style>
</head>
<body>
<div class="authorize-container">
    <h2>Prośba o autoryzację</h2>
    <p><strong>{{ $client->name }}</strong> prosi o dostęp do Twojego konta.</p>

    @if (count($scopes) > 0)
        <div class="scopes">
            <p><strong>Ta aplikacja będzie mogła:</strong></p>
            <ul>
                @foreach ($scopes as $scope)
                    <li>{{ $scope->description }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="buttons">
        <!-- Autoryzuj -->
        <form method="post" action="{{ route('passport.authorizations.approve') }}">
            @csrf
            <input type="hidden" name="state" value="{{ $request->state }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">
            <button type="submit" class="btn btn-approve">Autoryzuj</button>
        </form>

        <!-- Anuluj -->
        <form method="post" action="{{ route('passport.authorizations.deny') }}">
            @csrf
            @method('DELETE')
            <input type="hidden" name="state" value="{{ $request->state }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">
            <button class="btn btn-deny">Anuluj</button>
        </form>
    </div>
</div>
</body>
</html>

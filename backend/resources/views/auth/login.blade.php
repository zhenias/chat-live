<!DOCTYPE html>
<html>
<head>
    <title>Logowanie</title>
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
        .login-container {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 360px;
        }
        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 0.3rem;
            color: #555;
            font-size: 0.9rem;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.6rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: border 0.2s;
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007BFF;
            outline: none;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            color: #555;
        }
        .checkbox-label input {
            margin-right: 0.5rem;
        }
        button {
            width: 100%;
            padding: 0.7rem;
            background: #007BFF;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover {
            background: #0056b3;
        }
        .error {
            color: #d9534f;
            font-size: 0.85rem;
            margin-bottom: 0.8rem;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Logowanie</h2>
    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div>
            <label>Email</label>
            <input type="email" name="email" required>
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>
        <div>
            <label>Hasło</label>
            <input type="password" name="password" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>
        <div class="checkbox-label">
            <input type="checkbox" name="remember"> Zapamiętaj mnie
        </div>
        <button type="submit">Zaloguj</button>
    </form>
</div>
</body>
</html>

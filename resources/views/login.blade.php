<!DOCTYPE html>
<html>

<head>
    <title>Maverick</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <div class="login-container">

        <h1>Maverick</h1>

        <form method="POST" action="/login">
            @csrf

            <label>Username</label>
            <input type="text" name="username" value="{{ old('username') }}">

            <label>Password</label>
            <input type="password" name="password">

            <div class="row">
                <label class="remember">
                    <input type="checkbox" name="remember">
                    Remember Me
                </label>

                <a href="#">Forgot Password?</a>
            </div>

            @error('username')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">
                Login
            </button>

        </form>

    </div>

</body>

</html>
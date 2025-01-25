<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - College of Business Education</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #FFC107;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .navbar a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .navbar a:hover {
            background-color: #FF8c00;
            color: white;
        }

        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .login-header {
            background-color: #FFC107;
            color: #333;
            padding: 20px;
            text-align: center;
        }

        .login-header h1 {
            margin: 0;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .login-header p {
            margin: 0;
            font-size: 14px;
            opacity: 0.8;
        }

        .login-form {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #FFC107;
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: #FFC107;
            border: none;
            border-radius: 8px;
            color: #333;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .btn-login:hover {
            background-color: #FF8c00;
            color: white;
            transform: translateY(-1px);
        }

        .back-to-home {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .back-to-home a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .back-to-home a:hover {
            color: #FFC107;
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 10px;
            }
            
            .login-form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="/" class="nav-brand">College of Business Education</a>
            <div class="nav-links">
                <a href="{{ route('officer.login') }}">Officer Login</a>
                <a href="{{ route('enrollment.index') }}">Enrollment</a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="login-container">
            <div class="login-header">
                <h1>Student Login</h1>
                <p>Please enter your credentials to continue</p>
            </div>

            <div class="login-form">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" 
                            required autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            name="password" required autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember" 
                            {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember Me</label>
                    </div>

                    <button type="submit" class="btn-login">
                        <span>Login</span>
                        <i class='bx bx-right-arrow-alt'></i>
                    </button>

                    @if (Route::has('password.request'))
                        <div class="back-to-home">
                            <a href="{{ route('password.request') }}">
                                <i class='bx bx-help-circle'></i>
                                <span>Forgot Your Password?</span>
                            </a>
                        </div>
                    @endif

                    <div class="back-to-home">
                        <a href="/">
                            <i class='bx bx-left-arrow-alt'></i>
                            <span>Back to Home</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
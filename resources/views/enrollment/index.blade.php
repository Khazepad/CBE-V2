<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment - College of Business Education</title>
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

        .enrollment-container {
            width: 100%;
            max-width: 800px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .enrollment-header {
            background-color: #FFC107;
            color: #333;
            padding: 20px;
            text-align: center;
        }

        .enrollment-header h1 {
            margin: 0;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .enrollment-content {
            padding: 30px;
        }

        .enrollment-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .option-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .option-card:hover {
            transform: translateY(-5px);
        }

        .option-card h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .option-card p {
            color: #666;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: #FFC107;
            color: #333;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .requirements {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .requirements h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .requirements ul {
            list-style-type: none;
            padding: 0;
        }

        .requirements li {
            padding: 8px 0;
            color: #666;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .requirements li i {
            color: #FFC107;
        }

        @media (max-width: 768px) {
            .enrollment-container {
                margin: 10px;
            }
            
            .enrollment-content {
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
                <a href="{{ route('login') }}">Student Login</a>
                <a href="{{ route('officer.login') }}">Officer Login</a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="enrollment-container">
            <div class="enrollment-header">
                <h1>Welcome to Enrollment</h1>
                <p>Choose your enrollment type to begin</p>
            </div>

            <div class="enrollment-content">
                <div class="enrollment-options">
                    <div class="option-card">
                        <h3>New Student</h3>
                        <p>First time enrolling? Click here to start your journey.</p>
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Start New Enrollment
                        </a>
                    </div>  

                    <div class="option-card">
                        <h3>Existing Student</h3>
                        <p>Already enrolled? Login to continue your enrollment.</p>
                        <a href="{{ route('login') }}" class="btn btn-secondary">
                            Login to Enroll
                        </a>
                    </div>
                </div>

                <div class="requirements">
                    <h3>Enrollment Requirements</h3>
                    <ul>
                        <li><i class='bx bx-check-circle'></i> Valid ID</li>
                        <li><i class='bx bx-check-circle'></i> Previous School Records</li>
                        <li><i class='bx bx-check-circle'></i> 2x2 ID Picture</li>
                        <li><i class='bx bx-check-circle'></i> Birth Certificate</li>
                        <li><i class='bx bx-check-circle'></i> Good Moral Certificate</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College of Business Education</title>
    <link rel="stylesheet" href="path/to/your/styles.css"> <!-- Add your CSS file here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background-color: #f0f0f0;
            padding: 0;
            margin: 0;
            border: -10;
            overflow-y: auto;
            overflow-x: hidden;
            height: 100vh;
        }
        .navbar {
            background-color: #FFC107;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navbar a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: all 0.3s;
            margin: 0 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 5px 15px;
            border-radius: 8px;
        }
        .navbar a:hover {
            color: #FF8c00;
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        .navbar i {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .logo {
            margin-top: -200px;
            margin-left: 740px;
           
        }
        .container {
            margin-top: 30px;
            margin-left: 10px;
            width: 100%;
            justify-content: center;
            padding-bottom: 30px;
        }
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #FFC107;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #FF8c00;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ route('login') }}">
            <i class="fas fa-user-graduate"></i>
            Student
        </a>
        <a href="{{ route('officer.login') }}">
            <i class="fas fa-user-tie"></i>
            Officer
        </a>
        <a href="{{ route('enrollment.index') }}">
            <i class="fas fa-file-alt"></i>
            Enrollment
        </a>
    </div>
    <div class="container">
        <img src="{{ asset('images/cbe1.jpg') }}" alt="Department Logo" class="img-fluid my-4" style="max-width: 99%; height: auto; border-radius: 25px;">
        <div class="logo">
            <img src="{{ asset('images/dep.png') }}" alt="College Logo" class="img-fluid my-4" style="max-width: 99%; height: 400px;">
        </div>
    </div>
</body>
</html>

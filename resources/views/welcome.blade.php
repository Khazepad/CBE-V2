<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.COAHS', 'ADMS') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Retro pixelated font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            color: #333;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .rectangle {
            text-align: center;
            padding: 50px;
            border: 3px solid #fff;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.8); /* Dark transparent background */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative; /* Ensure the rectangle is positioned relative */
        }
        h1 {
            font-family: 'Anton', sans-serif;
            font-size: 5rem;
            color: #fff;
            margin-bottom: 0; /* Remove bottom margin */
            position: absolute; /* Position the h1 absolutely within the rectangle */
            bottom: 150px; /* Distance from the bottom */
            left: 40px; /* Distance from the left */
        }
        h2 {
            font-family: 'Anton', sans-serif;
            font-size: 5rem;
            color: #fff;
            margin-bottom: 0; /* Remove bottom margin */
            position: absolute; /* Position the h1 absolutely within the rectangle */
            bottom: 65px; /* Distance from the bottom */
            left: 40px; /* Distance from the left */
        }
        h3 {
            font-family: 'Anton', sans-serif;
            font-size: 3rem;
            color: #fff;
            margin-bottom: 0; /* Remove bottom margin */
            position: absolute; /* Position the h1 absolutely within the rectangle */
            bottom: 15px; /* Distance from the bottom */
            left: 40px; /* Distance from the left */
        }
        h5 {
            font-family: 'Poppins', sans-serif;
            color: #fff;
            font-size: 1.5rem;
        }
        h6 {
            font-family: 'Poppins', sans-serif;
            color: #333;
        }
        p {
            font-family: 'Poppins', sans-serif;
            color: #fff;
            font-size: 20px;
        }
        .logo {
            position: absolute; /* Position the logo absolutely within the rectangle */
            top: 50%; /* Center vertically */
            right: 15em;/* Distance from the right */
            transform: translateY(-50%); /* Adjust for the height of the logo */
            
        }
        .card-text-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .card-text {
            margin: 0;
            padding: 0;
            white-space: pre; /* Preserve whitespace */

        .lead {
            font-size: 1rem;
            color: #ccc;
        }
        .btn-custom {
            font-family: 'Press Start 2P', cursive;
            font-size: 14px;
            padding: 10px 20px;
            border: 3px solid #4e3a2a;
            background-color: #4e3a2a;
            color: #fff;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #3b2a1c;
            border-color: #3b2a1c;
            color: #f5f5f5;
            box-shadow: 4px 4px 8px #2c1e14;
            transform: scale(1.05);
        }

        
    </style>
</head>
<body>
    <div class="rectangle" style="width: 95%; height: 90%;">
        <img src="images/logo.png" alt="Logo" class="logo" style="max-width: 500%; height: 650px; margin-bottom: 50px;">
        <h1 class="mb-4">Appointment and Document</h1>
        <h2 class="mb-4">Management System </h2>
        <h3 class="mb-4">(ADMS)</h3>    
        <div class="card" style="position: absolute; top: 150px; left: 120px; margin: 0; background-color: rgba(255, 255, 255, 0.5); width: 20%; height: 20%;">
            <div class="card-body text-start">
                <div id="visionMissionCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <h5 class="mb-4" style="margin-bottom: 20px;">VISION</h5>
                            <p class="card-text">RMMC IS AN INSTITUTION OF</p>
                            <p class="card-text">INNOVATIVE DEVELOPMENT</p>
                            <p class="card-text">AND EXCELLENCE.</p>
                        </div>
                        <div class="carousel-item">
                        <h5 class="mb-4" style="margin-bottom: 20px;">MISSION</h5>
                            <p class="card-text">RMMC IS COMMITTED TO</p>
                            <p class="card-text">REALIZE HUMAN POTENTIALS</p>
                            <p class="card-text">THROUGH HOLISTIC EDUCATION.</p>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#visionMissionCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#visionMissionCarousel" data-bs-slide="next">
                        <span class="carousel-control-next" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
        <button class="btn btn-custom" style="position: absolute; bottom: 20px; right: 20px; font-size: 25px; color: white;" data-bs-toggle="modal" data-bs-target="#assistantModal">
            <i class="fas fa-info-circle"></i>
        </button>
        <nav class="-mx-1 top-0 right-0 p-4 flex flex-1 justify-end" style="position: absolute; right: 20px; color: white;">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-black dark:hover:text-black/80 dark:focus-visible:ring-white" style="font-family: 'Agrandir', sans-serif;">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-black/80 dark:focus-visible:ring-white" style="font-family: 'Agrandir', sans-serif; text-decoration: none; font-size: 1.3rem;">
                        LOG IN
                    </a>
                @endauth
            @endif
        </nav>
    </div>
    <video autoplay muted loop id="background-video">
        <source src="images/eyy.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <style>
        #background-video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            transform: translate(-50%, -50%);
        }
    </style>

    <!-- Bootstrap JS (optional, if you need Bootstrap's JavaScript features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Assistant Modal -->
    <div class="modal fade" id="assistantModal" tabindex="-1" aria-labelledby="assistantModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="assistantModalLabel">ADMS Assistant Panel</h6>
                </div>
                <div class="modal-body">
                    <h6 class="modal-text">Welcome to the Appointment and Document Management System (ADMS). Here you can manage your appointments and documents efficiently.</h6>
                    <h6 class="modal-text">The ADMS was developed by a team of skilled programmers who aimed to create a user-friendly and efficient system.</h6>
                    <h6 class="modal-text">The team included experts in software development, user experience design, and project management.</h6>
                    <h6 class="modal-text">The ADMS offers a range of features, including:</h6>
                    <h6 class="modal-text">• Appointment Scheduling: Easily schedule, reschedule, and cancel appointments.</h6>
                    <h6 class="modal-text">• Document Management: Store, organize, and retrieve documents with ease.</h6>
                    <h6 class="modal-text">• Notifications: Receive reminders and notifications for upcoming appointments and document deadlines.</h6>
                    <h6 class="modal-text">• User-Friendly Interface: Navigate the system effortlessly with an intuitive interface.</h6>
                    <h6 class="modal-text">The programmers behind ADMS have extensive experience in developing robust and reliable software solutions.</h6>
                    <h6 class="modal-text">They have utilized the latest technologies and best practices to ensure that the system is secure, efficient, and easy to use.</h6>
                    <h6 class="modal-text">If you have any questions or need assistance, feel free to reach out. We're here to help you make the most of the ADMS!</h6>
                </div>
                <div class="modal-footer" style="font-family: 'Poppins', sans-serif;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
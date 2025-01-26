<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation - College of Business Education</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <!-- Header with Logo -->
    <div style="text-align: center; margin-bottom: 30px;">
        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/dep-ndVRlmDXHfH7Hge84eKZWaePCfTbRO.png" alt="College Logo" style="max-width: 150px; height: auto;">
    </div>

    <!-- Main Content Container -->
    <div style="background: linear-gradient(to bottom,rgb(255, 229, 80), #FFF8DC); padding: 20px; border-radius: 10px; border: 1px solid #FFD700;">
        <h1 style="color: #333; text-align: center; margin-bottom: 30px; font-size: 24px;">Appointment Confirmation</h1>
        
        <!-- Appointment Details Card -->
        <div style="background-color: #ffffff; padding: 25px; border-radius: 8px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); margin-bottom: 25px;">
            <div style="border-left: 4px solid #FFD700; padding-left: 15px; margin-bottom: 15px;">
                <p style="font-size: 16px; margin: 10px 0;"><strong>Booking Reference:</strong> {{ $appointment->booking_reference_number }}</p>
            </div>
            
            <div style="display: grid; gap: 15px;">
                <p style="font-size: 16px; margin: 0;"><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}</p>
                <p style="font-size: 16px; margin: 0;"><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                <p style="font-size: 16px; margin: 0;"><strong>Purpose:</strong> {{ $appointment->purpose }}</p>
            </div>
        </div>

        <!-- Thank You Message -->
        <div style="text-align: center; margin: 30px 0;">
            <p style="font-size: 18px; color: #333;">Thank you for booking with us!</p>
            <p style="font-size: 14px; color: #666;">Please keep this email for your records.</p>
        </div>

        <!-- Important Notes -->
        <div style="background-color: #FFF8DC; padding: 20px; border-radius: 8px; margin-top: 25px;">
            <h2 style="color: #333; font-size: 18px; margin-top: 0;">Important Notes:</h2>
            <ul style="color: #555; margin: 10px 0; padding-left: 20px;">
                <li style="margin-bottom: 10px;">Please arrive 10 minutes before your scheduled appointment time.</li>
                <li style="margin-bottom: 10px;">Bring your student ID for verification purposes.</li>
                <li style="margin-bottom: 10px;">If you need to reschedule, please do so at least 24 hours in advance.</li>
            </ul>
        </div>

        <!-- Footer -->
        <div style="margin-top: 30px; text-align: center; color: #666; font-size: 14px; border-top: 1px solid #ddd; padding-top: 20px;">
            <p style="margin-bottom: 10px;">College of Business Education</p>
            <p style="margin-bottom: 10px;">
                <a href="mailto:cbeadmsytem@gmail.com" style="color: #333; text-decoration: none;">cbeadmsytem@gmail.com
                </a> | 
                <a href="tel:+1234567890" style="color: #333; text-decoration: none;">+1 (234) 567-890</a>
            </p>
            <p style="font-size: 12px; color: #999;">This is an automated email. Please do not reply.</p>
        </div>
    </div>
</body>
</html>


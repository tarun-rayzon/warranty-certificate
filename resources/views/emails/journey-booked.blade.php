<!DOCTYPE html>
<html>

<head>
    <title>Your Journey has been booked</title>
</head>

<body>
    <p>Hello {{ $user->name }},</p>

    <p>We are excited to inform you that your journey has been successfully booked.</p>

    <p>Here are your journey details:</p>
    @if ($journey_booking->booking_type == 'Hotel')
        <ul>
            <li><strong>Booking Type:</strong> {{ $journey_booking->booking_type }}</li>
            <li><strong>Destination:</strong> {{ $journey_booking->destination }}</li>
            <li><strong>Check In:</strong> {{ $journey_booking->check_in_date }}</li>
            <li><strong>Check Out:</strong> {{ $journey_booking->check_out_date }}</li>
        </ul>
    @else
        <ul>
            <li><strong>Departure Date:</strong> {{ $journey_booking->departure_date }}</li>
            <li><strong>From:</strong> {{ $journey_booking->from_location }}</li>
            <li><strong>To:</strong> {{ $journey_booking->to_location }}</li>
        </ul>
    @endif

    <p>If you have any questions or need assistance, please do not hesitate to reach out to our support team.</p>

    <p>Thank you for choosing Rayzon CRM. We are committed to providing you with the best possible experience.</p>

    <p>Best regards,<br>The Rayzon CRM Team</p>
</body>

</html>

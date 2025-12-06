<!DOCTYPE html>
<html>
<body>
    <h2>Your Booking is Confirmed</h2>

    <p>Hello {{ $booking->name ?? 'Customer' }},</p>

    <p>Your appointment is confirmed. Here are the details:</p>

    <table>
        <tr>
            <td><strong>Service:</strong></td>
            <td>{{ $booking->service->name }}</td>
        </tr>
        <tr>
            <td><strong>Date:</strong></td>
            <td>{{ $booking->date }}</td>
        </tr>
        <tr>
            <td><strong>Time:</strong></td>
            <td>{{ $booking->time }}</td>
        </tr>
    </table>

    <br>
    <p>Thank you for booking with us!</p>
</body>
</html>

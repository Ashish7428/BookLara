<!DOCTYPE html>
<html>
<head>
    <title>Book Approval Notification</title>
</head>
<body>
    <h1>Congratulations!</h1>
    <p>Dear {{ $book->author->full_name }},</p>
    <p>We are pleased to inform you that your book "{{ $book->title }}" has been approved and is now available on our platform.</p>
    <p>Thank you for contributing to our community!</p>
    <br>
    <p>Best regards,</p>
    <p>The BookRead Team</p>
</body>
</html>
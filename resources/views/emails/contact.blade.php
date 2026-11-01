<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo mensaje de contacto</title>
</head>
<body style="font-family: Arial, sans-serif; color: #222;">
    <h2 style="color: #099a35;">Nuevo mensaje desde la web</h2>
    <p><strong>Nombre:</strong> {{ $senderName }}</p>
    <p><strong>Email:</strong> {{ $senderEmail }}</p>
    <p><strong>Mensaje:</strong></p>
    <div style="white-space: pre-wrap; padding: 12px; background: #f6f6f6; border-left: 3px solid #099a35;">{{ $body }}</div>
</body>
</html>

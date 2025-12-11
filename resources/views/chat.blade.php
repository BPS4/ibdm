<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat</title>

    <!-- Vite JS & CSS -->
    @vite('resources/js/app.js')
</head>
<body>
    <div id="messages"></div>
    <input type="text" id="message">
   <button onclick="sendMessage()">Send</button>
</body>
</html>

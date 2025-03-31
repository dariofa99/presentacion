<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex items-center justify-center bg-gradient-to-r from-purple-500 to-indigo-500 animate-gradient">
    <div class="bg-white p-8 rounded-lg shadow-2xl max-w-sm w-full text-center">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Iniciar Sesión</h2>

        <div class="space-y-4">
            <a href="/login" class="block w-full bg-indigo-600 text-white py-3 rounded-lg text-lg font-semibold shadow-md hover:bg-indigo-700 transition-transform transform hover:scale-105">
                Ingresar
            </a>

            <hr class="border-gray-300">

            <a href="/register" class="block w-full bg-gray-300 text-gray-800 py-3 rounded-lg text-lg font-semibold shadow-md hover:bg-gray-400 transition-transform transform hover:scale-105">
                Registrarse
            </a>
        </div>
    </div>

    <style>
        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradientAnimation 10s ease infinite;
        }
    </style>
</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Contenedor del chat */
        #chat-box {
            padding: 10px;
            height: 350px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
            background-color: #f3f4f6;
            /* Gris claro */
            border-radius: 8px;
        }

        /* Mensajes */
        .chat-message {
            width: 100%;
            padding: 10px 14px;
            border-radius: 8px;
            word-break: break-word;
            font-size: 14px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Mensajes enviados (derecha) */
        .chat-message.sent {
            background-color: #554fc2;
            /* Azul índigo */
            color: white;
            align-self: flex-end;
            text-align: right;
        }

        /* Mensajes recibidos (izquierda) */
        .chat-message.received {
            background-color: #e5e7eb;
            /* Gris claro */
            color: black;
            align-self: flex-start;
            text-align: left;
        }

        /* Hora del mensaje */
        .chat-time {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 4px;
            display: block;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>

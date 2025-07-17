<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lavanderia Oasis</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS for Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom Styles -->
    <style>
        .bg-pharmacy {
            background: linear-gradient(to bottom right, #e0f7fa, #ffffff);
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 20px;
        }

        .glass-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.6);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .title-gradient {
            background: linear-gradient(90deg, #38bdf8, #4ade80);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 800;
            font-size: 3.5rem;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            animation: gradientShift 5s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .subtitle-color {
            background: linear-gradient(90deg, #a3e4d7, #96ceb4);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-size: 1.5rem;
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
            margin-bottom: 2rem;
        }

        .button-primary {
            background-color: #38bdf8;
            padding: 12px 24px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 600;
            text-transform: uppercase;
        }

        .button-primary:hover {
            background-color: #0ea5e9;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(14, 165, 233, 0.4);
        }
    </style>
</head>
<body class="font-poppins">
    <!-- Main Content -->
    <div class="bg-pharmacy">
        <div class="content flex flex-col items-center justify-center h-full">
            <div class="glass-card">
                <h1 class="title-gradient mb-6" data-aos="fade-up" data-aos-duration="1000">Lavanderia Oasis</h1>
                <p class="subtitle-color mb-8" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                    Tu lavandería de confianza dejándote la ropa limpia, más limpia que tu conciencia.
                </p>
                <div class="space-x-4" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
                    <a href="{{ route('login') }}" class="button-primary text-white">Inicio</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Initialize AOS -->
    <script>
        AOS.init();
    </script>
</body>
</html>

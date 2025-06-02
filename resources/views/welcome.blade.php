<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal RW Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap" rel="stylesheet">

    <style>
        body,
        html {
            font-family: 'Onest', Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body class="bg-slate-900 text-white flex items-center justify-center min-h-screen">
    <div class="text-center px-6">
        <!-- Logo -->
        <img src="{{ asset('images/logo-rw-digital.png') }}" alt="RW Digital Logo" class="mx-auto w-32 mb-6">

        <!-- Headline -->
        <h1 class="text-3xl font-medium mb-2">Selamat Datang di RW Digital</h1>
        <p class="text-slate-400 mb-8 max-w-md mx-auto">
            Platform digital untuk pengelolaan dan disposisi surat secara efisien dan modern. <br>Dapatkan kemudahan
            mengurus berbagai surat, seperti Surat Domisili, Surat Kematian, SKTM, Surat Izin Nikah, dan Surat Izin
            Kegiatan.
        </p>

        <div class="flex items-center justify-center gap-2">
            <!-- Login Button -->
            <a href="{{ route('filament.panel.pages.dashboard') }}"
                class="inline-block px-6 py-3 text-sm font-medium rounded-xl bg-cyan-500 hover:bg-cyan-600 transition">
                Masuk ke Aplikasi
            </a>
            <!-- Register Button -->
            <a href="{{ route('filament.panel.pages.dashboard') }}"
                class="inline-block px-6 py-3 text-sm font-medium rounded-xl bg-cyan-500 hover:bg-cyan-600 transition">
                Daftar Sekarang
            </a>
        </div>
    </div>
</body>

</html>

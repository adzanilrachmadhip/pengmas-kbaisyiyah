@props([
    'title' => null,
    'description' => "KB 'Aisyiyah 2 Dau adalah Kelompok Bermain di bawah naungan Pimpinan Cabang 'Aisyiyah Dau, Kabupaten Malang, yang memberikan pendidikan anak usia dini islami, hangat, dan menyenangkan.",
])
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title ? "{$title} — KB 'Aisyiyah 2 Dau" : "KB 'Aisyiyah 2 Dau — Kelompok Bermain Islami di Dau, Malang" }}</title>
<meta name="description" content="{{ $description }}">
@fonts
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sand-50 text-ink font-sans antialiased">

@include('partials.header')

<main>
{{ $slot }}
</main>

@include('partials.footer')

</body>
</html>

{{-- Tailwind + fonts via CDN — no build step. Custom brand palette
     (forest-*, sand-*, ink) is configured below instead of a @theme CSS
     file; see docs/ECMS.md if you ever need to swap this for a real
     build pipeline. --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          sans: ['Montserrat', 'ui-sans-serif', 'system-ui', 'sans-serif', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'],
        },
        colors: {
          forest: {
            50: '#f2f7f3', 100: '#dfe9e2', 200: '#bcd2c3', 300: '#9ab8a3', 400: '#6f9a7c',
            500: '#3f7452', 600: '#2f5d40', 700: '#264a34', 800: '#1f3c2b', 900: '#193024', 950: '#102018',
          },
          sand: {
            50: '#faf7f0', 100: '#f4eee0', 200: '#e8dcc0', 300: '#dac89a', 400: '#c7ab6c',
            500: '#b39152', 600: '#9c7838', 700: '#7c5f2e', 800: '#5e4824', 900: '#40311a',
          },
          ink: '#22231f',
        },
      },
    },
  };
</script>
<style>
  html { scroll-behavior: smooth; }
  ::selection { background-color: #bcd2c3; color: #193024; }
</style>

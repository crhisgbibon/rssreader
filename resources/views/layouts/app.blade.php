<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
      @if (isset($appTitle))
        {{ $appTitle }}
      @else
        {{ config('app.name', 'crhisgbibon') }}
      @endif
    </title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Add ins -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/vh.js'])
  </head>
    <body class="font-sans antialiased">
      <div class="min-h-screen">
        
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
          <header class="box-border border-b border-gray-100 box-border" id="topControl" style="min-height:calc(var(--vh) * 7.5)">
            {{ $header }}
          </header>
        @endif

        <!-- Page Content -->
        <main class="antialiased">
          {{ $slot }}
        </main>
      </div>
    </body>
</html>

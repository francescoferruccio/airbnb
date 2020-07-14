<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>BoolBnb</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="/js/app.js" charset="utf-8"></script>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
  </head>
  <body>
    <header>
      @include('components.nav')

      @include('header')
    </header>
    <main>

      @yield("content")

    </main>
    <footer>

      @include('footer')

    </footer>
  </body>
</html>

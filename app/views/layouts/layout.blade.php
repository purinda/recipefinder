<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Purinda Gunasekara">

    <title>Recipe Finder</title>

    <link href="http://getbootstrap.com/examples/starter-template/starter-template.css" rel="stylesheet">
    <link href="http://jasny.github.io/bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://jasny.github.io/bootstrap/dist/js/jasny-bootstrap.min.js"></script>
    <script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>

    <style>
        .btn-file {
            position: relative;
            overflow: hidden;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }
    </style>
  </head>
  <body>
  <!-- Page content -->
  @yield('content')

  </body>
</html>



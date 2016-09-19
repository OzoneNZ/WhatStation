<!DOCTYPE html>
<html lang="en" data-ng-app="whatstation">
    <head>
        <!-- Application metadata -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

        <!-- WhatStation metadata -->
        <meta name="description" content="New Zealand radio station frequency finder">
        <meta name="keywords" content="radio,station,new,zealand,frequency">
        <meta name="author" content="Blake Irwin">

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="/images/ws-logo.png" />

        <!-- JavaScripts -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.min.js" integrity="sha256-6Sr0HqNgUf/p88g6vsl87CrAnNqiOWhjlY6LS8jeWHA=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.3.1/angular-ui-router.min.js" integrity="sha256-WMX1oGxdlHQ+INIGXgmbExcvhBREk8bR9fSseB2qIVs=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha256-U5ZEeKfGNOja007MMD3YBI0A3OSZOQbeG6z2f2Y0hu8=" crossorigin="anonymous"></script>

        <!-- AngularJS application -->
        <script type="text/javascript">
            var app = angular.module('whatstation', [ 'ui.router' ]);
        </script>

        <!-- Application JavaScripts -->
        <script type="text/javascript" src="{{ elixir('js/app.js') }}"></script>

        <!-- Stylesheets -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha256-916EbMg70RQy9LHiGkXzG8hSg9EdNy97GazNG/aiY1w=" crossorigin="anonymous" />

        <!-- Application stylesheet -->
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}" />

        <title>WhatStation</title>
    </head>

    <body>
        <!-- Navigation -->
        <nav data-ng-controller="navigationController" class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed hamburger menu -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding image -->
                    <a class="navbar-brand" href="/">
                        <span>
                            <img id="ws-logo" src="/images/ws-logo.png" alt="WhatStation" />
                            WhatStation
                        </span>
                    </a>
                </div>

                <!-- Links -->
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Around me -->
                        <li data-ui-sref-active="active">
                            <a data-ui-sref="locate">
                                <span class="glyphicon glyphicon-map-marker"></span> Around me
                            </a>
                        </li>

                        <!-- Stations -->
                        <li data-ui-sref-active="active">
                            <a data-ui-sref="stations">
                                <span class="glyphicon glyphicon-headphones"></span> Stations
                            </a>
                        </li>

                        <!-- Regions -->
                        <li data-ui-sref-active="active">
                            <a data-ui-sref="regions">
                                <span class="glyphicon glyphicon-th-large"></span> Regions
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Application -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
                    <div data-ui-view></div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <p class="text-muted text-center">&copy; 2016 - <a href="mailto:blake@proxycha.in?subject=WhatStation">Blake Irwin</a></p>
            </div>
        </footer>
    </body>
</html>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>{$system_name}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="{$base_path}css/bootstrap.css?var={$timestamp}" rel="stylesheet">
        <link href="{$base_path}css/base.css?var={$timestamp}" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
        <style>
            body {
                padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
            }
        </style>
        <link href="{$base_path}css/bootstrap-theme.min.css?var={$timestamp}" rel="stylesheet">
        <link href="{$base_path}css/base.css?var={$timestamp}" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->

{**    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="/ico/favicon.png">
**}
  </head>

  <body>

    <div class="container">

      <form class="form-signin" action="index.php" method="post">
          <div class="jumbotron jumbotron-condensed" style="background-color: purple; color: whitesmoke; padding: 10px;"><h2 class="form-signin-heading">{$system_name}</h2></div>
      {if $message}<div class="alert alert-danger">{$message}</div>{/if}
       <input type="hidden" name="lang" value="en" />
        <input type="text" class="form-control" placeholder="{#username#}" name="username" value="{$username|default:''}">
        <input type="password" class="form-control" placeholder="{#password#}" name="password" value="{$password|default:''}">
        <input class="btn btn-large btn-primary" type="submit" value="Login&nbsp;&Gt;" />
      </form>

    </div> <!-- /container -->
    <footer class="footer" style="border-top: 1px solid #d0d0d0;">
      <div class="container-fluid">
          <p class="text-muted text-right">&COPY;&nbsp;2015&nbsp; All Rights Reserved.</p>
      </div>
    </footer>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{$base_path}js/jquery.js?var={$timestamp}"></script>
    <script src="{$base_path}js/bootstrap.js?var={$timestamp}"></script>

  </body>
</html>

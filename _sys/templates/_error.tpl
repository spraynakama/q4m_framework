<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>{$system_name}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="{$base_path}css/bootstrap.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 150px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }

            .form-signin {
                 max-width: 400px;
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
            .form-signin .form-signin-heading {
                margin-bottom: 10px;
            }



        </style>
        <link href="{$base_path}css/bootstrap-theme.min.css" rel="stylesheet">
        <link href="{$base_path}css/base.css" rel="stylesheet">
        <link href="{$base_path}jquery-ui/jquery-ui.min.css" rel="stylesheet">

        <script src="{$base_path}js/jquery.js"></script>
        <script src="{$base_path}js/bootstrap.min.js"></script>
        <script src="{$base_path}jquery-ui/jquery-ui.min.js"></script>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
        <![endif]-->


    </head>

    <body>

        <div class="form-signin">

            <h2 class="form-signin-heading">{$system_name}</h2>
            <div class="alert alert-danger">
                <strong>{$message1}: </strong><br />
                {$message2} {if $file}<br />
                    at {$file}{if $line}, line {$line}{/if}{/if} orz
                </div>
                <a href="/" class="btn btn-danger">Return Top<span class="glyphicon glyphicon-chevron-right"></span></a>
            </div> <!-- /container -->

        </body>
    </html>

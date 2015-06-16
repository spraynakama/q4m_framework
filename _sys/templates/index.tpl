<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="{$base_path}favicon.ico">
        <title>{#system_name#}</title>

        <!-- Le styles -->
        <link href="{$base_path}css/bootstrap.css?var={$timestamp}" rel="stylesheet">
        <style>
            body {
                padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
            }
        </style>
        <link href="{$base_path}css/bootstrap-theme.min.css?var={$timestamp}" rel="stylesheet">
        <link href="{$base_path}css/base.css?var={$timestamp}" rel="stylesheet">
        <link href="{$base_path}css/{block name=local_css}{/block}.css?var={$timestamp}" rel="stylesheet">

        <script src="{$base_path}js/jquery.js?var={$timestamp}"></script>
        <script src="{$base_path}js/bootstrap.min.js?var={$timestamp}"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <nav class="navbar navbar-fixed-top nab-top-bar navbar-inverse" id="global_nav">
            <form action="/index/logout" method="post" id="logout" name="logout">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="/">{**<img src="{$base_path}img_common/logo.png" alt="{#system_name#}" title="{#system_name#}"/>**}{#system_name#}</a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="{block name=home_active}{/block}"><a href="/">{#home#}</a></li>
                            <li class="{block name=customer_active}{/block}"><a href="/customer/">{#customer#}</a></li>
                            <li class="{block name=salon_active}{/block}"><a href="/salon/">{#salon#}</a></li>
                            <li class="{block name=staff_active}{/block}"><a href="/staff/">{#staff#}</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            {if $is_admin|default:0}
                                <li class="dropdown {block name=admin_active}{/block}">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{#ctl_menu#} <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="/user/">{#user_ctl#}</a></li>
                                        <li><a href="/data/">{#data_ctl#}</a></li>
                                    </ul>
                                </li>
                            {/if}
                            <li class="nav_status"><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;{$loginuser}</a></li>
                            <li class="divider-vertical"></li>
                            <li><a href="#" id="logout_but"><span class="glyphicon glyphicon-off"></span>&nbsp;{#logout#}</a></li>

                        </ul>
                    </div><!--/.navbar-collapse -->
                </div>
            </form>

        </nav>

        <!-- header end //-->

        <div class="container" id="main">
        {block name="main_content"}{/block}
    </div> <!-- /container -->


    <footer class="footer">
        <div class="container-fluid">
            <p class="text-muted text-right">&COPY;&nbsp;2015&nbsp; All Rights Reserved.</p>
        </div>
    </footer>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{$base_path}js/{$lang|default:'ja'}_menu.js?var={$timestamp}"></script>
{block name="local_javascript"}{/block}

</body>
</html>

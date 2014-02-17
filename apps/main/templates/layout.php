<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon"/>
        <?php use_css('bootstrap.min.css') ?>
        <?php use_css('bootstrap-responsive.min.css') ?>
        <?php use_css('default.css') ?>

        <title></title>
        <?php use_js('jquery.js'); ?>
        <?php use_js('bootstrap.min.js'); ?>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="nav-collapse collapse">
                    <ul class="nav">
                        <li class="">
                            <a href="/">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container body-content">
            <div class="row">
                <?php echo $contents ?>
            </div>
            <div class="row footer">
                <a href="/">@framework</a>
            </div>
        </div>
    </body>
</html>
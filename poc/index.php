<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Phighchart Example</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="http://code.highcharts.com/highcharts.js"></script>
    </head>
    <body>
        <?php require_once('Examples.php'); ?>
        <?php echo $chart->renderContainer(); ?>
        <?php echo $lineChart->renderContainer(); ?>

        <script type="text/javascript" charset="utf-8">
            (function($){ // encapsulate jQuery
                $(document).ready(function() {
                    <?php echo $chart->render(); ?>
                    <?php echo $lineChart->render(); ?>
                });
            })(jQuery);
        </script>
    </body>
</html>

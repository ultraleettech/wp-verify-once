<?php
/**
 * @var string $url
 * @var string $transactionId
 */
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no"/>
    <title><?= get_bloginfo() ?></title>

    <style type="text/css">
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        #content {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;
        }
        iframe { border: none; }
    </style>
</head>
<body>

<div id="content">
    <iframe width="100%" height="100%" src="<?= $url ?>"></iframe>
</div>

<script type="application/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="application/javascript">
(function($) {
    setInterval(function() {
        $.post('<?= admin_url( 'admin-ajax.php' ) ?>', {
            action: 'verifyOnceCheckStatus',
            transactionId: '<?= $transactionId ?>'
        }, function (data) {
            if ('verified' === data.status) {
                document.location.href = data.redirect;
            }
        }, 'json');
    }, 10000);
})(jQuery);
</script>

</body>
</html>

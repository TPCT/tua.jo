<?php

$googleAnalyticsKey = Yii::$app->settings->get('site.google_analytics_code');

?>


    <?php if ($googleAnalyticsKey): ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= $googleAnalyticsKey ?>" nonce="<?= $GLOBALS['nonce'] ?>" ></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', '<?= $googleAnalyticsKey ?>');
        </script>
    <?php endif;?>

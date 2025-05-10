<?php

$googleTagKey = Yii::$app->settings->get('site.google_tag_code');

?>


    <?php if ($googleTagKey): ?>
        <!-- Google Tag Manager -->
            <script nonce="<?= $GLOBALS['nonce'] ?>" >(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','<?=$googleTagKey?>');</script>
        <!-- End Google Tag Manager -->
    <?php endif;?>

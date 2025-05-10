<?php

$googleTagKey = Yii::$app->settings->get('site.google_tag_code');

?>


    <?php if ($googleTagKey): ?>
        <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?=$googleTagKey?>"
            height="0" width="0" class="d-none"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    <?php endif;?>




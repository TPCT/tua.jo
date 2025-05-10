<table style="background-color:whitesmoke;width:100%;" cellpadding="0" cellspacing="0" border="0">
    <tbody>
    <tr>
        <td style="width:562.5pt;padding:7.5pt;" valign="top">
            <div>
                <table style="background-color:white;width:100%;border-radius:3px;box-shadow:0 -1px 0 #e0e0e0,0 0 2px rgba(0,0,0,0.12),0 2px 4px rgba(0,0,0,0.24);min-width:720px;"
                       cellpadding="0" cellspacing="3" border="0">
                    <tbody>
                    <tr>
                        <td style="padding:15pt;" valign="top">
                            <table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
                                <tbody>
                                <tr>
                                    <td style="padding:0;" valign="top">
                                        <table style="max-width:576pt;" cellpadding="0" cellspacing="3" border="0">
                                            <tbody>
                                            <tr>
                                                <td style="padding:0.75pt;" valign="top">
                                                    <table style="max-width:576pt;" cellpadding="0" cellspacing="3"
                                                           border="0">
                                                        <tbody>
                                                        <tr>
                                                            <td style="padding:0.75pt;" valign="top">
                                                                <p style="font-size:12pt;font-family:Times New Roman,serif;margin:0;">
                                                                    <span style="font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;"><a
                                                                                data-auth="NotApplicable"
                                                                                rel="noopener noreferrer"
                                                                                target="_blank"
                                                                                href="https://tua.jo"
                                                                                title="https://tua.jo"
                                                                                data-linkindex="0"><b><span
                                                                                        style="color:#0E69BE;"><?= Yii::$app->settings->get('site.title', null, Yii::$app->language) ?></span></b></a> </span>
                                                                </p></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <p style="font-size:12pt;font-family:Times New Roman,serif;margin:0;">
                                                        <span style="font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont; display: none;">&nbsp;</span>
                                                    </p>
                                                    <table style="width:100%;border-radius:5px;border:1pt solid #CCCCCC;min-width:450px;"
                                                           cellpadding="0" cellspacing="3" border="1">
                                                        <tbody>
                                                        <tr>
                                                            <td style="padding:30pt 22.5pt 22.5pt 22.5pt;border-style:none;"
                                                                valign="top">
                                                                <p style="font-size:12pt;font-family:Times New Roman,serif;text-align:center;margin:3.75pt 0 0 0;"
                                                                   align="center"><span
                                                                            style="font-size: 22.5pt; font-family: Arial, sans-serif, serif, EmojiFont;"><?=Yii::t('site', 'ORDER_CONFIRMATION')?></span>
                                                                </p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:30pt 22.5pt 22.5pt 22.5pt;border-style:none;"
                                                                valign="top">
                                                                <p style="font-size:12pt;font-family:Times New Roman,serif;margin:3.75pt 0 0 0;">
                                                                    <span style="font-family: Arial, sans-serif, serif, EmojiFont;"><?=Yii::t('site', 'Dear')?> <span
                                                                                dir="rtl" lang="ar-SA"><?=$transaction->first_name . " " . $transaction->last_name?></span>
                                                                </p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:30pt 22.5pt 22.5pt 22.5pt;border-style:none;"
                                                                valign="top">
                                                                <p style="font-size:12pt;font-family:Times New Roman,serif;margin:3.75pt 0 0 0;">
                                                                    <span style="font-family: Arial, sans-serif, serif, EmojiFont;"><?=Yii::t('site', 'THANK_YOU_MESSAGE')?> <?=date('d/m/Y')?> <?=Yii::t('site', 'ORDER_CONFIRMATION_MESSAGE')?>.</span>
                                                                </p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:11.25pt 22.5pt;border-style:solid none;border-top-width:1pt;border-bottom-width:1pt;border-top-color:#CCCCCC;border-bottom-color:#CCCCCC;"
                                                                valign="top">
                                                                <p style="font-size:12pt;font-family:Times New Roman,serif;margin:3.75pt 0 0 0;">
                                                                    <b><span style="font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;"><?=Yii::t('site', 'EXPLAIN_ORDER')?>: </span></b>
                                                                </p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:30pt 22.5pt 22.5pt 22.5pt;border-style:none;"
                                                                valign="top">
                                                                <table style="width:100%;" cellpadding="0"
                                                                       cellspacing="3" border="0">
                                                                    <tbody>
                                                                    <?php foreach ($cart as $index => $item): ?>
                                                                        <tr>
                                                                            <td style="padding:11.25pt 0.75pt;"
                                                                                valign="top">
                                                                                <p style="font-size:12pt;font-family:Times New Roman,serif;margin:0;">
                                                                                    <span style="font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;"><?=$item['quantity']?> x <?=$item['title']?> </span>
                                                                                </p></td>
                                                                            <td style="padding:11.25pt 0.75pt;"
                                                                                valign="top">
                                                                                <p style="font-size:12pt;font-family:Times New Roman,serif;margin:0;">
                                                                                    <span style="font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;"><?=$item['total_jod']?> </span>
                                                                                </p></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:0;border-style:none;" valign="top">
                                                                <table style="width:100%;" cellpadding="0"
                                                                       cellspacing="3" border="0">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="padding:11.25pt 0.75pt;"
                                                                            valign="top">
                                                                            <p style="font-size:12pt;font-family:Times New Roman,serif;margin:7.5pt 0 0 0;">
                                                                                <b><span style="font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;"><?=Yii::t('site', 'RECEIPT_NUMBERS')?></span></b>
                                                                            </p></td>
                                                                    </tr>
                                                                    <?php foreach ($cart as $item): ?>
                                                                        <tr>
                                                                            <td style="padding:11.25pt 0.75pt;"
                                                                                valign="top">
                                                                                <p style="font-size:12pt;font-family:Times New Roman,serif;margin:0;">
                                                                                    <span style="font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;"><?=$item['donation_id']?> </span>
                                                                                </p></td>
                                                                            <td style="padding:11.25pt 0.75pt;"
                                                                                valign="top">
                                                                                <p style="font-size:12pt;font-family:Times New Roman,serif;margin:0;">
                                                                                    <span style="font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;"><?=$item['title']?> </span>
                                                                                </p></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:0;border-style:none;" valign="top">
                                                                <table style="width:100%;border-style:solid none;border-top-width:1pt;border-bottom-width:1pt;border-top-color:#CCCCCC;border-bottom-color:#CCCCCC;"
                                                                       cellpadding="0" cellspacing="3" border="1">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="padding:3.75pt 0.75pt 11.25pt 0.75pt;border-style:none;"
                                                                            valign="top">
                                                                            <p style="font-size:12pt;font-family:Times New Roman,serif;margin:0;">
                                                                                <b><span style="font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;"><?=Yii::t('site', 'BILLING_INFORMATION')?></span></b>
                                                                            </p></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="padding:11.25pt 0.75pt;border-style:none;"
                                                                            valign="top">
                                                                            <div>
                                                                                <div>
                                                                                    <p style="font-size:10.5pt;font-family:Arial,sans-serif;margin:0 0 11.25pt 0;">
                                                                                        <span><span dir="rtl"
                                                                                                    lang="ar-SA"><?=$transaction->first_name?></span></span><span
                                                                                                dir="ltr"></span><span
                                                                                                dir="ltr"></span><span
                                                                                                lang="ar-SA"><span
                                                                                                    dir="ltr"></span><span
                                                                                                    dir="ltr"></span> <span><span
                                                                                                        dir="rtl"><?=$transaction->last_name?></span></span></span><br>
<!--                                                                                        <span>--><?php //=$transaction->country->en_short_name?><!--</span></p></div>-->
                                                                                <div>
                                                                                    <div>
                                                                                        <p style="font-size:12pt;font-family:Times New Roman,serif;margin:0;">
                                                                                            <span style="font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;"><?=Yii::t('site', 'PHONE_NUMBER')?></span>
                                                                                        </p></div>
                                                                                    <div>
                                                                                        <p style="font-size:12pt;font-family:Times New Roman,serif;margin:0;">
                                                                                            <span style="font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;">+<?=$transaction->phone?></span>
                                                                                        </p></div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:0;border-style:none;" valign="top">
                                                                <p style="text-align:center;margin-bottom:0;"
                                                                   align="center"><?=Yii::t('site', 'SUB_TOTAL')?>: JOD <?=$sub_total?> </p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:0;border-style:none;" valign="top">
                                                                <p style="text-align:center;" align="center"><span
                                                                            style="font-size:18pt;"><?=Yii::t('site', 'ORDER_TOTAL')?>: JOD <?=$total?> </span>
                                                                </p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:0;border-style:none;" valign="top">
                                                                <p style="text-align:center;" align="center"><?=Yii::t('site', 'ORDER_THANK_YOU')?>! </p></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
<!--                    <tr>-->
<!--                        <td style="padding:0 15pt;" valign="top">-->
<!--                            <table style="width:100%;" cellpadding="0" cellspacing="0" border="0">-->
<!--                                <tbody>-->
<!--                                <tr>-->
<!--                                    <td style="padding:7.5pt 0 0 0;" valign="top">-->
<!--                                        <div>-->
<!--                                            <p style="font-size:12pt;font-family:Times New Roman,serif;margin:0;">-->
<!--                                                <strong><span-->
<!--                                                            style="color: rgb(0, 38, 75); font-size: 9pt; font-family: Arial, sans-serif, serif, EmojiFont;"><a-->
<!--                                                                data-auth="NotApplicable" rel="noopener noreferrer"-->
<!--                                                                target="_blank"-->
<!--                                                                href="https://u29092389.ct.sendgrid.net/ls/click?upn=T54-2FmHfBIs79jKD17D1-2BPIXrfyn0ZWeJ73H3zPrHi-2F6pjqqtMoEMayFIN0NTYqBVfN0E_e4ngHgw5XB2sFsGxZBHMgNfvdzU8AI18V1agqCa0-2FCUChN15hhTu7t6HIskw4kcvrCaRioUTfBqRNbFFTHwwled2zKu7RTuTFWFXb1VSxFkQCKo7TQxEiEDN2XxYd2GD45sSHKC-2BC5ozAPRyDJxulg61AwJBDWCfblMJjkDe-2FKZdt9Ivwdw1o8okY8z-2BGsdUMRrqNWa3i8yBeXJIsQrcPA-3D-3D"-->
<!--                                                                title="https://u29092389.ct.sendgrid.net/ls/click?upn=T54-2FmHfBIs79jKD17D1-2BPIXrfyn0ZWeJ73H3zPrHi-2F6pjqqtMoEMayFIN0NTYqBVfN0E_e4ngHgw5XB2sFsGxZBHMgNfvdzU8AI18V1agqCa0-2FCUChN15hhTu7t6HIskw4kcvrCaRioUTfBqRNbFFTHwwled2zKu7RTuTFWFXb1VSxFkQCKo7TQxEiEDN2XxYd2GD45sSHKC-2BC5ozAPRyDJxulg61AwJBDWCfblMJjkDe-2FKZdt9Ivwdw1o8okY8z-2BGsdUMRrqNWa3i8yBeXJIsQrcPA-3D-3D"-->
<!--                                                                data-linkindex="1"><span style="color:#00264B;">Terms of Use</span></a> <a-->
<!--                                                                data-auth="NotApplicable" rel="noopener noreferrer"-->
<!--                                                                target="_blank"-->
<!--                                                                href="https://u29092389.ct.sendgrid.net/ls/click?upn=T54-2FmHfBIs79jKD17D1-2BPIXrfyn0ZWeJ73H3zPrHi-2F5MNVXCIYG8KpsEU4A7ltRT0SdP_e4ngHgw5XB2sFsGxZBHMgNfvdzU8AI18V1agqCa0-2FCUChN15hhTu7t6HIskw4kcvzARI3wTKMvooMwKOHGJahY8Jp1txfAB6wV7tV2cuHJm9YGwSkLkU9RBmDC16gZjfg-2Be-2FjtGXHeMYVcGzJJsv7X9jmkgdbYHYNb8uYLGcwlyXrcVVlDVS8YE6FLBaQLAArXJmdKLNGSv-2BTyU9Deb6qA-3D-3D"-->
<!--                                                                title="https://u29092389.ct.sendgrid.net/ls/click?upn=T54-2FmHfBIs79jKD17D1-2BPIXrfyn0ZWeJ73H3zPrHi-2F5MNVXCIYG8KpsEU4A7ltRT0SdP_e4ngHgw5XB2sFsGxZBHMgNfvdzU8AI18V1agqCa0-2FCUChN15hhTu7t6HIskw4kcvzARI3wTKMvooMwKOHGJahY8Jp1txfAB6wV7tV2cuHJm9YGwSkLkU9RBmDC16gZjfg-2Be-2FjtGXHeMYVcGzJJsv7X9jmkgdbYHYNb8uYLGcwlyXrcVVlDVS8YE6FLBaQLAArXJmdKLNGSv-2BTyU9Deb6qA-3D-3D"-->
<!--                                                                data-linkindex="2"><span style="color:#00264B;">Privacy Policy</span></a> </span></strong><span-->
<!--                                                        style="color: rgb(0, 38, 75); font-size: 9pt; font-family: Arial, sans-serif, serif, EmojiFont;"></span>-->
<!--                                            </p></div>-->
<!--                                    </td>-->
<!--                                    <td style="padding:7.5pt 0 0 0;" valign="top">-->
<!--                                        <p style="font-size:12pt;font-family:Times New Roman,serif;text-align:center;margin:0;"-->
<!--                                           align="center"><span-->
<!--                                                    style="color: rgb(0, 38, 75); font-size: 9pt; font-family: Arial, sans-serif, serif, EmojiFont;">© 2023 - Tkiyet Um Ali. All Right Reserved. </span>-->
<!--                                        </p></td>-->
<!--                                    <td style="padding:0;" valign="top">-->
<!--                                        <p style="font-size:12pt;font-family:Times New Roman,serif;text-align:right;text-indent:-18pt;margin:0 0 0 3.75pt;"-->
<!--                                           align="right"><span-->
<!--                                                    style="color: rgb(0, 38, 75); font-size: 10pt; font-family: Symbol, serif, EmojiFont;"><span>·<span-->
<!--                                                            style="font-size: 7pt; font-family: &quot;Times New Roman&quot;, serif, EmojiFont;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span-->
<!--                                                    dir="ltr"></span><span-->
<!--                                                    style="color: rgb(0, 38, 75); font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;"><a-->
<!--                                                        data-auth="NotApplicable" rel="noopener noreferrer"-->
<!--                                                        target="_blank"-->
<!--                                                        href="https://u29092389.ct.sendgrid.net/ls/click?upn=T54-2FmHfBIs79jKD17D1-2BPMvHmPMPlgiLrrpH9AscZ0-2BLvtuRnKkyNHS1ijcjyHaBHbSR_e4ngHgw5XB2sFsGxZBHMgNfvdzU8AI18V1agqCa0-2FCUChN15hhTu7t6HIskw4kcvI0ldGUS8MJENWV6yZg-2FbUWgPT1l7H-2FjXRWZNqQHc-2B7qLlA3alzoImn6Zu2rx6uzNb7lbuSckFCBIU0YOchAa8o6uEmrCS23-2FT2AAAap2ngnueh5u09Y0DhljWcqA-2BdWvYkhIVTJd1GdiT0-2BY0g6Z-2FA-3D-3D"-->
<!--                                                        title="https://u29092389.ct.sendgrid.net/ls/click?upn=T54-2FmHfBIs79jKD17D1-2BPMvHmPMPlgiLrrpH9AscZ0-2BLvtuRnKkyNHS1ijcjyHaBHbSR_e4ngHgw5XB2sFsGxZBHMgNfvdzU8AI18V1agqCa0-2FCUChN15hhTu7t6HIskw4kcvI0ldGUS8MJENWV6yZg-2FbUWgPT1l7H-2FjXRWZNqQHc-2B7qLlA3alzoImn6Zu2rx6uzNb7lbuSckFCBIU0YOchAa8o6uEmrCS23-2FT2AAAap2ngnueh5u09Y0DhljWcqA-2BdWvYkhIVTJd1GdiT0-2BY0g6Z-2FA-3D-3D"-->
<!--                                                        data-linkindex="3"><b><span-->
<!--                                                                style="color:#00264B;font-size:9pt;"><img-->
<!--                                                                    id="x_x__x0000_i1026" border="0"-->
<!--                                                                    src="https://gallery.mailchimp.com/eba4067c7c70a2dedf16ef7c5/images/9f14a543-523d-4df4-8f60-14aead87b6b6.png"-->
<!--                                                                    data-imagetype="External"></span></b></a></span></p>-->
<!--                                        <p style="font-size:12pt;font-family:Times New Roman,serif;text-align:right;text-indent:-18pt;margin:0 0 0 3.75pt;"-->
<!--                                           align="right"><span-->
<!--                                                    style="color: rgb(0, 38, 75); font-size: 10pt; font-family: Symbol, serif, EmojiFont;"><span>·<span-->
<!--                                                            style="font-size: 7pt; font-family: &quot;Times New Roman&quot;, serif, EmojiFont;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span-->
<!--                                                    dir="ltr"></span><span-->
<!--                                                    style="color: rgb(0, 38, 75); font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;"><a-->
<!--                                                        data-auth="NotApplicable" rel="noopener noreferrer"-->
<!--                                                        target="_blank"-->
<!--                                                        href="https://u29092389.ct.sendgrid.net/ls/click?upn=T54-2FmHfBIs79jKD17D1-2BPP3L34WiAgJPF8gg4DirhsYFW-2F3Kxdwy8hzitsgShnkZAq51_e4ngHgw5XB2sFsGxZBHMgNfvdzU8AI18V1agqCa0-2FCUChN15hhTu7t6HIskw4kcvwgPJb6THqnPeV7e6ZxOOF-2BmJIiHOmWmos9RoeJXQ4zGEor9yZMcSZ4D59U8iz2gMqI9au8ozClLna734bbJSJdT9fa4MtHnGmMZo-2FcCpUw9NBa-2F-2Fzs09-2BQyx8t9KTsytk7FiCkKSjugku7nl2IXbyA-3D-3D"-->
<!--                                                        title="https://u29092389.ct.sendgrid.net/ls/click?upn=T54-2FmHfBIs79jKD17D1-2BPP3L34WiAgJPF8gg4DirhsYFW-2F3Kxdwy8hzitsgShnkZAq51_e4ngHgw5XB2sFsGxZBHMgNfvdzU8AI18V1agqCa0-2FCUChN15hhTu7t6HIskw4kcvwgPJb6THqnPeV7e6ZxOOF-2BmJIiHOmWmos9RoeJXQ4zGEor9yZMcSZ4D59U8iz2gMqI9au8ozClLna734bbJSJdT9fa4MtHnGmMZo-2FcCpUw9NBa-2F-2Fzs09-2BQyx8t9KTsytk7FiCkKSjugku7nl2IXbyA-3D-3D"-->
<!--                                                        data-linkindex="4"><b><span-->
<!--                                                                style="color:#00264B;font-size:9pt;"><img-->
<!--                                                                    id="x_x__x0000_i1027" border="0"-->
<!--                                                                    src="https://gallery.mailchimp.com/eba4067c7c70a2dedf16ef7c5/images/e8acb833-5a90-46c5-969f-b1e44d27149b.png"-->
<!--                                                                    data-imagetype="External"></span></b></a></span></p>-->
<!--                                        <p style="font-size:12pt;font-family:Times New Roman,serif;text-align:right;text-indent:-18pt;margin:0 0 0 3.75pt;"-->
<!--                                           align="right"><span-->
<!--                                                    style="color: rgb(0, 38, 75); font-size: 10pt; font-family: Symbol, serif, EmojiFont;"><span>·<span-->
<!--                                                            style="font-size: 7pt; font-family: &quot;Times New Roman&quot;, serif, EmojiFont;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span-->
<!--                                                    dir="ltr"></span><span-->
<!--                                                    style="color: rgb(0, 38, 75); font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;"><a-->
<!--                                                        data-auth="NotApplicable" rel="noopener noreferrer"-->
<!--                                                        target="_blank"-->
<!--                                                        href="https://u29092389.ct.sendgrid.net/ls/click?upn=T54-2FmHfBIs79jKD17D1-2BPHllbuhovf94W7nd7EjLEIj5ggnDl-2BzaJBqehzVQy63rr-2F8fGEOlAMnwUrZ7hMlVcw-3D-3DAums_e4ngHgw5XB2sFsGxZBHMgNfvdzU8AI18V1agqCa0-2FCUChN15hhTu7t6HIskw4kcvuLtVMbRWWPd-2Bl7s3eI75ae2jgKIH28u-2FsSpemX26YsVfk2L-2Byzr4oOhTbXGCeOpmOBcteiIETve-2B22-2FWJGwn-2FiUWN9LosVa9Iv71tLaV4RUDXa8lgzFqEJA5Y8rJMj7htf-2FtDVptkY-2BE99qZGK3I-2Bw-3D-3D"-->
<!--                                                        title="https://u29092389.ct.sendgrid.net/ls/click?upn=T54-2FmHfBIs79jKD17D1-2BPHllbuhovf94W7nd7EjLEIj5ggnDl-2BzaJBqehzVQy63rr-2F8fGEOlAMnwUrZ7hMlVcw-3D-3DAums_e4ngHgw5XB2sFsGxZBHMgNfvdzU8AI18V1agqCa0-2FCUChN15hhTu7t6HIskw4kcvuLtVMbRWWPd-2Bl7s3eI75ae2jgKIH28u-2FsSpemX26YsVfk2L-2Byzr4oOhTbXGCeOpmOBcteiIETve-2B22-2FWJGwn-2FiUWN9LosVa9Iv71tLaV4RUDXa8lgzFqEJA5Y8rJMj7htf-2FtDVptkY-2BE99qZGK3I-2Bw-3D-3D"-->
<!--                                                        data-linkindex="5"><b><span-->
<!--                                                                style="color:#00264B;font-size:9pt;"><img-->
<!--                                                                    id="x_x__x0000_i1028" border="0"-->
<!--                                                                    src="https://gallery.mailchimp.com/eba4067c7c70a2dedf16ef7c5/images/f4457382-ef37-466c-ada9-760674ffd9a5.png"-->
<!--                                                                    data-imagetype="External"></span></b></a></span></p>-->
<!--                                        <p style="font-size:12pt;font-family:Times New Roman,serif;text-align:right;text-indent:-18pt;margin:0 0 0 3.75pt;"-->
<!--                                           align="right"><span-->
<!--                                                    style="color: rgb(0, 38, 75); font-size: 10pt; font-family: Symbol, serif, EmojiFont;"><span>·<span-->
<!--                                                            style="font-size: 7pt; font-family: &quot;Times New Roman&quot;, serif, EmojiFont;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><span-->
<!--                                                    dir="ltr"></span><span-->
<!--                                                    style="color: rgb(0, 38, 75); font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;"><a-->
<!--                                                        data-auth="NotApplicable" rel="noopener noreferrer"-->
<!--                                                        target="_blank"-->
<!--                                                        href="https://u29092389.ct.sendgrid.net/ls/click?upn=T54-2FmHfBIs79jKD17D1-2BPP2AdfD8KV-2FWaozb2Fil2La41jhMgXhjOtNpkzmNL5E1nGnz_e4ngHgw5XB2sFsGxZBHMgNfvdzU8AI18V1agqCa0-2FCUChN15hhTu7t6HIskw4kcvl-2BfktCEWqRMmpKwhVAcNqeZ-2BJW1DXNIlBxFIVraI5lHMg9BtN4nIH3KzaCNLMWoBtLVypkx2rTBFSO2SW-2B80Fmly8LIgRdGwu53JrMAkA8kVc3qc8JcoEIWGFFt5hci-2F7nSve4OZTk8cojDmmd33Mg-3D-3D"-->
<!--                                                        title="https://u29092389.ct.sendgrid.net/ls/click?upn=T54-2FmHfBIs79jKD17D1-2BPP2AdfD8KV-2FWaozb2Fil2La41jhMgXhjOtNpkzmNL5E1nGnz_e4ngHgw5XB2sFsGxZBHMgNfvdzU8AI18V1agqCa0-2FCUChN15hhTu7t6HIskw4kcvl-2BfktCEWqRMmpKwhVAcNqeZ-2BJW1DXNIlBxFIVraI5lHMg9BtN4nIH3KzaCNLMWoBtLVypkx2rTBFSO2SW-2B80Fmly8LIgRdGwu53JrMAkA8kVc3qc8JcoEIWGFFt5hci-2F7nSve4OZTk8cojDmmd33Mg-3D-3D"-->
<!--                                                        data-linkindex="6"><b><span-->
<!--                                                                style="color:#00264B;font-size:9pt;"><img-->
<!--                                                                    id="x_x__x0000_i1029" border="0"-->
<!--                                                                    src="https://gallery.mailchimp.com/eba4067c7c70a2dedf16ef7c5/images/4729f367-f154-4897-ac8d-e20282456a07.png"-->
<!--                                                                    data-imagetype="External"></span></b></a></span></p>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                                </tbody>-->
<!--                            </table>-->
<!--                        </td>-->
<!--                    </tr>-->
                    </tbody>
                </table>
            </div>
        </td>
        <td style="padding:0;" valign="top">
            <p style="font-size:12pt;font-family:Times New Roman,serif;margin:0;"><span
                        style="color: rgb(0, 38, 75); font-size: 10.5pt; font-family: Arial, sans-serif, serif, EmojiFont;">&nbsp;</span>
            </p></td>
    </tr>
    </tbody>
</table>
<?php
/**
 * @link http://www.diemeisterei.de
 * @copyright Copyright (c) 2019 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * --- VARIABLES ---
 *
 * @var $save string
 * @var $learnMore string
 * @var $link string
 * @var $consent array
 */

use yii\helpers\Html; ?>

<div class="cookie-consent-popup">
    <div class="cookie-consent-top-wrapper">
        <p class="cookie-consent-message">
            <span class="cookie-consent-text"><?= $message ?></span>
        </p>
        <div class="d-flex justify-content-center btn-holder">
            <button class="cookie-consent-accept-all btn-cookie btn"><?= Html::a($learnMore, $link, ['class' => 'cookie-consent-link']) ?></button>
            <button class="cookie-consent-controls-toggle btn-cookie btn"><?= Html::a(Yii::t('site', 'Cookie Policy'), ['/site/cookie-policy'], ['class' => 'cookie-consent-link']) ?></button>
            <button class="cookie-consent-details-toggle btn-cookie btn"><?= $detailsOpen ?></button>
        </div>
    
    </div>
    <div class="cookie-consent-controls <?php if (!empty($visibleControls)): ?>open<?php endif; ?>">
        <?php foreach ($consent as $key => $item) : ?>
            <label for="<?= $key ?>" class="cookie-consent-control">
                <?= Html::checkbox($key, $item["checked"], [
                    'class' => 'cookie-consent-checkbox',
                    'data-cc-consent' => $key,
                    'disabled' => $item["disabled"],
                    'id' => $key
                ]) ?>
                <span class="text-white pr-2"><?= $item["label"] ?></span>
            </label>
        <?php endforeach ?>
        <button class="cookie-consent-save btn btn-cookie" data-cc-namespace="popup"><?= $save ?></button>
    </div>

    <div class="cookie-consent-details <?php if (!empty($visibleDetails)): ?>open<?php endif; ?>">
        <div class="cookie-consent-top-wrapper text-white">
            <span class="cookie-consent-text"><?= Yii::t('site', 'Please be aware that all information given or recorded are protected in accordance with the GDPR data protection law. And by proceeding you are approving that Strategiecs may save or process your “personal Data” for further information please read our privacy policy on our website') ?></span>
        </div>
    </div>
</div>

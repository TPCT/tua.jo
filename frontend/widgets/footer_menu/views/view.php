<?php

use common\helpers\Utility;
use yii\helpers\Url;

$currentRoute = Yii::$app->request->getUrl();

?>




<?php if (isset($footerParents)) : ?>
        <?php foreach ($footerParents as $key => $item) : ?>
            <div class="footer-item">
                <div class="footer-item-header">
                    <h3><?= $item->label ?></h3>
                    
                    <?php if ($item->childs) : ?>
                    <button class="toggleButton mobile-responsive" data-target="footer-item-<?= $key ?>">
                    <i class="fa-solid fa-plus"></i>
                    <i class="fa-solid fa-minus" ></i>
                    </button>
                    <?php endif; ?>
                </div>

                <?php if ($item->childs) : ?>
                    <ul id="footer-item-<?= $key ?>" >
                        <?php foreach ($item->childs as $subItem) : ?>
                            <li>
                                <a <?= Utility::PrintAllUrl($subItem->link) ?>>
                                    <?= $subItem->label ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
<?php endif; ?>

<?php
$style = <<<CSS
.fa-solid.fa-minus {
  display :none;
}
CSS;

$this->registerCss($style);

?>
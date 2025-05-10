<?php

use common\helpers\Utility;
use common\components\custom_base_html\CustomBaseHtml;

$currentRoute = Yii::$app->request->getUrl();
$lng = Yii::$app->language;

?>

<?php
    foreach ($links as $link) {
        if ($link['has_grandsons'])
            foreach ($link['children'] as $child) {
                $color = $child->menu_color ?:  "var(--primary-color)";
                $css = <<<CSS
                #cssmenu>ul>li>ul>li>a.nav-colored-item.child-$child->id
                  {
                     color: $color  !important;
                  }
                CSS;
                $this->registerCss($css);
            }
    }
?>

<?php foreach ($links as $link): ?>
    <?php if ($link['has_grandsons']): ?>
        <li class="has-sub first-level-nav-item">
        <span class="submenu-button">
                          <i class="fa-solid fa-plus"></i>
                        </span>
            <a <?=Utility::PrintAllUrl($link['url'])?>>
                <i class="fa-solid fa-chevron-down"></i>
                <?=$link['label']?>
            </a>
            <ul class="container">
                <?php foreach ($link['children'] as $child): ?>
                    <li class="<?=!empty($child->childs) ? "has-sub" : "" ?> second-level-nav-item">
                    <?php if (!empty($child->childs)): ?>
                    <span class="submenu-button">
                              <i class="fa-solid fa-plus"></i>
                            </span>
                            <?php endif; ?>
                        <?php if ($child->link): ?>
                            <a class="nav-colored-item child-<?=$child->id?>" <?=Utility::PrintAllUrl($child->link)?>>
                                <?=$child->label?>
                            </a>
                        <?php else: ?>
                            <a class="nav-colored-item child-<?=$child->id?>">
                                <?=$child->label?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($child->childs)): ?>
                            <ul class="desktop-sup-item-level-1">
                                <?php foreach ($child->childs as $grandson): ?>
                                    <li class="<?=!empty($grandson->childs) ? "has-sub" : ""?>">
                                        <a <?=Utility::PrintAllUrl($grandson->link)?>>
                                            <?=$grandson->label?>
                                        </a>
                                        <?php if (!empty($grandson->childs)): ?>
                                            <ul class="desktop-sup-item-level-2">
                                                <?php foreach ($grandson->childs as $inner_grandson): ?>
                                                    <li>
                                                        <a <?=Utility::PrintAllUrl($inner_grandson->link)?>>
                                                            <?=$inner_grandson->label?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <ul>
                                <?php foreach ($child->childs as $grandson): ?>
                                    <li class="<?=!empty($grandson->childs) ? "has-sub" : "" ?> third-level-nav-item">
                                        <a <?=Utility::PrintAllUrl($grandson->link)?>>
                                            <?=$grandson->label?>
                                        </a>
                                        <?php if (!empty($grandson->childs)): ?>
                                            <ul>
                                                <?php foreach ($grandson->childs as $inner_grandson): ?>
                                                    <li class="fourth-level-nav-item">
                                                        <a <?=Utility::PrintAllUrl($inner_grandson->link)?>>
                                                            <?=$inner_grandson->label?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php elseif ($link['has_children']): ?>
        <li class="has-sub first-level-nav-item">
            <span class="submenu-button">
                <i class="fa-solid fa-plus"></i>
            </span>
            <a <?= Utility::PrintAllUrl($link['url']) ?>>
                <i class="fa-solid fa-chevron-down"></i>
                <?= $link['label'] ?>
            </a>
            <ul class="container">
                <?php if ($link['children']): ?>
                    <?php foreach ($link['children'] as $child): ?>
                        <div class="second-level-items-group">
                            <li class="second-level-nav-item">
                                <a <?= Utility::PrintAllUrl($child->link) ?>>
                                    <?= $child->label ?>
                                </a>
                            </li>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </li>
    <?php else: ?>
        <li class="first-level-nav-item">
            <a class=" " <?= Utility::PrintAllUrl($link['url']) ?>>  <?= $link['label'] ?>  </a>
        </li>
    <?php endif; ?>
<?php endforeach; ?>
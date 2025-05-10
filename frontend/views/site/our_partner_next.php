<?php


use yeesoft\helpers\Html;
use common\helpers\Utility;

$lng = Yii::$app->language;

?>

              

<?php foreach ($ourPartners as $ourPartner): ?>

<div class="extra-content">
<?php if($ourPartner->url): ?>
                <a  <?= Utility::PrintAllUrl($ourPartner->url) ?>>   
                    <picture>
                        <img src="<?= \frontend\widgets\WebpImage::widget(["src" => $ourPartner->image, "alt" =>"" ,"loading" => "lazy",'css' => "", "just_image" => true]); ?>"  alt="<?= $ourPartner->title ?>" />
                    </picture>

                        <h4> <?= $ourPartner->title ?></h4>
                </a> 
                <?php else: ?>
                <picture>
                        <img src="<?= \frontend\widgets\WebpImage::widget(["src" => $ourPartner->image, "alt" =>"" ,"loading" => "lazy",'css' => "", "just_image" => true]); ?>"  alt="<?= $ourPartner->title ?>" />
                    </picture>
                    <h4> <?= $ourPartner->title ?> </h4>

                <?php endif; ?>

</div>
<?php endforeach; ?>

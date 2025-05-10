<?= $content; ?>


<p><?= \yii\helpers\Html::a(Yii::t('site', 'To Unsubscribe Click Here'), \yii\helpers\Url::toRoute(["/site/un-subscribe", "email" => $email], true)); ?></p>

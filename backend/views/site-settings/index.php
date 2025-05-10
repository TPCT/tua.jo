<?php
/**
 * Created by PhpStorm.
 * User: ajoudeh
 * Date: 7/5/18
 * Time: 10:05 PM
 */

use yeesoft\settings\assets\SettingsAsset;
use yeesoft\widgets\ActiveForm;
use kartik\helpers\Html;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteSettings */
/* @var $form yeesoft\widgets\ActiveForm */


$this->title = Yii::t('yee/settings', 'Site Settings');
$this->params['breadcrumbs'][] = $this->title;


SettingsAsset::register($this);
?>

    <div class="page-form">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="d-flex">
                    <div class="mx-2">
                        <?=Html::a(Yii::t('site', 'Import Donation Types'), \yii\helpers\Url::to(['/site/import-donation-types']), ['class' => 'btn btn-primary'])?>
                    </div>
                    <div class="mx-2">
                        <?=Html::a(Yii::t('site', 'Import Sponsorship Families'), \yii\helpers\Url::to(['/site/import-sponsorship-families']), ['class' => 'btn btn-primary'])?>
                    </div>

                    <div class="mx-2">
                        <?=Html::a(Yii::t('site', 'Import Campaigns'), \yii\helpers\Url::to(['/site/import-campaigns']), ['class' => 'btn btn-primary'])?>
                    </div>

                    <div class="mx-2">
                        <?=Html::a(Yii::t('site', 'Import Beneficiaries Countries'), \yii\helpers\Url::to(['/site/import-beneficiaries-countries']), ['class' => 'btn btn-primary'])?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $form = ActiveForm::begin([
            'id' => 'setting-form',
            'validateOnBlur' => false,
        ])
        ?>
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>

        <div class="row">

            <div class="col-md-6">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php if ($model->isMultilingual()): ?>
                            <?= \yeesoft\widgets\LanguagePills::widget() ?>
                        <?php endif; ?>

                        <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>

                        <?= $form->field($model, 'logo',['multilingual' => true])->widget(yeesoft\media\widgets\FileInput::className(), [
                                    'name' => 'logo',
                                    'buttonTag' => 'button',
                                    'buttonName' => Yii::t('yee', 'Browse'),
                                    'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                    'options' => ['class' => 'form-control for-img'],
                                    'template' => '<div class="header-logo thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                    'thumb' => 'original',
                                    'imageContainer' => '.header-logo',
                                    'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                    'callbackBeforeInsert' => 'function(e, data) {
                                    $(".header-logo").show();
                                }',
                            ]) 
                        ?>

                        <?= $form->field($model, 'top_logo',['multilingual' => true])->widget(yeesoft\media\widgets\FileInput::className(), [
                                    'name' => 'top_logo',
                                    'buttonTag' => 'button',
                                    'buttonName' => Yii::t('yee', 'Browse'),
                                    'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                    'options' => ['class' => 'form-control for-img'],
                                    'template' => '<div class="header-top_logo thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                    'thumb' => 'original',
                                    'imageContainer' => '.header-top_logo',
                                    'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                    'callbackBeforeInsert' => 'function(e, data) {
                                    $(".header-top_logo").show();
                                }',
                            ]) 
                        ?>



                        <?= $form->field($model, 'footer_logo',['multilingual' => true])->widget(yeesoft\media\widgets\FileInput::className(), [
                                    'name' => 'footer_logo',
                                    'buttonTag' => 'button',
                                    'buttonName' => Yii::t('yee', 'Browse'),
                                    'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                    'options' => ['class' => 'form-control for-img'],
                                    'template' => '<div class="footer_logo thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                    'thumb' => 'original',
                                    'imageContainer' => '.footer_logo',
                                    'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                    'callbackBeforeInsert' => 'function(e, data) {
                                    $(".footer_logo").show();
                                }',
                            ]) 
                        ?>
                        <?= $form->field($model, 'footer_url')->textInput(['maxlength' => true]) ?>

                        <?php $form->field($model, 'our_story_background_image',['multilingual' => true])->widget(yeesoft\media\widgets\FileInput::className(), [
                                    'name' => 'logo',
                                    'buttonTag' => 'button',
                                    'buttonName' => Yii::t('yee', 'Browse'),
                                    'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                    'options' => ['class' => 'form-control for-img'],
                                    'template' => '<div class="header-our_story_background_image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                    'thumb' => 'original',
                                    'imageContainer' => '.header-our_story_background_image',
                                    'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                    'callbackBeforeInsert' => 'function(e, data) {
                                    $(".header-our_story_background_image").show();
                                }',
                            ]) 
                        ?>

                        <?php $form->field($model, 'strategy_forum_url',['multilingual' => true])->textInput(['maxlength' => true]) ?>
                        
                        <?php $form->field($model, 'footer_brief',['multilingual' => true])->textarea(['maxlength' => true]) ?>
                        
                        <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->hint($model->getDescription('phone')) ?>
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true])->hint($model->getDescription('email')) ?>
                        <?= $form->field($model, 'complaint_page_email')->textInput(['maxlength' => true])->hint($model->getDescription('complaint_page_email')) ?>
                        <?= $form->field($model, 'address',['multilingual' => true])->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'address_url')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'google_map_url')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'street_address',['multilingual' => true])->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'address_region',['multilingual' => true])->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'postal_code',['multilingual' => true])->textInput(['maxlength' => true]) ?>

                        
                        <?php $form->field($model, 'alternative_phone')->textInput(['maxlength' => true])->hint($model->getDescription('alternative_phone')) ?>
                        <?php $form->field($model, 'fax')->textInput(['maxlength' => true])->hint($model->getDescription('fax')) ?>
                        <?php $form->field($model, 'p_o_box', ['multilingual' => true])->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'facebook_link')->textInput(['maxlength' => true])->hint($model->getDescription('facebook_link')) ?>
                        <?= $form->field($model, 'twitter_link')->textInput(['maxlength' => true])->hint($model->getDescription('twitter_link')) ?>
                        <?= $form->field($model, 'youtube_link')->textInput(['maxlength' => true])->hint($model->getDescription('youtube_link')) ?>
                        <?= $form->field($model, 'instagram_link')->textInput(['maxlength' => true])->hint($model->getDescription('instagram_link')) ?>
                        <?= $form->field($model, 'linked_in')->textInput(['maxlength' => true])->hint($model->getDescription('linked_in')) ?>
                        

                        <?php 
                        $form->field($model, 'video_homepage', ['multilingual' => true])->widget(yeesoft\media\widgets\FileInput::className(), [
                            'buttonTag' => 'button',
                            'buttonName' => Yii::t('site', 'Browse'),
                            'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                            'options' => ['class' => 'form-control'],
                            'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                            'thumb' => 'original',


                        ]) ?>

                        <?= $form->field($model, 'app_store_url')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'app_store_logo',['multilingual' => true])->widget(yeesoft\media\widgets\FileInput::className(), [
                                    'name' => 'app_store_logo',
                                    'buttonTag' => 'button',
                                    'buttonName' => Yii::t('yee', 'Browse'),
                                    'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                    'options' => ['class' => 'form-control for-img'],
                                    'template' => '<div class="header-app_store_logo thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                    'thumb' => 'original',
                                    'imageContainer' => '.header-app_store_logo',
                                    'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                    'callbackBeforeInsert' => 'function(e, data) {
                                    $(".header-app_store_logo").show();
                                }',
                            ]) 
                        ?>

                        <?= $form->field($model, 'google_store_url')->textInput(['maxlength' => true]) ?>


                        <?= $form->field($model, 'google_store_logo',['multilingual' => true])->widget(yeesoft\media\widgets\FileInput::className(), [
                                    'name' => 'google_store_logo',
                                    'buttonTag' => 'button',
                                    'buttonName' => Yii::t('yee', 'Browse'),
                                    'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                    'options' => ['class' => 'form-control for-img'],
                                    'template' => '<div class="header-google_store_logo thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                    'thumb' => 'original',
                                    'imageContainer' => '.header-google_store_logo',
                                    'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                    'callbackBeforeInsert' => 'function(e, data) {
                                    $(".header-google_store_logo").show();
                                }',
                            ]) 
                        ?>







                        <?php  $form->field($model, 'address', ['multilingual' => true])->textInput(['maxlength' => true]) ?>
                        <?=  $form->field($model, 'contact_us_email')->textInput(['maxlength' => true]) ?>
                        <?=  $form->field($model, 'volunteer_email')->textInput(['maxlength' => true]) ?>
                        <?=  $form->field($model, 'complaint_email')->textInput(['maxlength' => true]) ?>
                        <?=  $form->field($model, 'initimation_email')->textInput(['maxlength' => true]) ?>
                        <?=  $form->field($model, 'join_us_email')->textInput(['maxlength' => true]) ?>
                        <?=  $form->field($model, 'protection_email')->textInput(['maxlength' => true]) ?>
                        <?=  $form->field($model, 'sea_allegation_email')->textInput(['maxlength' => true]) ?>
                        <?=  $form->field($model, 'donation_campaing_email')->textInput(['maxlength' => true]) ?>
                        <?=  $form->field($model, 'gift_card_email')->textInput(['maxlength' => true]) ?>
                        <?=  $form->field($model, 'donation_gift_card_email')->textInput(['maxlength' => true]) ?>

                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="record-info">

                            <div class="form-group">

                                <?php $form->field($model, 'enable_filteration_at_all_page')->checkbox() ?>
                                <?php $form->field($model, 'enable_one_podcast_at_homepage')->checkbox() ?>
                                
                                <?= $form->field($model, 'google_analytics_code')->textInput(['maxlength' => true])->hint($model->getDescription('google_analytics_code')) ?>                        
                                <?= $form->field($model, 'google_tag_code')->textInput(['maxlength' => true])->hint($model->getDescription('google_tag_code')) ?>
                                <?= $form->field($model, 'meta_pixel_code')->textInput(['maxlength' => true])->hint($model->getDescription('meta_pixel_code')) ?>



                                <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>


                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6" style="">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="record-info">

                            <div class="form-group">

                              <?= $form->field($model, 'home_page_dar_abu_abdallah_hidden')->checkbox() ?>
                              <?= $form->field($model, 'home_page_our_impact_hidden')->checkbox() ?>
                                <?= $form->field($model, 'default_page_size')->textInput(['maxlength' => true])->hint($model->getDescription('default_page_size')) ?>
                                <?= $form->field($model, 'empowerment_page_size')->textInput(['maxlength' => true])->hint($model->getDescription('default_page_size')) ?>
                                <?= $form->field($model, 'photo_gellary_page_size')->textInput(['maxlength' => true])->hint($model->getDescription('default_page_size')) ?>
                                <?= $form->field($model, 'testimonisl_page_size')->textInput(['maxlength' => true])->hint($model->getDescription('news_page_size')) ?>
                                <?= $form->field($model, 'zakat_page_size')->textInput(['maxlength' => true])->hint($model->getDescription('news_page_size')) ?>
                                <?= $form->field($model, 'blogs_page_size')->textInput(['maxlength' => true])->hint($model->getDescription('news_page_size')) ?>
                                <?= $form->field($model, 'media_post_page_size')->textInput(['maxlength' => true])->hint($model->getDescription('news_page_size')) ?>
                                <?= $form->field($model, 'news_page_size')->textInput(['maxlength' => true])->hint($model->getDescription('news_page_size')) ?>
                                <?= $form->field($model, 'our_partner_page_size')->textInput(['maxlength' => true])->hint($model->getDescription('our_partner_page_size')) ?>
                                <?= $form->field($model, 'volunteer_page_size')->textInput(['maxlength' => true])->hint($model->getDescription('volunteer_page_size')) ?>
                                <?= $form->field($model, 'search_page_size')->textInput(['maxlength' => true])->hint($model->getDescription('search_page_size')) ?>
                                                              
                                <?= $form->field($model, 'gold_24_price')->widget(NumberControl::classname(), [
                                    'displayOptions' => [
                                        'placeholder' => '100'
                                    ],
                                    'maskedInputOptions' => [
                                        'min' => 0,
                                        'rightAlign' => false,

                                    ],
                                ]); ?>

                                <?= $form->field($model, 'gold_22_price')->widget(NumberControl::classname(), [
                                    'displayOptions' => [
                                        'placeholder' => '100'
                                    ],
                                    'maskedInputOptions' => [
                                        'min' => 0,
                                        'rightAlign' => false,

                                    ],
                                ]); ?>


                                <?= $form->field($model, 'gold_21_price')->widget(NumberControl::classname(), [
                                    'displayOptions' => [
                                        'placeholder' => '100'
                                    ],
                                    'maskedInputOptions' => [
                                        'min' => 0,
                                        'rightAlign' => false,

                                    ],
                                ]); ?>


                                <?= $form->field($model, 'gold_18_price')->widget(NumberControl::classname(), [
                                    'displayOptions' => [
                                        'placeholder' => '100'
                                    ],
                                    'maskedInputOptions' => [
                                        'min' => 0,
                                        'rightAlign' => false,

                                    ],
                                ]); ?>

                                <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


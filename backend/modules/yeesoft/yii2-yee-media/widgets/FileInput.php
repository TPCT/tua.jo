<?php
namespace yeesoft\media\widgets;

use yeesoft\media\assets\FileInputAsset;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;

/**
 * Class FileInput
 *
 * Basic example of usage:
 *
 *  <?= FileInput::widget([
 *      'name' => 'image',
 *      'buttonTag' => 'button',
 *      'buttonName' => 'Browse',
 *      'buttonOptions' => ['class' => 'btn btn-default'],
 *      'options' => ['class' => 'form-control'],
 *      // Widget template
 *      'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
 *      // Optional, if set, only this image can be selected by user
 *      'thumb' => 'original',
 *      // Optional, if set, in container will be inserted selected image
 *      'imageContainer' => '.img',
 *      // Default to FileInput::DATA_URL. This data will be inserted in input field
 *      'pasteData' => FileInput::DATA_URL,
 *      // JavaScript function, which will be called before insert file data to input.
 *      // Argument data contains file data.
 *      // data example: [alt: "Witch with cat", description: "123", url: "/uploads/2014/12/vedma-100x100.jpeg", id: "45"]
 *      'callbackBeforeInsert' => 'function(e, data) {
 *      console.log( data );
 *      }',
 *  ]) ?>
 *
 * This class provides media usage. You can optional select all media file info to your input field.
 *
 * @package yeesoft\media\widgets
 */
class FileInput extends InputWidget
{
    /**
     * @var string widget template
     */
    public $template = '<div class="input-group">{input}<span class="input-group-btn">{button}{reset-button}</span></div>';

    /**
     * @var string button tag
     */
    public $buttonTag = 'button';

    /**
     * @var string button name
     */
    public $buttonName = 'Browse';

    /**
     * @var array button html options
     */
    public $buttonOptions = ['class' => 'btn btn-default'];

    /**
     * @var string reset button tag
     */
    public $resetButtonTag = 'button';

    /**
     * @var string reset button name
     */
    public $resetButtonName = '<span class="text-danger glyphicon glyphicon-remove"></span>';

    /**
     * @var array reset button html options
     */
    public $resetButtonOptions = ['class' => 'btn btn-default'];

    /**
     * @var string Optional, if set, only this image can be selected by user
     */
    public $thumb = '';

    /**
     * @var string Optional, if set, in container will be inserted selected image
     */
    public $imageContainer = '';

    /**
     * @var string JavaScript function, which will be called before insert file data to input.
     * Argument data contains file data.
     * data example: [alt: "Witch with cat", description: "123", url: "/uploads/2014/12/vedma-100x100.jpeg", id: "45"]
     */
    public $callbackBeforeInsert = '';

    /**
     * @var string This data will be inserted in input field
     */
    public $pasteData = self::DATA_URL;

    /**
     * @var array widget html options
     */
    public $options = ['class' => 'form-control'];

    public $is_multiple = false;

    /**
     *
     * @var array selecte the frameSrc in case you use a different module name
     */
    public $frameSrc = ['/media/manage'];



    const DATA_ID = 'id';
    const DATA_URL = 'url';
    const DATA_ALT = 'alt';
    const DATA_DESCRIPTION = 'description';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->buttonOptions['id'])) {
            $this->buttonOptions['id'] = $this->options['id'] . '-btn';
        }

        $this->buttonName = Yii::t('yee', 'Browse');
        $this->is_multiple? $this->buttonOptions['role'] = 'media-launch-multiple'  : $this->buttonOptions['role'] = 'media-launch'; 
        $this->resetButtonOptions['role'] = 'clear-input';
        $this->resetButtonOptions['data-clear-element-id'] = $this->options['id'];
        $this->resetButtonOptions['data-image-container'] = $this->imageContainer;
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        if ($this->hasModel()) {
            $replace['{input}'] = Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $replace['{input}'] = Html::textInput($this->name, $this->value, $this->options);
        }

        $replace['{button}'] = Html::tag($this->buttonTag, $this->buttonName, $this->buttonOptions);
        $replace['{reset-button}'] = Html::tag($this->resetButtonTag, $this->resetButtonName, $this->resetButtonOptions);

        FileInputAsset::register($this->view);

        if (!empty($this->callbackBeforeInsert)) {
            $this->view->registerJs('
                $("#' . $this->options['id'] . '").on("fileInsert", ' . $this->callbackBeforeInsert . ');'
            );
        }

        $modal = $this->renderFile('@backend/modules/yeesoft/yii2-yee-media/views/manage/modal.php', [
            'inputId' => $this->options['id'],
            'btnId' => $this->buttonOptions['id'],
            'frameId' => $this->options['id'] . '-frame',
            'frameSrc' => Url::to($this->frameSrc),
            'thumb' => $this->thumb,
            'imageContainer' => $this->imageContainer,
            'pasteData' => $this->pasteData,
            'is_multiple'=>$this->is_multiple,
        ]);

        return strtr($this->template, $replace) . $modal;
    }
}
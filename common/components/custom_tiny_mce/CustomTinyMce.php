<?php

namespace common\components\custom_tiny_mce;

use yeesoft\helpers\Html;
use yeesoft\media\widgets\TinyMce;
use yii\helpers\Url;
use yii\web\JsExpression;

class CustomTinyMce extends TinyMce
{

    public function init()
    {
        parent::init();

        if (empty($this->clientOptions['file_picker_callback'])) {
            $this->clientOptions['file_picker_callback'] = new JsExpression(
                    'function(callback, value, meta) {
                    mediaTinyMCE(callback, value, meta);
                }'
            );
        }

        if (empty($this->clientOptions['document_base_url'])) {
            $this->clientOptions['document_base_url'] = '';
        }

        if (empty($this->clientOptions['convert_urls'])) {
            $this->clientOptions['convert_urls'] = false;
        }

        $this->clientOptions['setup'] = new \yii\web\JsExpression('function (editor) {
            editor.ui.registry.addButton("specialText", {
                text: "Special Text",
                tooltip: "Insert Special Text",
                onAction: (_) => editor.insertContent("<blockquote>Special Text</blockquote>")
                
            });
        }');
        
    }

    public function run()
    {
        if ($this->hasModel()) {
            $output = Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            $output = Html::textarea($this->name, $this->value, $this->options);
        }

        $this->registerClientScript();

        $modal = $this->renderFile('@backend/modules/yeesoft/yii2-yee-media/views/manage/modal.php', [
            'inputId' => $this->options['id'],
            'btnId' => $this->options['id'] . '-btn',
            'frameId' => $this->options['id'] . '-frame',
            'frameSrc' => Url::to(['/media/manage']),
            'thumb' => $this->thumb,
        ]);

        return $output . $modal;
    }
}


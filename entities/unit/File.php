<?php

namespace afzalroq\cms\entities\unit;

use kartik\file\FileInput;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 */
class File extends UnitActiveRecord
{

    public function rules()
    {
        return [
            [['data_0', 'data_1', 'data_2', 'data_3', 'data_4'], 'file'],
        ];
    }

    public function attributeLabels()
    {
        $language0 = Yii::$app->params['cms']['languages'][0] ?? '';
        $language1 = Yii::$app->params['cms']['languages'][1] ?? '';
        $language2 = Yii::$app->params['cms']['languages'][2] ?? '';
        $language3 = Yii::$app->params['cms']['languages'][3] ?? '';
        $language4 = Yii::$app->params['cms']['languages'][4] ?? '';

        return [
            'data_0' => Yii::t('unit', 'File') . '(' . $language0 . ')',
            'data_1' => Yii::t('unit', 'File') . '(' . $language1 . ')',
            'data_2' => Yii::t('unit', 'File') . '(' . $language2 . ')',
            'data_3' => Yii::t('unit', 'File') . '(' . $language3 . ')',
            'data_4' => Yii::t('unit', 'File') . '(' . $language4 . ')',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            $this->getBehaviorConfig('data_0'),
            $this->getBehaviorConfig('data_1'),
            $this->getBehaviorConfig('data_2'),
            $this->getBehaviorConfig('data_3'),
            $this->getBehaviorConfig('data_4'),
        ];
    }

    private function getBehaviorConfig($attribute)
    {
        $module = Yii::$app->getmodule('cms');

        return [
            'class' => FileUploadBehavior::class,
            'attribute' => $attribute,
            'filePath' => $module->path . '/data/units/[[attribute_id]]/[[filename]].[[extension]]',
            'fileUrl' => $module->host . '/data/units/[[attribute_id]]/[[filename]].[[extension]]'
        ];
    }

    public function getData($key)
    {
        return $this->getUploadedFileUrl('data_' . $key);
    }

    public function get()
    {
        $key = \Yii::$app->params['l'][\Yii::$app->language];

        if (!$this['data_' . $key]) {
            $key = 0;
        }

        return $this->getUploadedFileUrl('data_' . $key);
    }

    public function getFormField($form, $key = '0', $language = '')
    {
        $thisLanguage = $language ? '(' . $language . ')' : '';
        return $form->field($this, '[' . $this->id . ']data_' . $key)->widget(FileInput::class, [ // TODO use form array and key is BLOCK_ID
            'options' => ['accept' => '*'],
            'language' => Yii::$app->language,
            'pluginOptions' => [
                'showPreview' => true,
                'showCaption' => false,
                'showRemove' => false,
                'showCancel' => false,
                'showUpload' => false,
                'previewFileType' => 'any',
                'browseClass' => 'btn btn-primary btn-block',
                'browseLabel' => Yii::t('unit', 'Upload'),
                'layoutTemplates' => [
                    'main1' => '<div class="kv-upload-progress hide"></div>{browse}{preview}',
                ],
                'initialPreview' => [
                    Html::a($this->{'data_' . $key}, $this->getUploadedFileUrl('data_' . $key), ['target' => '_blank'])
                ],
            ],
        ])->label($this->label . $thisLanguage);
    }

    public function beforeValidate()
    {
        $this->data_0 = UploadedFile::getInstanceByName(Html::getInputName($this, '[' . $this->id . ']data_0'));
        $this->data_1 = UploadedFile::getInstanceByName(Html::getInputName($this, '[' . $this->id . ']data_1'));
        $this->data_2 = UploadedFile::getInstanceByName(Html::getInputName($this, '[' . $this->id . ']data_2'));
        $this->data_3 = UploadedFile::getInstanceByName(Html::getInputName($this, '[' . $this->id . ']data_3'));
        $this->data_4 = UploadedFile::getInstanceByName(Html::getInputName($this, '[' . $this->id . ']data_4'));
        return parent::beforeValidate();
    }
}

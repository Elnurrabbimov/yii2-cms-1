<?php

namespace afzalroq\cms\entities\unit;

use afzalroq\cms\helpers\UnitType;
use mihaildev\elfinder\ElFinder;
use sadovojav\ckeditor\CKEditor;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;

/**
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 */
class Text extends UnitActiveRecord
{

    public function rules()
    {
        return [
            [['data_0', 'data_1', 'data_2', 'data_3', 'data_4'], 'string'],
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
            'data_0' => Yii::t('unit', 'Text') . '(' . $language0 . ')',
            'data_1' => Yii::t('unit', 'Text') . '(' . $language1 . ')',
            'data_2' => Yii::t('unit', 'Text') . '(' . $language2 . ')',
            'data_3' => Yii::t('unit', 'Text') . '(' . $language3 . ')',
            'data_4' => Yii::t('unit', 'Text') . '(' . $language4 . ')',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function getData($key)
    {
        return $this->{'data_' . $key};
    }

    public function get()
    {
        $key = \Yii::$app->params['l'][\Yii::$app->language];

        if (!$this['data_' . $key]) {
            $key = 0;
        }

        return $this->{'data_' . $key};
    }


    public function getFormField($form, $key = '0', $language = '')
    {
        $thisLanguage = $language ? '(' . $language . ')' : '';
        switch ($this->type) {
            case UnitType::STRINGS:
            case UnitType::STRING_COMMON:
                return $form->field($this, '[' . $this->id . ']data_' . $key)->textarea(['rows' => 16])->label($this->label . $thisLanguage);
            case UnitType::TEXTS:
            case UnitType::TEXT_COMMON:
                return $form->field($this, '[' . $this->id . ']data_' . $key)->widget(CKEditor::class, [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                        'preset' => 'full',
                        'extraPlugins' => 'image2,widget,oembed,video',
                        'language' => Yii::$app->language,
                        'height' => 300,
                    ]),
                ])->label($this->label . $thisLanguage);
        }
    }

    public function load($data, $formName = null)
    {
        $success = false;

        foreach ($data as $postFormName => $formDataArray) {
            if ($postFormName == 'Text') {
                foreach ($data[$this->formName()] as $id => $formData) {
                    if ($this->id == $id) {
                        $success = Model::load($formDataArray, $id);
                    }
                }
            }
        }

        return $success;
    }
}

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model afzalroq\cms\entities\Items */
/* @var $entity \afzalroq\cms\entities\Entities */

$this->title =  \yii\helpers\StringHelper::truncate($model->text_1_0,50,'...');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Items'), 'url' => ['index', 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = ['label' => $model->slug, 'url' => ['view', 'id' => $model->id, 'slug' => $entity->slug]];
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update');
?>
<div class="items-update">

    <?= $this->render('_form', [
        'model' => $model,
        'entity' => $entity
    ]) ?>

</div>

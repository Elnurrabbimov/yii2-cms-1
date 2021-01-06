<?php


/* @var $this yii\web\View */
/* @var $model abdualiym\cms\entities\Entities */
/* @var $cae abdualiym\cms\entities\CaE */
/* @var $unassignedCollections abdualiym\cms\entities\Collections[] */


$this->title = Yii::t('cms', 'Update CaE: {name}', [
	'name' => $cae->collection->slug,
]);


$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Entities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->slug, 'url' => ['view', 'id' => $model->id]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cae-update">

	<?= $this->render('_form', [
		'model' => $model,
		'cae' => $cae,
		'unassignedCollections' => $unassignedCollections
	]) ?>

</div>

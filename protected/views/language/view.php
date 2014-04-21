<?php
/* @var $this LanguageController */
/* @var $model Language */

$this->breadcrumbs=array(
	'Languages'=>array('index'),
	$model->language_id,
);

$this->menu=array(
	array('label'=>'List Language', 'url'=>array('index')),
	array('label'=>'Create Language', 'url'=>array('create')),
	array('label'=>'Update Language', 'url'=>array('update', 'id'=>$model->language_id)),
	array('label'=>'Delete Language', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->language_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Language', 'url'=>array('admin')),
);
?>

<h1>View Language #<?php echo $model->language_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'language_id',
		'language_code',
		'language_status',
	),
)); ?>

<?php
/* @var $this LanguageController */
/* @var $model Language */

$this->breadcrumbs=array(
	'Languages'=>array('index'),
	$model->language_id=>array('view','id'=>$model->language_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Language', 'url'=>array('index')),
	array('label'=>'Create Language', 'url'=>array('create')),
	array('label'=>'View Language', 'url'=>array('view', 'id'=>$model->language_id)),
	array('label'=>'Manage Language', 'url'=>array('admin')),
);
?>

<h1>Update Language <?php echo $model->language_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
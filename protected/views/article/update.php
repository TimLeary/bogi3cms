<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->menu=array(
	array('label'=>'List Article', 'url'=>array('index')),
	array('label'=>'Create Article', 'url'=>array('create')),
);
?>

<h1>Update Article <?php echo $model->article_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
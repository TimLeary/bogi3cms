<?php
/* @var $this ArticleController */
/* @var $data Article */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->article_id), array('view', 'id'=>$data->article_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_title')); ?>:</b>
	<?php echo CHtml::encode($data->article_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_text')); ?>:</b>
	<?php echo CHtml::encode($data->article_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_status')); ?>:</b>
	<?php echo CHtml::encode($data->article_status); ?>
	<br />


</div>
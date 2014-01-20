<?php
/* @var $this ArticleCrudController */
/* @var $data Article */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->article_id), array('view', 'id'=>$data->article_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_parent_id')); ?>:</b>
	<?php echo CHtml::encode($data->article_parent_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_language_id')); ?>:</b>
	<?php echo CHtml::encode($data->article_language_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_desc')); ?>:</b>
	<?php echo CHtml::encode($data->article_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_keywords')); ?>:</b>
	<?php echo CHtml::encode($data->article_keywords); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link')); ?>:</b>
	<?php echo CHtml::encode($data->link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_title')); ?>:</b>
	<?php echo CHtml::encode($data->article_title); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('article_text')); ?>:</b>
	<?php echo CHtml::encode($data->article_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_seq')); ?>:</b>
	<?php echo CHtml::encode($data->article_seq); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_just_parent')); ?>:</b>
	<?php echo CHtml::encode($data->is_just_parent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_just_link')); ?>:</b>
	<?php echo CHtml::encode($data->is_just_link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_status')); ?>:</b>
	<?php echo CHtml::encode($data->article_status); ?>
	<br />

	*/ ?>

</div>
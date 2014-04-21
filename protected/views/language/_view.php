<?php
/* @var $this LanguageController */
/* @var $data Language */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('language_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->language_id), array('view', 'id'=>$data->language_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('language_code')); ?>:</b>
	<?php echo CHtml::encode($data->language_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('language_status')); ?>:</b>
	<?php echo CHtml::encode($data->language_status); ?>
	<br />


</div>
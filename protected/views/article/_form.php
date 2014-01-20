<?php
/* @var $this ArticleController */
/* @var $model Article */
/* @var $form CActiveForm */
?>

<div class="form">
<?php Yii::import('ext.imperavi-redactor-widget.ImperaviRedactorWidget'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->hiddenField($model,'article_id'); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'article_title'); ?>
		<?php echo $form->textField($model,'article_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'article_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_text'); ?>
                <?php $this->widget('ImperaviRedactorWidget', array(
                    'model' => $model,
                    'attribute' => 'article_text',
                )); ?>
                <?php echo $form->error($model,'article_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_status'); ?>
		<?php echo CHtml::activeDropDownList($model,'article_status',array('inedit'=>'inedit','active'=>'active','passive'=>'passive')); ?>
		<?php echo $form->error($model,'article_status'); ?>
	</div>
        <iframe id="imageUpload" width="100%" height="75" src="<?php echo Yii::app()->createUrl('medium/imageUploader',array('areaId'=>Yii::app()->params['articleArea'],'objectId' => $model->article_id));?>" scrolling="no" style="overflow: hidden"></iframe>
        <div id="imageSorter"></div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    function iframeLoaded(){
        refreshSorter();
    }
    
    function refreshSorter(){
        $.ajax({url: '<?php echo Yii::app()->createUrl('medium/imageSorter',array('areaId'=> Yii::app()->params['articleArea'],'objectId' => $model->article_id));?>',
            success: function(data) {
                $('#imageSorter').children().remove();
                $('#imageSorter').append(data);
            }
        });
    }
    
    $(document).ready(function() {
    
    });
</script>

<style>
    #imageUploder{
            background-color:#cacaca;
    }
    input#imageLoader{
        background-color: #10a4c6;
        color:#ffffff;
        text-transform: uppercase;
        border: none;
    }
    body{
    	padding: 0px 10px;
    }
</style>
<div id="imageUploder">
<div id="imageUploderForm">
    <?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); ?>
    <?php echo CHtml::fileField('file'); ?>
    <?php echo CHtml::submitButton(Yii::t('app', 'Upload'),array('id'=>'imageLoader')); ?>
    <?php echo CHtml::endForm(); ?>
</div>
<div><?= Yii::t('image','used_format_jpg_max_size') ?> <?= ini_get('upload_max_filesize') ?></div>
</div>
<script type="text/javascript">
    window.onload = function() {
        parent.iframeLoaded();
    }
</script>

<iframe id="imageUpload" width="100%" height="75" src="<?php echo Yii::app()->createUrl('medium/imageUploader',array('areaId'=>Yii::app()->params['backgroundArea'],'objectId' => Yii::app()->params['backgroundId']));?>" scrolling="no" style="overflow: hidden"></iframe>
<div id="imageSorter"></div>
<script type="text/javascript">
    function iframeLoaded(){
        refreshSorter();
    }
    
    function refreshSorter(){
        $.ajax({url: '<?php echo Yii::app()->createUrl('medium/imageSorter',array('areaId'=> Yii::app()->params['backgroundArea'],'objectId' => Yii::app()->params['backgroundId']));?>',
            success: function(data) {
                $('#imageSorter').children().remove();
                $('#imageSorter').append(data);
            }
        });
    }
    
    $(document).ready(function() {
    
    });
</script>
<ul>
<?php
    $items = array();
    foreach ($wImages as $wImage):
        $items[$wImage->medium->medium_id] = '<div class="picSortBox"><div style="background-image: url('.Yii::app()->baseUrl.'/images/uploaded/thumbnail/'.$wImage->medium->filename.'); background-repeat: no-repeat; background-position: center top; width:'.Yii::app()->params['thumbnailSizeMaxX'].'px; height:'.Yii::app()->params['thumbnailSizeMaxY'].'px;"></div>';
        $items[$wImage->medium->medium_id] .= '<div>'.CHtml::ajaxLink(Yii::t('image','delete'),Yii::app()->createUrl('medium/deleteImage',array('mediumId' => $wImage->medium->medium_id,'areaId'=>$areaId,'object_id'=>$objectId)),array('success'=>'refreshSorter()'),array('name'=>'deleteImageLink_'.$wImage->medium->medium_id)).'</div></div>';
    endforeach;
    if($items != null){
        $this->widget('zii.widgets.jui.CJuiSortable',array(
            'id' => 'imageSort',
            'items' => $items,
            // additional javascript options for the JUI Sortable plugin
            'options'=>array(
                //'start' => "js:function(){window.old_position = $(this).sortable('toArray');}",
                'update' => "js:function(){
                    var sortObj = new Object();
                    sortObj.newOrder = $(this).sortable('toArray');
                    console.log(JSON.stringify(sortObj));

                    $.ajax({
                        url: '".Yii::app()->createUrl('medium/changeSort',array('areaId'=>$areaId,'objectId' =>$objectId))."&newOrderStr='+JSON.stringify(sortObj),
                        success: function(data) {
                            refreshSorter();
                        }
                    });
                }",
                'delay'=>'300',
            ),
        ));
    }
?>
</ul>
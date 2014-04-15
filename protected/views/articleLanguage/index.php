<?php
    echo $this->renderPartial('_languageList',array('activeLanguages'=>$activeLanguages,'actualLanguage'=>$actualLanguage));

    $breadcrumbArray = array();
    if($wElderParents != null): ?>
        <div id="articleBreadcrumb">
            <a href="<?= Yii::app()->createUrl('articleLanguage/index',array('parentId'=>null)) ?>">Article base</a> > 
        <?php
        $parentCounter = 0;
        $parentNum = count($wElderParents);
        foreach ($wElderParents as $wElderParent): ?>
            <?php //if(++$parentCounter != $parentNum): ?>
                <a href="<?= Yii::app()->createUrl('articleLanguage/index',array('parentId'=>key($wElderParent))) ?>"><?= ucfirst($wElderParent[key($wElderParent)]) ?></a> > <?php
            // endif;
        endforeach; ?>
        </div>
        <?php
    endif;

    $this->menu=array(
        array('label'=>'Create Article', 'url'=>array('create','parentId' => $wParentId,'language'=>$actualLanguage)),
    );
?>

<?php //var_dump($wArticles, $wParentId); ?>
<?php 
    $articleShowList = array();
    if($wArticles != null){
        foreach ($wArticles as $wArticle){
            $articleShowList[$wArticle['article_id']] = '<div class="articleList">';
            $articleShowList[$wArticle['article_id']] .= '<div class="moveIt"></div>';
            $articleShowList[$wArticle['article_id']] .= '<div class="title">';
            $articleShowList[$wArticle['article_id']] .= $wArticle['article_title'];
            $articleShowList[$wArticle['article_id']] .= '</div>';
            $articleShowList[$wArticle['article_id']] .= '<div class="editIt"><a href="'.Yii::app()->createUrl('articleLanguage/update',array('id'=>$wArticle['article_id'])).'"></a></div>';
            if(($wArticle['is_just_parent']==0)OR($wArticle['is_just_parent']=="")){
                $articleShowList[$wArticle['article_id']] .= '<div class="parentIt"><a href="'.Yii::app()->createUrl('articleLanguage/index',array('parentId'=>$wArticle['article_id'])).'"></a></div>';
            } else {
                $articleShowList[$wArticle['article_id']] .= '<div class="showChildsIt"><a href="'.Yii::app()->createUrl('articleLanguage/index',array('parentId'=>$wArticle['article_id'])).'"></a></div>';
            }
            $articleShowList[$wArticle['article_id']] .= '<div class="deleteIt"><a href="'.Yii::app()->createUrl('articleLanguage/delete',array('id' => $wArticle['article_id'])).'"></a></div>';
            $articleShowList[$wArticle['article_id']] .= '</div>';
        }
    }
?>
<?php
    if($wArticles != null){
        $this->widget('zii.widgets.jui.CJuiSortable',array(
            'id' => 'articleShowList',
            'items' => $articleShowList,
            // additional javascript options for the JUI Sortable plugin
            'options'=>array(
                'delay'=>'300',
                'update' => "js:function(){
                                var sortObj = new Object();
                                sortObj.newOrder = $(this).sortable('toArray');
                                console.log(JSON.stringify(sortObj));
                                $.ajax({
                                    url: '".Yii::app()->createUrl('article/changeSort',array('parentId'=>$wParentId))."&newOrderStr='+JSON.stringify(sortObj),
                                    success: function(data) {
                                        window.location.reload();
                                    }
                                });

                            }",
            ),
        ));
        ?>  
        <?php
    }
?>
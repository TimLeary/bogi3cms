<?php
/* @var $this ArticleController */
/* @var $dataProvider CActiveDataProvider */
/*
$this->breadcrumbs=array(
	'Articles',
);
*/
$this->menu=array(
    array('label'=>'Create Article', 'url'=>array('create','parentId' => $wParentId)),
    array('label'=>'Manage Article', 'url'=>array('admin')),
);
?>

<h1>Articles</h1>
<?php var_dump($wArticles, $wParentId); ?>
<?php 
    $articleShowList = array();
    
    foreach ($wArticles as $wArticle){
        $articleShowList[$wArticle['article_id']] = '<div class="articleList">';
        $articleShowList[$wArticle['article_id']] .= '<div class="moveIt"></div>';
        $articleShowList[$wArticle['article_id']] .= '<div class="title">';
        $articleShowList[$wArticle['article_id']] .= $wArticle['article_title'];
        $articleShowList[$wArticle['article_id']] .= '</div>';
        $articleShowList[$wArticle['article_id']] .= '<div class="editIt"><a href="'.Yii::app()->createUrl('article/update',array('id'=>$wArticle['article_id'])).'"></a></div>';
        if(($wArticle['is_just_parent']==0)OR($wArticle['is_just_parent']=="")){
            $articleShowList[$wArticle['article_id']] .= '<div class="parentIt"><a href="'.Yii::app()->createUrl('article/index',array('parentId'=>$wArticle['article_id'])).'"></a></div>';
        } else {
            $articleShowList[$wArticle['article_id']] .= '<div class="showChildsIt"><a href="'.Yii::app()->createUrl('article/index',array('parentId'=>$wArticle['article_id'])).'"></a></div>';
        }
        $articleShowList[$wArticle['article_id']] .= '<div class="deleteIt"><a href="'.Yii::app()->createUrl('article/delete',array('parentId'=>$wParentId,'id' => $wArticle['article_id'])).'"></a></div>';
        $articleShowList[$wArticle['article_id']] .= '</div>';
    }
?>
<?php
    $this->widget('zii.widgets.jui.CJuiSortable',array(
        'id' => 'articleShowList',
        'items' => $articleShowList,
        // additional javascript options for the JUI Sortable plugin
        'options'=>array(
            'delay'=>'300',
        ),
    ));
?>
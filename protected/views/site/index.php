<?php
    $jsCalls = array();
?>
<?php
if($wArticles != null):
    ?>
    <div id="showArticle">
        <?php
        foreach ($wArticles as $wArticle):
            $pictures = MediaToObject::model()->getPicturesByObject(Yii::app()->params['articleArea'], $wArticle['article_id']);
        ?>
        <div class="articleView">
			<div class="articleTitle">
				<h3><?=$wArticle['article_title']?></h3>
			</div>
			<div class="articleBody">
				<?php if($pictures != null): ?>
				<div class="articlePicBox">
					<div id="articleItem-<?= $wArticle['article_id'] ?>" class="left articleImage linkCursor" style="background-image: url('<?= Yii::app()->getBaseUrl(true).'/images/uploaded/thumbnail/'.$pictures[0]['filename']?>'); width:<?= Yii::app()->params['thumbnailSizeMaxX']?>px; height:<?= Yii::app()->params['thumbnailSizeMaxY']?>px;"></div>
				</div>
				<?php endif; ?>
				<div class="articleContent"><?=$wArticle['article_text']?></div>
			</div>
        </div>
		<div class="clear"></div>
        <?php 
            $jsCall = null;
            if($pictures != null):
                $jsCall = '$("#articleItem-'.$wArticle['article_id'].'").click(function() {';
                $jsCall .= '$.fancybox([';
                foreach ($pictures as $onePic):
                    $jsCall .= "'".Yii::app()->getBaseUrl(false).'/images/uploaded/medium/'.$onePic['filename']."',";
                endforeach;
                $jsCall .= '], {
                        \'padding\'			: 0,
                        \'transitionIn\'		: \'none\',
                        \'transitionOut\'		: \'none\',
                        \'type\'              : \'image\',
                        \'changeFade\'        : 0
                    });';
                $jsCall .= '});';
                $jsCalls[] = $jsCall;
            endif;
        ?>
        
        <?php  
        endforeach;
        ?>
    </div>
    <?php
endif;
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        <?= implode(' ', $jsCalls) ?>
    });
</script>
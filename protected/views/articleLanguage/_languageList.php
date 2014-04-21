<?php if($activeLanguages): ?>
<div id="articleLanguagesList">
    <ul>
        <?php foreach ($activeLanguages as $language): ?>
        <li><a href="<?= Yii::app()->createUrl('articleLanguage/index',array('language'=>$language['language_code'])) ?>" class="<?php if($actualLanguage == $language['language_code']):?>actual<?php endif; ?>"><?= $language['language_code'] ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
<?php

/**
 * This is the model class for table "article".
 *
 * The followings are the available columns in table 'article':
 * @property integer $article_id
 * @property integer $article_parent_id
 * @property integer $article_language_id
 * @property integer $article_brother_id
 * @property string $article_desc
 * @property string $article_keywords
 * @property string $link
 * @property string $article_title
 * @property string $article_text
 * @property integer $article_seq
 * @property integer $is_just_parent
 * @property integer $is_just_link
 * @property string $article_status
 *
 * The followings are the available model relations:
 * @property ArticleLanguage $articleBrother
 * @property ArticleLanguage[] $articles
 * @property ArticleLanguage $articleParent
 * @property ArticleLanguage[] $articles1
 * @property Language $articleLanguage
 */
class ArticleLanguage extends CActiveRecord
{
        public $elderParents = array();
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_title', 'required'),
			array('article_parent_id, article_language_id, article_brother_id, article_seq, is_just_parent, is_just_link', 'numerical', 'integerOnly'=>true),
			array('article_desc, article_keywords, link', 'length', 'max'=>500),
			array('article_title', 'length', 'max'=>255),
			array('article_status', 'length', 'max'=>7),
			array('article_text', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('article_id, article_parent_id, article_language_id, article_brother_id, article_desc, article_keywords, link, article_title, article_text, article_seq, is_just_parent, is_just_link, article_status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'articleBrother' => array(self::BELONGS_TO, 'ArticleLanguage', 'article_brother_id'),
			'articles' => array(self::HAS_MANY, 'ArticleLanguage', 'article_brother_id'),
			'articleParent' => array(self::BELONGS_TO, 'ArticleLanguage', 'article_parent_id'),
			'articles1' => array(self::HAS_MANY, 'ArticleLanguage', 'article_parent_id'),
			'articleLanguage' => array(self::BELONGS_TO, 'Language', 'article_language_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'article_id' => 'Article',
			'article_parent_id' => 'Article Parent',
			'article_language_id' => 'Article Language',
			'article_brother_id' => 'Article Brother',
			'article_desc' => 'Article Desc',
			'article_keywords' => 'Article Keywords',
			'link' => 'Link',
			'article_title' => 'Article Title',
			'article_text' => 'Article Text',
			'article_seq' => 'Article Seq',
			'is_just_parent' => 'Is Just Parent',
			'is_just_link' => 'Is Just Link',
			'article_status' => 'Article Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('article_parent_id',$this->article_parent_id);
		$criteria->compare('article_language_id',$this->article_language_id);
		$criteria->compare('article_brother_id',$this->article_brother_id);
		$criteria->compare('article_desc',$this->article_desc,true);
		$criteria->compare('article_keywords',$this->article_keywords,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('article_title',$this->article_title,true);
		$criteria->compare('article_text',$this->article_text,true);
		$criteria->compare('article_seq',$this->article_seq);
		$criteria->compare('is_just_parent',$this->is_just_parent);
		$criteria->compare('is_just_link',$this->is_just_link);
		$criteria->compare('article_status',$this->article_status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArticleLanguage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getArticlesByParentId($parentId = null, $articleStatus = 'active', $languageId = null){
            $articles = Yii::app()->db->createCommand()
                ->select(array('*'))
                ->from('article a')
                ->order(array('a.article_seq ASC'));
            
            if($articleStatus == 'all'){
                $articles->where('a.article_status != \'inedit\'');
            } else {
                $articles->where('a.article_status = :articleStatus',array(':articleStatus' => $articleStatus));
            }
            
            if($parentId == null){
                $articles->andWhere('a.article_parent_id is null');
            } else {
                $articles->andWhere('a.article_parent_id = :articleParentId', array(':articleParentId' => $parentId));
            }
            
            if($languageId != null){
                $articles->andWhere('a.article_language_id = :languageId', array(':languageId'=>$languageId));
            }
            
            return $articles->queryAll();
        }
        
        public function getArticleById($articleId = null, $articleStatus = 'active'){
            $articles = Yii::app()->db->createCommand()
                ->select(array('*'))
                ->from('article a')
                ->where('a.article_status = :articleStatus',array(':articleStatus' => $articleStatus))
                ->andWhere('a.article_id = :articleId', array(':articleId' => $articleId));
            
            return $articles->queryAll();
        }
        
        public function getElderParents($articleId = null){
            $article = ArticleLanguage::model()->findByPk($articleId);
            
            if($article != null){
                $tmpArray = array($article->article_id => $article->article_title);
                array_unshift($this->elderParents, $tmpArray);
                if($article->article_parent_id != null){
                    self::getElderParents($article->article_parent_id);
                }
                return $this->elderParents;
            }
        }
        
        public function getElderParentsId($articleId = null){
            $article = ArticleLanguage::model()->findByPk($articleId);
            
            if($article != null){
                $tmpArray = $article->article_id;
                array_unshift($this->elderParents, $tmpArray);
                if($article->article_parent_id != null){
                    self::getElderParentsId($article->article_parent_id);
                }
                return $this->elderParents;
            }
        }
        
        public function getARArticlesByParentId($parentId = null, $articleStatus = 'active'){
            $criteria = new CDbCriteria();
            $criteria->alias = 'a';
            if($parentId == null){
                $criteria->condition = "a.article_status = :articleStatus and a.article_parent_id is null";
                $criteria->params = array(':articleStatus'=>$articleStatus);
            } else {
                $criteria->condition = "a.article_status = :articleStatus and a.article_parent_id = :articleParentId";
                $criteria->params = array(':articleStatus'=>$articleStatus,':articleParentId'=>$parentId);
            }
            $criteria->order = 'a.article_seq ASC';
            return Article::model()->findAll($criteria);
        }
        
        public function getLastSeq($parentId = null){
            $articles = Yii::app()->db->createCommand()
                ->select(array('count(*) as seq'))
                ->from('article a')
                ->where('a.article_status = :articleStatus',array(':articleStatus' => 'active'));
            
            if($parentId == null){
                $articles->andWhere('a.article_parent_id is null');
            } else {
                $articles->andWhere('a.article_parent_id = :articleParentId', array(':articleParentId' => $parentId));
            }
            
            return $articles->queryRow();
        }
        
        public function getBasicMenu($parentId, $languageId = null){
            $returnArray = array();
            $menu = Yii::app()->db->createCommand()
                ->select(array('article_id','article_seq','link','article_title','is_just_parent','is_just_link','article_status'))
                ->from('article')
                ->where('article_status = :articleStatus',array(':articleStatus' => 'active'));
            
            if($parentId == null){
                $menu->andWhere('article_parent_id is null');
            } else {
                $menu->andWhere('article_parent_id = :articleParentId', array(':articleParentId' => $parentId));
            }
            
            $menu->andWhere('article_language_id = :languageId',array(':languageId'=>$languageId));
            
            $menu->order(array('article_seq ASC'));
            
            $menuItems = $menu->queryAll();
            
            $i = 0;
            foreach($menuItems as $item){
                $returnArray[$i] = $item;
                $returnArray[$i]['childs'] = self::getBasicMenu($item['article_id'],$languageId);
                $i++;
            }
            
            return $returnArray;
        }
        
        public function getVeryFirstChild($languageId){
            $menu = Yii::app()->db->createCommand()
                ->select(array('article_id','is_just_parent'))
                ->from('article')
                ->where('article_status = :articleStatus',array(':articleStatus' => 'active'))
                ->andWhere('article_parent_id is null')
                ->andWhere('article_language_id = :languageId',array(':languageId' => $languageId))
                ->order(array('article_seq ASC'))
                ->limit(1);
            return $menu->queryRow();
        }
}

<?php

class MediumController extends Controller
{
        /**
         * @return array action filters
         */
        public function filters()
        {
                return array(
                        'accessControl', // perform access control for CRUD operations
                        'postOnly + delete', // we only allow deletion via POST request
                );
        }

        /**
         * Specifies the access control rules.
         * This method is used by the 'accessControl' filter.
         * @return array access control rules
         */
        public function accessRules()
        {
                return array(
                        array('allow',  // allow all users to perform 'index' and 'view' actions
                                'actions'=>array('getMedium','testResize'),
                                'users'=>array('*'),
                        ),
                        array('allow', // allow authenticated user to perform 'create' and 'update' actions
                                'actions'=>array('imageUploader','imageSorter','changeSort','update','admin','delete','imageUpload','deleteImage'),
                                'expression' => 'Yii::app()->user->isGuest() === 0',
                        ),
                        /*
                        array('allow', // allow admin user to perform 'admin' and 'delete' actions
                                'actions'=>array(''),
                                'expression' => 'Yii::app()->user->isAdmin()==1'
                        ),
                         */
                        array('deny',  // deny all users
                                'users'=>array('*'),
                        ),
                );
        }
        
        public function generateImageFileName($areaId, $objectId){
            $wNumImage = MediaToObject::model()->count('area_id = :areaId and object_id = :objectId',array(':areaId' => $areaId,':objectId' => $objectId));
            ++$wNumImage;
            if($wNumImage < 10){
                $wNumImage = '0'.$wNumImage;
            }
            
            return $areaId.'_'.$objectId.'_'.$wNumImage;
        }
        
        public function getExtension ($mime_type){
            $extensions = array(
                'image/jpg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/jpeg' => 'jpeg',
                'miage/pjpeg' => 'pjpeg'
                
            );
            return $extensions[$mime_type];
        }

        public function actionImageUploader(){
            $objectId = Yii::app()->request->getParam('objectId');
            $areaId = Yii::app()->request->getParam('areaId');
            
            if($areaId == Yii::app()->params['giftArea']){
                $giftElement = Gift::model()->find('gift_id = :objectId',array(':objectId' => $objectId));
                if($giftElement == null){
                    throw new Exception('Not valid object.');
                } else {
                    if(($giftElement->creator_id != Yii::app()->user->id)&&(Yii::app()->user->isAdmin() !== 1)){
                        throw new Exception('Permission denied.');
                    } elseif ((Yii::app()->user->isAdmin() !== 1)&&($giftElement->donation_status != Yii::app()->params['giftTempStatus'])) {
                        throw new Exception('Permission denied.');
                    }
                }
            } else if($areaId == Yii::app()->params['articleArea']){
                $wArticle = Article::model()->find('article_id = :objectId',array(':objectId' => $objectId));
                if($wArticle == null){
                    throw new Exception('Not valid object.');
                } else {
                    if(Yii::app()->user->isAdmin() !== 1){
                        throw new Exception('Permission denied.');
                    }
                }
            } else {
                throw new Exception('Not valid area.');
            }
            
            $generatedFileName = self::generateImageFileName($areaId,$objectId);
            
            $newFileUrl = null;
            
            //var_dump($_FILES);
            
            if($_FILES != null){
                $_FILES['file']['type'] = strtolower($_FILES['file']['type']);
                if (/* $_FILES['file']['type'] == 'image/png'
                || */ $_FILES['file']['type'] == 'image/jpg'/*
                || $_FILES['file']['type'] == 'image/gif' 
                */ || $_FILES['file']['type'] == 'image/jpeg' /*
                || $_FILES['file']['type'] == 'image/pjpeg'*/)
                {   
                    $newFileName = $generatedFileName.'.'.self::getExtension($_FILES['file']['type']);
                    
                    move_uploaded_file($_FILES["file"]["tmp_name"],APP_PATH.'/images/uploaded/original/'.$newFileName);
                    
                    $wObjNum = MediaToObject::model()->count('area_id = :areaId and object_id = :objectId',array(':areaId' => $areaId,':objectId' => $objectId));
                    
                    $wImage = new Medium();
                    $wImage->setAttributes(array(
                        'mime_type' => $_FILES['file']['type'],
                        'filename' => $newFileName
                    ));
                    
                    $wImage->save();
                    $imageId = $wImage->getPrimaryKey();
                    
                    $wImageToObject = new MediaToObject();
                    $wImageToObject->setAttributes(array(
                        'medium_id' => $imageId, 
                        'area_id' => $areaId,
                        'object_id' => $objectId,
                        'priority' => $wObjNum + 1
                    ));
                    $wImageToObject->save();
                    
                    self::generateMediumImage($newFileName);
                    self::generateThumbnailImage($newFileName);
                }
            }
            $this->renderPartial('imageUploader',array('objectId'=>$objectId,'areaId'=>$areaId, 'newFileUrl' => $newFileUrl),false,true);
        }
            
        public function actionImageSorter($objectId = null,$areaId = null){
            $cs=Yii::app()->clientScript;
            $cs->scriptMap=array(
               '*.js' => FALSE,
               '*.css' => FALSE
            );
            
            if($objectId == null){
                $objectId = Yii::app()->request->getParam('objectId');
            }
            if($areaId == null){
                $areaId = Yii::app()->request->getParam('areaId');
            }
            
            $criteria = new CDbCriteria;
            $criteria->with = 'medium'; 
            $criteria->condition = 'object_id = :objectId and area_id = :areaId';
            $criteria->params = array(
                ':objectId' => $objectId,
                ':areaId' => $areaId
            );
            $criteria->together = true;
            $criteria->order = 'priority';
            $wImages = MediaToObject::model()->findAll($criteria);

            $this->renderPartial('imageSorter',array('objectId'=>$objectId,'areaId'=>$areaId,'wImages' => $wImages),false,true);
        }
        
        public function actionChangeSort(){
            $objectId = Yii::app()->request->getParam('objectId');
            $areaId = Yii::app()->request->getParam('areaId');
            $newOrderStr = Yii::app()->request->getParam('newOrderStr');
            
            $wMedias = MediaToObject::model()->findAll('object_id = :objectId and area_id = :areaId',array(':objectId' => $objectId, ':areaId' => $areaId));
            $newOrderObj = CJSON::decode($newOrderStr,TRUE);
            foreach ($wMedias as $wMedia) {
                $natPosition = array_search($wMedia->medium_id,$newOrderObj['newOrder']);
                $position = $natPosition + 1;
                $wMedia->setAttribute('priority',$position);
                $wMedia->save();
            }
        }
        
        public function actionDeleteImage(){
            $isDeleted = FALSE;
            $mediumId = Yii::app()->request->getParam('mediumId');
            $areaId = Yii::app()->request->getParam('areaId');
            $objectId = Yii::app()->request->getParam('objectId');
            
            if(Yii::app()->user->isAdmin() !== 1){
                if($areaId == Yii::app()->params['giftArea']){
                    //search for owner
                    $mediumSelect = Yii::app()->db->createCommand()
                        ->select(array('mo.media_to_object_id','gf.creator_id'))
                        ->from('media_to_object mo')
                        ->join('gift gf','mo.object_id = gf.gift_id')
                        ->where('mo.medium_id = :mediumId',array(':mediumId' => $mediumId))
                        ->andWhere('gf.donation_status = :tmp',array(':tmp' => Yii::app()->params['giftTempStatus']))
                        ->queryRow();
                    
                    if($mediumSelect != null){
                        if($mediumSelect['creator_id'] == Yii::app()->user->id){
                            self::deleteElement($areaId,$objectId,$mediumId);
                            $isDeleted = TRUE;
                        }
                    }
                }
            } else {
                self::deleteElement($areaId,$objectId,$mediumId);
                $isDeleted = TRUE;
            }
            
            echo $isDeleted;
            // self::actionImageSorter($objectId, $areaId);
        }
        
        protected function generateThumbnailImage($fileName){
            try{
                $originalFile = APP_PATH.'/images/uploaded/original/'.$fileName;
                $thumbnailImagePath = APP_PATH.'/images/uploaded/thumbnail/'.$fileName;

                list($source_image_width, $source_image_height, $source_image_type) = getimagesize($originalFile);
                switch ($source_image_type) {
                    case IMAGETYPE_GIF:
                        $source_gd_image = imagecreatefromgif($originalFile);
                        break;
                    case IMAGETYPE_JPEG:
                        $source_gd_image = imagecreatefromjpeg($originalFile);
                        break;
                    case IMAGETYPE_PNG:
                        $source_gd_image = imagecreatefrompng($originalFile);
                        break;
                }

                if ($source_gd_image === false) {
                    return false;
                }


                //$height = (($orig_height * $width) / $orig_width);
                $width = (($source_image_width * Yii::app()->params['thumbnailSizeMaxY'])/$source_image_height);

                $thumbnail_gd_image = imagecreatetruecolor($width, Yii::app()->params['thumbnailSizeMaxY']);
                imagecopyresized($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $width, Yii::app()->params['thumbnailSizeMaxY'], $source_image_width, $source_image_height);
                imagejpeg($thumbnail_gd_image, $thumbnailImagePath, 90);
                imagedestroy($source_gd_image);
                imagedestroy($thumbnail_gd_image);
            } catch (Exception $e){
                echo $e->getMessage();
            }
        }
        
        protected function generateMediumImage($fileName){
            $originalFile = APP_PATH.'/images/uploaded/original/'.$fileName;
            $thumbnailImagePath = APP_PATH.'/images/uploaded/medium/'.$fileName;
            
            //var_dump('generateMediumImage - path: '.$thumbnailImagePath);

            list($source_image_width, $source_image_height, $source_image_type) = getimagesize($originalFile);
            
            //var_dump($source_image_width, $source_image_height, $source_image_type);
            try{
                switch ($source_image_type) {
                    case IMAGETYPE_GIF:
                        $source_gd_image = imagecreatefromgif($originalFile);
                        break;
                    case IMAGETYPE_JPEG:
                        $source_gd_image = imagecreatefromjpeg($originalFile);
                        break;
                    case IMAGETYPE_PNG:
                        $source_gd_image = imagecreatefrompng($originalFile);
                        break;
                }
            } catch (Exception $e){
                var_dump($e);
            }
            
            //var_dump('Source gd image:',$source_gd_image);
            
            if ($source_gd_image === false) {
                return false;
            }

            $source_aspect_ratio = $source_image_width / $source_image_height;
            $thumbnail_aspect_ratio = Yii::app()->params['mediumSizeMaxX'] / Yii::app()->params['mediumSizeMaxY'];
            if ($source_image_width <= Yii::app()->params['mediumSizeMaxX'] && $source_image_height <= Yii::app()->params['mediumSizeMaxY']) {
                $thumbnail_image_width = $source_image_width;
                $thumbnail_image_height = $source_image_height;
            } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
                $thumbnail_image_width = (int) (Yii::app()->params['mediumSizeMaxY'] * $source_aspect_ratio);
                $thumbnail_image_height = Yii::app()->params['mediumSizeMaxY'];
            } else {
                $thumbnail_image_width = Yii::app()->params['mediumSizeMaxX'];
                $thumbnail_image_height = (int) (Yii::app()->params['mediumSizeMaxX'] / $source_aspect_ratio);
            }
            $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
            imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
            imagejpeg($thumbnail_gd_image, $thumbnailImagePath, 90);
            imagedestroy($source_gd_image);
            imagedestroy($thumbnail_gd_image);
            return true;
        }


        protected function deleteElement($areaId,$objectId,$mediumId){
            $wMedia = Medium::model()->find('medium_id = :mediumId',array(':mediumId'=>$mediumId));
            unlink(APP_PATH.'/images/uploaded/original/'.$wMedia->filename);
            unlink(APP_PATH.'/images/uploaded/thumbnail/'.$wMedia->filename);
            unlink(APP_PATH.'/images/uploaded/medium/'.$wMedia->filename);
            $wMedia->delete();
            MediaToObject::model()->find('medium_id = :mediumId',array(':mediumId'=>$mediumId))->delete();
        }
        
        public function actionTestResize(){
            ini_set('display_errors', 'On');
            error_reporting(E_ALL);
            
            var_dump(gd_info());
            $testFileName = 'test.jpg';
            $origPath = APP_PATH.'/images/uploaded/original/'.$testFileName;
            var_dump($origPath,  file_exists($origPath));
            
            var_dump('generateMediumImage exists:',method_exists($this, 'generateMediumImage'));
            self::generateMediumImage($testFileName);
            $mediumPath = APP_PATH.'/images/uploaded/medium/'.$testFileName;
            var_dump($mediumPath,  file_exists($mediumPath));
            
            var_dump('generateThumbnailImage exists:',method_exists($this, 'generateThumbnailImage'));
            self::generateThumbnailImage($testFileName);
            $thumbPath = APP_PATH.'/images/uploaded/thumbnail/'.$testFileName;
            var_dump($thumbPath,  file_exists($thumbPath));
            
            unlink($mediumPath);
            unlink($thumbPath);
        }
}
<?php

class WebUser extends CWebUser {
    private $_model;
    
    public function isGuest() {
        if(Yii::app()->user->id != null)
            return 0;
        else 
            return 1;
    }
    
    public function isAdmin() {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user===null){
            return 0;
        } else {
            if($user->user_status === 'nimda'){
                return 1;
            } else {
                return 0;
            }
        }
    }
    
    public function isManager() {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user===null){
            return 0;
        } else {
            if($user->user_status === 'manager'){
                return 1;
            } else {
                return 0;
            }
        }
    }
    
    protected function loadUser($id=null){
        if($this->_model===null)
        {
            if($id!==null)
                $this->_model=User::model()->findByPk($id);
        }
        return $this->_model;
    }
}
?>
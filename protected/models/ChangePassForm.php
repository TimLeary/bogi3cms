<?php

class ChangePassForm extends CFormModel {
    public $currentPassword;
    public $newPassword;
    public $newPassword_repeat;
    private $_user;
  
    public function rules(){
        return array(
            array(
                'currentPassword', 'compareCurrentPassword'
            ),
            array(
                'currentPassword, newPassword, newPassword_repeat', 'required'
            ),
            array(
                'newPassword_repeat', 'compare', 'compareAttribute'=>'newPassword'
            ),
        );
    }
  
    public function compareCurrentPassword($attribute,$params){
        if(User::model()->hashPassword($this->currentPassword) !== $this->_user->password){
            $this->addError($attribute,'Invalid password!');
        }
    }
  
    public function init(){
        if(Yii::app()->user->isGuest() === 0){
            $this->_user = User::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
        }
    }
  
    public function attributeLabels(){
        return array(
            'currentPassword'=>'Current password',
            'newPassword'=>'New password',
            'newPassword_repeat'=>'New password (repeat)',
        );
    }
  
    public function changePassword() {
        $this->_user->password = User::model()->hashPassword($this->newPassword);
        return $this->_user->save();
    }
}
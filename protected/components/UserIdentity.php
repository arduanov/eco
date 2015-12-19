<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

    public function authenticate($role_id = array(1,2)){
        //ищем пользователя по имени    
        $record=Users::model()->findByAttributes(array('login'=>$this->username));
        //если пользователь найден и его пароль совпадает с введенным...
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if($record->password!==md5($this->password) || !in_array($record->role_id,$role_id))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            //...сохраняем данные пользователя (логин, имя , электронная почта)
            $this->_id=$record->id;
            $this->setState('login', $record->login);
            $this->setState('name', $record->username);
            $this->setState('email', $record->email);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId(){
        return $this->_id;
    }

}
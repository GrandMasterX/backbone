<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * @var User $user user model that we will get by email
	 */
	public $user;
    public $email;

	public function __construct($username,$password=null)
	{
		// sets username and password values
		parent::__construct($username,$password);

		$this->user = User::model()->find('LOWER(email)=?',array(strtolower($this->username)));
        $this->email = $username;
        if(isset($this->user->id)){
            Yii::app()->user->login($this->user, Yii::app()->params['loginDuration']);
        }
		if($password === null)
		{
                    
			/**
			 * you can set here states for user logged in with oauth if you need
			 * you can also use hoauthAfterLogin()
			 * @link https://github.com/SleepWalker/hoauth/wiki/Callbacks
			 */
			$this->errorCode=self::ERROR_NONE;
		}
	}

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() 
	{
		if ($this->user === null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		elseif (!$this->user->validatePassword($this->password))
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else 
		{
			$this->errorCode = self::ERROR_NONE;
		}
		return $this->errorCode == self::ERROR_NONE;
	}

	public function getId()
	{
		return $this->user->id;
	}

	public function getName()
	{
		return $this->user->email;
	}
        
        public function getEmail() {
            return $this->user->email;
        }
}
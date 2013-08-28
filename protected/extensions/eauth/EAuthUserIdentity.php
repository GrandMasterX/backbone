<?php
/**
 * EAuthUserIdentity class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * EAuthUserIdentity is a base User Identity class to authenticate with EAuth.
 * @package application.extensions.eauth
 */
class EAuthUserIdentity extends CBaseUserIdentity {

	const ERROR_NOT_AUTHENTICATED = 3;

	/**
	 * @var EAuthServiceBase the authorization service instance.
	 */
	protected $service;
        protected $scope;

	/**
	 * @var string the unique identifier for the identity.
	 */
	protected $id;

	/**
	 * @var string the display name for the identity.
	 */
	protected $name;
        protected $gender;
        protected $url;
        protected $timezone;
        protected $photo_medium;
        protected $city;
        protected $country;
        protected $access_token;

	/**
	 * Constructor.
	 * @param EAuthServiceBase $service the authorization service instance.
	 */
	public function __construct($service) {
		$this->service = $service;
	}

	/**
	 * Authenticates a user based on {@link service}.
	 * This method is required by {@link IUserIdentity}.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
		if ($this->service->isAuthenticated) {
			$this->id = $this->service->id;
			$this->name = $this->service->getAttribute('name');
                        $this->gender = $this->service->getAttribute('gender');
                        $this->url = $this->service->getAttribute('url');
                        $this->city = $this->service->getAttribute('city');
                        $this->country = $this->service->getAttribute('country');
                        $this->timezone = $this->service->getAttribute('timezone');
                        $this->photo_medium = $this->service->getAttribute('photo_medium');
                        $this->scope = $this->service->getAttribute('scope');
                        $this->access_token = $this->service->getAttribute('access_token');
			$this->setState('id', $this->id);
			$this->setState('name', $this->name);
			$this->setState('service', $this->service->serviceName);

			// You can save all given attributes in session.
			//$attributes = $this->service->getAttributes();
			//$session = Yii::app()->session;
			//$session['eauth_attributes'][$this->service->serviceName] = $attributes;

			$this->errorCode = self::ERROR_NONE;
		}
		else {
			$this->errorCode = self::ERROR_NOT_AUTHENTICATED;
		}
		return !$this->errorCode;
	}

	/**
	 * Returns the unique identifier for the identity.
	 * This method is required by {@link IUserIdentity}.
	 * @return string the unique identifier for the identity.
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Returns the display name for the identity.
	 * This method is required by {@link IUserIdentity}.
	 * @return string the display name for the identity.
	 */
	public function getName() {
		return $this->name;
	}
        public function getServicename() {
            return $this->service->serviceName;
        }
        public function getService() {
            return $this->service;
        }
        public function getGender() {
            return $this->gender;
        }
        public function getUrl() {
            return $this->url;
        }
        public function getCity() {
            return $this->city;
        }
        public function getCountry() {
            return $this->Country;
        }
        public function getMphoto() {
            return $this->photo_medium;
        }
        public function getTimezone() {
            return $this->timezone;
        }
        public function getScope() {
            return $this->scope;
        }
        public function getAccess_token() {
            return $this->access_token;
        }
}

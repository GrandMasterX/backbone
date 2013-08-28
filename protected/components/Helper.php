<?php
  class Helper 
  {
    public static function myPrint_r($array = null, $die = false)
    {
        echo "<pre>";
            print_r($array);
        echo "</pre>";
        
        if ($die)
            die;
    }
    
    public static function randomPassword($length = 12)
    {
        return Helper::randomCode($length);
    }

    public static function randomCode($length = 12)
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#_-%^&*()";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); 
    }
    
    public static function randomNumberCode($length = 5)
    {
        $numbers = "1234567890";
        $pass = array();
        $alphaLength = strlen($numbers) - 1;
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $numbers[$n];
        }
        return implode($pass); 
    }    
    
    public static function createHash($length = 12)
    {
        return $hash = sha1(uniqid(Helper::randomCode($length) . mt_rand(), true));
    }
    
    public static function sendSimpleEmail($from, $recipient, $title, $body, $replyTo=null, $headers=null)
    {
        $replyTo = (is_null($replyTo)) ? $from : $replyTo;  
        $headers = (is_null($headers)) ? "From: {$from}\r\nReply-To: {$replyTo}\r\nContent-type: text/plain; charset=utf-8" : $headers;
        return mail($recipient,$title,$body,$headers);
    } 
    
    /**
    * returns route in parts
    * Array
    * (
    *   [0] => admin
    *   [1] => user
    *   [2] => index
    * ) 
    */
    public static function getRouteParts() {
        return $routeParts = explode('/', Yii::app()->controller->getRoute());
    }
    
    /**
    * returns first two route parts
    * @return admin/user
    */
    public static function getRoutePartsForModuleAndController() {
        $routeParts = explode('/', Yii::app()->controller->getRoute());
        return $moduleAndController = $routeParts[0].'/'.$routeParts[1];
    }
    
    public static function getTranslation($model,$field)
    {
        return (empty($model->translations[Yii::app()->language]->$field)) 
            ? Yii::t('translations', 'Перевод отсутствует') : $model->translations[Yii::app()->language]->$field;
    }
    
    public static function getTranslationWithLabel($model,$field, $label=false)
    {
        $value=($label) 
            ? '<span class="label label-success item-state">' . Yii::t('item', 'Обработан') . '</span>' . $model->translations[Yii::app()->language]->$field
            : $model->translations[Yii::app()->language]->$field;
        
        return (empty($model->translations[Yii::app()->language]->$field)) 
            ? Yii::t('translations', 'Перевод отсутствует') 
            : $value;
    }
    
    public static function getTranslationWithTwoLabels($model,$field, $ready=false,$unavailable=false)
    {
        $value='';
        if($ready) 
            $value='<span class="label label-success item-state">' . Yii::t('item', 'Обработан') . '</span>';  

        if($unavailable) 
            $value='<span class="label label-warning item-state">' . Yii::t('item', 'Нет в наличии') . '</span>';
            
        if($ready && $unavailable) 
            $value='<span class="label label-success item-state">' . Yii::t('item', 'Обработан') . '</span>' . '<span class="label label-warning item-state">' . Yii::t('item', 'Нет в наличии') . '</span>';
        
        return (empty($model->translations[Yii::app()->language]->$field)) 
            ? Yii::t('translations', 'Перевод отсутствует') 
            : $value . $model->translations[Yii::app()->language]->$field;
    }

      public static function getTranslationWithTwoLabelsNoObj($data,$field, $ready=false,$unavailable=false)
      {
          $value='';
          if($ready)
              $value='<span class="label label-success item-state">' . Yii::t('item', 'Обработан') . '</span>';

          if($unavailable)
              $value='<span class="label label-warning item-state">' . Yii::t('item', 'Нет в наличии') . '</span>';

          if($ready && $unavailable)
              $value='<span class="label label-success item-state">' . Yii::t('item', 'Обработан') . '</span>' . '<span class="label label-warning item-state">' . Yii::t('item', 'Нет в наличии') . '</span>';

          return (empty($data[$field]))
              ? Yii::t('translations', 'Перевод отсутствует')
              : $value . $data[$field];
      }
    
    public static function getLabel()
    {
        return '<span class="label label-warning">' . Yii::t('item', 'Нет фото') . '</span>';
    }         
    
    public static function getItemsFromXmlUrl($url)
    {
      //check url for accessibility
      $Headers = @get_headers($url);
      if (preg_match("|200|", $Headers[0])) {
        $menu = simplexml_load_file($url);
        return $menu;
      } else {
        return false;
      }
    }
    
    public static function createDir($dirName, $permissions = '0777')
    {
        if (!file_exists($dirName) || !is_dir($dirName))
        {
            mkdir($dirName);
            chmod($dirName, 0777);
        }
    }
    
    public static function removeDir($dirName)
    {
        if (file_exists($dirName) && is_dir($dirName))
        {
            rmdir($dirName);
        }
    }
    
/*    public static function getClientIP() {
        if (isset($_SERVER)) {

            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
                return $_SERVER["HTTP_X_FORWARDED_FOR"];

            if (isset($_SERVER["HTTP_CLIENT_IP"]))
                return $_SERVER["HTTP_CLIENT_IP"];

            return $_SERVER["REMOTE_ADDR"];
        }

        if (getenv('HTTP_X_FORWARDED_FOR'))
            return getenv('HTTP_X_FORWARDED_FOR');

        if (getenv('HTTP_CLIENT_IP'))
            return getenv('HTTP_CLIENT_IP');

        return getenv('REMOTE_ADDR');
    }*/
     /**
     * функция определяет ip адрес по глобальному массиву $_SERVER
     * ip адреса проверяются начиная с приоритетного, для определения возможного использования прокси
     * @return ip-адрес
     */
    public static function getClientIP() {
        $ip = false;
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipa[] = trim(strtok($_SERVER['HTTP_X_FORWARDED_FOR'], ','));
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipa[] = $_SERVER['HTTP_CLIENT_IP'];       
        if (isset($_SERVER['REMOTE_ADDR']))
            $ipa[] = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_X_REAL_IP']))
            $ipa[] = $_SERVER['HTTP_X_REAL_IP'];
        
        // проверяем ip-адреса на валидность начиная с приоритетного.
        foreach($ipa as $ips) {
            //  если ip валидный обрываем цикл, назначаем ip адрес и возвращаем его
            if(Helper::is_valid_ip($ips)) {
                $ip = $ips;
                break;
            }
        }
        return $ip;
    }
    
     /**
     * функция для проверки валидности ip адреса
     * @param ip адрес в формате 1.2.3.4
     * @return bolean : true - если ip валидный, иначе false
     */
    public static function is_valid_ip($ip=null) {
        if(preg_match("#^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$#", $ip))
            return true; // если ip-адрес попадает под регулярное выражение, возвращаем true
        
        return false; // иначе возвращаем false
    }

    
    public static function getBrowser() {
        if (isset($_SERVER["HTTP_USER_AGENT"]) OR ($_SERVER["HTTP_USER_AGENT"] != "")) {
            $visitor_user_agent = $_SERVER["HTTP_USER_AGENT"];
        } else {
            $visitor_user_agent = "Unknown";
        }
        $bname = 'Unknown';
        $version = "0.0.0";
     
        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/', $visitor_user_agent) && !preg_match('/Opera/', $visitor_user_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/', $visitor_user_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/', $visitor_user_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/', $visitor_user_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/', $visitor_user_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/', $visitor_user_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } elseif (preg_match('/Seamonkey/', $visitor_user_agent)) {
            $bname = 'Seamonkey';
            $ub = "Seamonkey";
        } elseif (preg_match('/Konqueror/', $visitor_user_agent)) {
            $bname = 'Konqueror';
            $ub = "Konqueror";
        } elseif (preg_match('/Navigator/', $visitor_user_agent)) {
            $bname = 'Navigator';
            $ub = "Navigator";
        } elseif (preg_match('/Mosaic/', $visitor_user_agent)) {
            $bname = 'Mosaic';
            $ub = "Mosaic";
        } elseif (preg_match('/Lynx/', $visitor_user_agent)) {
            $bname = 'Lynx';
            $ub = "Lynx";
        } elseif (preg_match('/Amaya/', $visitor_user_agent)) {
            $bname = 'Amaya';
            $ub = "Amaya";
        } elseif (preg_match('/Omniweb/', $visitor_user_agent)) {
            $bname = 'Omniweb';
            $ub = "Omniweb";
        } elseif (preg_match('/Avant/', $visitor_user_agent)) {
            $bname = 'Avant';
            $ub = "Avant";
        } elseif (preg_match('/Camino/', $visitor_user_agent)) {
            $bname = 'Camino';
            $ub = "Camino";
        } elseif (preg_match('/Flock/', $visitor_user_agent)) {
            $bname = 'Flock';
            $ub = "Flock";
        } elseif (preg_match('/AOL/', $visitor_user_agent)) {
            $bname = 'AOL';
            $ub = "AOL";
        } elseif (preg_match('/AIR/', $visitor_user_agent)) {
            $bname = 'AIR';
            $ub = "AIR";
        } elseif (preg_match('/Fluid/', $visitor_user_agent)) {
            $bname = 'Fluid';
            $ub = "Fluid";
        } else {
            $bname = 'Unknown';
            $ub = "Unknown";
        }
     
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $visitor_user_agent, $matches)) {
            // we have no matching number just continue
        }
     
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($visitor_user_agent, "Version") < strripos($visitor_user_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }
     
        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }
     
        return array(
            'userAgent' => $visitor_user_agent,
            'name' => $bname,
            'version' => $version,
            'pattern' => $pattern
        );
    }
    
    public static function getOS()
    {
        $browser = $_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/Linux/',$browser)) $os = 'Linux';
        elseif(preg_match('/Win/',$browser)) $os = 'Windows';
        elseif(preg_match('/Mac/',$browser)) $os = 'Mac';
        else $os = 'UnKnown';
        return $os;
    }
    
    public static function getUri()
    {
        return explode('/', $_SERVER['REQUEST_URI']);
    }
    
    public static function returnUrlToArray()
    {
        return explode('/', Yii::app()->user->returnUrl);
    }
    
    public static function urlReferrerToArray()
    {
        return explode('/', Yii::app()->getRequest()->getUrlReferrer());
    }
    
    public static function urlHasAdminWord()
    {
        $match=preg_match('/\badmin\b/', Yii::app()->getRequest()->getUrlReferrer(), $matches);
        return ($match==1) ? true : false;
    }        
            
    public static function CheckUrl($string) {
        if(CHttpRequest::getUrlReferrer()) {
            $fromPage = CHttpRequest::getUrlReferrer();
        } else {
            return false;
        }
        if (strpos($fromPage, $string)){
            $pos = strpos($fromPage, $string);
            if($pos)
                return substr($fromPage,$pos+1);
            else 
                return false;
        } else {
            return false;
        }
    }
        
    public static function isAdminUrl()
    {
        return Helper::urlHasAdminWord();
    }
    
    /**
    * returns current time;
    * 
    */
    public static function getCurrentTime()
    {
        return new CDbExpression('NOW()');
    }
    
    public static function LocateByIp($ip, $timeout=1) {
     $ret = array('country'=> '', 'state'=> '', 'city'=> '');  //'flag'=>'UNKNOWN', 
     if (!is_string($ip) || strlen($ip) < 1 || $ip == '127.0.0.1' || $ip == 'localhost') {$ip = '93.74.60.82';}    /// Ukraine, Kiev
    
     $curlopt_useragent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)';
     $url = 'http://ipinfodb.com/ip_locator.php?ip=' . urlencode($ip);
     $ch = curl_init();
     
     $curl_opt = array(
        CURLOPT_FOLLOWLOCATION => 0,
        CURLOPT_HEADER => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_USERAGENT => $curlopt_useragent,
        CURLOPT_URL => $url,
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_REFERER => 'http://' . $_SERVER['HTTP_HOST'],
     );
     
     curl_setopt_array($ch, $curl_opt);
     $content = curl_exec($ch);
     ///if (!is_null($curl_info)) { $curl_info = curl_getinfo($ch); }
     curl_close($ch);

     if ( preg_match('{<li>Country : (\\w*)\\b}i', $content, $regs) ) { $ret['country'] = $regs[1]; }
     if ( preg_match('{<li>City : ([^<]*)</li>}i', $content, $regs) ) { $ret['city'] = $regs[1]; }
     if ( preg_match('{<li>State/Province : ([^<]*)</li>}i', $content, $regs) ) { $ret['state'] = $regs[1]; }
     ///  str_replace( '/img', 'http://ipinfodb.com/img', 
     return $ret; 
    }
    
  }
?>

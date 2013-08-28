<?php



class SysLogger extends Yii ////YiiBase
{
    
    private static $_logger;

    public function __construct()
    {
/*        $this->setPagination(new Pagination);

        if(($id=$this->getId())!='')
        {
            $this->setPagination(array(
                'sizeVar'=>$id.'_size',
            ));
        }*/

       ///self::getLogger()->attachEventHandler('onFlush',array($this,'collectLogs'));     ///!!!!!!!!
       ///   echo "construct";     die;
       /// parent::__construct();
    }
    
    /**
     * Writes a trace message.
     * This method will only log a message when the application is in debug mode.
     * @param string $msg message to be logged
     * @param string $category category of the message
     * @see log
     */
    public static function trace($msg,$category='application')
    {
        if(YII_DEBUG)
            self::log($msg,CLogger::LEVEL_TRACE,$category);
    }

    /**
     * Logs a message.
     * Messages logged by this method may be retrieved via {@link CLogger::getLogs}
     * and may be recorded in different media, such as file, email, database, using
     * {@link CLogRouter}.
     * @param string $msg message to be logged
     * @param string $level level of the message (e.g. 'trace', 'warning', 'error'). It is case-insensitive.
     * @param string $category category of the message (e.g. 'system.web'). It is case-insensitive.
     */    
    public static function log($msg,$level=CLogger::LEVEL_INFO,$category='application', $data=array() )
    {
        if(self::$_logger===null)
            self::$_logger=new Logger;   ///CLogger; 
                
        if(YII_DEBUG && YII_TRACE_LEVEL>0 && $level!==CLogger::LEVEL_PROFILE)
        {
            $traces=debug_backtrace();
            $count=0;
            foreach($traces as $trace)
            {
                if(isset($trace['file'],$trace['line']) && strpos($trace['file'],YII_PATH)!==0)
                {
                    $msg.="\nin ".$trace['file'].' ('.$trace['line'].')';
                    if(++$count>=YII_TRACE_LEVEL)
                        break;
                }
            }
        }
        
        
        ///$syslogger = new SysLogger;
        self::$_logger->log($msg,$level,$category, $data);
        //self::getLogger()->attachEventHandler('onFlush',array(self,'collectLogs'));   ///self
        ///echo "<pre><br>";     print_r(self::$_logger);      die;
        //self::getLogger()->flush(true);
        
    }   
    
     /**
     * @return Logger message logger
     */
    public static function getLogger()
    {
        if(self::$_logger!==null)
            return self::$_logger;
        else
            return self::$_logger=new Logger;
    }

    /**
     * Sets the logger object.
     * @param Logger $logger the logger object.
     * @since 1.1.8
     */
    public static function setLogger($logger)
    {
        self::$_logger=$logger;
    } 

}
?>

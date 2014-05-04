<?php

/**
 * Session Class
 *
 * Session Class
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/DB-Wrapper.html
 */

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

define('SESSION_NAME', APPLICATION_NAME . '_SESS');

class Session
{
	public		$CookieExpirationDays = 5;
	private		$SessionPrefix = SESSION_NAME;
	
	/**
    * Class Constructor, initializing Session
    *
    * @return   void
    */
    public function __construct()
    {
        $this->SessionSetup();
	}	
	
	/**
    * Session Setup
    *
    * This method sets the session security info.  It should be called FIRST and only by
    * the class {@link __construct()} method.
    *
    * @return   void
    */
    private function SessionSetup()
    {
        if(!isset($_SESSION))
        {
            //$dir_path = ini_get('session.save_path') . DIRECTORY_SEPARATOR . _SESSION_DIR;
            //if(!is_dir($dir_path)) mkdir($dir_path);
			
			if( ini_set('session.save_path', SESSION_PATH) !== false )
			{   
				if( ini_get('session.use_trans_sid') == true)
				{
					ini_set('url_rewriter.tags'     , '');
					ini_set('session.use_trans_sid' , false);
				}
				
				$lifetime = 60 * 60 * 24 * $this->CookieExpirationDays;
				ini_set('session.gc_maxlifetime'  , $lifetime);
				ini_set('session.gc_divisor'      , '1');
				ini_set('session.gc_probability'  , '1');
				ini_set('session.cookie_lifetime' , '0');
			}
            session_name(SESSION_NAME);
            session_start();
        }
        $this->Algorithm = function_exists('hash') && in_array('sha256', hash_algos()) ? 'sha256' : NULL;
    }
	
	public function Set($SessionKey, $SessionValue)
	{
		$_SESSION[$this->SessionPrefix . '_' . $SessionKey] = $SessionValue;
	}
	
	public function Get($SessionKey)
	{
		if(isset($_SESSION[$this->SessionPrefix . '_' . $SessionKey]))
		return $_SESSION[$this->SessionPrefix . '_' . $SessionKey];
		else return NULL;
	}
	
	/**
    * Regenerate Session ID
    *
    * This is used to regenerate the session id.
    * It will delete the old session file automatically.
    *
    * @param    void
    * @return   void
    */
    protected function RegenerateSessionID()
    {
        // I *think* if the parameter is NULL or false, the session info (such as session filename)
        // can be stored in the database and then restored on successful login.
        session_regenerate_id(true); // Requires PHP => 5.1
    }
	
	/**
    * Destroy Session
    *
    * This is used to detroy the user session when called.
    *
    * @param    void
    * @return   void
    */
    protected function Destroy()
    {
        if(isset($_SESSION)) $_SESSION = array();
        if(isset($_COOKIE[session_name()])) setcookie(session_name(), '', time() -40000);
        @session_destroy();
        return;
    }
}


?>
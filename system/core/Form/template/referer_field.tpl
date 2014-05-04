<?php

/**
 * User Class
 *
 * User Class
 *
 * @package		VNP
 * @subpackage	Base libraries
 * @author		VNP Dev team
 * @category	Base layer
 * @link		http://vnphp.com/docs/base-layer/libraries/DB-Wrapper.html
 */

if( !defined('VNP_SYSTEM') && !defined('VNP_APPLICATION') ) die('Access denied!');

class User extends Session
{
	/**
    * Secure Key - (This should be changed for security reasons!)
    */
    private $SecurityKey = 'SECUREDSALT_';
    private $UseUserAgent = true;
    
   /**
    * IP Block Length (change this to add extra session securty)
    *
    * @param    integer
    */
    private $IPBlockLength = 4;
    
   /**
    * Algorithm
    * @var      string
    */
    private $Algorithm;
	private $LoggedCheckingSessionName = '_UserLoggedUniqueID';
	private $IsLoggedSessionName = 'IsLogged';
	private $Debug = false;
    
    public function __construct()
    {
    }
		
	public function CheckLogin( $username, $password )
    {
		$GetUser = DB::Query('users')
							->GroupWhere('CheckUsername', function($Q) use ($username) {
								$Q->Where('username', '=', $username)->_OR()
								  ->Where('email', '=', $username);
							})
							->Get();
		if($GetUser->status && $GetUser->num_rows == 1)
		{
			require SYSTEM_PATH . 'core/User/PasswordHash.php';
			$_Hasher =  new PasswordHash(8, FALSE);
			if($_Hasher->CheckPassword($password, $GetUser->Result[0]['password'])) {
				$_SESSION[$this->IsLoggedSessionName] = true;
				unset($GetUser->Result[0]['password']);
				$_SESSION['UserInfo'] = $GetUser->Result[0];
			}
			Helper::Notify('error', 'Wrong password!');
		}
		Helper::Notify('error', 'User not found!');
    }
	
	static function GeneratePassword($pass) {
		require SYSTEM_PATH . 'core/User/PasswordHash.php';
		$_Hasher = new PasswordHash(8, FALSE);
		return $_Hasher->HashPassword($pass);
	}
	
	/**
    * Set Login Session
    *
    * This method sets the session variables for a valid login.  This should be called
    * after login details have been varified, which at this 
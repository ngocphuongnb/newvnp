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
    * after login details have been varified, which at this point should only be by the
    * {@link user_login()} method.
    *
    * @param    array           An array containing the user's details.
    * @return   bool            'true' if successful, 'false' if not
    * @access   protected
    */
    protected function SetLoggedUserData( $values )
    {
        $this->RegenerateSessionID();
        $_SESSION[$this->LoggedCheckingSessionName] = $this->UniqueKeyGenerator();
        
        $_SESSION['uid']       = $values['id'];
        $_SESSION['username']  = htmlspecialchars($values['username']);
        $_SESSION[$this->IsLoggedSessionName] = true;
        
        if(!session_id() && DEBUG)
            trigger_error('There is no session id!  Make sure session_start() is being called first!', E_USER_WARNING);
        
        return true;
    }
	
	/**
    * User Logout
    *
    * Logs the user out by calling the {@link Destroy()} method.  Simple as that.
    *
    * @param    void
    * @return   void
    * @access   public
    */
    public function Logout()
    {
        $this->Destroy();
    }
	
	 /**
    * Is User Logged In
    *
    * This checks the current user's SESSION data to see if the user is logged in and
    * if not, it will return false.
    *
    * @param    void
    * @return   bool        'true' if they are logged in, 'false' if not
    * @access   public
    */
    public function IsLogged()
    {
        if(isset($_SESSION[$this->IsLoggedSessionName]) && $_SESSION[$this->IsLoggedSessionName]) return true;
		else return false;
    }
	
   /**
    * Make UniqueKey
    *
    * This creates a unique key for the user that is used to validate the $_SESSION.
    * It combines the {@link $SecurityKey} property, the user agent, and however many "blocks"
    * of the IP address specified by the {@link $IPBlockLength} property to form a unique string
    * that is then converted to an encrypted hash.
    *
    * It will be assigned to the $_SESSION[$this->LoggedCheckingSessionName] key and used for validating the SESSION.
    * To further secure it, change the value of {@link $SecurityKey} to something unique.
    *
    * @param    void
    * @return   string      An encrypted hash either 30(MD5), 40(sha1), or 64(hash) characters long
    *                       depending on which encryption function is used.
    */
    private function UniqueKeyGenerator()
    {
        $uniquekey = $this->SecurityKey;
        if( $this->UseUserAgent ) $uniquekey .= $_SERVER['HTTP_USER_AGENT'];
        
        // Compile and dissect the user's IP address
        $uniquekey .= implode('.', array_slice(explode('.', $_SERVER['REMOTE_ADDR']), 0, $this->IPBlockLength));
        
        // Fallback to sha1 or md5 if hash() function doesn't exist
        if($this->Algorithm === NULL) return function_exists('sha1') ? sha1($uniquekey) : md5($uniquekey);
        
        return hash($this->Algorithm, $uniquekey);
    }
    
   /**
    * Validate UniqueKey
    *
    * This validates the current uniquekey to ensure it is valid.
    *
    * @param    void
    * @return   bool
    * @access   protected
    */
    protected function ValidateLoggedUniqueKey()
    {
        $this->RegenerateSessionID();
        
        if(isset($_SESSION[$this->LoggedCheckingSessionName]))
			return $_SESSION[$this->LoggedCheckingSessionName] === $this->UniqueKeyGenerator();
        
        if(ENVIRONMENT == 'develop' || $this->Debug) echo '_UniqueKey is not set!';
        return false;
    }
	
	public function AddUuser( $username, $password )
    {
        $username = trim($username); // Remove any extra whitespace
        $password = trim($password);
        if(strlen($username) < 1 || strlen($password) < 1) return false;
        
        extract($this->EncryptPassword($password));
        
		$I = array(	'username'	=> $username,
					'password'	=> $password,
					'email'		=> '',
					'pattern'	=> $pattern,
					'salt1'		=> $salt1,
					'salt2'		=> $salt2,
					'status'	=> 1
				);
        return DB::Query('user_base')->Insert($I);
    }
}

?>
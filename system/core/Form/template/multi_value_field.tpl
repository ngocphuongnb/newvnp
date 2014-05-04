ION[$this->LoggedCheckingSessionName] key and used for validating the SESSION.
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
    * @return 
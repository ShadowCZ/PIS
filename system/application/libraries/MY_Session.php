<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Extended Session class
 * @author Radim Res
 */
class MY_Session extends CI_Session {
    private $debug_session = false;

    function __construct() {
        $CI =& get_instance();
        if ( $CI->input->cookie('sessionDebug') )  {
            $this->debug_session = true;
        }
        
        if ($this->debug_session) echo "session: construct<br>";
        
        if( !isset($_SESSION) ) session_start();
        parent::__construct();
    }


    /**
     * @desc Read session
     * @author Radim Res
     * @access Public
     * @param void
     * @return void
     */
    function sess_read() {
        if ($this->debug_session) echo "session: read<br>";
        
        if (! isset($_SESSION)) return FALSE;

        $session = $_SESSION;
        
        if ((isset($session['last_activity']) && $session['last_activity'] + $this->sess_expiration) < $this->now)
        {
                $this->sess_destroy();
                return FALSE;
        }

        // Does the IP Match?
        if ($this->sess_match_ip == TRUE AND $session['ip_address'] != $this->CI->input->ip_address())
        {
                $this->sess_destroy();
                return FALSE;
        }

        // Does the User Agent Match?
        if ($this->sess_match_useragent == TRUE AND trim($session['user_agent']) != trim(substr($this->CI->input->user_agent(), 0, 50)))
        {
                $this->sess_destroy();
                return FALSE;
        }

        // Session is valid!
        $this->userdata = $session;
        unset($session);

        return TRUE;
    }    
    
    /**
     * @desc Save session
     * @author Radim Res
     * @access Public
     * @param void
     * @return void
     */
    public function sess_write() {
        if ($this->debug_session) echo "session: write<br>";
        
        $_SESSION = $this->userdata;
    }

    /**
     * @desc Create session
     * @author Radim Res
     * @access Public
     * @param void
     * @return void
     */
    public function sess_create() {
        if ($this->debug_session) echo "session: create<br>";

        $sessid = '';
        while (strlen($sessid) < 32)
        {
                $sessid .= mt_rand(0, mt_getrandmax());
        }

        // To make the session ID even more secure we'll combine it with the user's IP
        $sessid .= $this->CI->input->ip_address();

        $this->userdata = array(
                                                'session_id' 	=> md5(uniqid($sessid, TRUE)),
                                                'ip_address' 	=> $this->CI->input->ip_address(),
                                                'user_agent' 	=> substr($this->CI->input->user_agent(), 0, 50),
                                                'last_activity'	=> $this->now
                                                );

        $this->sess_write();
    }
 
    /**
     * @desc Update session
     * @author Radim Res
     * @access Public
     * @param void
     * @return void
     */
    public function sess_update() {
        if ($this->debug_session) echo "session: update<br>";
        
        // We only update the session every five minutes by default
        if (($this->userdata['last_activity'] + $this->sess_time_to_update) >= $this->now)
        {
                return;
        }

        // Save the old session id so we know which record to
        // update in the database if we need it
        $old_sessid = $this->userdata['session_id'];
        $new_sessid = '';
        while (strlen($new_sessid) < 32)
        {
                $new_sessid .= mt_rand(0, mt_getrandmax());
        }

        // To make the session ID even more secure we'll combine it with the user's IP
        $new_sessid .= $this->CI->input->ip_address();

        // Turn it into a hash
        $new_sessid = md5(uniqid($new_sessid, TRUE));

        // Update the session data in the session data array
        $this->userdata['session_id'] = $new_sessid;
        $this->userdata['last_activity'] = $this->now;

        $this->sess_write();
    }
    
    
    /**
     * @desc Session destroy
     * @author Radim Res
     * @access Public
     * @param void
     * @return void
     */
    public function sess_destroy() {
        // disable destroy, because asynchronously received data (AJAX) need session always
        // comentor: Radim Res
        
        //if ($this->debug_session) echo "session: destroy<br>";
        
        //if ( isset($_SESSION) ) session_destroy();
    }

}
?>

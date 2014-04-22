<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @desc Parent Controller
 * @author Radim Res
  */
class MY_Controller extends CI_Controller {

    /**
     * @desc   $aJavascriptFiles - list of javascript files included to view of the controller
     * @var    string
     * @access Protected
     */
    protected $aJavascriptFiles = array();
    /**
     * @desc   $aCssFiles - list of CSS files included to view of the controller
     * @var    string
     * @access Protected
     */
    protected $aCssFiles = array();
    
    /**
     * @desc   Class Constructor
     * @access Public
     * @param  void
     * @return void
     */
    public function __construct($_internal_call = false) {
        if ( $_internal_call )
            $this->_assign_ic_attributes();
        
        parent::__construct();
        $this->s->assign('bLogout', false);

        $this->load->database();
        $this->load->model(array('memployee'));
        
        $this->load->helper( array( 'show_message' ) );
        if ($this->session->flashdata( 'severity' ) ) {
            show_message($this->session->flashdata( 'severity' ), $this->session->flashdata( 'title' ));
        }

        if ( $this->input->cookie('ci_profiler_on') ) {
            $this->output->enable_profiler( TRUE );
        }
        $this->s->assign( 'sActiveUserName', $this->session->userdata('user_name') );
        
        $this->s->assign( 'aMainMenu', $this->getMenu( 'main' ) );
        $this->s->assign( 'aAdminMenu', $this->getMenu( 'admin' ) );
        
        if ($this->input->post('validation_errors')) {
            $this->s->assign('validation_errors', $this->input->post('validation_errors'));
        }
        $aDateFormats = $this->config->item('dateformats');
//      $this->s->assign('sDatepickerDateFormat', isset($aDateFormats['phpToDatepicker'][$this->muser->dateFormat]) ? $aDateFormats['phpToDatepicker'][$this->muser->dateFormat] : 'yy-mm-dd');
//      $this->s->assign('sSmartyDateFormat', isset($aDateFormats['phpToSmarty'][$this->muser->dateFormat]) ? $aDateFormats['phpToSmarty'][$this->muser->dateFormat] : '%Y-%m-%d %R');

        //add the general css
        array_push( $this->aCssFiles, 'jquery-ui-custom', 'style', 'global' );
        //add the general js 
        // or is possible add jquery-1.5.2.min jquery-ui-1.8.11.custom.min
        array_push( $this->aJavascriptFiles, 'jquery-1.5.2.min', 'global', 'jquery-ui-1.8.11.custom.min' );
    }
    
    private function _assign_ic_attributes() {
        $CI =& get_instance();
   		foreach (array_keys(get_object_vars($CI)) as $key)
		{
			if ( ! isset($this->$key))
			{			
				// In some cases using references can cause
				// problems so we'll conditionally use them
				$this->$key = $CI->$key;
			}
		}
    }
    
    /**
     * @desc redirects to uri baring a text message and its severity 0 - common message, 1 - error
     * @access Public
     * @param string $uri
     * @param string $message
     * @param int $severity
     * @return void
     */
    public function redirect($uri, $sTitle, $mSeverity = 0) {
    	$this->session->set_flashdata('title', $sTitle);
        $this->session->set_flashdata('severity', $mSeverity);
    	redirect($uri, 'location');
    }

    /**
     * 
     * @desc rewrites page to uri with $_POST from the current page using curl extension.
     * @access Public
     * @param string $uri
     * @return void
     */
    public function redirectPost($controller, $method, $id = NULL) {

        $this->s->assign('validation_errors', validation_errors());

        if (NULL !== $id) {
            $this->$method($id);
        } else {
            $this->$method();
        }


        /**
          $this->s->assign('validation_errors', validation_errors()); // validation_errors());

          $postfields = 'validation_errors=' . validation_errors();
          foreach ( $_POST as $key => $value) {
          $postfields .= '&' . $key . '=' . $value;
          }

          $ch = curl_init( site_url( $uri ) );
          curl_setopt( $ch, CURLOPT_POST, 1);
          curl_setopt( $ch, CURLOPT_POSTFIELDS, $postfields);
          curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt( $ch, CURLOPT_HEADER, 0);
          curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
          $page = curl_exec($ch);


          header("Content-Type: text/html");
          echo $page;
          //echo $temp_output;
          //echo ob_get_clean();

          curl_close( $ch );
         * */
    }

    /**
     * @desc calls $this->Log->log() to create a log in db
     * @access Public
     * @param int $iType
     * @param int $iSev
     * @param string $DsDump
     * @param int $iTick
     * @return void
     */
    public function log($iType, $iSev, $sDump, $iTick = null) {
        $this->mlog->tlog($iType, $iSev, $sDump, $iTick = null);
    }
    
    /**
     * @desc   Action of unauthenticated operation, shows
     * @access Public
     * @param  void
     * @return void
     */
    public function accessdenied(){
        
        $this->s->assign( 'last_permited_access' , $this->session->userdata('last_permited_access') );
        $this->s->display( 'dsp_access_denied.php' );
        exit;
    }
    
    public function getMenu( $sMenu ) {
        switch ( $sMenu ) {
            case 'main' :
                /**
                 * TODO: add rights
                 */
                //if ( $this->muser->checkRight( 'ET_C_CTICKET_SHOWMY' ) )
                /*
                $aMenu[] = array( 'href' => site_url( 'cparcel/register' ), 'label' => _('Register a parcel at reception') );
                $aMenu[] = array( 'href' => site_url( 'corder/search' ), 'label' => _('To key a return') );
                $aMenu[] = array( 'href' => site_url( 'cprocess/search' ), 'label' => _('Process pending products') );
                $aMenu[] = array( 'href' => site_url( 'cadmin/index' ), 'label' => _('Customer / Warehouse configuration') );
                */
             break;
            case 'admin' : // admin submenu
                /**
                 * Dont need meanwhile
                 */
             break;
        }
        
        if ( isset( $aMenu ) )
            return (array) $aMenu;
        
        return NULL;
    }
    

}
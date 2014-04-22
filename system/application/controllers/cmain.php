<?php  if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}
/**
 * Controller for main page
 * 
 * @author Radim Res
 * @package banka
 * @version 0.1.1.0
 */

class CMain extends MY_Controller{

    public function __construct($_internal_call = false) {
        parent::__construct($_internal_call);
    }

	// tato metoda se provede pokud je request cmain/
    public function index() {
        if( $this->session->userdata('login') == 1) {
            $this->showBlank();
        } else {
            $this->showLogin();
        }
    }

	// prázdný formulář po přihlášení
	// TODO: dle role zobrazit příslušné menu
    public function showBlank() {
        $this->s->displayWithHeader('dsp_blank.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
	// zobrazí formulář pro přihlášení
    public function showLogin() {
        $this->s->displayWithHeader('dsp_login.php', $this->aJavascriptFiles, $this->aCssFiles );
    }

	// submit přihlášení
    public function doLogin() {
        $this->load->model(array('memployee'));
        $this->memployee->login = $this->input->post('login');
        $this->memployee->pass = $this->input->post('pass');

        if ($this->memployee->authentication() && $this->memployee->isActive()) {
            $this->memployee->lastIp = $_SERVER['REMOTE_ADDR'];
            $this->memployee->update();

            $aSession = array(
                'login' => 1,
                'user_id' => $this->memployee->ID,
                'user_name' => $this->memployee->name . " " . $this->memployee->surname,
// Dočasná ukázka jak pracujeme s ORM
//                'player_id' => $this->muser->player->ID,
//                'ally_id' => $this->muser->player->ally->ID,
                'role_id' => $this->memployee->role,
            );
			// nastaví session
            $this->session->set_userdata($aSession);
            redirect('cmain/', 'location');
        } else {
            // TODO: chybová hláška
            $this->showLogin();
        }
    }
    
	// odhlášení ze systému
    public function logout() {
        $this->session->set_userdata(array (
            'login' => 0,
            'user_name' => "",
        ));
        
        // TODO: hláška odhlášení
        $this->showLogin();
    }
}

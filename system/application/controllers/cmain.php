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
            switch ($this->session->userdata('role')) {
                case 1:
                    redirect('cadmin/', 'location');
                    break;
                case 2:
                    redirect('cadvice/', 'location');
                    break;
                case 3:
                    redirect('coperation/', 'location');
                    break;
                case 4:
                    redirect('ctransaction/', 'location');
                    break;
                default:    
                    $this->showBlank();
                    break;
            }
        } else {
            $this->showLogin();
        }
    }

	// prázdný formulář po přihlášení
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
                'role' => $this->memployee->role->ID,
            );
			// nastaví session
            $this->session->set_userdata($aSession);
            $this->redirect('cmain/', 'Úspěšně přihlášen', 1);
        } else {
            $this->redirect('cmain/', 'Špatné přihlašovací údaje', 2);
        /*
            if ($this->memployee->isActive()) {
                $this->redirect('cmain/', 'Špatné přihlašovací údaje', 2);
            } else {
                $this->redirect('cmain/', 'Uživatel nebyl aktivován', 2);
            }
        */
        }
    }
    
	// odhlášení ze systému
    public function logout() {
        $this->session->set_userdata(array (
            'login' => 0,
            'user_name' => "",
            'role' => "",
        ));
        
        $this->redirect('cmain/', 'Úspěšně odhlášen', 1);
    }
}

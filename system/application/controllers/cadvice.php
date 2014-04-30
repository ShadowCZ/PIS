<?php  if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}
/**
 * Controller for main page
 * 
 * @author Tomas Smetka
 * @package banka
 * @version 0.1.1.0
 */

class CAdvice extends MY_Controller{

    public function __construct($_internal_call = false) {
        parent::__construct($_internal_call);
        $this->load->model(array('maccount', 'maccounttype', 'mclient', 'mdelegatedperson'));
    }

    public function index() {
        $this->showClientList();
    }
    
	// zobrazí přehled klientů
    public function showClientList() {
        $aClients = $this->mclient->getAll();
        $this->s->assign('aClients', $aClients);
        $this->s->displayWithHeader('dsp_client_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
	// zobrazí formulář pro vytvoření nového klienta
    public function showClientCreate() {
        $this->s->displayWithHeader('dsp_client.php', $this->aJavascriptFiles, $this->aCssFiles );
    }    

        // zobrazí formulář pro vytvoření nového bankovního účtu pro zvoleného klienta
    public function showAccountCreate($iClient) {
        $oClient = $this->mclient->getById($iClient);
        $this->s->assign('oClient', $oClient);
        $this->s->displayWithHeader('dsp_account.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
        // zobrazí formulář pro editaci klienta
    public function showAccountList($iClient = 0, $sAccountFilter = "") {
        if ($iClient > 0) {
            $oAccounts = $this->maccount->getClientAccounts($iClient);
        }

        /*
        $oClient = $this->mclient->getById($iClient);
        $this->s->assign('oClient', $oClient);
        $this->s->displayWithHeader('dsp_client', $this->aJavascriptFiles, $this->aCssFiles );
    */
      }      
         
    
        // zobrazí formulář pro editaci klienta
    public function showClient($iClient=0) {
        $oClient = $this->mclient->getById($iClient);
        $this->s->assign('oClient', $oClient);
        $this->s->displayWithHeader('dsp_client.php', $this->aJavascriptFiles, $this->aCssFiles );
    }    
     
	// zrušení bankovního účtu příslušného uživatele
    public function removeAccount($iAccount) {
        $this->maccount->delete($iAccount);
        redirect('cadvice/showAccountList/'.$iClient, 'location');
    }
}

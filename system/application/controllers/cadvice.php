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
        $this->load->model(array('maccount', 'maccounttype', 'mclient', 'mdelegatedperson', 'moperation'));
    }

    public function index() {
        $this->showClientList();
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
        $aAccounts = $this->maccount->getClientAccounts($iClient, $sAccountFilter);

        $this->s->assign('aAccounts', $aAccounts);
        $this->s->displayWithHeader('dsp_account_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }      
    
	// zobrazí přehled klientů
    public function showClientList() {
        $aClients = $this->mclient->getAll();
        
        $this->s->assign('aClients', $aClients);
        $this->s->displayWithHeader('dsp_client_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    } 
  
        // zobrazí formular pro editaci klienta
    public function showClientEdit($iClient) {
        $oClient = $this->mclient->getById($iClient);
        
        $this->s->assign('oClient', $oClient);
        $this->s->displayWithHeader('dsp_client.php', $this->aJavascriptFiles, $this->aCssFiles );
    }   

        // zobrazí detail uctu, seznam delegovanych osob, seznam operaci uctu
    public function showAccountDetail($iAccount) {
        $oAccount = $this->maccount->getById($iAccount);
        $aPersons = $this->mdelegatedperson->getByAccount($iAccount);
        $aOperations = $this->moperation->getByAccount($iAccount); 
        
        $this->s->assign('oAccount', $oAccount);
        $this->s->assign('aPersons', $aPersons);
        $this->s->assign('aOperations', $aOperations);
        $this->s->displayWithHeader('dsp_account_detail.php', $this->aJavascriptFiles, $this->aCssFiles );
    }

        // zobrazí formulář pro editaci účtu a jeho delegovaných osob
    public function showAccountEdit($iAccount) {
        $oAccount = $this->maccount->getById($iAccount);
        $aPersons = $this->mdelegatedperson->getByAccount($iAccount);
        
        $this->s->assign('oAccount', $oAccount);
        $this->s->assign('aPersons', $aPersons);
        $this->s->displayWithHeader('dsp_account.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
        // zobrazí formulář pro úpravu limitu delegované osoby
        // pokud neni zadano ID klienta, jsou k uctu vypsany vsechny delegovane osoby
    public function showDelegatedPerson($iAccount, $iClient = 0) {
        $aPersons = array();
        if ($iClient > 0) {
            $aPersons = $this->mdelegatedperson->getByAccountAndClient($iAccount, $iClient);
        } else {
            $aPersons = $this->mdelegatedperson->getByAccount($iAccount);
        }
        $oAccount = $this->maccount->getById($iAccount);
        
        $this->s->assign('oAccount', $oAccount);
        $this->s->assign('aPersons', $aPersons);
        $this->s->displayWithHeader('dsp_delegated_person.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
        // funkce vytvori noveho klienta
    public function createClient() {
        if ($this->input->post('name')) {
            $this->mclient->name = $this->input->post('name');
        }  
        if ($this->input->post('surname')) {
            $this->mclient->surname = $this->input->post('surname');
        }         
        if ($this->input->post('address1')) {
            $this->mclient->address1 = $this->input->post('address1');
        }        
        if ($this->input->post('address2')) {
            $this->mclient->address2 = $this->input->post('address2');
        }    
        if ($this->input->post('postalCode')) {
            $this->mclient->postalCode = $this->input->post('postalCode');
        }            
        if ($this->input->post('personalNumber')) {
            $this->mclient->personalNumber = $this->input->post('personalNumber');
        } 
        if ($this->input->post('tel')) {
            $this->mclient->tel = $this->input->post('tel');
        } 
        if ($this->input->post('email')) {
            $this->mclient->email = $this->input->post('email');
        } 

        $iClient = $this->mclient->update();
        redirect('cadvice/showAccountCreate/'.$iClient, 'location');
    }    

            // funkce vytvori noveho ucet
    public function createAccount($iClient) {
        if ($this->input->post('type')) {
            $this->maccount->type = $this->input->post('type');
        }  
        if ($this->input->post('client')) {
            $this->maccount->client = $iClient;
        }         
        if ($this->input->post('number')) {
            $this->maccount->number = $this->input->post('number');
        }        
        if ($this->input->post('value')) {
            $this->maccount->value = 0;
        }
        if ($this->input->post('availableValue')) {
            $this->maccount->availableValue = 0;
        }  
        
        $this->maccount->update();
        redirect('cadvice/showAccountList/'.$iClient, 'location');
    }    
    
        // funkce updatuje zadaneho klienta
    public function updateClient($iClient) {
        $this->mclient = $this->mclient->getById($iClient);

        if ($this->input->post('name')) {
            $this->mclient->name = $this->input->post('name');
        }  
        if ($this->input->post('surname')) {
            $this->mclient->surname = $this->input->post('surname');
        }         
        if ($this->input->post('address1')) {
            $this->mclient->address1 = $this->input->post('address1');
        }        
        if ($this->input->post('address2')) {
            $this->mclient->address2 = $this->input->post('address2');
        }    
        if ($this->input->post('postalCode')) {
            $this->mclient->postalCode = $this->input->post('postalCode');
        }            
        if ($this->input->post('personalNumber')) {
            $this->mclient->personalNumber = $this->input->post('personalNumber');
        } 
        if ($this->input->post('tel')) {
            $this->mclient->tel = $this->input->post('tel');
        } 
        if ($this->input->post('email')) {
            $this->mclient->email = $this->input->post('email');
        } 

        $this->mclient->update();
        redirect('cadvice/showClientList/'.iClient, 'location');
    } 
    
            // funkce updatuje zvoleny ucet
    public function updateAccount($iAccount) {
        $this->maccount = $this->maccount->getById($iAccount);
        
        if ($this->input->post('type')) {
            $this->maccount->type = $this->input->post('type');
        }  
        if ($this->input->post('client')) {
            $this->maccount->client = $this->input->post('client');
        }         
        if ($this->input->post('number')) {
            $this->maccount->number = $this->input->post('number');
        }        
        if ($this->input->post('value')) {
            $this->maccount->value = $this->input->post('value');
        }
        if ($this->input->post('availableValue')) {
            $this->maccount->availableValue = $this->input->post('availableValue');
        }  
        
        $this->maccount->update();
        redirect('cadvice/showAccountList/'.$iClient, 'location');
    }   
    
    // zobrazí formulář s editací účtu
    public function showAccount($iAccount = 0) {
        $oAccount = $this->maccount->getById($iAccount);
        $aAccountTypes = $this->maccounttype->getAll();
        $aPersons = $this->mdelegatedperson->getByAccount($iAccount);
        $aClients = $this->mclient->getAll();
        
        $this->s->assign('aClients', $aClients);
        $this->s->assign('aPersons', $aPersons);
        $this->s->assign('oAccount', $oAccount);
        $this->s->assign('aType', $aAccountTypes);
        $this->s->displayWithHeader('dsp_account_edit.php', $this->aJavascriptFiles, $this->aCssFiles );
    }  
            
        // zobrazí formulář pro editaci klienta
    public function showClient($iClient=0) {
        if ($iClient > 0) {
            $oClient = $this->mclient->getById($iClient);
        } else {
            $oClient = $this->mclient;
        }
        
        $this->s->assign('oClient', $oClient);
        $this->s->displayWithHeader('dsp_client.php', $this->aJavascriptFiles, $this->aCssFiles );
    }    

        // vypise seznam vsech klientu, kteri odpovidaji zadanemu filtru
    public function showClientSelect($iAccount, $sClientFilter = "") {
        $oAccout = $this->maccount->getById($iAccount);
        $aPersons = $this->mclient->getFilteredClients($sClientFilter);
        $this->s->assign('oAccount', $oAccout);
        $this->s->assign('aPersons', $aPersons);
        $this->s->displayWithHeader('dsp_client_select.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
        // prida delegovanou osobu k uctu
    public function addDelegatedPerson($iAccount, $iClient = 0) {
    /*
        if ($iClient == 0) {
             redirect('cadvice/showClientSelect/'.$iAccount, 'location');
        }
    */
        if ($this->input->post('newPerson') === false) {
            redirect('cadvice/showAccount/'.$iAccount, 'location');
        }
    
        //$this->mdelegatedperson->client = $iClient;
        $this->mdelegatedperson->client = $this->input->post('newPerson');
        $this->mdelegatedperson->account = $iAccount;
        $this->mdelegatedperson->limit = $this->input->post('newLimit');
        $this->mdelegatedperson->update();
        redirect('cadvice/showAccount/'.$iAccount, 'location');
    } 
    
    // update limitu delegovane osoby
    public function updateDelegatedPerson($iDelegatedPerson) {
        $this->mdelegatedperson = $this->mdelegatedperson->getById($iDelegatedPerson);   
        if ($this->input->post('limit')) {
            $this->mdelegatedperson->limit = $this->input->post('limit');
        }
        
        $iAccount = $this->mdelegatedperson->account;
        $this->mdelegatedperson->update();
        
        redirect('cadvice/showAccountDetail/'.$iAccount, 'location');
    }
    
    // update limitu delegovane osoby
    public function updateDelegatedPersons() {
        $aLimits = $this->input->post('limit');

        if ($aLimits === false) {
            redirect('cadvice/showAccountDetail/'.$iAccount, 'location');
        }
        
        foreach($aLimits as $iPerson => $iLimit) {
            $this->mdelegatedperson = $this->mdelegatedperson->getById($iPerson);
            $this->mdelegatedperson->limit = $iLimit;
            $this->mdelegatedperson->update();
        }
 
        $iAccount = $this->mdelegatedperson->account;
        
        redirect('cadvice/showAccount/'.$iAccount, 'location');
    } 
    
	// zrušení bankovního účtu příslušného uživatele
    public function removeAccount($iAccount) {
        $iClient = $this->maccount->getAccountOwner($iAccount);
        $this->maccount->delete($iAccount);
        
        redirect('cadvice/showAccountList/'.$iClient, 'location');
    }
    
    // odstrani delegovanou osobu
    public function removeDelegatedPerson($iDelegatedPerson) {
        $this->mdelegatedperson = $this->mdelegatedperson->getById($iDelegatedPerson);
        $iAccount = $this->mdelegatedperson->account;
        $this->mdelegatedperson->delete();
        
        redirect('cadvice/showAccount/'.$iAccount, 'location');
        //redirect('cadvice/showAccountDetail/'.$iAccount, 'location');
    }
}

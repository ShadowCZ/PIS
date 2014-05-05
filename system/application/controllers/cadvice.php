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
        $this->s->displayWithHeader('dsp_client_create.php', $this->aJavascriptFiles, $this->aCssFiles );
    }   
    
    // zobrazí formulář pro vytvoření nového bankovního účtu pro zvoleného klienta
    public function showAccountCreate($iClient) {
        $oClient = $this->mclient->getById($iClient);
        $aTypes = $this->maccounttype->getAll();
        
        $this->s->assign('oClient', $oClient);
        $this->s->assign('aTypes', $aTypes);
        $this->s->displayWithHeader('dsp_account.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
     
    // zobrazí formulář pro editaci klienta
    public function showAccountList($iClient = 0, $sAccountFilter = "") {
        $aAccounts = $this->maccount->getClientAccounts($iClient, $sAccountFilter);

        $this->s->assign('iClient', $iClient);
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
    
    // funkce pro vytvoření nového klienta
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
        $this->redirect('cadvice/showAccountCreate/'.$iClient, 'Klient úspěšně vytvořen', 1);
    }    

    // funkce pro vytvoření nového účtu
    public function createAccount($iClient) {
        if ($this->input->post('type')) {
            $this->maccount->type = $this->input->post('type');
        }  

        $this->maccount->client = $iClient;
      
        if ($this->input->post('number')) {
            $this->maccount->number = $this->input->post('number');
        }        
        if ($this->input->post('value')) {
            $this->maccount->value = $this->input->post('value');
        }

        $this->maccount->availableValue = $this->input->post('value');
        
        $this->maccount->update();
        $this->redirect('cadvice/showAccountList/'.$iClient, 'Účet úspěšně vytvořen', 1);
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
        $this->redirect('cadvice/showClientList/'.iClient, 'Klient úspěšně upraven', 1);
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
        $this->redirect('cadvice/showAccountList/'.$iClient, 'Účet úspěšně upraven', 1);
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
             $this->redirect('cadvice/showClientSelect/'.$iAccount, 'location');
        }
    */
        $iClient = $this->input->post('newPerson');
        if ($iClient === false) {
            $this->redirect('cadvice/showAccount/'.$iAccount, 'Klient nevybrán', 3);
        }
        
        if ($this->mdelegatedperson->getByAccountAndClient($iAccount, $iClient) !== false) {
            $this->redirect('cadvice/showAccount/'.$iAccount, 'Osoba již byla pověřena', 2);
        }
    
        $this->mdelegatedperson->client = $iClient;
        $this->mdelegatedperson->account = $iAccount;
        $this->mdelegatedperson->limit = $this->input->post('newLimit');
        $this->mdelegatedperson->update();
        $this->redirect('cadvice/showAccount/'.$iAccount, 'Osoba úspěšně pověřena', 1);
    } 
    
    // update limitu delegovane osoby
    public function updateDelegatedPerson($iDelegatedPerson) {
        $this->mdelegatedperson = $this->mdelegatedperson->getById($iDelegatedPerson);   
        if ($this->input->post('limit')) {
            $this->mdelegatedperson->limit = $this->input->post('limit');
        }
        
        $iAccount = $this->mdelegatedperson->account;
        $this->mdelegatedperson->update();
        
        $this->redirect('cadvice/showAccountDetail/'.$iAccount, 'Limit úspěšně upraven', 1);
    }
    
    // update limitu delegovane osoby
    public function updateDelegatedPersons() {
        $aLimits = $this->input->post('limit');

        if ($aLimits === false) {
            $this->redirect('cadvice/showAccountDetail/'.$iAccount, 'Limity nemohly být nastaveny', 2);
        }
        
        foreach($aLimits as $iPerson => $iLimit) {
            $this->mdelegatedperson = $this->mdelegatedperson->getById($iPerson);
            $this->mdelegatedperson->limit = $iLimit;
            $this->mdelegatedperson->update();
        }
 
        $iAccount = $this->mdelegatedperson->account;
        
        $this->redirect('cadvice/showAccount/'.$iAccount, 'Limity byly úspěšně upraveny', 1);
    } 
    
	// zrušení bankovního účtu příslušného uživatele
    public function removeAccount($iAccount) {
        $iClient = $this->maccount->getAccountOwner($iAccount);
        $this->maccount->delete($iAccount);
        
        $this->redirect('cadvice/showAccountList/'.$iClient, 'Účet úspěšně odstraněn', 1);
    }
    
    	// odstraneni uzivatele ze systemu
    public function removeClient($iClient) {
        $oClient = $this->mclient->getById($iClient);
        $oClient->delete();
        
        $this->redirect('cadvice/showClientList/', 'Klient úspěšně odstraněn', 1);
    }
    
    // odstrani delegovanou osobu
    public function removeDelegatedPerson($iDelegatedPerson) {
        $this->mdelegatedperson = $this->mdelegatedperson->getById($iDelegatedPerson);
        $iAccount = $this->mdelegatedperson->account;
        $this->mdelegatedperson->delete();
        
        $this->redirect('cadvice/showAccount/'.$iAccount, 'Pověřená osoba byla úspěšně odebrána', 1);
        //$this->redirect('cadvice/showAccountDetail/'.$iAccount, 'location');
    }
}

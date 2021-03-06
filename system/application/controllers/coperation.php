<?php  if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}
/**
 * Controller for main page
 * 
 * @author Radim Res
 * @package banka
 * @version 0.1.1.0
 */

class COperation extends MY_Controller{

    public function __construct($_internal_call = false) {
        parent::__construct($_internal_call);
        
        if( $this->session->userdata('login') != 1) {
            $this->redirect('cmain/', 'Nejste přihlášen', 2);
        }

        if( $this->session->userdata('role') != 3 && $this->session->userdata('role') != 1 ) {
            $this->redirect('cmain/', 'Nemáte oprávnění', 2);
        }
  
        $this->load->model(array('memployee', 'mrole', 'mclient', 'maccount', 'maccounttype', 'mdelegatedperson', 'moperation', 'moperationtype'));
        
        $aMenu = array();
        $aMenu[] = array( 'href' => site_url( 'coperation/showClientList' ), 'label' => 'Klienti' );
        $aMenu[] = array( 'href' => site_url( 'coperation/showAccountList' ), 'label' => 'Účty' );
        if ($this->session->userdata('role') == 1) {
            $aMenu[] = array( 'href' => site_url( 'cadmin/' ), 'label' => 'Zpět' );
        }
        $this->s->assign('aMenu', $aMenu);
    }

    public function index() {
        $this->showClientList();
    }
    
    // Zobrazí přehled klientů
    public function showClientList() {
        $aClients = $this->mclient->getAll();
        
        $this->s->assign('aClients', $aClients);
        $this->s->assign('iActiveMenu', 0);
        $this->s->displayWithHeader('operation/dsp_client_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
    // Zobrazí přehled účtů
    public function showAccountList($iClient = 0, $sAccountFilter = "") {
        $aAccounts = $this->maccount->getClientAccounts($iClient, $sAccountFilter);

        $this->s->assign('aAccounts', $aAccounts);
        $this->s->assign('iActiveMenu', 1);
        $this->s->displayWithHeader('operation/dsp_account_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }  
    
    // Zobrazí přehled delegovaných osob
    public function showDelegatedPersonList($iAccount=0) {
        if ($iAccount == 0) {
            $this->redirect('coperation/showAccountList', 'Nebyl zvolen bankovní účet', 3);
        }
        $aPersons = $this->mdelegatedperson->getByAccount($iAccount);
        
        $this->s->assign('aPersons', $aPersons);
        $this->s->assign('iActiveMenu', 1);
        $this->s->displayWithHeader('operation/dsp_delegated_person_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }

    // Zobrazí detail účtu s limetem pověřené osoby a se zbylou částkou, kterou může vybrat
    public function showAccountDetail($iAccount=0, $iPerson=0) {
        if ($iAccount == 0) {
            $this->redirect('coperation/showAccountList', 'Nebyl zvolen bankovní účet', 3);
        }
        if ($iPerson == 0) {
            $this->redirect('coperation/showAccountList', 'Nebyl zvolen uživatel', 3);
        }
        $oAccount = $this->maccount->getById($iAccount);
        $oPerson = $this->mdelegatedperson->getById($iPerson);
        $aOperations = $this->moperation->getLastOperations($iPerson, 30);
        $iAvailableCash = $this->moperation->getAvailableCashInLimit($iPerson, 7);
        
        $this->s->assign('oAccount', $oAccount);
        $this->s->assign('oPerson', $oPerson);
        $this->s->assign('aOperations', $aOperations);
        $this->s->assign('iAvailableCash', $iAvailableCash);
        $this->s->assign('iActiveMenu', 1);
        $this->s->displayWithHeader('operation/dsp_account_detail.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
    // Zobrazí formulář pro vložení / vybrání částky
    public function showOperation($iAccount=0, $iPerson=0, $iAction=0) {
        if ($iAccount == 0) {
            $this->redirect('coperation/showAccountList', 'Nebyl zvolen bankovní účet', 3);
        }
        if ($iPerson == 0) {
            $this->redirect('coperation/showAccountList', 'Nebyl zvolen uživatel', 3);
        }
        if ($iAction == 0) {
            $this->redirect('coperation/showAccountList', 'Nebyla zvolena akce', 3);
        }
        $oAccount = $this->maccount->getById($iAccount);
        $oPerson = $this->mdelegatedperson->getById($iPerson);
        $iAvailableCash = $this->moperation->getAvailableCashInLimit($iPerson, 7);

        $this->s->assign('iAction', $iAction);
        $this->s->assign('oAccount', $oAccount);
        $this->s->assign('oPerson', $oPerson);
        $this->s->assign('iAvailableCash', $iAvailableCash);
        $this->s->assign('iActiveMenu', 1);
        $this->s->displayWithHeader('operation/dsp_operation.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
    // Zobrazí formulář pro převod částky z účtu na účet
    public function showTransfer($iAccount=0, $iPerson=0) {
        if ($iAccount == 0) {
            $this->redirect('coperation/showAccountList', 'Nebyl zvolen bankovní účet', 3);
        }
        if ($iPerson == 0) {
            $this->redirect('coperation/showAccountList', 'Nebyl zvolen uživatel', 3);
        }
        $oAccount = $this->maccount->getById($iAccount);
        $oPerson = $this->mdelegatedperson->getById($iPerson);
        $iAvailableCash = $this->moperation->getAvailableCashInLimit($iPerson, 7);

        $this->s->assign('oAccount', $oAccount);
        $this->s->assign('oPerson', $oPerson);
        $this->s->assign('iAvailableCash', $iAvailableCash);
        $this->s->assign('iActiveMenu', 1);
        $this->s->displayWithHeader('operation/dsp_transfer.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
    // Provede výběr
    public function doWithdraw($iAccount, $iPerson) {
        $iValue = $this->input->post('value');
        if ($iValue < 100) {
            $this->redirect('coperation/showOperation/' . $iAccount . '/' . $iPerson . '/2', 'Minimální výběr je 100,-', 2);
        }
        
        $iAvailableCash = $this->moperation->getAvailableCashInLimit($iPerson, 7);
        if ($iValue > $iAvailableCash) {
            $this->redirect('coperation/showOperation/' . $iAccount . '/' . $iPerson . '/2', 'Překročen týdenní limit. Dostupné: '. $iAvailableCash, 2);
        }
    
        $this->moperation->delegatedPerson = $iPerson;
        $this->moperation->account = $iAccount;
        $this->moperation->employee = $this->session->userdata('user_id');
        $this->moperation->type = 1;
        $this->moperation->value = $iValue;
        $this->moperation->update();

        $this->maccount = $this->maccount->getById($iAccount);
        $this->maccount->value -= $iValue;
        $this->maccount->availableValue -= $iValue;
        $this->maccount->update();
        
        $this->redirect('coperation/showAccountDetail/' . $iAccount . '/' . $iPerson, 'Transakce proběhla úspěšně', 1);
    }

    // Provede vklad
    public function doDeposit($iAccount, $iPerson) {
        $iValue = $this->input->post('value');
        if ($iValue < 100) {
            $this->redirect('coperation/showOperation/' . $iAccount . '/' . $iPerson . '/1', 'Minimální vklad je 100,-', 2);
        }

        $this->moperation->delegatedPerson = $iPerson;
        $this->moperation->account = $iAccount;
        $this->moperation->employee = $this->session->userdata('user_id');
        $this->moperation->type = 2;
        $this->moperation->value = $iValue;
        $this->moperation->update();

        $this->maccount = $this->maccount->getById($iAccount);
        $this->maccount->value += $iValue;
        $this->maccount->availableValue += $iValue;
        $this->maccount->update();
        
        $this->redirect('coperation/showAccountDetail/' . $iAccount . '/' . $iPerson, 'Transakce proběhla úspěšně', 1);
    }
    
    // Provede převod
    public function doTransfer($iAccount, $iPerson) {
        $iValue = $this->input->post('value');
        if ($iValue < 100) {
            $this->redirect('coperation/showTransfer/' . $iAccount . '/' . $iPerson, 'Minimální převod je 100,-');
        }

        $iAvailableCash = $this->moperation->getAvailableCashInLimit($iPerson, 7);
        if ($iValue > $iAvailableCash) {
            $this->redirect('coperation/showTransfer/' . $iAccount . '/' . $iPerson, 'Překročen týdenní limit. Dostupné: '. $iAvailableCash, 2);
        }
        
        $this->moperation->delegatedPerson = $iPerson;
        $this->moperation->account = $iAccount;
        $this->moperation->employee = $this->session->userdata('user_id');
        $this->moperation->type = 3;
        $this->moperation->value = $iValue;
        $this->moperation->targetAccount = $this->input->post('targetAccount');
        $this->moperation->bank = $this->input->post('bank');
        $this->moperation->VS = $this->input->post('VS');
        $this->moperation->SS = $this->input->post('SS');
        $this->moperation->CS = $this->input->post('CS');
        $this->moperation->message = $this->input->post('message');
        $this->moperation->update();

        $this->maccount = $this->maccount->getById($iAccount);
        $this->maccount->availableValue -= $iValue;
        $this->maccount->update();
    
        $this->redirect('coperation/showAccountDetail/' . $iAccount . '/' . $iPerson, 'Transakce proběhla úspěšně', 1);
    }
}

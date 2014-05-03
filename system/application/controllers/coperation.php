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
        $this->load->model(array('memployee', 'mrole', 'mclient', 'maccount', 'maccounttype', 'mdelegatedperson', 'moperation', 'moperationtype'));
    }

    public function index() {
        $this->showClientList();
    }
    
    // Zobrazí přehled klientů
    public function showClientList() {
        $aClients = $this->mclient->getAll();
        
        $this->s->assign('aClients', $aClients);
        $this->s->displayWithHeader('operation\dsp_client_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
    // Zobrazí přehled účtů
    public function showAccountList($iClient = 0, $sAccountFilter = "") {
        $aAccounts = $this->maccount->getClientAccounts($iClient, $sAccountFilter);

        $this->s->assign('aAccounts', $aAccounts);
        $this->s->displayWithHeader('operation\dsp_account_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }  
    
    // Zobrazí přehled delegovaných osob
    public function showDelegatedPersonList($iAccount) {
        $aPersons = $this->mdelegatedperson->getByAccount($iAccount);
        
        $this->s->assign('aPersons', $aPersons);
        $this->s->displayWithHeader('operation\dsp_delegated_person_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }

    // Zobrazí detail účtu s limetem pověřené osoby a se zbylou částkou, kterou může vybrat
    public function showAccountDetail($iAccount, $iPerson) {
        $oAccount = $this->maccount->getById($iAccount);
        $oPerson = $this->mdelegatedperson->getById($iPerson);
        $aOperations = $this->moperation->getLastOperations($iPerson, 30);
        $iAvailableCash = $this->moperation->getAvailableCashInLimit($iPerson, 7);
        
        $this->s->assign('oAccount', $oAccount);
        $this->s->assign('oPerson', $oPerson);
        $this->s->assign('aOperations', $aOperations);
        $this->s->assign('iAvailableCash', $iAvailableCash);
        $this->s->displayWithHeader('operation\dsp_account_detail.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
    // Zobrazí formulář pro vložení / vybrání částky
    public function showOperation($iAccount, $iPerson, $iAction) {
        $oAccount = $this->maccount->getById($iAccount);
        $oPerson = $this->mdelegatedperson->getById($iPerson);
        $iAvailableCash = $this->moperation->getAvailableCashInLimit($iPerson, 7);

        $this->s->assign('iAction', $iAction);
        $this->s->assign('oAccount', $oAccount);
        $this->s->assign('oPerson', $oPerson);
        $this->s->assign('iAvailableCash', $iAvailableCash);
        $this->s->displayWithHeader('operation\dsp_operation.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
    // Zobrazí formulář pro převod částky z účtu na účet
    public function showTransfer($iAccount, $iPerson) {
        $oAccount = $this->maccount->getById($iAccount);
        $oPerson = $this->mdelegatedperson->getById($iPerson);
        $iAvailableCash = $this->moperation->getAvailableCashInLimit($iPerson, 7);

        $this->s->assign('oAccount', $oAccount);
        $this->s->assign('oPerson', $oPerson);
        $this->s->assign('iAvailableCash', $iAvailableCash);
        $this->s->displayWithHeader('operation\dsp_transfer.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
    // Provede výběr
    public function doWithdraw($iAccount, $iPerson) {
        $iValue = $this->input->post('value');
        if ($iValue < 1) {
            // TODO: error message
            redirect('coperation/showOperation/' . $iAccount . '/' . $iPerson . '/2', 'location');
        }
    
        $this->moperation->delegatedPerson = $iPerson;
        $this->moperation->account = $iAccount;
        $this->moperation->employee = $this->session->userdata('user_id');
        $this->moperation->type = 2;
        $this->moperation->value = $iValue;
        $this->moperation->update();

        $this->maccount = $this->maccount->getById($iAccount);
        $this->maccount->value -= $iValue;
        $this->maccount->availableValue -= $iValue;
        $this->maccount->update();
        
        redirect('coperation/showAccountDetail/' . $iAccount . '/' . $iPerson, 'location');
    }

    // Provede vklad
    public function doDeposit($iAccount, $iPerson) {
        $iValue = $this->input->post('value');
        if ($iValue < 1) {
            // TODO: error message
            redirect('coperation/showOperation/' . $iAccount . '/' . $iPerson . '/1', 'location');
        }
    
        $this->moperation->delegatedPerson = $iPerson;
        $this->moperation->account = $iAccount;
        $this->moperation->employee = $this->session->userdata('user_id');
        $this->moperation->type = 1;
        $this->moperation->value = $iValue;
        $this->moperation->update();

        $this->maccount = $this->maccount->getById($iAccount);
        $this->maccount->value += $iValue;
        $this->maccount->availableValue += $iValue;
        $this->maccount->update();
        
        redirect('coperation/showAccountDetail/' . $iAccount . '/' . $iPerson, 'location');
    }
    
    // Provede převod
    public function doTransfer($iAccount, $iPerson) {
        $iValue = $this->input->post('value');
        if ($iValue < 1) {
            // TODO: error message
            redirect('coperation/showTransfer/' . $iAccount . '/' . $iPerson, 'location');
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
    
        redirect('coperation/showAccountDetail/' . $iAccount . '/' . $iPerson, 'location');
    }
}

<?php  if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}
/**
 * Controller for main page
 * 
 * @author Tomas Smetka
 * @package banka
 * @version 0.1.1.0
 */

class CTransaction extends MY_Controller{

    public function __construct($_internal_call = false) {
        parent::__construct($_internal_call);
        $this->load->model(array('maccount', 'moperation', 'mclient'));
    }

    public function index() {
        
        $hit = $_SESSION['user_id'];
        echo $hit;
        //$this->showClientList();
    }

    	// zobrazí seznam vsech transakci filtrovanych podle vlastnika uctu, cisla uctu a datumu
    public function showTransferList($iClient = 0, $iAccount = 0, $fromDate = null, $toDate = null)  {
        if ($this->input->post('client')) {
            $iClient = $this->input->post('client');
        }
        if ($this->input->post('account')) {
            $iAccount = $this->input->post('account');
        } 
        if ($this->input->post('fromDate')) {
            $fromDate = $this->input->post('fromDate');
        } 
        if ($this->input->post('toDate')) {
            $toDate = $this->input->post('toDate');
        } 
        
        $aAccounts = array();
        if ($iClient > 0) {
            $aAccounts = $this->maccount->getClientAccounts($iClient, "");
        }
        $aTransfers = $this->moperation->getTransfersByAccountAndDate($iAccount, $fromDate, $toDate);
        $this->s->assign('aAccounts', $aAccounts);
        $this->s->assign('aTransfers', $aTransfers);
        $this->s->displayWithHeader('dsp_transfer_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }   
    
        // zobrazí formulář pro vytvoření nového bankovního účtu pro zvoleného klienta
    public function  showOperationList($iClient = 0, $iAccount = 0, $fromDate = null, $toDate = null) {
        if ($this->input->post('client')) {
            $iClient = $this->input->post('client');
        }
        if ($this->input->post('account')) {
            $iAccount = $this->input->post('account');
        } 
        if ($this->input->post('fromDate')) {
            $fromDate = $this->input->post('fromDate');
        } 
        if ($this->input->post('toDate')) {
            $toDate = $this->input->post('toDate');
        } 
        
        $aAccounts = array();
        if ($iClient > 0) {
            $aAccounts = $this->maccount->getClientAccounts($iClient, "");
        }
        $aOperations = $this->moperation->getOperationsByAccountAndDate($iAccount, $fromDate, $toDate);
        $this->s->assign('aAccounts', $aAccounts);
        $this->s->assign('aOperations', $aOperations);
        $this->s->displayWithHeader('dsp_operation_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
     
    
        // zobrazí formulář pro editaci klienta
    public function showTransactionDetail($iClient = 0, $iAccount = 0, $fromDate = null, $toDate = null, $iOperation) {
        if ($this->input->post('client')) {
            $iClient = $this->input->post('client');
        }
        if ($this->input->post('account')) {
            $iAccount = $this->input->post('account');
        } 
        if ($this->input->post('fromDate')) {
            $fromDate = $this->input->post('fromDate');
        } 
        if ($this->input->post('toDate')) {
            $toDate = $this->input->post('toDate');
        } 
        
        $oOperation = $this->moperation->getById($iOperation);
        
        $this->s->assign('oOperation', $oOperation);
        $this->s->assign('iClient', $iClient);
        $this->s->assign('iAccount', $iAccount);
        $this->s->assign('fromDate', $fromDate);
        $this->s->assign('toDate', $toDate);
        $this->s->displayWithHeader('dsp_transfer_detail.php', $this->aJavascriptFiles, $this->aCssFiles );        
    }      
    
	// zobrazí přehled klientů
    public function showAccountOwnerList($iClient = 0, $iAccount = 0, $fromDate = null, $toDate = null) {
        if ($this->input->post('client')) {
            $iClient = $this->input->post('client');
        }
        if ($this->input->post('account')) {
            $iAccount = $this->input->post('account');
        } 
        if ($this->input->post('fromDate')) {
            $fromDate = $this->input->post('fromDate');
        } 
        if ($this->input->post('toDate')) {
            $toDate = $this->input->post('toDate');
        } 
        
        $aClients = $this->mclient->getAll();
        
        $this->s->assign('aClients', $aClients);
        $this->s->assign('iClient', $iClient);
        $this->s->assign('iAccount', $iAccount);
        $this->s->assign('fromDate', $fromDate);
        $this->s->assign('toDate', $toDate);
        $this->s->displayWithHeader('dsp_account_owner_list.php', $this->aJavascriptFiles, $this->aCssFiles );       
    } 
  
        // zobrazí seznam vsech vlastniku uctu
    public function doAcceptTransfer($iClient = 0, $iAccount = 0, $fromDate = null, $toDate = null, $iOperation) {
        $oOperation = $this->moperation->getById($iOperation);
        $oOperation->state = 1;
        $oOperation->update();
        redirect('ctransaction/showTransferList/'.$iClient.'/'.$iAccount.'/'.$fromDate.'/'.$toDate, 'location');
    }   

        // zobrazí formulář pro editaci účtu a jeho delegovaných osob
    public function doRejectTransfer($iClient = 0, $iAccount = 0, $fromDate = null, $toDate = null, $iOperation) {
        $oOperation = $this->moperation->getById($iOperation);
        $oOperation->state = 2;
        $oOperation->update();
        redirect('ctransaction/showTransferList/'.$iClient.'/'.$iAccount.'/'.$fromDate.'/'.$toDate, 'location');
    }
    
        // zobrazí detail uctu, seznam delegovanych osob, seznam operaci uctu
    public function doExport($iClient = 0, $iAccount = 0, $fromDate = null, $toDate = null, $itype = 0) {

    }

}
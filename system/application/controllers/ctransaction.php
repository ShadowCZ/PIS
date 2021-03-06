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
        
        if( $this->session->userdata('login') != 1) {
            $this->redirect('cmain/', 'Nejste přihlášen', 2);
        }

        if( $this->session->userdata('role') != 4 && $this->session->userdata('role') != 1 ) {
            $this->redirect('cmain/', 'Nemáte oprávnění', 2);
        }
  
        $this->load->model(array('maccount', 'moperation', 'mclient'));
        
        $aMenu = array();
        $aMenu[] = array( 'href' => site_url( 'ctransaction/showOperationList' ), 'label' => 'Vklady / Výběry' );
        $aMenu[] = array( 'href' => site_url( 'ctransaction/showTransferList' ), 'label' => 'Převody' );
        if ($this->session->userdata('role') == 1) {
            $aMenu[] = array( 'href' => site_url( 'cadmin/' ), 'label' => 'Zpět' );
        }
        $this->s->assign('aMenu', $aMenu);
    }

    public function index() {
        $this->showOutstandingTransferList();
    }

    	// seznam vsech transakci (bez vkladu a vyberu)
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
        
        $aAccounts = $this->maccount->getAll();
        $aClients = $this->mclient->getAll();
        if ($iClient > 0) {
            $aAccounts = $this->maccount->getClientAccounts($iClient, "");
        }
        $aTransfers = array();
        if ($iAccount > 0) {
            $aTransfers = $this->moperation->getTransfersByAccountAndDate($iAccount, $fromDate, $toDate);
        }
        else {
            $aTransfers = $this->moperation->getTransfersByAccountAndDate(null, $fromDate, $toDate);
        }
        $this->s->assign('aAccounts', $aAccounts);
        $this->s->assign('aClients', $aClients);
        $this->s->assign('aTransfers', $aTransfers);
        $this->s->assign('iClient', $iClient);
        $this->s->assign('iAccount', $iAccount);
        $this->s->assign('fromDate', $fromDate);
        $this->s->assign('toDate', $toDate);
        $this->s->assign('iActiveMenu', 1);
        $this->s->displayWithHeader('dsp_transfer_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }   
    
        // seznam vsech operaci (transakce, vklady, vybery)
    public function showOperationList($iClient = 0, $iAccount = 0, $fromDate = null, $toDate = null) {
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
        
        $aAccounts = $this->maccount->getAll();
        $aClients = $this->mclient->getAll();
        if ($iClient > 0) {
            $aAccounts = $this->maccount->getClientAccounts($iClient, "");
        }
        if ($iClient > 0) {
            $aAccounts = $this->maccount->getClientAccounts($iClient, "");
        }
        $aOperations = array();
        if ($iAccount > 0) {
            $aOperations = $this->moperation->getOperationsByAccountAndDate($iAccount, $fromDate, $toDate);
        }
        else {
            $aOperations = $this->moperation->getOperationsByAccountAndDate(null, $fromDate, $toDate);
        }

        $this->s->assign('aAccounts', $aAccounts);
        $this->s->assign('aClients', $aClients);
        $this->s->assign('aOperations', $aOperations);
        $this->s->assign('iClient', $iClient);
        $this->s->assign('iAccount', $iAccount);
        $this->s->assign('fromDate', $fromDate);
        $this->s->assign('toDate', $toDate);
        $this->s->assign('iActiveMenu', 0);
        $this->s->displayWithHeader('dsp_operation_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
     
    
        // detail operace
    public function showTransactionDetail($iOperation=0, $iClient = 0, $iAccount = 0, $fromDate = null, $toDate = null) {
        if ($iOperation == 0) {
            $this->redirect('ctransaction/showTransferList/', 'Nebyla zvolena operace', 3);
        }
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
        $this->s->assign('iActiveMenu', 1);
        $this->s->displayWithHeader('dsp_transfer_detail.php', $this->aJavascriptFiles, $this->aCssFiles );        
    }      
    
	// seznam vsech vlastniku uctu
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
        $this->s->assign('iActiveMenu', 0);
        $this->s->displayWithHeader('dsp_account_owner_list.php', $this->aJavascriptFiles, $this->aCssFiles );       
    } 
  
        // schvaleni prevodu mezi ucty
    public function doAcceptTransfer($iClient = 0, $iAccount = 0, $fromDate = null, $toDate = null, $iOperation = 0) {
        if ($iOperation == 0) {
            $this->redirect('ctransaction/showTransferList/', 'Nebyla zvolena operace', 3);
        }
        $oOperation = $this->moperation->getById($iOperation);
        $oOperation->state = 1;
        $oOperation->employee = $_SESSION['user_id'];
        $oOperation->update();
        $this->redirect('ctransaction/showTransferList/'.$iClient.'/'.$iAccount.'/'.$fromDate.'/'.$toDate, 'Převod byl schválen', 1);
    }   

        // zamitnuti prevodu mezi ucty
    public function doRejectTransfer($iClient = 0, $iAccount = 0, $fromDate = null, $toDate = null, $iOperation=0) {
        if ($iOperation == 0) {
            $this->redirect('ctransaction/showTransferList/', 'Nebyla zvolena operace', 3);
        }
        $oOperation = $this->moperation->getById($iOperation);
        $oOperation->state = 2;
        $oOperation->employee = $_SESSION['user_id'];
        $oOperation->update();
        $this->redirect('ctransaction/showTransferList/'.$iClient.'/'.$iAccount.'/'.$fromDate.'/'.$toDate, 'Klient byl odmítnut', 1);
    }
    
        // vypis z uctu, podle promenne iType se rozhoduje o filtrovani transakci (1) nebo vsech operaci (0)
    public function doExport($iClient = 0, $iAccount = 0, $fromDate = null, $toDate = null, $iType = 0) {
        if ($iAccount == 0) {
            $this->redirect('ctransaction/showTransferList/', 'Nebyla zvolen bankovní účet', 3);
        }
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
        if ($this->input->post('type')) {
            $iType = $this->input->post('type');
        } 
        
        if ($iType == 0) {
            redirect('ctransaction/showOperationList/'.$iClient.'/'.$iAccount.'/'.$fromDate.'/'.$toDate, 'location');
        }
        else {
            redirect('ctransaction/showTransferList/'.$iClient.'/'.$iAccount.'/'.$fromDate.'/'.$toDate, 'location');
        }
    }
    
    	// seznam vsech nevyrizenych transakci (bez vkladu a vyberu)
    public function showOutstandingTransferList()  {
        $aAccounts = $this->maccount->getAll();
        $aClients = $this->mclient->getAll();
        $aTransfers = $this->moperation->getOutstandingTransfers();
        $this->s->assign('iClient', 0);
        $this->s->assign('iAccount', 0);
        $this->s->assign('fromDate', null);
        $this->s->assign('toDate', null);
        $this->s->assign('aTransfers', $aTransfers);
        $this->s->assign('aAccounts', $aAccounts);
        $this->s->assign('aClients', $aClients);
        $this->s->assign('iActiveMenu', 1);
        $this->s->displayWithHeader('dsp_transfer_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }  
      
    public function generateOperationsToPDF($iClient = 0, $iAccount = 0, $fromDate = null, $toDate = null)  { 
        if ($iAccount == 0) {
            $this->redirect('ctransaction/showOperationList/', 'Nebyla zvolen bankovní účet', 3);
        }
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
        if ($this->input->post('type')) {
            $iType = $this->input->post('type');
        }
        
        $rand = rand();
        $filename = md5($rand);
        $filename .= '.pdf';
        $pdfFilePath = 'download/'.$filename;
        
        // naplneni daty pro view
        $aOperations = $this->moperation->getOperationsByAccountAndDate($iAccount, $fromDate, $toDate);
        $oAccount = $this->maccount->getById($iAccount);
        $data['account_number'] = $oAccount->number;
        $data['from'] = $fromDate;
        $data['to'] = $toDate;
        $data['client'] = $oAccount->client->name . " " . $oAccount->client->surname . " (ID: " . $oAccount->client->ID . ")";
        $data['account_type'] = $oAccount->type->description;
        $data['operations'] = $aOperations;
        
        if (file_exists($pdfFilePath) == FALSE)
        {    
            ini_set('memory_limit','32M');
            $html = $this->load->view('pdf_operation', $data, true); // render the view into HTML
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->SetFooter('PIS'.'|{PAGENO}|'.date("Y-m-d H:i:s")); // Add a footer for good measure <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
            $pdf->WriteHTML($html); // write the HTML into the PDF
            $pdf->Output($pdfFilePath, 'D'); // send to download 
        }
            
        $this->showOperationList($iClient, $iAccount, $fromDate, $toDate);   
    }
    
    public function generateTransactionsToPDF($iClient = 0, $iAccount = 0, $fromDate = null, $toDate = null)  { 
        if ($iAccount == 0) {
            $this->redirect('ctransaction/showTransferList/', 'Nebyla zvolen bankovní účet', 3);
        }
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
        if ($this->input->post('type')) {
            $iType = $this->input->post('type');
        }
        
        $rand = rand();
        $filename = md5($rand);
        $filename .= '.pdf';
        $pdfFilePath = 'download/'.$filename;
        
        // naplneni daty pro view
        $aOperations = $this->moperation->getTransfersByAccountAndDate($iAccount, $fromDate, $toDate);
        $oAccount = $this->maccount->getById($iAccount);
        $data['account_number'] = $oAccount->number;
        $data['from'] = $fromDate;
        $data['to'] = $toDate;
        $data['client'] = $oAccount->client->name . " " . $oAccount->client->surname . " (ID: " . $oAccount->client->ID . ")";
        $data['account_type'] = $oAccount->type->description;
        $data['operations'] = $aOperations;
        
        if (file_exists($pdfFilePath) == FALSE)
        {    
            ini_set('memory_limit','32M');
            $html = $this->load->view('pdf_transaction', $data, true); // render the view into HTML
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->SetFooter('PIS'.'|{PAGENO}|'.date("Y-m-d H:i:s")); // Add a footer for good measure <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
            $pdf->WriteHTML($html); // write the HTML into the PDF
            $pdf->Output($pdfFilePath, 'D'); // send to download 
        }
            
        $this->showOperationList($iClient, $iAccount, $fromDate, $toDate);   
    }
}

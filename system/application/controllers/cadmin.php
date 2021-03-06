<?php  if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}
/**
 * Controller for admin page
 * 
 * @author Radim Res
 * @package banka
 * @version 0.1.1.0
 */

class CAdmin extends MY_Controller{

    public function __construct($_internal_call = false) {
        parent::__construct($_internal_call);
        
        if( $this->session->userdata('login') != 1) {
            $this->redirect('cmain/', 'Nejste přihláše', 2);
        }

        if( $this->session->userdata('role') != 1) {
            $this->redirect('cmain/', 'Nemáte oprávnění', 2);
        }
        $this->load->model(array('memployee', 'mrole'));
        
        $aMenu = array();
        $aMenu[] = array( 'href' => site_url( 'cadmin/showEmployeeList' ), 'label' => 'Zaměstnanci' );
        $aMenu[] = array( 'href' => site_url( 'cadvice/showClientList' ), 'label' => 'Finanční poradce' );
        $aMenu[] = array( 'href' => site_url( 'coperation/showClientList' ), 'label' => 'Zadání operace' );
        $aMenu[] = array( 'href' => site_url( 'ctransaction/showOperationList' ), 'label' => 'Transakce' );
        $this->s->assign('aMenu', $aMenu);
        $this->s->assign('iActiveMenu', 0);
    }

    public function index() {
        $this->showEmployeeList();
    }
    
	// zobrazí přehled zaměstnanců
    public function showEmployeeList() {
        $aEmployees = $this->memployee->getAll();
        $this->s->assign('aEmployees', $aEmployees);
        $this->s->displayWithHeader('dsp_employee_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }

	// zobrazí formulář pro editaci zaměstnanců
    public function showEmployee($iEmployee = 0) {
        if ($iEmployee == 0) {
            $this->redirect('cadmin/showEmployeeList', 'Nebyl vybrán zaměstnanec', 3);
        }
        if ($iEmployee > 0) {
            $oEmployee = $this->memployee->getById($iEmployee);
        } else {
            $oEmployee = $this->memployee;
        }
        
        $aRole = $this->mrole->getAll();

        $this->s->assign('aRole', $aRole);
        $this->s->assign('oEmployee', $oEmployee);
        $this->s->displayWithHeader('dsp_employee.php', $this->aJavascriptFiles, $this->aCssFiles );
    }
    
	// zobrazí formulář pro vytvoření nového zaměstnance
    public function createEmployee() {
        $aRole = $this->mrole->getAll();
        $this->s->assign('aRole', $aRole);
        $this->s->displayWithHeader('dsp_create_employee.php', $this->aJavascriptFiles, $this->aCssFiles );
    }

	// akce pro editaci a vytvoření nového zaměstnance
    public function updateEmployee($iEmployee = 0) {
        $sMSGAction = "vyvořen";
        if ($iEmployee > 0) {
            $this->memployee = $this->memployee->getById($iEmployee);
            $sMSGAction = "upraven";
        }
        
        if ($this->input->post('login')) {
            $this->memployee->login = $this->input->post('login');
        }
        if ($this->input->post('name')) {
            $this->memployee->name = $this->input->post('name');
        }
        if ($this->input->post('surname')) {
            $this->memployee->surname = $this->input->post('surname');
        }  
        if ($this->input->post('role')) {
            $this->memployee->role = $this->input->post('role');
        }
        if ($this->input->post('address1')) {
            $this->memployee->address1 = $this->input->post('address1');
        }
        if ($this->input->post('address2')) {
            $this->memployee->address2 = $this->input->post('address2');
        }
        if ($this->input->post('postalCode')) {
            $this->memployee->postalCode = $this->input->post('postalCode');
        }
        if ($this->input->post('tel')) {
            $this->memployee->tel = $this->input->post('tel');
        }                
        if ($this->input->post('password')) {
            $this->memployee->pass = $this->input->post('password');
        }         
        if ($this->input->post('email')) {
            $this->memployee->email = $this->input->post('email');
        }
        if ($this->input->post('active') !== false) {
            $this->memployee->active = $this->input->post('active');
        }

        $this->memployee->update();
        $this->redirect('cadmin/showEmployeeList/', 'Zaměstnanec úspěšně ' . $sMSGAction, 1);
    }

    
	// zobrazí formulář pro přihlášení
    public function removeEmployee($iEmployee = 0) {
        if ($iEmployee == 0) {
            $this->redirect('cadmin/showEmployeeList', 'Nebyla vybrán zaměstnanec', 3);
        }
        $this->memployee->delete($iEmployee);
        $this->redirect('cadmin/showEmployeeList/', 'Zaměstnanec úspěšně odebrán', 1);
    }
    
	// zobrazí přehled zaměstnanců
    public function AJAXGetEmployeeList() {
        $sFilter = $this->input->post('sFilter');
        $aEmployees = $this->memployee->getByFilter($sFilter);
        $this->s->assign('sFilter', $sFilter);
        $this->s->assign('aEmployees', $aEmployees);
        $this->s->display('AJAX/dsp_employee_list.php');
    }
}

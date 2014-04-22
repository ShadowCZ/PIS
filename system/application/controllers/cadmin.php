<?php  if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}
/**
 * Controller for main page
 * 
 * @author Radim Res
 * @package banka
 * @version 0.1.1.0
 */

class CAdmin extends MY_Controller{

    public function __construct($_internal_call = false) {
        parent::__construct($_internal_call);
        $this->load->model(array('memployee'));
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

	// zobrazí formulář pro editaci a vkládání nových zaměstnanců
    public function showEmployee($iEmployee = 0) {
        if ($iEmployee > 0) {
            $oEmployee = $this->memployee->getById($iEmployee);
        } else {
            $oEmployee = null;
        }
        $this->s->assign('oEmployee', $oEmployee);
        $this->s->displayWithHeader('dsp_employee.php', $this->aJavascriptFiles, $this->aCssFiles );
    }

	// akce pro editaci a vytvoření nového zaměstnance
    public function updateEmployee($iEmployee = 0) {
        if ($iEmployee > 0) {
            $oEmployee = $this->memployee->getById($iEmployee);
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
        if ($this->input->post('id_role')) {
            $this->memployee->role = $this->input->post('id_role');
        }
        if ($this->input->post('address1')) {
            $this->memployee->address1 = $this->input->post('address1');
        }
        if ($this->input->post('address2')) {
            $this->memployee->address2 = $this->input->post('address2');
        }
        if ($this->input->post('postal_code')) {
            $this->memployee->postalCode = $this->input->post('postal_code');
        }
        if ($this->input->post('telephone')) {
            $this->memployee->tel = $this->input->post('telephone');
        }                
        if ($this->input->post('password')) {
            $this->memployee->pass = $this->input->post('password');
        }         
        if ($this->input->post('email')) {
            $this->memployee->email = $this->input->post('email');
        }
        if ($this->input->post('active')) {
            $this->memployee->active = $this->input->post('active');
        }
        
        $this->memployee->update();
        redirect('cadmin/showEmployeeList/', 'location');
    }

    
	// zobrazí formulář pro přihlášení
    public function removeEmployee($iEmployee) {
        $this->memployee->delete($iEmployee);
        redirect('cadmin/showEmployeeList/', 'location');
    }
}

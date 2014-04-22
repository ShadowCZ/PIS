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
            $this->memployee->login = $this->input->post('name');
        }
        if ($this->input->post('surname')) {
            $this->memployee->login = $this->input->post('surname');
        }
        // TODO: další položky
        
        $this->memployee->update();
        redirect('cadmin/showEmployeeList/', 'location');
    }

    
	// zobrazí formulář pro přihlášení
    public function removeEmployee($iEmployee) {
        $this->memployee->remove($iEmployee);
        redirect('cadmin/showEmployeeList/', 'location');
    }
}

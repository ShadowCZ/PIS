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
    }
	// zobrazí přehled zaměstnanců
    public function showEmployeeList() {
        $this->s->displayWithHeader('dsp_employee_list.php', $this->aJavascriptFiles, $this->aCssFiles );
    }

	// zobrazí formulář pro editaci a vkládání nových zaměstnanců
    public function showEmployee($iEmployee = 0) {
        $this->s->displayWithHeader('dsp_employee.php', $this->aJavascriptFiles, $this->aCssFiles );
    }

	// akce pro editaci a vytvoření nového zaměstnance
    public function updateEmployee($iEmployee = 0) {
        redirect('cadmin/showEmployeeList/', 'location');
    }

    
	// zobrazí formulář pro přihlášení
    public function removeEmployee($iEmployee) {
        redirect('cadmin/showEmployeeList/', 'location');
    }
}

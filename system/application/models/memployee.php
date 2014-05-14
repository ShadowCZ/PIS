<?php  if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * Model for table employee
 * 
 * @author    Radim Res
 * @package   banka
 * @version   0.1.1.0
 */
class MEmployee extends MY_Model
{

    /**
     * Array of class attributes corresponding to columns in a table
     *
     * @access protected
     * @var    array
     */
    protected $_cols = array(
        'ID' => array(
            'column_name' => 'id_employee',
        ),
        'role' => array(
            'column_name' => 'id_role',
            'relationship' => array(
                'type' => 'has_one',
                'table' => 'role',
                'class' => 'MRole'
            )
        ),
        'name' => array(
            'column_name' => 'name',
        ),
        'surname' => array(
            'column_name' => 'surname',
        ),
        'address1' => array(
            'column_name' => 'address1',
        ),
        'address2' => array(
            'column_name' => 'address2',
        ),
        'postalCode' => array(
            'column_name' => 'postal_code',
        ),
        'tel' => array(
            'column_name' => 'telephone',
        ),
        'login' => array(
            'column_name' => 'login',
        ),
        'pass' => array(
            'column_name' => 'password',
        ),
        'email' => array(
            'column_name' => 'email',
        ),
        'active' => array(
            'column_name' => 'active',
        ),
        'lastIp' => array(
            'column_name' => 'last_ip',
        ),
    );
    
    /**
     * Table name
     *
     * @access protected
     * @var    string
     */
    protected $_base_table = 'employee';

    /**
     * Returns ID of row
     *
     * @access public
     * @return int
     */
    public function  __toString() {
        return $this->ID;
    }

    public function loginExist() {
    // TODO: šlo by použít active record
		$sql = "SELECT login
               FROM employee
               WHERE login='" . $this->login . "'";

        $resources = $this->db->query( $sql );
        if ($resources->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

	public function authentication() {
	// TODO: šlo by použít active record
         $sql = "SELECT *
               FROM employee
               WHERE login='" . $this->login . "' AND password='" . $this->pass . "'";

        $resources = $this->db->query( $sql );

        if (($row = current($resources->result())) == false) return false;
		
		$map = $this->getMap();
        foreach ($row as $key => $att) {
            $this->$map[$key] = $att;
        }
		
        return true;
    }
	
    public function isActive () {
        return $this->active == 1 ? true : false;
    }
    
    public function getByFilter($sFilter) {
        $map = $this->getMap();

        $sCond = " WHERE name LIKE '%" . $sFilter . "%' OR surname LIKE '%" . $sFilter . "%'";
        
        $sql = "SELECT * FROM employee";
        
        $sql .= $sCond;
      
        $resources = $this->db->query( $sql );

        $aEmployees = array();
        foreach ($resources->result() as $row) {
            $oEmployee = new MEmployee();
            foreach ($row as $key => $att) {
                $oEmployee->$map[$key] = $att;
            }
            $aEmployees[] = $oEmployee;
        }
        return $aEmployees;
    }
}
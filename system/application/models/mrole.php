<?php  if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * Model for table role
 * 
 * @author    Radim Res
 * @package   banka
 * @version   0.1.1.0
 */
class MRole extends MY_Model
{

    /**
     * Array of class attributes corresponding to columns in a table
     *
     * @access protected
     * @var    array
     */
    protected $_cols = array(
        'ID' => array(
            'column_name' => 'id_role',
        ),
        'name' => array(
            'column_name' => 'name',
        ),
        'desc' => array(
            'column_name' => 'description',
        ),
    );
    
    /**
     * Table name
     *
     * @access protected
     * @var    string
     */
    protected $_base_table = 'role';

    /**
     * Returns ID of role
     *
     * @access public
     * @return int
     */
    public function  __toString() {
        return $this->ID;
    }
}
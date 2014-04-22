<?php  if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * Model for table account_type
 * 
 * @author    Radim Res
 * @package   banka
 * @version   0.1.1.0
 */
class MAccountType extends MY_Model
{

    /**
     * Array of class attributes corresponding to columns in a table
     *
     * @access protected
     * @var    array
     */
    protected $_cols = array(
        'ID' => array(
            'column_name' => 'id_account_type',
        ),
        'name' => array(
            'column_name' => 'name',
        ),
        'description' => array(
            'column_name' => 'description',
        ),
    );
    
    /**
     * Table name
     *
     * @access protected
     * @var    string
     */
    protected $_base_table = 'account_type';

    /**
     * Returns ID of row
     *
     * @access public
     * @return int
     */
    public function  __toString() {
        return $this->ID;
    }
}
<?php  if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * Model for table account
 * 
 * @author    Radim Res
 * @package   banka
 * @version   0.1.1.0
 */
class MAccount extends MY_Model
{

    /**
     * Array of class attributes corresponding to columns in a table
     *
     * @access protected
     * @var    array
     */
    protected $_cols = array(
        'ID' => array(
            'column_name' => 'id_account',
        ),
        'type' => array(
            'column_name' => 'id_account_type',
            'relationship' => array(
                'type' => 'has_one',
                'table' => 'account_type',
                'class' => 'MAccountType'
            )
        ),
        'client' => array(
            'column_name' => 'id_client',
            'relationship' => array(
                'type' => 'has_one',
                'table' => 'client',
                'class' => 'MClient'
            )
        ),
        'number' => array(
            'column_name' => 'account_number',
        ),
        'value' => array(
            'column_name' => 'value',
        ),
        'avaibleValue' => array(
            'column_name' => 'avaibleValue',
        ),
    );
    
    /**
     * Table name
     *
     * @access protected
     * @var    string
     */
    protected $_base_table = 'account';

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
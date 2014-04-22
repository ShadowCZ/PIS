<?php  if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * Model for table delegated_person
 * 
 * @author    Radim Res
 * @package   banka
 * @version   0.1.1.0
 */
class MDelegatedPerson extends MY_Model
{

    /**
     * Array of class attributes corresponding to columns in a table
     *
     * @access protected
     * @var    array
     */
    protected $_cols = array(
        'ID' => array(
            'column_name' => 'id_delegate_person',
        ),
        'client' => array(
            'column_name' => 'id_client',
            'relationship' => array(
                'type' => 'has_one',
                'table' => 'client',
                'class' => 'MClient'
            )
        ),
        'account' => array(
            'column_name' => 'id_account',
            'relationship' => array(
                'type' => 'has_one',
                'table' => 'account',
                'class' => 'MAccount'
            )
        ),
        'limit' => array(
            'column_name' => 'value_limit',
        ),
    );
    
    /**
     * Table name
     *
     * @access protected
     * @var    string
     */
    protected $_base_table = 'delegated_person';

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
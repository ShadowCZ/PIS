<?php  if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * Model for table client
 * 
 * @author    Radim Res
 * @package   banka
 * @version   0.1.1.0
 */
class MClient extends MY_Model
{

    /**
     * Array of class attributes corresponding to columns in a table
     *
     * @access protected
     * @var    array
     */
    protected $_cols = array(
        'ID' => array(
            'column_name' => 'id_client',
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
        'personalNumber' => array(
            'column_name' => 'personal_number',
        ),
        'tel' => array(
            'column_name' => 'telephone',
        ),
        'email' => array(
            'column_name' => 'email',
        ),
    );
    
    /**
     * Table name
     *
     * @access protected
     * @var    string
     */
    protected $_base_table = 'client';

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
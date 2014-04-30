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
        'avalaibleValue' => array(
            'column_name' => 'avalaible_value',
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
    
    /**
     * Returns array of accounts for client
     * @param int $iClient
     * @param string $sAccountFilter
     * @access public
     * @return array
     */
    public function getClientAccounts($iClient = 0, $sAccountFilter = null) {

        $map = $this->getMap();

        $sCond = "";
        if ($iClient > 0) {
            $sCond = "id_client = " . $iClient;
        }
        
        if (isset($sAccountFilter)) {
            if ($iClient > 0) {
                $sCond .= " AND ";
            }
            $sCond .= "account_number LIKE " . $sAccountFilter;
        }
        $sql = "SELECT *
               FROM account
               WHERE " . $sCond;

        $resources = $this->db->query( $sql );

        $aAccounts = array();
        foreach ($resources->result() as $row) {
            $oAccount = new MAccount();
            foreach ($row as $key => $att) {
                $oAccount->$map[$key] = $att;
            }
            $aAccounts[] = $oAccount;
        }
        return $aAccounts;
    }
}
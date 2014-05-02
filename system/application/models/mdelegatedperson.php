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
            'column_name' => 'id_delegated_person',
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
    
    
    /**
     * Returns array of delegatedPersons for account
     * @param int $iAccount
     * @access public
     * @return array
     */
    public function getByAccount($iAccount) {

        $map = $this->getMap();

        $sql = "SELECT *
               FROM delegated_person
               WHERE id_account=" . $iAccount;

        $resources = $this->db->query( $sql );

        $aDelegatedPersons = array();
        foreach ($resources->result() as $row) {
            $oDelegatedPerson = new MDelegatedPerson();
            foreach ($row as $key => $att) {
                $oDelegatedPerson->$map[$key] = $att;
            }
            $aDelegatedPersons[] = $oDelegatedPerson;
        }
        return $aDelegatedPersons;
    }
    
    /**
     * Returns delegatedPerson for combination account and client
     * @param int $iAccount
     * @param int $iClient
     * @access public
     * @return bool
     */
    public function getByAccountAndClient($iAccount, $iClient) {

        $map = $this->getMap();

        $sql = "SELECT *
               FROM delegated_person
               WHERE id_account=" . $iAccount . " id_client=" . $iClient;

        $resources = $this->db->query( $sql );

        if (($row = current($resources->result())) == false) return false;
		
		$map = $this->getMap();
        foreach ($row as $key => $att) {
            $this->$map[$key] = $att;
        }
        
        return true;
    }
}
<?php  if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * Model for table operation
 * 
 * @author    Radim Res
 * @package   banka
 * @version   0.1.1.0
 */
class MOperation extends MY_Model
{

    /**
     * Array of class attributes corresponding to columns in a table
     *
     * @access protected
     * @var    array
     */
    protected $_cols = array(
        'ID' => array(
            'column_name' => 'id_operation',
        ),
        'delegatedPerson' => array(
            'column_name' => 'id_delegated_person',
            'relationship' => array(
                'type' => 'has_one',
                'table' => 'delegated_person',
                'class' => 'MDelegatedPerson'
            )
        ),
        'employee' => array(
            'column_name' => 'id_employee',
            'relationship' => array(
                'type' => 'has_one',
                'table' => 'employee',
                'class' => 'MEmployee'
            )
        ),
        'type' => array(
            'column_name' => 'id_operation_type',
            'relationship' => array(
                'type' => 'has_one',
                'table' => 'operation_type',
                'class' => 'MOperationType'
            )
        ),
        'targetAccount' => array(
            'column_name' => 'target_account_number',
        ),
        'bank' => array(
            'column_name' => 'bank_number',
        ),
        'VS' => array(
            'column_name' => 'variable_symbol',
        ),
        'SS' => array(
            'column_name' => 'specific_symbol',
        ),
        'CS' => array(
            'column_name' => 'constant_symbol',
        ),
        'date' => array(
            'column_name' => 'date',
        ),
        'value' => array(
            'column_name' => 'value',
        ),
        'message' => array(
            'column_name' => 'message',
        ),
    );
    
    /**
     * Table name
     *
     * @access protected
     * @var    string
     */
    protected $_base_table = 'operation';

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
     * Returns array of operations for account
     * @param int $iAccount
     * @access public
     * @return array
     */
    public function getByAccount($iAccount) {

        $map = $this->getMap();

        $sql = "SELECT o.*
               FROM operation o
               JOIN delegated_person d ON d.id_delegated_person = o.id_delegated_person
               WHERE id_account=" . $iAccount;
               
        $resources = $this->db->query( $sql );

        $aOperations = array();
        foreach ($resources->result() as $row) {
            $oOperation = new MOperation();
            foreach ($row as $key => $att) {
                $oOperation->$map[$key] = $att;
            }
            $aOperations[] = $oOperation;
        }
        return $aOperations;
    }
    
        // vraci seznam transakci danneho uctu filtrovanych podle datumu
    public function getTransfersByAccountAndDate($iAccount, $from, $to) {

        $map = $this->getMap();

        $sql = "SELECT o.*
               FROM operation o
               JOIN delegated_person d ON d.id_delegated_person = o.id_delegated_person
               WHERE id_account=" . $iAccount . " AND id_operation_type=3";
    
        if (isset($from) && ! empty($from)) {
            $sql .= "  AND date>=". $from;
        }
        if (isset($to) && ! empty($to)) {
            $sql .= "  AND date<=". $to;
        }        
   
        $resources = $this->db->query( $sql );

        $aTransfers = array();
        foreach ($resources->result() as $row) {
            $oOperation = new MOperation();
            foreach ($row as $key => $att) {
                $oOperation->$map[$key] = $att;
            }
            $aTransfers[] = $oOperation;
        }
        return $aTransfers;
    }
    
        // vraci seznam operaci danneho uctu filtrovanych podle datumu
    public function getOperationsByAccountAndDate($iAccount, $from, $to) {

        $map = $this->getMap();

        $sql = "SELECT o.*
               FROM operation o
               JOIN delegated_person d ON d.id_delegated_person = o.id_delegated_person
               WHERE id_account=" . $iAccount;
    
        if (isset($from) && ! empty($from)) {
            $sql .= "  AND date>=". $from;
        }
        if (isset($to) && ! empty($to)) {
            $sql .= "  AND date<=". $to;
        }        
   
        $resources = $this->db->query( $sql );

        $aOperations = array();
        foreach ($resources->result() as $row) {
            $oOperation = new MOperation();
            foreach ($row as $key => $att) {
                $oOperation->$map[$key] = $att;
            }
            $aOperations[] = $oOperation;
        }
        return $aOperations;
    }

    /**
     * Returns array of operations by delegated person for last days
     * @param int $iPerson
     * @param int $iDays
     * @access public
     * @return array
     */
    public function getLastOperations($iPerson = 0, $iDays) {

        $map = $this->getMap();

        if ($iPerson > 0) {
            $sCond = "id_delegated_person=" . $iPerson;
        } else {
            $sCond = "";
        }
        $sCond .= " AND date >= DATE_ADD(CURDATE(), INTERVAL -" . $iDays . " DAY)";

        $sql = "SELECT *
               FROM operation
               WHERE " . $sCond;
               
        $resources = $this->db->query( $sql );

        $aOperations = array();
        foreach ($resources->result() as $row) {
            $oOperation = new MOperation();
            foreach ($row as $key => $att) {
                $oOperation->$map[$key] = $att;
            }
            $aOperations[] = $oOperation;
        }
        return $aOperations;
    }

    /**
     * Returns available cash in limit
     * @param int $iPerson
     * @param int $iDays
     * @access public
     * @return int
     */
    public function getAvailableCashInLimit($iPerson = 0, $iDays) {
        
        if ($iPerson < 1 || $iDays < 1) {
            return false;
        }
    
        $map = $this->getMap();

        $sql = "SELECT SUM(value) as spend
               FROM operation
               WHERE id_operation_type != 2 AND id_delegated_person=" . $iPerson . " AND date >= DATE_ADD(CURDATE(), INTERVAL -" . $iDays . " DAY)";
               
        $resources = $this->db->query( $sql );
        if (($row = current($resources->result())) == false) {
            return false;
        }

        $iSpend = $row->spend;
        $oPerson = new MDelegatedPerson();
        $oPerson->getById($iPerson);
        
        return $oPerson->limit - $iSpend;
    }    
}
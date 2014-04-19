<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Load an sql_select library and preload it with $sql.
 * 
 * @param  string $sSQL
 * @param  string $sOrderBy
 * @return object
 */
function sql_select( $sSQL, $aAttr = NULL ) {
    $CI =& get_instance(  );
    
    $CI->load->library( 'sql_select' );
    
    return new Sql_select( $sSQL, $aAttr );
}

/**
 * Create an sql_select with a specified model.
 * 
 * @param  string $sModel
 * @param  array $aSqlSelectAttr
 * @param  array $aAttr
 * @return object
 */
function sql_select_model( $sModel, $aSqlSelectAttr = NULL, $aAttr = NULL ) {
    $CI =& get_instance(  );
    
    $CI->load->model( $sModel );
    
    return sql_select( $CI->$sModel->sql_select( $aAttr ), $aSqlSelectAttr );
}

/**
 * Get a next value in sequence.
 * 
 * @param  string $sSequence
 * @return int|bool
 */
function sql_seq_id($sSequence) {
    $oCI = & get_instance();
    //$CI->db->query call fce num_rows()
    //the function num_rows() in oci8_result.php is causing the extra DB queries
    // that leads to the sequence getting incremented more than it should. 
    
    //$aID = $CI->db->query( " SELECT " . $sSequence . ".NEXTVAL ID FROM DUAL " )->row_array(  );
    //return (int) $aID['ID'];
    
    // Run the Query
    $mResultId = $oCI->db->simple_query(" SELECT " . $sSequence . ".NEXTVAL ID FROM DUAL ");

    if (FALSE === $mResultId) {
        return FALSE;
    };
    // Load and instantiate the result driver	
    $sDriver = $oCI->db->load_rdriver();
    $oRES = new $sDriver();
    $oRES->result_id = $mResultId;
    $oRES->conn_id = $oCI->db->conn_id;
    $oRES->stmt_id = $oCI->db->stmt_id;
    $oRES->curs_id = NULL;

    $oRES->result_array();

    $iID = $oRES->result_array[0]['ID'];

    return (int) $iID;
}
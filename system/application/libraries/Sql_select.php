<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * A simple library for handling a result of SELECTing multiple rows.
 * @author  Radim Res
 */

class Sql_select {
    
    public $sSQL;
    public $aAttr;
    public $res;
    public $items;
    
    public $total;
    public $page;
    public $perpage;
    public $pages;
    
    /**
     * Library constructor
     * The constructor accepts the actual SQL query for selecting from database and a mandatory ORDER BY parameter.
     * @param  string $sSQL
     * @param  array $aAttr
     * @return void
     */
    public function __construct( $sSQL = NULL, $aAttr = NULL ) {
        $this->sSQL = $sSQL;
        $this->aAttr = $aAttr;
    }
    
    /**
     * Get the result of an SQL select as this object
     * This method returns either the complete list of records or a subset defined by $page and $perpage parameters.
     * @access public
     * @param  int $page
     * @param  int $perpage
     * @return object
     */
    public function get( $page = NULL, $perpage = NULL ) {
        $CI =& get_instance(  );
        
        if ( $page && $perpage ) {
            $total = $CI->db->query( $this->sql_total(  ) )->row_array(  );
            $this->total = (int) $total['TOTAL'];
            
            $sql_page = $this->sql_page(  );
            
            $page_start = ($page * $perpage) - $perpage + 1;
            $page_end   = $page * $perpage + 1;
            
            $stmt = OCIParse( $CI->db->conn_id, $sql_page )
                OR die ( 'Can not parse query' );
            
            oci_bind_by_name( $stmt, ":page_start", $page_start );
            oci_bind_by_name( $stmt, ":page_end",   $page_end );
            $this->res = oci_execute( $stmt );
            oci_fetch_all( $stmt, $items, NULL, NULL, OCI_FETCHSTATEMENT_BY_ROW );
            
            $this->items = (array) $items;
        } else {
            $this->res = $CI->db->query( $this->sql_all(  ) );
            $this->total = $this->res->num_rows();
        } 
        
        $this->page    = (int) $page ? $page : 1;
        $this->perpage = (int) $perpage ? $perpage : ( $this->total ? $this->total : 1 );
        $this->pages   = (int) ceil( $this->total / $this->perpage );
        
        return $this;
    }
    
    /**
     * Get the SQL query for selecting the NUMBER of rows
     * @access public
     * @return string
     */
    public function sql_total(  ) {
        $sSQL = " SELECT COUNT(*) total FROM ( " . str_replace( '%rn%', NULL, $this->sSQL ) . " ) t_total ";
        
        return $sSQL;
    }
    
    /**
     * Get an SQL query for selecting all rows
     * @access public
     * @return string
     */
    public function sql_all(  ) {
        $sSQL = str_replace( '%rn%', NULL, $this->sSQL );
        
        return $sSQL;
    }
    
    /**
     * Get an SQL query for selecting a specific page
     * @access public
     * @param  int $page
     * @param  int $perpage
     * @return string
     */
    public function sql_page(  ) {
        if ( isset( $this->aAttr['orderBy'] ) ) {
            $sRowSql = " ROW_NUMBER () OVER ( ORDER BY " . $this->aAttr['orderBy'] . " ) rn, ";
        }
        $sSQL = " SELECT rn, t_select.* ";
        if ( isset( $this->aAttr['select'] ) ) {
            $sSQL .= " , " . $this->aAttr['select'];
        }
        $sSQL .= " FROM ( " . str_replace( '%rn%', $sRowSql, $this->sSQL ) . " ) t_select ";
        $sSQL .= " WHERE ( rn >= :page_start ) AND ( rn < :page_end ) ";
        
        return $sSQL;
    }
    
    /**
     * Get a result of SQL select as an array of items
     * @access public
     * @return array
     */
    public function items(  ) {
        if ( !$this->res )
            $this->get(  );
        
        if ( isset( $this->items ) )
            return (array) $this->items;
        
        return (array) $this->res->result_array(  );
    }
    
    /**
     * Get a result of SQL select as an array of objects
     * @param  string $sModel
     * @return array
     */
    public function objects( $sModel ) {
        if (!$this->res)
            $this->get(  );
        
        $CI =& get_instance(  );
        
        $CI->load->model( $sModel );
        
        $objects = array(  );
        foreach ( (array) $this->items(  ) as $key => $item ) {
            $objects[$key] = $this->_getModelInstace($sModel);
            $objects[$key]->fillFromDB($item);
        }
        
        return (array) $objects;
    }
    
    /**
     * Returns new model instance, mainly used to be overriden in unit tests
     * @param string $sModel
     * @return MY_Model
     */
    protected function _getModelInstace($sModel) {
        return new $sModel();
    }
    
    /**
     * Get the first result of an SQL select as an object
     * @access public
     * @param  string $sModel
     * @return object
     */
    public function object( $sModel ) {
        if ( !$this->res )
            $this->get(  );
        
        if ( !$this->total(  ) )
            return FALSE;
        
        $CI =& get_instance(  );
        
        $CI->load->model( $sModel );
        
        $aItems = $this->items(  );
        $oObject = $this->_getModelInstace($sModel);
        $oObject->fillFromDB( $aItems[0] );
        
        return $oObject;
    }
    
    /**
     * Get an associative array from SQL query result
     * @access public
     * @param  string $sModel
     * @param  string $id
     * @param  string $label
     * @return array
     */
    public function assoc( $sModel, $sID = 'ID', $sLabel = 'label' ) {
        if ( !$this->res )
            $this->get(  );
        
        foreach ( $this->objects( $sModel ) as $item ) {
            $items[$item->$sID] = $item->$sLabel;
        }
        
        if ( !isset( $items ) )
            return array(  );
        
        return (array) $items;
    }
    
    /**
     * Get selected data as a grid array.
     * @param  string $sModel
     * @return array
     */
    public function grid( $sModel ) {
        foreach ( $this->objects( $sModel ) as $oObject )
            $aGrid[] = $oObject->getForGrid(  );
        
        return (array) $aGrid;
    }
    
    /**
     * Get all items' IDs
     * @param  string $ident
     * @return array
     */
    public function getIDs( $ident = 'ID' ) {
        return (array) array_map( function ( $item ) use ( $ident ) { if ( isset( $item[$ident] ) ) return $item[$ident]; return NULL; }, $this->items(  ) );
    }
    
    /**
     * Get the total number of rows of an SQL select query
     * @access public
     * @return int
     */
    public function total(  ) {
        if ( !$this->res )
            $this->get(  );
        
        return $this->total;
    }
    
    /**
     * Get the pagination string
     * @access public
     * @param  string $sBaseUri
     * @return string
     */
    public function getPagination( $sBaseUri = NULL, $sPrefix = 'offset:' ) {
        
        function getOffset( $iOffset, $sSeparator = '/', $sPrefix = 'offset:' ) {
            if ( (int) $iOffset > 0 )
                return $sSeparator . $sPrefix . $iOffset;
            
            return NULL;
        }
        
        if ($this->pages === 1)
            return NULL;
        
        $aPages = $this->getPaginationPages(  );
        $sStr = '';
        if(isset($aPages)) {
        
            // class="first-page"
            $sStr .= '<p class="pagination">';
            $sStr .= '<a class="first-page" href="' . site_url($sBaseUri . getOffset($this->pageOffset(1))) . '">&larr; ' . _('first_page') . '</a>';
            if ($this->page > 1)
                $sStr .= '<a class="previous" href="' . site_url($sBaseUri . getOffset($this->pageOffset($this->page - 1))) . '">&larr; ' . _('previous') . '</a>';
            else
                $sStr .= '<a class="previous" href="' . site_url($sBaseUri . getOffset($this->pageOffset(1))) . '">&larr; ' . _('previous') . '</a>';
            
            foreach ($aPages as $iPageKey => $iPage) {
                if ((int) $this->page === (int) $iPage) {
                    $sStr .= '<a class="active" href="">' . $iPage . '</a>';
                } else {
                    $sStr .= '<a href="' . site_url($sBaseUri . getOffset($this->pageOffset($iPage))) . '">' . $iPage . '</a>';
                }
                if (isset($aPages[$iPageKey + 1])) {
                    if ($aPages[$iPageKey + 1] > $iPage + 1) {
                        $sStr .= '<span>...</span>';
                    }
                }
            }
            
            if ($this->page < $this->pages) {
                $sStr .= '<a class="next" href="' . site_url($sBaseUri . getOffset($this->pageOffset($this->page + 1))) . '">' . _('next') . ' &rarr;</a>';
            } else {
                $sStr .= '<a class="next" href="' . site_url($sBaseUri . getOffset($this->pageOffset($this->pages))) . '" disabled>&larr; ' . _('next') . '</a>';
            }
            $sStr .= '<a class="last-page" href="' . site_url($sBaseUri . getOffset($this->pageOffset($this->pages))) . '">&larr; ' . _('last_page') . '</a>';
            $sStr .= '</p>';
        }
        
        return $sStr;
        
    }
    
    /**
     * Get the array of pages to view in pagination
     * @access public
     * @param  int $offset
     * @return array
     */
    public function getPaginationPages( $iOffset = 2 ) {
        $n = array(  );
        for ($i = $this->page - $iOffset; $i <= $this->page + $iOffset; $i++) {
            if ($i > 0 && $i <= $this->pages) $n[] = $i;
        }
        for ($i = 1; $i <= min(array($iOffset, $this->pages)); $i++) {
            $n[] = $i;
        }
        for ($i = $this->pages; $i >= $this->pages - $iOffset + 1; $i--) {
            if ($i > 0 && $i <= $this->pages) $n[] = $i;
        }
        
        $n = array_unique($n);
        sort($n, SORT_NUMERIC);
        
        return $n;
    }
    
    /**
     * Generate a widget allowing change the number of results per page.
     * @return string
     */
    public function getPerpageSwitcher( $sBaseUri = NULL, $iPage = 1, $sPrefix = 'perpage:' ) {
        $CI =& get_instance(  );
        
        if ( $this->total() < min( $CI->config->item( 'per_page_options' ) ) )
            return NULL;
        
        $str = '';
        
        foreach ( $CI->config->item( 'per_page_options' ) as $iPerpage ) {
            if ( $this->perpage == $iPerpage )
                $str .= '<a class="active" href="' . site_url( $sBaseUri . '/' . $sPrefix . $iPerpage . getOffsetUri( floor( ( $iPage - 1 ) * $this->perpage / $iPerpage ) * $iPerpage ) ) . '">' . $iPerpage . '</a>';
            else
                $str .= '<a href="' . site_url( $sBaseUri . '/' . $sPrefix . $iPerpage . getOffsetUri( floor( ( $iPage - 1 ) * $this->perpage / $iPerpage ) * $iPerpage ) ) . '">' . $iPerpage . '</a>';
        }
        
        $str = '<p class="number-per-page">'._("records_per_page").': ' . $str . '</p>';
        
        return $str;
    }
    
    /**
     * Get the page offset
     * @access public
     * @param  int $iPage
     * @return int
     */
    public function pageOffset( $iPage ) {
        return (int) $iPage * $this->perpage - $this->perpage;
    }
    
}
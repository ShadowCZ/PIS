<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Parent Model
 * @author Radim Res
 */
class MY_Model extends CI_Model
{
    const SORT_ASC = 'ASC';
    const SORT_DESC = 'DESC';

    /**
     * Local cahche of loaded objects
     * @var array
     */
    protected $_aLoadedObjects = array();

    /**
     * Local cache of queries
     * @var array
     */
    protected $_aCachedQueries = array();
    protected $_cols = array();

    /**
     * $_has_many - array describing has_many relationships to the class
     * @var    array
     * @access Protected
     */
    protected $_has_many = array();

    /**
     * $_base_table - name of a base table of a model in a db, must be uppercase
     * @var    string
     * @access Protected
     */
    protected $_base_table;

    /**
     * $_primary_key - key of a $this->_cols array which represents a column in db which is a primary key
     * @var    string
     * @access Protected
     */
    protected $_primary_key = 'ID';

    /**
     * $_columns - an array of column names of a $this->_base_table created in constructor for better access
     * @var    array
     * @access Protected
     */
    protected $_columns = array();

    /**
     * Settings whether the sequence should be used to get primary keys
     * @var boolean
     */
    protected $_use_sequence = false;

    /**
     * Identifies whether the object is new (insert) or not (update)
     * @var bool
     */
    protected $_is_new = false;

    /**
     * Set whether the object is new
     * @param bool $bIsNew
     */
    public function setIsNew($bIsNew = true)
    {
        $this->_is_new = $bIsNew;
    }

    /**
     * Returns whether the object is new
     * @return bool
     */
    public function isNew()
    {
        return $this->_is_new;
    }

    /**
     * Instances counts of models (for profiler)
     * @var array
     */
    static public $aInstancesCounts = array();

    public function __construct()
    {
        $sClassname = get_called_class();

        if (isset(static::$aInstancesCounts[$sClassname])) {
            static::$aInstancesCounts[$sClassname]++;
        } else {
            static::$aInstancesCounts[$sClassname] = 1;
        }
        parent::__construct();
        // we null values of all columns for a clean and fresh start
        foreach ($this->_cols as $sColumnName => $aColumn) {
            $this->_cols[$sColumnName]['value'] = null;
            $this->_cols[$this->_primary_key]['dont_save'] = true;
            $this->_columns[] = $this->_cols[$sColumnName]['column_name'];
        }
    }

    /**
     * Getter for $_base_table
     * @access Public
     * @param  void
     * @return string
     */
    public function getBaseTable()
    {
        return $this->_base_table;
    }
    
    /**
     * Returns primary key column name
     * @return string
     */
    public function getPrimaryKeyColumn()
    {
        return $this->_primary_key;
    }

    /**
     * magic method used for setting data structure of a class
     * @access Public
     * @param string $sAttributeName
     * @param string $mValue
     * @return mixed
     */
    public function __set($sAttributeName, $mValue)
    {
        // yes, there is a column of that name, we set a value
        if (array_key_exists($sAttributeName, $this->_cols)) {
            $this->_cols[$sAttributeName]['value'] = $mValue;
            return;
        } else {
            $bSet = false;
            foreach ($this->_cols as $sKey => $aCol) {

                if ($aCol['column_name'] == $sAttributeName) {
                    $this->_cols[$sKey]['value'] = $mValue;
                    $bSet = TRUE;
                }
            }
            // if not, we set a class property
            if (!$bSet) {
                $this->$sAttributeName = $mValue;
            }
        }
    }

    /**
     * gets all the names of columns of a class
     * @access Public
     * @static
     * @param void
     * @return array array of strings
     */
    public function getAllColumns()
    {
        $aColumns = array();
        foreach ($this->_cols as $sColumnName => $aColumn) {
            $aColumns[] = $this->_cols[$sColumnName]['column_name'];
        }
        return $aColumns;
    }

    /**
     * instances of all objects of a relationship between tables
     * @access Public
     * @static
     * @param string $sTableName
     * @param int $iID
     * @return array array of strings
     */
    public function getAllForRelationship($sColumnName, $iID)
    {
        $this->db->select(implode(',', $this->_columns));
        $this->db->where($sColumnName, $iID);
        if (in_array('ACTIVE', $this->_columns)) {

            $this->db->where('ACTIVE', '1');
        }
        $aReturn = $this->db->get($this->_base_table);
        $sClassName = get_class($this);
        $aRet = array();
        foreach ($aReturn->result() as $oRow) {
            $oNewInstance = new $sClassName();
            foreach ($this->_columns as $sColumnName) {
                $oNewInstance->$sColumnName = $oRow->$sColumnName;
            }
            $aRet[] = $oNewInstance;
        }
        return $aRet;
    }

    /**
     * magic method to access data structure of a class, including lazy loading of relationships
     * @access Public
     * @static
     * @param string $sTableName
     * @param int $iID
     * @return array array of strings
     */
    public function __get($sAttributeName)
    {
        if (array_key_exists($sAttributeName, $this->_cols)) {
            if (isSet($this->_cols[$sAttributeName]['relationship'])) {
                if (!is_object($this->_cols[$sAttributeName]['value'])) {
                    if (is_null($this->_cols[$sAttributeName]['value'])) {
                        return null;
                    }
                    $sClassName = $this->_cols[$sAttributeName]['relationship']['class'];
                    $this->load->model($sClassName);
                    $CI = & get_instance();
                    try
                    {
                        $oNewInstance = $CI->$sClassName->getByID($this->_cols[$sAttributeName]['value']);
                    }
                    catch(DBObjectNotFoundException $e)
                    {
                        $oNewInstance = null;
                    }
                    $this->_cols[$sAttributeName]['value'] = $oNewInstance;
                    return $oNewInstance;
                } else {
                    return $this->_cols[$sAttributeName]['value'];
                }
            } else {
                return $this->_cols[$sAttributeName]['value'];
            }
        } elseif (array_key_exists($sAttributeName, $this->_has_many)) {
            $sClassName = $this->_has_many[$sAttributeName]['class'];
            $this->load->model($sClassName);
            $CI = & get_instance();

            return $CI->$sClassName->getAllForRelationship($this->_cols[$this->_primary_key]['column_name'], $this->_cols[$this->_primary_key]['value']);
        } elseif (isSet($this->$sAttributeName)) {
            return $this->$sAttributeName;
        } else {
            return parent::__get($sAttributeName);
        }
    }

    /**
     * stores data of a class into db. it updates a record if it exists or inserts a new one
     * @access Public
     * @param void
     * @return int returns primary key of stored object
     */
    public function update()
    {

        $aData = $this->_getDataToSave();

        if ($this->_cols[$this->_primary_key]['value'] === NULL || ( isset($this->_cols[$this->_primary_key]['value']) && $this->_is_new === true )) {
            if ($this->_use_sequence == true && $this->_is_new != TRUE) {
                $this->_cols[$this->_primary_key]['value'] = $this->getSeqID();
            }
            $aData[$this->_cols[$this->_primary_key]['column_name']] = $this->_cols[$this->_primary_key]['value'];

            $this->db->insert($this->_base_table, $aData);
        } else {
            $this->db->where($this->_cols[$this->_primary_key]['column_name'], $this->_cols[$this->_primary_key]['value']);
            $this->db->update($this->_base_table, $aData);
        }

        return mysql_insert_id();//(int) $this->_cols[$this->_primary_key]['value'];
    }

    /**
     * Returns data to be saved to db
     * @return array
     */
    protected function _getDataToSave()
    {
        $aData = array();

        foreach ($this->_cols as $sKey => $aColumn) {
            if (isSet($aColumn['dont_save']) && TRUE === (boolean) $aColumn['dont_save']) {
                continue;
            }

            if (isset($aColumn['relationship'])) {
                if ($aColumn['relationship']['type'] === 'has_one') {
                    $oValue = $aColumn['value'];
                    if (is_object($oValue)) {
                        $aData[$aColumn['column_name']] = $oValue->_cols[$oValue->_primary_key]['value'];
                    } else {
                        $aData[$aColumn['column_name']] = $aColumn['value'];
                    }
                } else {
                    // nothing's happening if relationship type is 'has many', but lets have this open for future....
                }
            } else {
                $aData[$aColumn['column_name']] = $aColumn['value'];
            }
        }

        return $aData;
    }

    /**
     * gets an instance of a class from a db based on an ID
     * @access Public
     * @param int $iID
     * @return object
     */
    public function getById($iID)
    {
        $this->db->select(implode(',', $this->_columns));
        $this->db->from($this->_base_table);
        if (is_array($iID)) {
            foreach ($iID as $mID) {
                $this->db->where($this->_cols[$this->_primary_key]['column_name'], $iID);
            }
        } else {
            $this->db->where($this->_cols[$this->_primary_key]['column_name'], $iID);
        }
        $oReturn = $this->db->get();
        $aReturn = $oReturn->result();

        if (count($aReturn) < 1)
        {
            throw new DBObjectNotFoundException('Object not found.');
        }

        if (count($aReturn) > 1)
        {
            throw new MoreThanOneDBObjectFoundException('More than one object found.');
        }

        $sClassName = get_class($this);
        $oModel = new $sClassName();

        foreach ($this->_cols as $sParameterID => $aColumn) {
            $oModel->$sParameterID = $aReturn[0]->$aColumn['column_name'];
        }

        return $oModel;
    }

    /**
     * fills a data into an object - generally incoming from a html form or any other source
     * @access Public
     * @param array $aParams
     * @return void
     */
    public function fill($aParams)
    {
        foreach ($aParams as $sParamName => $mParam) {
            if (array_key_exists($sParamName, $this->_cols)) {
                $this->$sParamName = $mParam;
            }
        }
    }

    /**
     * Fill data into an object from a database row
     * @access public
     * @param  array $aParams
     * @return bool
     */
    public function fillFromDB($aData)
    {
        foreach ($this->_cols as $sProperty => $aProperties) {
            $this->$sProperty = $aData[$aProperties['column_name']];
        }

        return TRUE;
    }

    /**
     * most likely only for developing, it returns instances of all the rows in a _base_table
     * @access Public
     * @param string $orderBy optional | orders result by column name specified in $orderBy
     * @param integer $iOrganisationId
     * @return array array of instances of a class
     */
    public function getAll($orderBy = NULL, $direction = NULL)
    {
        if ($orderBy !== NULL) {
            $this->db->order_by($orderBy, $direction);
        }

        $this->db->select(implode(',', $this->_columns));
        $aReturn = $this->db->get($this->_base_table);

        $aRet = array();
        foreach ($aReturn->result() as $oRow) {
            $sClassName = get_class($this);
            $oNewInstance = new $sClassName();
            foreach ($this->_columns as $sColumnName) {
                $oNewInstance->$sColumnName = $oRow->$sColumnName;
            }
            $aRet[] = $oNewInstance;
        }
        return $aRet;
    }

    /**
     * get asociative array with all labels ()
     * @access Public
     * @param integer $iOrganisationId
     * @return array
     */
    public function getAllLabels($iOrganisationId = NULL)
    {

        $aItems = $this->getAll(NULL, $iOrganisationId);
        $aRet = array();

        foreach ($aItems as $oItem) {
            $sPK = $oItem->_primary_key;
            $aRet[$oItem->$sPK] = $oItem->label;
        }
        ksort($aRet);

        return $aRet;
    }

    /**
     * for use within attribute data tables (varchar2, int, etc...)
     * @access Public
     * @param int $iTicketID
     * @param int $iAttributeID
     * @return object even if there is no record in that table, this return an instance with $ticketID and $attributeID set, value nulled
     */
    public function getByTicketIDAttributeID($iTicketID, $iAttributeID)
    {
        $class = get_class($this);

        $aTicketAttributes = $this->getObjectsByFilter(array(
            'ticket' => $iTicketID,
            'attribute' => $iAttributeID,
        ));

        $oTicketAttribute = current($aTicketAttributes);

        if (!is_object($oTicketAttribute))
        {
            $oTicketAttribute = new $class;
            $oTicketAttribute->fill(array(
                'ticket' => $iTicketID,
                'attribute' => $iAttributeID,
            ));

            $oTicketAttribute->update();
        }

        return $oTicketAttribute;
    }

    /**
     * Return array of all results from a query
     * @access Private
     * @param array $result - array of object
     * @return array $aRet
     */
    protected function getResult($result)
    {
        $aRet = array();
        foreach ($result as $oRow) {
            $sClassName = get_class($this);
            $oNewInstance = new $sClassName();
            foreach ($this->_columns as $sColumnName) {
                $oNewInstance->$sColumnName = $oRow->$sColumnName;
            }
            $aRet[] = $oNewInstance;
        }
        return $aRet;
    }

    /**
     * Export the object into an array so grid helper can use it
     * @access public
     * @return array
     */
    function getForGrid()
    {
        $aValues = array();

        foreach ((array) $this->_cols as $key => $column)
            $aValues[(string) $key] = (string) $column['value'];

        return $aValues;
    }

    /**
     * Raise given sequence value and return it
     * @access public
     * @param string $sSequenceName name of sequence to raise and return
     * @return integer $iSequenceValue the raised value
     */
    public function getSeqID()
    {
        $this->load->helper('sql_select');

        return sql_seq_id($this->_pk_sequence);
    }

    /**
     * Return a label by id only for tables with label
     * @access  protected
     * @param   integer $id
     * @param   stirng $table
     * @return  object $result attribute LABEL or NULL
     */
    protected function getLabelById($id)
    {
        $result = NULL;
        $this->db->select('LABEL');
        $this->db->where($this->_cols['ID']['column_name'], $id);
        $query = $this->db->get($this->_base_table);
        if ($query->num_rows() > 0) {
            $result = current($query->result());
        }
        return $result;
    }

    /**
     *  get asociative array for a select
     * @access  Public
     * @param   string $select column name
     * @param   string $where optional
     * @param   string $orderBy optional | orders result by column name specified in $orderBy
     * @return  array for a select
     */
    public function getPairs($sSelect, $where = NULL, $orderBy = NULL)
    {

        if ($where !== NULL) {
            $this->db->where($where);
        }

        if ($orderBy !== NULL) {
            $this->db->order_by($orderBy);
        }

        $aRet = array();
        if (is_string($sSelect)) {

            $aItems = $this->getAll();

            foreach ($aItems as $oItem) {

                $sPK = $oItem->_primary_key;
                $aRet[$oItem->$sPK] = $oItem->$sSelect;
            }
        }
        return $aRet;
    }

    /**
     * Returns array of objects based on filter
     * @param array $aFilter
     * @return array
     */
    public function getObjectsByFilter(array $aFilter = array())
    {
        $this->_prepareQueryConditionsFromFilter($aFilter);

        $aResult = $this->_getQueryResult($aFilter);

        $aObjects = array();
        foreach ($aResult as $oRow) {
            $oObject = new static();
            $oObject->fillFromDB((array) $oRow);
            $aObjects[$oObject->{$oObject->getPrimaryKeyColumn()}] = $oObject;
        }

        return $aObjects;
    }

    /**
     * Returns array of DB objects
     * @param array $aFilter
     * @return array
     */
    // @TODO - Different caching system, this one fails, when user use limit, then query with same string excepting different values,
    // but current caching system returns him previous result
    public function getDBObjectsByFilter(array $aFilter = array(), $bUseCache = true )
    {
        $sIdentifier = md5(serialize($aFilter));
        if (isset($this->_aCachedQueries[$sIdentifier]) && $bUseCache ) {
            return $this->_aCachedQueries[$sIdentifier];
        }

        $this->_prepareQueryConditionsFromFilter($aFilter);
        $aResult = $this->_getQueryResult($aFilter);
        $oObjectsCollection = new \DBO\ObjectCollection($this);
        foreach ($aResult as $oRow) {
            $oObject = $this->_getNewDBObjectInstance();
            $oObject = $this->_fillObjectWithData($oObject, $oRow);

            $oObjectsCollection->add($oObject);
            $this->_aLoadedObjects[$oObject->id()] = $oObject;
        }

        $this->_aCachedQueries[$sIdentifier] = $oObjectsCollection;

        return $oObjectsCollection;
    }

    /**
     * Returns count of all results matching the filter
     * @param array $aFilter
     * @return int
     */
    public function countDBObjectsByFilter(array $aFilter = array())
    {
        $this->_prepareQueryConditionsFromFilter($aFilter);
        return $this->db->count_all_results($this->_base_table);
    }

    /**
     * Returns sql query built from filter
     * @param array $aFilter
     */
    public function getSqlQueryForFilter(array $aFilter, array $aSelectColumns = array())
    {
        $this->_setSelectColumns($aSelectColumns);
        $this->_prepareQueryConditionsFromFilter($aFilter);
        $sQuery = $this->db->get_sql($this->getBaseTable());
        return $sQuery;
    }

    /**
     * Sets columns to be selected
     * @param array $aColumns
     */
    protected function _setSelectColumns(array $aColumns)
    {
        if (!empty($aColumns)) {
            $aCols = $this->_getCols();
            $sSelectColumns = '';
            $sSeparator = '';
            foreach ($aColumns as $sColumn) {
                if (isset($aCols[$sColumn])) {
                    $sSelectColumns .= $sSeparator . $aCols[$sColumn]['column_name'];
                    $sSeparator = ',';
                }
            }

            $this->db->select($sSelectColumns);
        }
    }

    /**
     * Fills object with data from row
     * @param \DBO\Object $oObject
     * @param stdClass $oData
     * @return \DBO\Object
     */
    protected function _fillObjectWithData(\DBO\Object $oObject, stdClass $oData)
    {
        foreach ($this->_getCols() as $sAttributeName => $aColumnInfo) {
            $oObject[$sAttributeName] = $oData->{$aColumnInfo['column_name']};
        }

        return $oObject;
    }

    /**
     * Returns array of cols (useful for unit tests
     * @return array
     */
    protected function _getCols()
    {
        return $this->_cols;
    }

    /**
     * Returns DB object instance
     * @return \DBO\Object
     */
    protected function _getNewDBObjectInstance()
    {
        throw new Exception('Must reimplement this method.');
    }

    /**
     * Returns query result with limit/offset from filter
     * @param array $aFilter
     * @return array
     */
    protected function _getQueryResult(array $aFilter)
    {
        $aLimit = array(
            'limit' => null,
            'offset' => null,
        );

        $aLimit = array_merge($aLimit, $aFilter);

        if (!is_null($aLimit['limit']) && (is_null($aLimit['offset']) || $aLimit['offset'] < 1)) {
            $aLimit['limit'] += 1; // need to do this vecause of how CI driver works
        }

        $oResult = $this->db->get($this->_base_table, $aLimit['limit'], $aLimit['offset']);
        return $oResult->result();
    }

    /**
     * Returns associative array of data based on filter and columns
     * @param array $aFilter
     * @param array $aColumns
     * @return array
     */
    public function getAssociativeDataByFilter(array $aFilter, array $aColumns = array())
    {
        $this->_prepareQueryConditionsFromFilter($aFilter);

        if (!empty($aColumns)) {
            if (!in_array($this->_primary_key, $aColumns)) {
                $aColumns[] = $this->_primary_key;
            }

            $sSelectColumns = '';
            $sSeparator = '';
            foreach ($aColumns as $sColumn) {
                if (isset($this->_cols[$sColumn])) {
                    $sSelectColumns .= $sSeparator . $this->_cols[$sColumn]['column_name'];
                    $sSeparator = ',';
                }
            }

            $this->db->select($sSelectColumns);
        }
        $aResult = $this->_getQueryResult($aFilter);

        $aResultData = array();
        foreach ($aResult as $oRow) {
            $aResultData[$oRow->{$this->_cols[$this->_primary_key]['column_name']}] = (array) $oRow;
        }

        return $aResultData;
    }

    /**
     * Sets all the conditions based on filter
     * @param array $aFilter
     */
    protected function _prepareQueryConditionsFromFilter(array $aFilter = array())
    {
        foreach ($aFilter as $sColumn => $mValue) {
            $aMatches = array();
            $sOperator = '';
            $sColumnName = $sColumn;
            if (preg_match('#([A-z0-9_]+)(.*)#', $sColumn, $aMatches)) {
                $sColumnName = $aMatches[1];
                $sOperator = $aMatches[2];
            }
            if (isset($this->_cols[$sColumnName])) {
                if (is_array($mValue)) {
                    $this->db->where_in($this->_cols[$sColumnName]['column_name'] . $sOperator, $mValue);
                } else {
                    $this->db->where($this->_cols[$sColumnName]['column_name'] . $sOperator, $mValue);
                }
            } else {
                $aMatches = array();
                if (preg_match('#([^_]+)_(.+)#', $sColumn, $aMatches)) {
                    $sModifier = $aMatches[1];
                    $sRealColumn = $aMatches[2];
                    $this->_prepareColumnConditionForModifier($sRealColumn, $sModifier, $mValue);
                }
            }
        }

        $this->_prepareQuerySortConditionsFromFilter($aFilter);
    }

    /**
     * Creates sort part of query
     * @param array $aFilter
     */
    protected function _prepareQuerySortConditionsFromFilter(array $aFilter)
    {
        if (isset($aFilter['sort']) && is_array($aFilter['sort'])) {
            foreach ($aFilter['sort'] as $sColumn => $sOrder) {
                if (isset($this->_cols[$sColumn])) {
                    $sOrderBy = self::SORT_ASC;
                    if ($sOrder == self::SORT_DESC) {
                        $sOrderBy = self::SORT_DESC;
                    }
                    $this->db->order_by($this->_cols[$sColumn]['column_name'], $sOrderBy);
                }
            }
        }
    }

    /**
     * Prepares condition for column based on modifier
     * @param string $sColumn
     * @param string $sModifier
     * @param mixed $mValue
     */
    protected function _prepareColumnConditionForModifier($sColumn, $sModifier, $mValue)
    {

        $aMatches = array();
        $sOperator = '';
        if (preg_match('#([A-z_]+)(.*)#', $sColumn, $aMatches)) {
            $sColumn = $aMatches[1];
            $sOperator = $aMatches[2];
        }

        if (!isset($this->_cols[$sColumn])) {
            return;
        }

        switch ($sModifier) {
            case 'upper':
                $this->db->where('UPPER(' . $this->_cols[$sColumn]['column_name'] . ')', $mValue);
                break;

            case 'inselect':
                $this->db->where($this->_base_table . '.' . $this->_cols[$sColumn]['column_name'] . ' IN', '(' . $mValue . ')', false);
                break;

            case 'noescape':
                $this->db->where($this->_cols[$sColumn]['column_name'] . $sOperator, '(' . $mValue . ')', false);
                break;
        }
    }

    /**
     * Returns a single object based on filter criteria
     * @param array $aFilter
     * @return MY_Model
     */
    public function getSingleObjectByFilter(array $aFilter)
    {
        $this->_prepareQueryConditionsFromFilter($aFilter);
        $aResult = $this->_getQueryResult($aFilter);
        $oObject = null;

        if (count($aResult) > 1) {
            throw new MoreThanOneDBObjectFoundException('More than one object found.');
        }

        if (count($aResult) < 1)
        {
            throw new DBObjectNotFoundException('Object not found.');
        }

        $oObject = new static();
        $oFirstRow = current($aResult);
        $oObject->fillFromDB((array) $oFirstRow);

        return $oObject;
    }

    /**
     * Returns a single DB object based on filter criteria
     * @param array $aFilter
     * @return DBO\Object
     */
    public function getSingleDBObjectByFilter(array $aFilter)
    {
        $oObject = null;
        $this->_prepareQueryConditionsFromFilter($aFilter);

        $aResult = $this->_getQueryResult($aFilter);

        if (count($aResult) > 1) {
            throw new MoreThanOneDBObjectFoundException('More than one object found.');
        }

        if (count($aResult) < 1)
        {
            throw new DBObjectNotFoundException('Object not found.');
        }

        $oRow = current($aResult);
        $oObject = $this->_getNewDBObjectInstance();
        $oObject = $this->_fillObjectWithData($oObject, $oRow);

        $this->_aLoadedObjects[$oObject->id()] = $oObject;

        return $oObject;
    }

    /**
     * Tries to find object in cache first. If not found it executes db query as usual
     * @param int $iObjectId
     * @return \DBO\Object
     */
    public function getSingleDBObjectByIdFromCache($iObjectId)
    {
        $oObject = null;
        if (isset($this->_aLoadedObjects[$iObjectId])) {
            $oObject = $this->_aLoadedObjects[$iObjectId];
        }

        if (!is_object($oObject)) {
            $oObject = $this->getSingleDBObjectByFilter(array(
                $this->getPrimaryKeyColumn() => $iObjectId,
                    ));
        }

        return $oObject;
    }

    /**
     * Deletes current record from database
     */
    public function delete($iRow = 0)
    {
        if ($iRow > 0) {
            $this->{$this->_primary_key} = $iRow;
        }
        $this->db->where($this->_cols[$this->_primary_key]['column_name'], $this->{$this->_primary_key});
        $this->db->delete($this->_base_table);
    }

    /**
     * Loads objects by ids on relationship model based on attribute definition
     * @param string $sAttributeName
     * @param array $aObjectIds
     */
    public function loadRelationshipObjectsByIds($sAttributeName, array $aObjectIds)
    {
        if ($this->_hasRelationshipForAttribute($sAttributeName)) {
            $oRelationshipModel = $this->_getRelationshipModelForAttribute($sAttributeName);
            $oRelationshipModel->loadObjectsByIdsToCache($aObjectIds);
        }
    }

    /**
     * Returns relationship model
     * @param type $sAttributeName
     * @return MY_Model
     */
    protected function _getRelationshipModelForAttribute($sAttributeName)
    {
        $sModel = strtolower($this->_cols[$sAttributeName]['relationship']['class']);
        $oCI = get_instance();
        $oCI->load->model($sModel);
        return $oCI->{$sModel};
    }

    /**
     * Checks if the attribute has relation
     * @param string $sAttributeName
     * @return bool
     */
    protected function _hasRelationshipForAttribute($sAttributeName)
    {
        return isset($this->_cols[$sAttributeName]) && isset($this->_cols[$sAttributeName]['relationship']);
    }

    /**
     * Loads objects to local cache
     * @param array $aObjectIds
     */
    public function loadObjectsByIdsToCache(array $aObjectIds)
    {
        $aObjectIdsToBeLoaded = array_diff($aObjectIds, array_keys($this->_aLoadedObjects));
        if (!empty($aObjectIdsToBeLoaded)) {
            $aFilter = array(
                $this->getPrimaryKeyColumn() => $aObjectIdsToBeLoaded,
            );
            $this->_prepareQueryConditionsFromFilter($aFilter);

            $aResult = $this->_getQueryResult($aFilter);

            foreach ($aResult as $oRow) {
                $oObject = $this->_getNewDBObjectInstance();
                $oObject = $this->_fillObjectWithData($oObject, $oRow);

                $this->_aLoadedObjects[$oObject->id()] = $oObject;
            }
        }
    }

    /**
     * Returns relationship object based on the id
     * @param string $sAttributeName
     * @param int $iObjectId
     * @return \DBO\Object
     */
    public function getRelationshipObjectById($sAttributeName, $iObjectId)
    {
        $oObject = null;
        if ($this->_hasRelationshipForAttribute($sAttributeName)) {
            $oRelationshipModel = $this->_getRelationshipModelForAttribute($sAttributeName);
            $oObject = $oRelationshipModel->getSingleDBObjectByIdFromCache($iObjectId);
        }
        return $oObject;
    }

    /**
     * Returns map of relationships between db cols and model attributes
     * @return array
     */
    public function getMap() {
        $map = array();
        foreach ($this->_cols as $key => $att) {
            $map[$att['column_name']] = $key;
        }
        return $map;
    }
}
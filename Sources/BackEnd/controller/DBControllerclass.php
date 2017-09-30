<?php


/**
 *
 */
class DB_Control implements sql_controller
{
	/**
	 *
	 */
	public function __construct()
	{
		$this->dbCon = new PDO($GLOBALS['DB_DSN'],$GLOBALS['DB_USER'],
		$GLOBALS['DB_PASSWORD']);
		$this->dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * @var PDO
	 */
	public $dbCon;

	/**
	 * @var \User
	 */
	public $user;

	
	/**
	 *@param Array $ary Description
   * cols = ['imageID','imageTitle','creationDate','imagestatus','userID']
	 */
	public function addImage($ary)
	{
		$t = $this;
    $table = 'Camagru.gallery';
    $Col = ['imageID','imageTitle','creationDate','imageStatus','userID'];
    $query = $t->insert($table, $Col, $ary);
    $query .= "ON DUPLICATE imageStatus";
    $statement = $t->dbCon->query($query);
    $statement->execute();
    if ($statement->errorCode() == 0){
      return true;
    }
    return false;
	}

	/**
	 *
	 */
	public function delImage($id)
	{
		return $id;
	}

	/**
	 * @inheritDoc
	 * @param void $table
	 * @param ArrayObject $Col
	 * @param ArrayObject $values
	 * @return string
	 */
	public function insert($table,  $Col, $values)
	{
		$str = "INSERT INTO ";
    $str .= $table . " (";
    $str .= $this->arrayJustify($Col) . " ) VALUES ( ";
    $str .= $this->arrayJustify($values) . ")";
    return $str;
	}

	/**
	 * @inheritDoc
	 * @param void $table
	 * @param void $colname
	 * @param void $tableid
	 * @return string
	 */
	public function delete($table, $colname, $tableid)
	{
		// TODO: implement here
    $query = " DELETE FROM $table WHERE ";
    $query .= " $colname = $tableid;";
		return $query;
	}

	/**
	 * @inheritDoc
	 * @param ArrayObject $selection
	 * @param string $table
	 * @param string $limiter
	 */
	public function select($selection, $table, $limiter)
	{
    $query = "SELECT ";
    $query .= $this->arrayJustify($selection,2) . " FROM " . $table;
    if ($limiter!= null){
      $query .= " WHERE $limiter";
    }
    return $query;
	}

	/**
	 * @inheritDoc
	 * @param string $table
	 * @param ArrayObject $colVals
	 * @param string $limiter
	 */
	public function update($table, $colVals, $limiter)
	{
		$query = "UPDATE $table SET ";
    $query .= "$colVals WHERE $limiter";
    return $query;
	}

	/**
	 * @inheritDoc
	 * @param string $query
	 * @param PDO $db
	 * @return PDOStatement
	 */
	public function prep($query, $db)
	{
    $this->dbCon = $db;
    $statement =$db->prepare($query);
		return $statement;
	}

	/**
	 * @inheritDoc
	 * @param ArrayObject $arry
	 * @param int $mode
	 * @return string
	 */
	public function arrayJustify($arry, $mode)
	{
    $query = "";
    if (is_array($arry)) {
      $query = " {$arry[0]} ";
      if ($mode == 1){
        $query = "'{$arry[0]}'";
      }
      $query .= $this->aJhelper($arry,$mode);
    } else {
      $query = $arry;
    }
    return $query;
	}

	/**
	 * @inheritDoc
	 */
	public  function aJhelper($obj,$mode)
	{
		// TODO: implement her
    $res = "";
    $len = sizeof($obj);
    if ($obj[1] !== NULL) {
      for ($a = 1; $a < $len; $a++) {
        $res .= ($mode == 1)?",'{$obj[$a]}'":",{$obj[$a]}";
      }
    }
    return "$res";
	}
}

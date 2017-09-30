<?php


/**
 *
 */
interface sql_controller
{
	/**
	 * @param void $table
	 * @param ArrayObject $Col
	 * @param ArrayObject $values
	 * @return string
	 */
	public function insert($table,  $Col,  $values);

	/**
	 * @param void $table
	 * @param void $colname
	 * @param void $tableid
	 * @return string
	 */
	public function delete($table, $colname, $tableid);

	/**
	 * @param ArrayObject $selection
	 * @param string $table
	 * @param string $limiter
	 */
	public function select( $selection, $table, $limiter);

	/**
	 * @param string $table
	 * @param ArrayObject $colVals
	 * @param string $limiter
	 */
	public function update($table,  $colVals, $limiter);

	/**
	 * @param string $query
	 * @param PDO $db
	 * @return PDOStatement
	 */
	public function prep($query, $db);

	/**
	 * @param ArrayObject $arry
	 * @param int $mode
	 * @return string
	 */
	public function arrayJustify( $arry, $mode);

	/**
	 *
	 */
	public function aJhelper( $obj, $mode);
}

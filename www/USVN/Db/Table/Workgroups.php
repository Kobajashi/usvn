<?php
/**
 * Model for workgroups table
 *
 * @author Team USVN <contact@usvn.info>
 * @link http://www.usvn.info/
 * @license http://www.cecill.info/licences/Licence_CeCILL_V2-en.txt CeCILL V2
 * @copyright Copyright 2007, Team USVN
 * @since 0.5
 * @package USVN_Db
 * @subpackage Table
 *
 * This software has been written at EPITECH <http://www.epitech.net>
 * EPITECH, European Institute of Technology, Paris - FRANCE -
 * This project has been realised as part of
 * end of studies project.
 *
 * $Id $
 */

/**
 * Model for workgroups table
 *
 * Extends USVN_Db_Table for magic configuration and methods
 *
 */
class USVN_Db_Table_Workgroups extends USVN_Db_Table {
	/**
	 * The primary key column (underscore format).
	 *
	 * Without our prefixe...
	 *
	 * @var string
	 */
	protected $_primary = array("workgroups_id");

	/**
	 * The table name derived from the class name (underscore format).
	 *
	 * @var array
	 */
	protected $_name = "workgroups";


	/**
	 * Associative array map of declarative referential integrity rules.
	 * This array has one entry per foreign key in the current table.
	 * Each key is a mnemonic name for one reference rule.
	 *
	 * Each value is also an associative array, with the following keys:
	 * - columns	   = array of names of column(s) in the child table.
	 * - refTableClass = class name of the parent table.
	 * - refColumns	= array of names of column(s) in the parent table,
	 *				   in the same order as those in the 'columns' entry.
	 * - onDelete	  = "cascade" means that a delete in the parent table also
	 *				   causes a delete of referencing rows in the child table.
	 * - onUpdate	  = "cascade" means that an update of primary key values in
	 *				   the parent table also causes an update of referencing
	 *				   rows in the child table.
	 *
	 * @var array
	 */
	protected $_referenceMap = array(
	"Groups" => array(
	"columns"	   	=> array("groups_id"),
	"refTableClass" => "USVN_Db_Table_Groups",
	"refColumns"	=> array("groups_id"),
	),
	"Projects" => array(
	"columns"	   	=> array("projects_id"),
	"refTableClass" => "USVN_Db_Table_Projects",
	"refColumns"	=> array("project_id"),
	),
	"Rights" => array(
	"columns"		=> array("rights_id"),
	"refTableClass"	=> "USVN_Db_Table_Access",
	"refColumns"	=> array("rights_id"),
	),
	);

	public function GetProjectGroups($project_name)
	{
		$db = $this->getAdapter();
    	$select = $db->select();
    	$select->from(USVN_Db_Table::$prefix . 'workgroups', '*');
    	$select->join(USVN_Db_Table::$prefix . 'groups', USVN_Db_Table::$prefix . 'workgroups.groups_id = ' . USVN_Db_Table::$prefix . 'groups.groups_id');
    	$select->join(USVN_Db_Table::$prefix . 'projects', USVN_Db_Table::$prefix . 'workgroups.projects_id = ' . USVN_Db_Table::$prefix . 'projects.projects_id');
    	$select->where(USVN_Db_Table::$prefix . 'projects.projects_name = ?', $project_name);
		$select->group(USVN_Db_Table::$prefix . 'workgroups.groups_id');
		$result = $db->fetchAll($select);
    	return $result;
	}
}

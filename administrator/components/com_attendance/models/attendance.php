<?php
/**
 * @version     2.0.0
 * @package     com_attendance
 * @copyright   Copyright (C) 2015. Alle Rechte vorbehalten.
 * @license     GNU General Public License Version 2 oder später; siehe LICENSE.txt
 * @author      Artelsmair Roman <aroaro@gmx.at> - http://artelsmair.at
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');
/*JLoader::register('AttendanceHelper', JPATH_COMPONENT . DS . 'helpers ' . DS . 'attendance.php');*/

/**
 * Attendance model.
 */
class AttendanceModelAttendance extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_ATTENDANCE';


	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Attendance', $prefix = 'AttendanceTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_attendance.attendance', 'attendance', array('control' => 'jform', 'load_data' => $loadData));
        
        
			if($form->getFieldAttribute('created', 'default') == 'NOW'){
				$form->setFieldAttribute('created', 'default', date('H:i:s'));
			}
			if($form->getFieldAttribute('modified', 'default') == 'NOW'){
				$form->setFieldAttribute('modified', 'default', date('H:i:s'));
			}
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_attendance.edit.attendance.data', array());

		if (empty($data)) {
			$data = $this->getItem();
            
		}

		return $data;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 *
	 * @return	mixed	Object on success, false on failure.
	 * @since	1.6
	 */
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk)) {

			//Do any procesing on fields here if needed

		}

		return $item;
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @since	1.6
	 */
	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');

		if (empty($table->id)) 
    {

			// Set ordering to the last item if not set
			if (@$table->ordering === '') 
      {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM attendance');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}

		}
    
    /*Convert Date Format from d.m.Y (display format) to Y-m-d (database format)*/
    /* 31.12.2015 -> 2015-12-31  */
    
    $newdate = 'null';
    $olddate = $table->date;
    if (strlen($olddate) > 0)
    {
      /* $newdate = substr($olddate,6,4)."-".substr($olddate,3,2)."-".substr($olddate,0,2); */
      $newDate = AttendanceHelper::aroGetDate($olddate, "d.m.Y", "Y-m-d");
    }
    $table->date = $newdate;
	}

}
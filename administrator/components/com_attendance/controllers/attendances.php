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

jimport('joomla.application.component.controlleradmin');

/**
 * Attendances list controller class.
 */
class AttendanceControllerAttendances extends JControllerAdmin
{
  public function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask('unpublish', 'publish');
		$this->registerTask('addBookingfield', 'editBookingfield');
		$this->registerTask('apply', 'save');
	}  
  
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'attendance', $prefix = 'AttendanceModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
    
    
	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function saveOrderAjax()
	{
		// Get the input
		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');

		// Sanitize the input
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);

		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder($pks, $order);

		if ($return)
		{
			echo "1";
		}

		// Close the application
		JFactory::getApplication()->close();
	}
    
  /*
	 * Method to printout data
	 *
	 * @return  void
	 *
	 * @since   2016.02
  */
  
  public function printout()
	{
 
		// Get the input
		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');
 
		// Sanitize the input
		JArrayHelper::toInteger($pks);
 
		// Get the model
		$model = $this->getModel();
 
		$return = $model->printout();
 
		// Redirect to the list screen.
		$this->setRedirect(JRoute::_('index.php?option=com_attendances&view=attendances', false)); 
	}
  
    /*
    public function printout()
    {
      echo 'Printout';
      die;
  
      
        require_once JPATH_COMPONENT . '/helpers/printtable.php';
        require_once JPATH_COMPONENT . '/views/attendances/tmpl/print_table.php';
        
        window.open("http://www.esv-kepi.at/administrator/components/com_attendance/views/attendances/print_table.php", "_blank", "width=200, height=100");
      
        /*
        $view = JFactory::getApplication()->input->getCmd('view', 'attendances');
        JFactory::getApplication()->input->set('view', $view);
        parent::display($cachable, $urlparams);
        return true;
    }
        */
    
}
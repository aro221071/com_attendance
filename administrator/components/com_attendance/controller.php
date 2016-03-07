<?php

/**
 * @version     2.0.0
 * @package     com_attendance
 * @copyright   Copyright (C) 2015. Alle Rechte vorbehalten.
 * @license     GNU General Public License Version 2 oder später; siehe LICENSE.txt
 * @author      Artelsmair Roman <aroaro@gmx.at> - http://artelsmair.at
 */
// No direct access
defined('_JEXEC') or die;

class AttendanceController extends JControllerLegacy {

    /**
     * Method to display a view.
     *
     * @param	boolean			$cachable	If true, the view output will be cached
     * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return	JController		This object to support chaining.
     * @since	1.5
     */
    public function display($cachable = false, $urlparams = false) 
    {
        require_once JPATH_COMPONENT . '/helpers/attendance.php';

        $view = JFactory::getApplication()->input->getCmd('view', 'teilnahmen');
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }
    
    /* Der Zweig funktioniert wenn in der Url http://www.esv-kepi.at/administrator/index.php?option=com_attendance&view=attendances&task=printout
    public function printout()
    {
        require_once JPATH_COMPONENT . '/helpers/printtable.php';
        require_once JPATH_COMPONENT . '/views/attendances/tmpl/print_table.php';
        
        window.open("http://www.esv-kepi.at/administrator/components/com_attendance/views/attendances/print_table.php", "_blank", "width=200, height=100");
      
        $view = JFactory::getApplication()->input->getCmd('view', 'attendances');
        JFactory::getApplication()->input->set('view', $view);
        parent::display($cachable, $urlparams);
        return $this;
    }
    */   
}

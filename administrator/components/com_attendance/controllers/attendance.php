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

jimport('joomla.application.component.controllerform');

/**
 * Attendance controller class.
 */
class AttendanceControllerAttendance extends JControllerForm
{
    function __construct() 
    {
        $this->view_list = 'attendances';
        parent::__construct();
    }
    
    function printout()
    {
      echo "Ausdrucken !";
      
    }
}
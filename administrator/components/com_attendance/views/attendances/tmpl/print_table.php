<?php
  /**
   * @version     1.0.0
   * @package     com_attendances
   * @copyright   Copyright (C) 2015. Alle Rechte vorbehalten.
   * @license     GNU General Public License Version 2 oder sp�ter; siehe LICENSE.txt
   * @author      Roman Artelsmair <roman@artelsmair.at> - http://www.artelsmair.at
   */
  // no direct access
  defined('_JEXEC') or die;
  
  /*
  JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
  JHtml::_('behavior.tooltip');
  JHtml::_('behavior.formvalidation');
  JHtml::_('formbehavior.chosen', 'select');
  JHtml::_('behavior.keepalive');
  */
  require_once JPATH_COMPONENT . '/helpers/attendance.php';
  
  // Import CSS
  // $document = JFactory::getDocument();
  // /administrator/components/com_attendance/views/attendances/tmpl
  // $document->addStyleSheet('components/com_attendance/assets/css/attendance_admin.css');
  // $document->addStyleSheet('components/com_attendance/views/attendances/tmpl/attendance_print.css');
  
  $params = array
  (
    from => '2014-01-01',
    to   => '2015-12-31',
    sum  => '1'            
  );
  $tbl = AttendanceHelper::aroGetAttendancesPrintTable($params);
  echo $tbl;
?>

<html>
  <head>
    <title>Teilnahmen ausdrucken</title>
  </head>
  <body onload='window.print(); window.close();' />
  </body>
</html>

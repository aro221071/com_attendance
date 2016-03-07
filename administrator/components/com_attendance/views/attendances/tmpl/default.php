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
  
  JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
  JHtml::_('behavior.tooltip');
  JHtml::_('behavior.formvalidation');
  JHtml::_('formbehavior.chosen', 'select');
  JHtml::_('behavior.keepalive');
  
  // Import CSS
  $document = JFactory::getDocument();
  // /administrator/components/com_attendance/views/attendances/tmpl
  $document->addStyleSheet('components/com_attendance/assets/css/attendance_admin.css');
  $document->addStyleSheet('components/com_attendance/views/attendances/tmpl/attendance_print.css');

       //var url = "<?php echo JURI::base()?>index.php?option=com_attendances&task="+task; 
  
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
    if ((task == "attendances.printout"))
    {
       var url = "<?php echo JURI::base()?>index.php?option=com_attendances&task=printout; 
    }
    else
    {
		  Joomla.submitform(task, document.getElementById('adminForm'));
    }    
	}
</script>


<html>
  <head>
    <title>Teilnahmen ausdrucken</title>
  </head>
  <body>
    <span id="filter" style="width:100%;">
        <label for="filter_search_from" class="element">
          <?php echo "Datum von: " /*JText::_('ATTENDANCE_DATE_FROM')*/; ?>
        </label>
        <input type="text" class="inputbox" name="filter_search_from" id="filter_search" placeholder="
          <?php echo JText::_('JSEARCH_FILTER_FROM'); ?>" 
          value="<?php echo $this->escape($this->state->get('filter.search.from')); ?>" title="<?php echo JText::_('JSEARCH_FILTER_FROM'); ?>" 
        />
        <br>
        <label for="filter_search" class="element">
          <?php echo "Datum bis: " /*JText::_('ATTENDANCE_DATE_TO')*/;?>
        </label>
        <input type="text" name="filter_search_to" id="filter_search" placeholder="
          <?php echo JText::_('JSEARCH_FILTER'); ?>" 
          value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('JSEARCH_FILTER'); ?>" 
        />
        <br>
        <?php
          $params = array
          (
            from => '2014-01-01',
            to   => '2015-12-31',
            sum  => '1'            
          );
          $tbl = AttendanceHelper::aroGetAttendancesPrintTable($params);
          echo $tbl;
        ?>
    </span>
  </body>
</html>

<?php
?>
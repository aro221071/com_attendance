<?php
/**
 * @version     2.0.0
 * @package     com_attendance
 * @copyright   Copyright (C) 2015. Alle Rechte vorbehalten.
 * @license     GNU General Public License Version 2 oder später; siehe LICENSE.txt
 * @author      Artelsmair Roman <aroaro@gmx.at> - http://artelsmair.at
 */
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canCreate = $user->authorise('core.create', 'com_attendance');
$canEdit = $user->authorise('core.edit', 'com_attendance');
$canCheckin = $user->authorise('core.manage', 'com_attendance');
$canChange = $user->authorise('core.edit.state', 'com_attendance');
$canDelete = $user->authorise('core.delete', 'com_attendance');
?>

<form action="<?php echo JRoute::_('index.php?option=com_attendance&view=teilnahmen'); ?>" method="post" name="adminForm" id="adminForm">

    <?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
    <table style="width:35%; margin-bottom:10px;border: 0;" class="table table-striped" id = "teilnahmeList" >

    
    <?php if (isset($this->items[0]->id)): ?>
    <?php endif; ?>

    				<?php if ($canEdit || $canDelete): ?>
					<th class="center">
				<?php echo JText::_('COM_ATTENDANCE_TEILNAHMEN_ACTIONS'); ?>
				</th>
				<?php endif; ?>

    </tr>
    <tfoot>
    <tr>
        <td style="border:0" colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
            <?php echo $this->pagination->getListFooter(); ?>
        </td>
    </tr>
    </tfoot>
    <tbody>
    <?php echo JHtml::_('form.token'); ?>

    </tbody>    
    </table>

    <?php foreach ($this->items as $i => $item) 
    {
        $canEdit = $user->authorise('core.edit', 'com_attendance');
    ?>
            <table width="100%" style="border: 3px solid #B3B2B2;margin-bottom:5px;">
              <col width="20%">
              <col width="80%">
                <?php echo getStr($item, 'title',       'Turnier: ',             'attendance_td_title_');      ?>
                <?php echo getStr($item, 'type',        'Turnierart: ',          'attendance_td_typestr_');    ?>
                <?php echo getStr($item, 'mode',        'Modus: ',               'attendance_td_mode_');       ?>
                <?php echo getStr($item, 'date',        'Datum: ',               'attendance_td_date_');       ?>
                <?php echo getStr($item, 'year_nr',     'Jahr / Nummer: ',       'attendance_td_yearnr_');     ?>
                <?php echo getStr($item, 'place_teams', 'Platz / Teams:',        'attendance_td_placeteams_'); ?>
                <?php echo getStr($item, 'team',        'Fahrer / Mannschaft: ', 'attendance_td_team_');       ?>
                <?php echo getStr($item, 'comment',     'Bemerkung:',            'attendance_td_comment_');    ?>
           </table>
    <?php 
    }  

  function getStr($result, $linekey, $label, $id)
  {
    $text = "";
    switch ($linekey) 
	  {
      case "title":
        if (strlen($result->name) > 0)
		      {$text = $result->name;}
        break;
	    case "type":
        if (strlen($result->type) > 0 && $result->type != "0")
		      {$text = $result->type;}
        break;
	    case "mode":
        if (strlen($result->mode) > 0)
		      {$text = $result->mode;}
        break;
      case "date":
        if ($result->date == "0000-00-00")
          {$text = "";}
        else if (strlen($result->date) > 0)
		      {$text = date('d.m.Y', strtotime($result->date));}
        break;	  
      case "year_nr":
        if ((strlen($result->date) == 0 || $result->date = "0000-00-00") && strlen($result->year) > 0 && strlen($result->number) > 0)
		      {$text = $result->year . ' / ' . $result->number;}
		    break;	  
      case "place_teams":
        if ( strlen($result->place) > 0 && 
             strlen($result->teams) > 0 && 
             $result->place != "0" && 
             $result->teams != "0"
           )
		       {
             $text = $result->place . '. von ' . $result->teams . ' Mannschaften';
           }
        elseif (strlen($result->place) > 0 && 
                $result->place != "0")     
		      {$text = $result->place . '.';}
        elseif (strlen($result->teams) > 0 && 
               $result->teams != "0")
		      {$text = 'Es nahmen ' . $result->teams . ' Mannschaften teil';}
        break;
      case "team":
        if (strlen($result->driver) > 0 && strlen($result->team) > 0)
		      {$text = $result->driver . ' (F), ' . $result->team;}
        elseif (strlen($result->team) > 0)
		      {$text = $result->team;}
        elseif (strlen($result->driver) > 0)
		      {$text = $result->driver . ' (F)';}
        break;    
      case "comment":
        if (strlen($result->comment) > 0)
		      {$text = $result->comment;}
        break;    
    }
	  
    if (strlen($text) > 0)
	  {
		  $hdr = '<td class="title" style="padding:2px;" id="' . $id . 'title" >' . $label . '</td>';
		  $val = '<td class="value" style="padding:2px;" id="' . $id . 'value" >' . $text .  '</td>';
		  return '<tr">'.$hdr.$val.'</tr>';              
	  }
    else
    {
      return "";
    }  
  }
?>

    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
    <input type="hidden" name="filter_order_Dir" value="<?php echo "desc"; ?>"/>
                                                        <?php /* echo $listDirn; */ ?>
              
</form> 


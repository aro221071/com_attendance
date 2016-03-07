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

/**
 * Attendance helper.
 */
class AttendanceHelper 
{

  /**
   * Configure the Linkbar.
  */
  
  public static function addSubmenu($vName = '') 
  {
    JHtmlSidebar::addEntry( JText::_('COM_ATTENDANCE_TITLE_TEILNAHMEN'), 'index.php?option=com_attendance&view=teilnahmen', $vName == 'teilnahmen');
    JHtmlSidebar::addEntry( JText::_('COM_ATTENDANCE_TITLE_TYPES'),      'index.php?option=com_attendance&view=types',      $vName == 'types');
    JHtmlSidebar::addEntry( JText::_('COM_ATTENDANCE_TITLE_ATTENDANCES'),'index.php?option=com_attendance&view=attendances',$vName == 'attendances');
  }

  /**
   * Gets a list of the actions that can be performed.
   *
   * @return	JObject
   * @since	1.6
  */
  public static function getActions() 
  {
    $user = JFactory::getUser();
    $result = new JObject;

    $assetName = 'com_attendance';

    $actions = array('core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete');

    foreach ($actions as $action)
    {
      $result->set($action, $user->authorise($action, $assetName));
    }
    return $result;
  }
  
  public static function aroFormatDate($date)
  {
    $bd = $date;
    $dt = date_create($bd);
    $bo = date_timestamp_get($dt);
    $bo = date('d.m.Y', $bo);
    return $bo;
  }
  
  /**
   * Convert a Date 
   *
   * @return	JObject
   * @since	1.6
  */
  public static function aroGetDate($strDate, $strFormatFrom, $strFormatTo)
  {
    $dt = $strDate;
    if ($strFormatFrom == "Y-m-d" OR $strFormatFrom = "")
    {
      /* 2014-12-31 */
      $y =  substr($strDate, 0, 4);
      $m =  substr($strDate, 5, 2);
      $d =  substr($strDate, 8, 2);
    }
    elseif ($strFormatFrom == "d.m.Y")
    {
      /* 31.12.2014 */
      $d =  substr($strDate, 0, 2);
      $m =  substr($strDate, 3, 2);
      $y =  substr($strDate, 6, 4);
    }
    
    if ($strFormatTo == "Y-m-d" OR $strFormatTo == "")
    {
      $dt = DateTime::createFromFormat('Y-m-d', $y.'-'.$m.'-'.$d);
    }
    elseif ($strFormatTo == "d.m.Y")
    {
      $dt = DateTime::createFromFormat('d.m.Y', $d.'.'.$m.'.'.$y);
    }
    return $dt;
  }
  
  public static function aroNumberCorrectAndGet($id, $date)
  {
    /*
    $year = date_format($date, 'Y');
    var_dump($year);
    
    $stmtSel = "SELECT MAX(number) 
                  FROM #__attendance_items 
                 WHERE year = '$year'
                   AND date <= '$date' ";
    
    $stmtUpd = "UPDATE #__attendance_items
                   SET number = number + 1 
                 WHERE year = '$year'
                   AND date > '$date'";
    */
    $newnumber = 1;
    /*
    $db = JFactory::getDbo();
		$db->setQuery($stmtSel);
    $row = $db->loadRow();
    
    if ($row)
    {
      $number = $row['0'];
      if ($number == 0 || is_null($number))
      {
        $newnumber = 1;     
      }
      else 
      {
        $newnumber = $number + 1;
      }
      var_dump($newnumber);
    }
    else 
    {
      $newnumber = 1;
    }
    */
    return $newnumber;
    /*if $stmtSel no result doesnt update number*/
  }

  public static function aroGetAttendancesPrintTable($params)
  {
    // init and execute loop
    $out            = "";
    $sumAnzTurniere = 0;
    $sumKm          = 0;
    $sumKmCash      = 0;
    $sumPlace       = 0;
    $sumFee         = 0;

    $date_from = AttendanceHelper::aroGetDate($params["from"], "Y-m-d", "Y-m-d");
    $date_to   = AttendanceHelper::aroGetDate($params["to"],   "Y-m-d", "Y-m-d");
    $dt_from   = $date_from->format("d.m.Y");
    $dt_to     = $date_to->format("d.m.Y");
    $sum       = $param["sum"];

    $out = $out . "";
    $out = $out . '<table class="atttable" border=1 cellspacing="0" cellpadding="4">';

    // column definition
    $out = $out . '<colgroup>
                     <col class="colDate">
                     <col class="colName">
                     <col class="colFare" style="text-align:rigtht;">
                     <col class="colFee" style="text-align:rigtht;">
                     <col class="colDistance" style="text-align:rigtht;">
                     <col class="colPlace">
                     <col class="colTeams">
                     <col class="colTeam">
                   </colgroup>'; 

    $out = $out . '<thead class="atttrhead">';
    // title row
    $out = $out . '<tr>';
    $out = $out . '<td colspan="8" style="font-size:16pt;padding:15px;">';
    $out = $out . 'ASK&Ouml; Kematen-Piberbach Turnier Teilnahmen von&nbsp' . $dt_from . '&nbsp;bis&nbsp;' . $dt_to;
    $out = $out . '</td>';
    $out = $out . '</tr>';
    // ------------------------------
    // header row - column titles
    // Datum
    $out = $out . '<td class="atttrhead">';
    $out = $out . 'Datum';
    $out = $out . '</td>';
    // Turniername
    $out = $out . '<td class="atttrhead" >';
    $out = $out . 'Turniername';
    $out = $out . '</td>';
    // Stargeb�hr
    $out = $out . '<td class="atttrhead">';
    $out = $out . 'Start<br>geb.';
    $out = $out . '</td>';
    // Km
    $out = $out . '<td class="atttrhead">';
    $out = $out . 'Gef.<br>Km';
    $out = $out . '</td>';
    // Km Geld
    $out = $out . '<td class="atttrhead">';
    $out = $out . 'Km<br>Geld';
    $out = $out . '</td>';
    // Platz
    $out = $out . '<td class="atttrhead">';
    $out = $out . 'Platz';
    $out = $out . '</td>';
    // Teilnehmer
    $out = $out . '<td class="atttrhead">';
    $out = $out . 'Teams';
    $out = $out . '</td>';
    // Personen
    $out = $out . '<td class="atttrhead">';
    $out = $out . 'Spielernamen';
    $out = $out . '</td>';
    // ------------------------------
    $out = $out . '</thead>';

    // execute query 
    $dbo = JFactory::getDbo();
    $qry = $dbo->getQuery(true);
    $qry->select('date, distance, name, fee, fare, place, teams, driver, team, comment');
    $qry->from('#__attendance_items');
    $qry->where(" state > 0 AND date >= '". $date_from->format("Y-m-d") . "' AND date <= '" . $date_to->format("Y-m-d") . "'"); 
    $qry->order('date');
    $dbo->setQuery($qry);

    $out = $out.'<tbody>';
    $result = $dbo->loadObjectList();
    foreach ($result as $item)
    {
      $out = $out.'<tr>';
      $out = $out.'<td>';
      if (is_null($item->date) OR $item->date == "0000-00-00")
      {
        $out = $out . '&nbsp;';        
      }
      else 
      {
        $out = $out . AttendanceHelper::aroFormatDate($item->date);
      }
      $out = $out.'</td>';
      $out = $out.'<td>';
      $out = $out . $item->name;
      $out = $out.'</td>';
      $out = $out.'<td style="text-align:right;">';
      $out = $out . $item->fee;
      $out = $out.'</td">';
      $out = $out.'<td  style="text-align:right;">';
      $out = $out . $item->distance;
      $out = $out.'</td>';
      $out = $out.'<td  style="text-align:right;">';
      $out = $out . $item->fare;
      $out = $out.'</td>';
      $out = $out.'<td style="text-align:right;">';
      $out = $out . $item->place;
      $out = $out.'</td>';
      $out = $out.'<td style="text-align:right;">';
      $out = $out . $item->teams;
      $out = $out.'</td>';
      $out = $out.'<td>';
      if ($item->driver == '' AND $item->team == '')
      {
        $out = $out . " ";
      }
      elseif ($item->driver != '' AND $item->team != '')
      {
        $out = $out . $item->driver . ' (F), ' . $item->team;
      }
      elseif ($item->driver != '' OR $item->team != '')
      {
        $out = $out . $item->driver . $item->team;
      }
      $out = $out.'</td>';
      $out = $out.'</tr>';

      $sumAnzTurniere = $sumAnzTurniere + 1;
      $sumKm          = $sumKm          + $item->distance;
      $sumKmCash      = $sumKmCash      + $item->fare;
      $sumFee         = $sumFee         + $item->fee;

    }

    $out = $out.'<tr>';
            // Datum
    $out = $out . '<td class="atttrhead">';
    $out = $out . '&nbsp;';
    $out = $out . '</td>';
    // Turniername
    $out = $out . '<td class="atttrhead" >';
    $out = $out . 'Summe&nbsp;' . $sumAnzTurniere . '&nbsp;Turniere';
    $out = $out . '</td>';
    // Stargeb�hr
    $out = $out . '<td class="atttrhead">';
    $out = $out . $sumFee;
    $out = $out . '</td>';
    // Km
    $out = $out . '<td class="atttrhead">';
    $out = $out . $sumKm;
    $out = $out . '</td>';
    // Km Geld
    $out = $out . '<td class="atttrhead">';
    $out = $out . $sumKmCash;
    $out = $out . '</td>';
    // Platz
    $out = $out . '<td class="atttrhead">';
    $out = $out . '&nbsp;';
    $out = $out . '</td>';
    // Teilnehmer
    $out = $out . '<td class="atttrhead">';
    $out = $out . '&nbsp;';
    $out = $out . '</td>';
    // Personen
    $out = $out . '<td class="atttrhead">';
    $out = $out . '&nbsp;';
    $out = $out . '</td>';
    $out = $out.'</tr>';

    $out = $out.'</tbody>';
    $out = $out.'</table>';
    
    $out = str_replace("ö", "&ouml;", $out);    
    $out = str_replace("ü", "&uuml;", $out);
    $out = str_replace("ä", "&auml;", $out);
    $out = str_replace("Ö", "&Ouml;", $out);    
    $out = str_replace("Ü", "&Uuml;", $out);
    $out = str_replace("Ä", "&Auml;", $out);
    
    return $out;        
  }  
}
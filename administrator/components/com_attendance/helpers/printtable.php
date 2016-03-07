<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

  defined('_JEXEC') or die;
  
  JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
  JHtml::_('behavior.tooltip');
  JHtml::_('behavior.formvalidation');
  JHtml::_('formbehavior.chosen', 'select');
  JHtml::_('behavior.keepalive');
  
  // Import CSS
  $document = JFactory::getDocument();

  class PrinterHelper
  {
  
    function printtable($query)
    {
      $db = JFactory.getDbo();
      $db->setQuery($query);
      $rows = $db->loadObjectList();

      $tbl = "";
      
        $tbl = $tbl . "<table>";
        $tbl = $tbl . "<tr>";

        $tbl = $tbl . "<th>";
        $tbl = $tbl . "";
        $tbl = $tbl . "</th>";
        
        $tbl = $tbl . "<th>";
        $tbl = $tbl . "";
        $tbl = $tbl . "</th>";
        
        $tbl = $tbl . "<th>";
        $tbl = $tbl . "";
        $tbl = $tbl . "</th>";
        
        $tbl = $tbl . "<th>";
        $tbl = $tbl . "";
        $tbl = $tbl . "</th>";
      
      $tbl = $tbl . "</tr>";

      
      $iRow = 0;
      $iRows = 0;
      $iCol = 0;
      $iCols = 0;
      
      foreach( $rows as $row ) 
      { 
        $iCols = count($row);
        while ($iCol < $iCols)
        {
          $tbl = $tbl. "<tr>";
        
          $tbl = $tbl. "<td>";
          $tbl = $tbl . $row->name;
          
          $tbl = $tbl. "</td>";
        }
      
        $tbl = $tbl. "</tr>";      
      }
    }
  }

?>
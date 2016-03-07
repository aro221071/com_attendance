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

jimport('joomla.application.component.view');

/**
 * View class for a list of Attendance.
 */
class AttendanceViewAttendances extends JViewLegacy 
{

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        AttendanceHelper::addSubmenu('attendances');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() 
    {
        require_once JPATH_COMPONENT . '/helpers/attendance.php';

        $state = $this->get('State');
        $canDo = AttendanceHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_ATTENDANCE_TITLE_ATTENDANCES'), 'attendances.png');

        //Check if the form exists before showing the add/edit buttons
        /*
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/attendance';
        if (file_exists($formPath)) 
        {

            
            if ($canDo->get('core.create')) 
            {
                JToolBarHelper::addNew('attendance.add', 'JTOOLBAR_NEW');
            }
        
            if ($canDo->get('core.edit') && isset($this->items[0])) 
            {
                JToolBarHelper::editList('attendance.edit', 'JTOOLBAR_EDIT');
            }
        }
        */
        
        /*JToolBarHelper::custom('attendances.search',   'options', 'options', 'JTOOLBAR_SEARCH',  false);*/
        JToolBarHelper::custom('attendances.printout', '', '', 'JTOOLBAR_PRINTOUT', false, false);

        /*
        if ($canDo->get('core.edit.state')) 
        {
            if (isset($this->items[0]->state)) 
            {
                JToolBarHelper::divider();
                JToolBarHelper::custom('attendances.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('attendances.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } 
            else if (isset($this->items[0])) 
            {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'attendances.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) 
            {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('attendances.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) 
            {
                JToolBarHelper::custom('attendances.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }
        
        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) 
        {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) 
            {
                JToolBarHelper::deleteList('', 'attendances.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } 
            else if ($canDo->get('core.edit.state')) 
            {
                JToolBarHelper::trash('attendances.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }
        */

        if ($canDo->get('core.admin')) 
        {
            JToolBarHelper::preferences('com_attendance');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_attendance&view=attendances');

        $this->extra_sidebar = '';
        //
    }

  	protected function getSortFields()
    {
      return array(
      'a.id' => JText::_('JGRID_HEADING_ID'),
      'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
      'a.state' => JText::_('JSTATUS'),
      );
    }

    
    
    /*
    public function printout($task = '', $icon = '', $iconOver = '', $alt = '', $listSelect = false)
    {
        $this->state = $this->get('State');
        
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        AttendanceHelper::addSubmenu('attendances');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        echo "da ist die SAU !";
        parent::display($tpl);
    }
    */    
}

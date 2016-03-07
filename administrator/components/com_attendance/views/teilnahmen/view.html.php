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
class AttendanceViewTeilnahmen extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        AttendanceHelper::addSubmenu('teilnahmen');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/attendance.php';

        $state = $this->get('State');
        $canDo = AttendanceHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_ATTENDANCE_TITLE_TEILNAHMEN'), 'teilnahmen.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/teilnahme';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('teilnahme.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('teilnahme.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('teilnahmen.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('teilnahmen.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'teilnahmen.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('teilnahmen.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('teilnahmen.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'teilnahmen.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('teilnahmen.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_attendance');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_attendance&view=teilnahmen');

        $this->extra_sidebar = '';
                                                        
        //Filter for the field type;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_attendance.teilnahme', 'teilnahme');

        $field = $form->getField('type');

        $query = $form->getFieldAttribute('filter_type','query');
        $translate = $form->getFieldAttribute('filter_type','translate');
        $key = $form->getFieldAttribute('filter_type','key_field');
        $value = $form->getFieldAttribute('filter_type','value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items))
        {
            foreach ($items as $item)
            {
                if ($translate == true)
                {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                }
                else
                {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
            '$Type',
            'filter_type',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.type')),
            true
        );
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.name' => JText::_('COM_ATTENDANCE_TEILNAHMEN_NAME'),
		'a.date' => JText::_('COM_ATTENDANCE_TEILNAHMEN_DATE'),
		'a.type' => JText::_('COM_ATTENDANCE_TEILNAHMEN_TYPE'),
		'a.mode' => JText::_('COM_ATTENDANCE_TEILNAHMEN_MODE'),
		'a.place' => JText::_('COM_ATTENDANCE_TEILNAHMEN_PLACE'),
		'a.teams' => JText::_('COM_ATTENDANCE_TEILNAHMEN_TEAMS'),
		'a.driver' => JText::_('COM_ATTENDANCE_TEILNAHMEN_DRIVER'),
		'a.team' => JText::_('COM_ATTENDANCE_TEILNAHMEN_TEAM'),
		'a.distance' => JText::_('COM_ATTENDANCE_TEILNAHMEN_DISTANCE'),
		'a.fee' => JText::_('COM_ATTENDANCE_TEILNAHMEN_FEE'),
		'a.fare' => JText::_('COM_ATTENDANCE_TEILNAHMEN_FARE'),
		'a.currency' => JText::_('COM_ATTENDANCE_TEILNAHMEN_CURRENCY'),
		'a.comment' => JText::_('COM_ATTENDANCE_TEILNAHMEN_COMMENT'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		);
	}

}

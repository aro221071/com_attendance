<?php

/**
 * @version     2.0.0
 * @package     com_attendance
 * @copyright   Copyright (C) 2015. Alle Rechte vorbehalten.
 * @license     GNU General Public License Version 2 oder später; siehe LICENSE.txt
 * @author      Artelsmair Roman <aroaro@gmx.at> - http://artelsmair.at
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Attendance records.
 */
class AttendanceModelTeilnahmen extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'year', 'a.year',
                'number', 'a.number',
                'name', 'a.name',
                'date', 'a.date',
                'type', 'a.type',
                'mode', 'a.mode',
                'place', 'a.place',
                'teams', 'a.teams',
                'driver', 'a.driver',
                'team', 'a.team',
                'distance', 'a.distance',
                'fee', 'a.fee',
                'fare', 'a.fare',
                'currency', 'a.currency',
                'sortkey', 'a.sortkey',
                'published', 'a.published',
                'comment', 'a.comment',
                'created', 'a.created',
                'creator', 'a.creator',
                'modified', 'a.modified',
                'modifier', 'a.modifier',
                'ordering', 'a.ordering',
                'state', 'a.state',
                'created_by', 'a.created_by',

            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) 
    {
      // Initialise variables.
      $app = JFactory::getApplication('administrator');

      // Load the filter state.
      $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
      $this->setState('filter.search', $search);

      $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
      $this->setState('filter.state', $published);


      //Filtering type
      $this->setState('filter.type', $app->getUserStateFromRequest($this->context.'.filter.type', 'filter_type', '', 'string'));


      // Load the parameters.
      $params = JComponentHelper::getParams('com_attendance');
      $this->setState('params', $params);

      // List state information.
      parent::populateState('a.ordering', 'desc');
    }

    /**
    * Method to get a store id based on model configuration state.
    *
    * This is necessary because the model is used by the component and
    * different modules that might need different sets of data or different
    * ordering requirements.
    *
    * @param	string		$id	A prefix for the store id.
    * @return	string		A store id.
    * @since	1.6
    */
    protected function getStoreId($id = '') 
    {
      // Compile the store id.
      $id.= ':' . $this->getState('filter.search');
      $id.= ':' . $this->getState('filter.state');

      return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() 
    {
      // Create a new query object.
      $db = $this->getDbo();
      $query = $db->getQuery(true);

      // Select the required fields from the table.
      $query->select(
              $this->getState(
                      'list.select', 'DISTINCT a.*'
              )
      );
      $query->from('`#__attendance_items` AS a');

        
      // Join over the users for the checked out user
      $query->select("uc.name AS editor");
      $query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
      // Join over the foreign key 'type'
      $query->select('#__attendance_type_1854361.shortname AS types_shortname_1854361');
      $query->join('LEFT', '#__attendance_type AS #__attendance_type_1854361 ON #__attendance_type_1854361.id = a.type');
      // Join over the user field 'created_by'
      $query->select('created_by.name AS created_by');
      $query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

      // Join Club
      $query->select('club.name AS club');
      $query->join('LEFT', '#__clubmanager_club AS club ON club.id = a.club');


      // Filter by published state
      $published = $this->getState('filter.state');
      if (is_numeric($published)) 
      {
        $query->where('a.state = ' . (int) $published);
      } 
      else if ($published === '') 
      {
        $query->where('(a.state IN (0, 1))');
      }

      // Filter by search in title
      $search = $this->getState('filter.search');
      if (!empty($search)) 
      {
        if (stripos($search, 'id:') === 0) 
        {
          $query->where('a.id = ' . (int) substr($search, 3));
        } 
        else 
        {
          $search = $db->Quote('%' . $db->escape($search, true) . '%');
          $query->where('( a.name LIKE '.$search.'  OR  a.date LIKE '.$search.'  OR  a.type LIKE '.$search.'  OR  a.mode LIKE '.$search.'  OR  a.place LIKE '.$search.'  OR  a.teams LIKE '.$search.'  OR  a.driver LIKE '.$search.'  OR  a.team LIKE '.$search.'  OR  a.distance LIKE '.$search.'  OR  a.fee LIKE '.$search.'  OR  a.fare LIKE '.$search.'  OR  a.currency LIKE '.$search.'  OR  a.comment LIKE '.$search.' )');
        }
      }

        

		//Filtering type
		$filter_type = $this->state->get("filter.type");
		if ($filter_type) 
    {
			$query->where("a.type = '".$db->escape($filter_type)."'");
		}


    // Add the list ordering clause.
    $orderCol = $this->state->get('list.ordering');
    $orderDirn = $this->state->get('list.direction');
    if ($orderCol && $orderDirn) 
    {
      $query->order($db->escape($orderCol . ' ' . $orderDirn));
    }

    return $query;
    }

    public function getItems() {
        $items = parent::getItems();
        
		foreach ($items as $oneItem) {

			if (isset($oneItem->type)) 
      {
				$values = explode(',', $oneItem->type);

				$textValue = array();
				foreach ($values as $value)
        {
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('shortname'))
							->from('`#__attendance_type`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) 
           {
						$textValue[] = $results->shortname;
					}
				}
        $oneItem->type = !empty($textValue) ? implode(', ', $textValue) : $oneItem->type;
			}
		}
    return $items;
  }
}

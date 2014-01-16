<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * HelloWorld Form Field class for the HelloWorld component
 */
class JFormFieldattendance extends JFormFieldList
{

        /**
         * The field type.
         *
         * @var         string
         */
        protected $type = 'attendance';
 
        /**
         * Method to get a list of options for a list input.
         *
         * @return      array           An array of JHtml options.
         */
        protected function getOptions() 
        { 
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                $query->select('view_name, id');
                $query->from('#__sched_views');
                $db->setQuery((string)$query);
                $messages = $db->loadObjectList();
                $options = array();
                if ($messages)
                {
                        foreach($messages as $message) 
                        {
                                $options[] = JHtml::_('select.option', $message->id, $message->view_name, $message->id);
                        }
                }
                $options = array_merge(parent::getOptions(), $options);
                return $options;
        }
}
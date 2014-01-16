<?php
/**
* 
* @package JDownloads
* @copyright (C) 2013 www.jdownloads.com
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* This plugin compares the Joomla 'Viewing access levels' with the jDownloads user groups and add missing users to the user groups with the same names in jDownloads.
* How to use:  To add the users to a jDownloads user group, create a new user groups in jDownloads with exactly the same name as in the Joomla 'Viewing access levels'. 
*              Afterwards are added automaticly alle needed users to this group.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );


jimport('joomla.plugin.plugin');
 
class plgSystemMatch_user_groups_jdownloads extends JPlugin 
{ 
     
     public function __construct(& $subject, $config)
     {
            parent::__construct($subject, $config);
            $this->loadLanguage();
     }


     function onAfterInitialise() 
     { 
             $app = JFactory::getApplication();
            
             // We do not run in frontend
             // if (!$app->isAdmin()) return;            
             
             // Get Joomla version
             $jversion = new JVersion(); 
             $jvers = $jversion->RELEASE;
             
             // Get a db connection.
             $db  = JFactory::getDbo();
             $now = JFactory::getDate(); 
                 
             // Exist the tables?
             $prefix = $db->getPrefix(); 
             $tablelist = $db->getTableList();
             if ( !in_array ( $prefix.'jdownloads_groups', $tablelist ) ){
                 return;
             } 

            $plugin = JPluginHelper::getPlugin('system', 'match_user_groups_jdownloads');
            jimport( 'joomla.utilities.utility' );

            $query = $db
                ->getQuery(true)
                ->select(array('title','rules'))
                ->from('#__viewlevels')
                ->innerJoin('#__jdownloads_groups ON #__viewlevels.title = #__jdownloads_groups.groups_name');             
            $db->setQuery($query);             
            $group_viewlevels = $db->loadObjectList();
            
            if ($group_viewlevels != null) {
                // we have jdownloads groups, matching viewlevels 
                foreach ($group_viewlevels as $group_viewlevel) {
                    //Get a list of all the users in the groups    
                    $query = $db
                        ->getQuery(true)
                        ->select(array('user_id'))
                        ->from('#__user_usergroup_map')
                        ->where('group_id IN (' . implode(',',json_decode($group_viewlevel->rules)) . ')');                        
                    $db->setQuery($query);                     
                    $usergroup_mapping = $db->loadObjectList();
                    
                    //process each group
                    $userlist=array();
                    if ($usergroup_mapping != null) {
                        foreach ($usergroup_mapping as $usergroup_map) {
                            $userlist[]=$usergroup_map->user_id;
                        };
                    }

                    //update jdownloads with users if not empty
                    if(!empty($userlist)) {
                        $autosynced = JText::_('PLG_SYSTEM_MATCH_USER_GROUPS_JDOWNLOADS_AUTOSYNCED');
                        $fields     = array('groups_members=\''. implode(',', array_unique($userlist)) .'\'',
                                            'groups_description=\''.$autosynced.' '.$now.'\'',
                                            'groups_access=1');
                        $conditions = array('groups_name=\''. $group_viewlevel->title . '\'');
                        $query = $db->getQuery(true);
                        $query->update('#__jdownloads_groups')
                            ->set($fields)
                            ->where($conditions);
                        $db->setQuery($query);

                        try {
                            if ($jvers == '3.1' || $jvers == '3.0'){
                                // Use $db->execute() for Joomla 3.0.
                                $result = $db->execute();
                            } else {
                                $result = $db->query();
                            }
                        } catch (Exception $e) {
                            printf("UPDATE ERROR %s",$query);                            
                        }
                    }
                }
            }
     }
}        
?>
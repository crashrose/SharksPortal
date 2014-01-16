<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controllerform');

/**
 * Events Controller
*/

class attendanceControllerResponse extends JControllerForm
{
	
	protected $text_prefix = 'COM_ATTENDANCE_RESPONSE';
	/**
	 * Proxy for getModel.
	 * @since       2.5
	 */
	protected $view_list = 'Responses';
	

	
	public function getModel($name = 'Response', $prefix = 'attendanceModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
	
// 	public function batch($model = null)
// 	{
// 		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
// // 	var_dump ($this);	 
// 		// Set the model
// 		$model	= $this->getModel('Response', '', array());
// echo "here3";
// 		// Preset the redirect
// 		$this->setRedirect(JRoute::_('index.php?option=com_attendance&view=UnkResponses' . $this->getRedirectToListAppend(), false));
		
// 		$input	= JFactory::getApplication()->input;
// 		$vars	= $input->post->get('responses', array(), 'array');
// 		dump($vars);
// 		return $model->batch($vars);
// 	}
	
// 	protected function insert_responses()
// 	{
// 		// Set the variables
// // 		$user = JFactory::getUser();
// // 		$table = $this->getTable();
// 		echo "test insert";
	
// 		// 		foreach ($pks as $pk)
// 			// 		{
// 			// 			if ($user->authorise('core.edit', $contexts[$pk]))
// 				// 			{
// 				// 				$table->reset();
// 				// 				$table->load($pk);
// 				// 				$table->cid = (int) $value;
	
// 				// 				if (!$table->store())
// 					// 				{
// 					// 					$this->setError($table->getError());
// 					// 					return false;
// 					// 				}
// 					// 			}
// 					// 			else
// 						// 			{
// 						// 				$this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));
// 						// 				return false;
// 						// 			}
// 						// 		}
	
// 						// Clean the cache
// 						// 		$this->cleanCache();
// 		parent::__construct();
// 						return true;
// 				}
// // 				function __construct()
// // 				{
// // 					
// // 					parent::__construct();
				
// // 					// Register Extra tasks
// // 					$this->registerTask( 'insert_responses', 'insert_responses');
// // 				}

}
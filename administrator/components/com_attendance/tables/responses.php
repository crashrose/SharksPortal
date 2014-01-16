<?php
// No direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

// import Joomla table library
jimport ( 'joomla.database.table' );

/**
 * Attendance Response table class
 */
class attendanceTableResponses extends JTable {
	/**
	 * Constructor
	 *
	 * @param
	 *        	object Database connector object
	 */
	function __construct(&$db) {
		parent::__construct ( '#__sched_responses', 'id', $db );
	}
	public function store($keyArray, $updateNulls = false) {
		// Initialise variables.
		$k = $this->_tbl_key;
		if (! empty ( $this->asset_id )) {
			$currentAssetId = $this->asset_id;
		}
		
		// The asset id field is managed privately by this class.
		if ($this->_trackAssets) {
			unset ( $this->asset_id );
		}
		
		// If a primary key exists update the object, otherwise insert it.

			$setInactive = $this->setAsInactive($keyArray);

			$stored = $this->_db->insertObject ( $this->_tbl, $this, $this->_tbl_key );

		// If the store failed return false.
		if (! $stored) {
			$e = new JException ( JText::sprintf ( 'JLIB_DATABASE_ERROR_STORE_FAILED', get_class ( $this ), $this->_db->getErrorMsg () ) );
			$this->setError ( $e );
			return false;
		}
		
		// If the table is not set to track assets return true.
		if (! $this->_trackAssets) {
			return true;
		}
		
		if ($this->_locked) {
			$this->_unlock ();
		}
		
		//
		// Asset Tracking
		//
		
		$parentId = $this->_getAssetParentId ();
		$name = $this->_getAssetName ();
		$title = $this->_getAssetTitle ();
		
		$asset = JTable::getInstance ( 'Asset', 'JTable', array (
				'dbo' => $this->getDbo () 
		) );
		$asset->loadByName ( $name );
		
		// Re-inject the asset id.
		$this->asset_id = $asset->id;
		
		// Check for an error.
		if ($error = $asset->getError ()) {
			$this->setError ( $error );
			return false;
		}
		
		// Specify how a new or moved node asset is inserted into the tree.
		if (empty ( $this->asset_id ) || $asset->parent_id != $parentId) {
			$asset->setLocation ( $parentId, 'last-child' );
		}
		
		// Prepare the asset to be stored.
		$asset->parent_id = $parentId;
		$asset->name = $name;
		$asset->title = $title;
		
		if ($this->_rules instanceof JAccessRules) {
			$asset->rules = ( string ) $this->_rules;
		}
		
		if (! $asset->check () || ! $asset->store ( $updateNulls )) {
			$this->setError ( $asset->getError () );
			return false;
		}
		
		// Create an asset_id or heal one that is corrupted.
		if (empty ( $this->asset_id ) || ($currentAssetId != $this->asset_id && ! empty ( $this->asset_id ))) {
			// Update the asset_id field in this table.
			$this->asset_id = ( int ) $asset->id;
			
			$query = $this->_db->getQuery ( true );
			$query->update ( $this->_db->quoteName ( $this->_tbl ) );
			$query->set ( 'asset_id = ' . ( int ) $this->asset_id );
			$query->where ( $this->_db->quoteName ( $k ) . ' = ' . ( int ) $this->$k );
			$this->_db->setQuery ( $query );
			
			if (! $this->_db->execute ()) {
				$e = new JException ( JText::sprintf ( 'JLIB_DATABASE_ERROR_STORE_FAILED_UPDATE_ASSET_ID', $this->_db->getErrorMsg () ) );
				$this->setError ( $e );
				return false;
			}
		}
		
		return true;
	}
	public function setAsInactive($keyArray) {

		$where = ' WHERE rsvp_event = ' . $keyArray ['rsvp_event'] . ' AND rsvp_user = ' . $keyArray ['rsvp_user'];
		$set = ' SET rsvp_active = 0 ';
		$statement = 'UPDATE ' . $this->_db->quoteName($this->_tbl) . $set . $where;

		// Set the query and execute the update.
		$this->_db->setQuery ( $statement);
		return $this->_db->execute ();
	}
}
<?php
/**
 * @package api
 * @subpackage objects
 */
class KalturaEdgeServer extends KalturaRemoteServer
{	
	/**
	 * remoteServer host name
	 *
	 * @var string
	 * @filter like,mlikeor,mlikeand
	 */
	public $playbackHostName;
	
	/**
	 * Delivery profile ids comma seperated
	 * @var string
	 */
	public $deliveryProfileIds;
		
	private static $map_between_objects = array
	(
		"playbackHostName",
		"deliveryProfileIds",
	);
	
	/* (non-PHPdoc)
	 * @see KalturaObject::getMapBetweenObjects()
	 */
	public function getMapBetweenObjects ( )
	{
		return array_merge ( parent::getMapBetweenObjects() , self::$map_between_objects );
	}
	
	/* (non-PHPdoc)
	 * @see KalturaObject::toInsertableObject()
	 */
	public function toInsertableObject($object_to_fill = null, $props_to_skip = array())
	{
		if(is_null($object_to_fill))
			$object_to_fill = new EdgeServer();
			
		return parent::toInsertableObject($object_to_fill, $props_to_skip);
	}
}

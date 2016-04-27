<?php
/**
 * @package Scheduler
 * @subpackage Copy
 */
class kCopyingCategoryEntryEngine extends kCopyingEngine
{
	/* (non-PHPdoc)
	 * @see KCopyingEngine::copy()
	 */
	protected function copy(KalturaFilter $filter, KalturaObjectBase $templateObject) {
		$this->copyCategoryEntries ();
		
	}

	protected function copyCategoryEntries (KalturaFilter $filter, KalturaObjectBase $templateObject)
	{
		$filter->orderBy = KalturaCategoryEntryOrderBy::CREATED_AT_ASC;
		
		$categoryEntryList = KBatchBase::$kClient->categoryEntry->listAction($filter, $this->pager);
		if(!count($categoryEntryList->objects))
			return 0;
			
		KBatchBase::$kClient->startMultiRequest();
		foreach($categoryEntryList->objects as $categoryEntry)
		{
			$newCategoryEntry = $this->getNewObject($categoryEntry, $templateObject);
			KBatchBase::$kClient->categoryEntry->add($newCategoryEntry);
		}
		
		$results = KBatchBase::$kClient->doMultiRequest();
		foreach($results as $index => $result)
			if(!is_int($result))
				unset($results[$index]);
				
		if(!count($results))
			return 0;
			
		$lastCopyId = end($results);
		$this->setLastCopyId($lastCopyId);
		
		return count($results);
	}
	/* (non-PHPdoc)
	 * @see KCopyingEngine::getNewObject()
	 */
	protected function getNewObject(KalturaObjectBase $sourceObject, KalturaObjectBase $templateObject) {
		$class = get_class($sourceObject);
		$newObject = new $class();
		
		/* @var $newObject KalturaCategoryUser */
		/* @var $sourceObject KalturaCategoryUser */
		/* @var $templateObject KalturaCategoryUser */
		
		$newObject->categoryId = $sourceObject->categoryId;
		$newObject->entryId = $sourceObject->entryId;
			
		if(!is_null($templateObject->categoryId))
			$newObject->categoryId = $templateObject->categoryId;
		if(!is_null($templateObject->entryId))
			$newObject->entryId = $templateObject->entryId;
	
		return $newObject;
	}

	
}
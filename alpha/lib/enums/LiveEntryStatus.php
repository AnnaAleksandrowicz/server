<?php
/**
 * @package Core
 * @subpackage model.enum
 */ 
interface LiveEntryStatus extends BaseEnum
{
	const STOPPED = 0;
	const PLAYABLE = 1;
	const BROADCASTING = 2;
	const CONNECTED = 3;
}

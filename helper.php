<?php
/**
 * @package        mod_qlqlmessages
 * @copyright    Copyright (C) 2015 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
use Joomla\Database\DatabaseDriver;

defined('_JEXEC') or die;

class modQlmessagesHelper
{
    /** @var $db DatabaseDriver */
    public $db;
    public $params;
    public $module;

    function __construct($db, $module, $params)
    {
        $this->module = $module;
        $this->params = $params;
        $this->db = $db;
    }

    public function getMessagesByFolder(?int $folderId = null): array
    {
        $query = $this->db->getQuery(true);
        $query
            ->select('*')
            ->from('#__messages');
        if (is_numeric($folderId)) {
            $query->where(sprintf('folder = %s', $folderId));
        }
        $this->db->setQuery($query);
        return $this->db->loadObjectList();
	}
}

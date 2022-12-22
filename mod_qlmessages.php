<?php
/**
 * @package		mod_qlmessages
 * @copyright	Copyright (C) 2022 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
use Joomla\Database\DatabaseDriver;

defined('_JEXEC') or die;
require_once dirname(__FILE__).'/helper.php';

/** @var $module  */
/** @var $params  */
$helper = new modQlmessagesHelper(\Joomla\CMS\Factory::getContainer()->get(DatabaseDriver::class), $module, $params);

$messages = $helper->getMessagesByFolder();
require JModuleHelper::getLayoutPath('mod_qlmessages', $params->get('layout', 'default'));

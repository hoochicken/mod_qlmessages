<?php
/**
 * @package		mod_qlmessages
 * @copyright	Copyright (C) 2022 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
use Joomla\CMS\Factory;
// no direct access
defined('_JEXEC') or die;
$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->registerStyle('qlmessages', 'mod_qlmessages/styles.css');
$wa->useStyle('qlmessages');
?>

<div class="qlmessages" id="module<?php echo $module->id ?>">
</div>
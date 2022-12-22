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
/** @var stdClass $module*/
/** @var JRegistry $params*/
/** @var array $messages [stdClass] */
require_once JPATH_BASE . '/modules/mod_qlmessages/php/classes/QlGrid.php';
// require_once __DIR__ . '/../php/QlGrid.php';
?>
<div class="qlmessages" id="module<?php echo $module->id ?>">
    <?php
    $table = new QlGrid($messages, QlGrid::enrichColumns(['message_id', 'subject', 'message']));
    echo $table->getHtmlTable();
    ?>
</div>

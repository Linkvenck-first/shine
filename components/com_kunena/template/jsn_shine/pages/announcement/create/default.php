<?php
/**
 * Kunena Component
 * @package     Kunena.Template
 * @subpackage  Pages.Announcement
 *
 * @copyright   (C) 2008 - 2016 Kunena Team. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link        https://www.kunena.org
 **/
defined('_JEXEC') or die;

$content = $this->execute('Announcement/Edit');

$this->addBreadcrumb(
	JText::_('COM_KUNENA_ANN_ANNOUNCEMENTS'),
	'index.php?option=com_kunena&view=announcement&layout=list'
);

echo $content;

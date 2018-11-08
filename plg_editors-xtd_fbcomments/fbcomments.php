<?php
/**
 * @package    Facebook Comments Package
 * @version    0.5.0
 * @author     Artem Pavluk - www.art-pavluk.com
 * @copyright  Copyright (c) 2010 - 2018 Private master Pavluk. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link       https://art-pavluk.com
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;

class PlgButtonFbComments extends CMSPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since 0.5.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * Facebook comments button
	 *
	 * @param   string $name The name of the button to add
	 *
	 * @return  JObject  The button options as JObject
	 *
	 * @since 0.5.0
	 */
	public function onDisplay($name)
	{
		HTMLHelper::_('script', 'media/plg_editors-xtd_fbcomments/js/fbcomments.js', array('version' => 'auto'));

		// Pass some data to javascript
		Factory::getDocument()->addScriptOptions(
			'xtd-fbcomments',
			array(
				'editor' => $this->_subject->getContent($name),
				'exists' => Text::_('PLG_EDITORS-XTD_FBCOMMENTS_ALREADY_EXISTS', true),
			)
		);

		$button          = new JObject;
		$button->modal   = false;
		$button->class   = 'btn';
		$button->onclick = 'insertFbComments(\'' . $name . '\');return false;';
		$button->text    = Text::_('PLG_EDITORS-XTD_FBCOMMENTS_BUTTON');
		$button->name    = 'comments';
		$button->link    = '#';

		return $button;
	}
}
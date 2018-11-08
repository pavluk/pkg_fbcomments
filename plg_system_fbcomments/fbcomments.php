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
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;

class plgSystemFbComments extends CMSPlugin
{
	/**
	 * Replace shortcodes from body
	 *
	 * {fbcomments_form}
	 *
	 * @return  void
	 *
	 * @since 0.5.0
	 */
	public function onAfterRender()
	{
		if (Factory::getApplication()->isSite())
		{
			$language    = str_replace('-', '_', Factory::getLanguage()->getTag());
			$app_id      = $this->params->get('app_id', '');
			$facebook_js = <<<FACEBOOK
			<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = 'https://connect.facebook.net/$language/sdk.js#xfbml=1&version=v3.2&appId=$app_id';
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
        </script> 
FACEBOOK;
			$html        = '<div id="fb-root"></div>';
			$html        .= '<div class="fb-comments" data-width="100%" data-href="' . Uri::getInstance()->toString() . '"></div>';
			$body        = JResponse::getBody();
			preg_match_all('{fbcomments_form}', $body, $matches, PREG_PATTERN_ORDER);
			if (!empty($matches[0]))
			{
				$body = str_replace('</head>', $facebook_js . PHP_EOL . '</head>', $body);
				$body = str_replace('{fbcomments_form}', $html, $body);

				JResponse::setBody($body);
			}


		}
	}
}
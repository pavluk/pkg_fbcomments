/*
 * @package    Facebook Comments Package
 * @version    0.5.0
 * @author     Artem Pavluk - www.art-pavluk.com
 * @copyright  Copyright (c) 2010 - 2018 Private master Pavluk. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link       https://art-pavluk.com
 */

window.insertFbComments = function (editor) {
	"use strict";
	if (!Joomla.getOptions('xtd-fbcomments')) {
		// Something went wrong!
		return false;
	}

	var content, options = window.Joomla.getOptions('xtd-fbcomments');

	if (window.Joomla && window.Joomla.editors && window.Joomla.editors.instances && window.Joomla.editors.instances.hasOwnProperty(editor)) {
		content = window.Joomla.editors.instances[editor].getValue();
	} else {
		content = (new Function('return ' + options.editor))();
	}

	if (content.match(/{fbcomments_form}/i)) {
		alert(options.exists);
		return false;
	}
	else {
		/** Use the API, if editor supports it **/
		if (window.Joomla && window.Joomla.editors && window.Joomla.editors.instances && window.Joomla.editors.instances.hasOwnProperty(editor)) {
			window.Joomla.editors.instances[editor].replaceSelection('<div>{fbcomments_form}</div>');
		} else {
			window.jInsertEditorText('<div>{fbcomments_form}</div>', editor);
		}
	}
};
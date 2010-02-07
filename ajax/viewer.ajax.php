<?php
/**
 * Ajax functionality
 * @author Kissaki
 */

require_once dirname(__FILE__).'/ajax.ajax.php';

/**
 * ajax functionality, functions for the admin section
 * @author Kissaki
 */
class Ajax_Viewer extends Ajax
{
	public static function getServerTreeAsHtml()
	{
		self::checkParameters(array('serverId'));
		$serverId = $_POST['serverId'];
		echo ServerViewer::getHtmlCode4ViewServer($serverId);
	}
}

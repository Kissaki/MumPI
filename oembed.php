<?php
define('MUMPHPI_MAINDIR', dirname(__FILE__));

if (!file_exists('settings.inc.php')) {
	header('HTTP/1.1 500 Internal Server Error');
	header('Content-Type: text/plain; charset=utf-8');
	echo 'Failed to locate settings file.';
	exit();
}

if (!isset($_GET['url']))
{
	header('400 Bad Request');
	header('Content-Type: text/plain; charset=utf-8');
	echo 'Invalid request. Missing required url parameter. See http://oembed.com/';
	exit();
}

//We should create a response according to the url parameter…
//require_once(dirname(__FILE__) . '/classes/SettingsManager.php');
//if ($url 
//404 Not Found

$url = html_entity_decode($_GET['url']);
$width = isset($_GET['maxwidth']) ? intval(html_entity_decode($_GET['maxwidth'])) : 180;
$height = isset($_GET['maxwidth']) ? intval(html_entity_decode($_GET['maxheight'])) : 200;
$format = isset($_GET['format']) ? html_entity_decode($_GET['format']) : 'json';

if ($format !== 'json')
{
	header('501 Not Implemented');
	header('Content-Type: text/plain; charset=utf-8');
	echo 'Unsupported format.';
	exit();
}

$serverid = !empty($_GET['serverid']) ? intval($_GET['serverid']) : 1;

$html = <<<'EOD'
<div id="mview-container"></div>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="mview.js"></script>
<script type="text/javascript">
  var settings = {
      target: '#mview-container',
      source: '../?view=json&serverId=%d&callback=?',
      resurl: '',
      refreshinterval: 30
    };
  mv = new MView(settings);
  mv.load();');
</script>
EOD;

$html = sprintf($html, $serverid);

header('Content-Type: application/json; charset=utf-8');
echo json_encode(
	array(
		'type' => 'rich',
		'version' => '1.0',
		// Optional parameters follow
//		'title' => '',
//		'author_name' => '',
//		'author_url' => '',
//		'provider_name' => '',
//		'provider_url' => '',
		// suggested cache lifetime, in seconds
//		'cache_age' => '10',
//		'thumbnail_url' => '',
//		'thumbnail_width' => '',
//		'thumbnail_height' => '',
		// type rich, required
		'html' => $html,
		'width' => $width,
		'height' => $height,
	)
);

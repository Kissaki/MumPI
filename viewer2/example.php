<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
</head>
<body>

<h1>MumPI standalone JS <a href="http://mumble.sourceforge.net/Channel_Viewer_Protocol" rel="external">MumbleViewerProtocol</a> Viewer – valid HTML, no iframe</h1>

<h2>How to embed:</h2>
<pre>
&lt;div id="mview-container">&lt;/div>
&lt;script type="text/javascript" src="mview.js">&lt/script>
&lt;script type="text/javascript">
  mview.load(document.getElementById('mview-container'), '<span style="text-decoration:strike-through;">pathto</span>/MumPI/?view=json&amp;serverId=&amp;callback=?');
&lt/script>
</pre>

<h2>Example:</h2>
<div id="mview-container"></div>
<script type="text/javascript" src="mview.js"></script>
<script type="text/javascript">
  mview.load(document.getElementById('mview-container'), '../?view=json&amp;serverId=<?php echo (!empty($_GET['serverid']) ? intval($_GET['serverid']) : 1); ?>');
</script>

</body>
</html>
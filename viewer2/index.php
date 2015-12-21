<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>MView – Mumble Channel Viewer</title>
</head>
<body>

<div id="mview-container"></div>
<script type="text/javascript" src="//code.jquery.com/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="mview.js"></script>
<script type="text/javascript">
  var settings = {
      target: '#mview-container',
      source: '../?view=json&serverId=<?php echo (!empty($_GET['serverid']) ? intval($_GET['serverid']) : 1); ?>&callback=?',
      resurl: '',
      refreshinterval: 30
    };
  mv = new MView(settings);
  mv.load();
</script>

</body>
</html>
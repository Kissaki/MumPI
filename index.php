<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="DooC Forum - Index" />
	<meta name="keywords" content="PHP, MySQL, bulletin, board, free, open, source, smf, simple, machines, forum" />
	<script language="JavaScript" type="text/javascript">
	<link rel="stylesheet" type="text/css" href="style.css" />

	<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
		var current_header = true;

		function shrinkHeader(mode)
		{
			smf_setThemeOption("collapse_header", mode ? 1 : 0, null, "0437f3539922170e24ecfc9ede6d6993");
			document.getElementById("upshrink").src = smf_images_url + (mode ? "/upshrink2.gif" : "/upshrink.gif");

			document.getElementById("upshrinkHeader").style.display = mode ? "none" : "";
			document.getElementById("upshrinkHeader2").style.display = mode ? "none" : "";

			current_header = mode;
		}
	// ]]></script>
		<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
			var current_header_ic = false;

			function shrinkHeaderIC(mode)
			{
				smf_setThemeOption("collapse_header_ic", mode ? 1 : 0, null, "0437f3539922170e24ecfc9ede6d6993");
				document.getElementById("upshrink_ic").src = smf_images_url + (mode ? "/expand.gif" : "/collapse.gif");

				document.getElementById("upshrinkHeaderIC").style.display = mode ? "none" : "";

				current_header_ic = mode;
			}
		// ]]></script>

</head>
<body>
	<div class="tborder" >
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="catbg" height="32">
					<img src="http://clandooc.de/images/banners/dooc_banner_0.jpg" style="margin: 4px;" alt="DooC Forum" />
				</td>
				<td align="right" class="catbg">
					<img src="http://www.clandooc.de/forum/Themes/default/images/smflogo.gif" style="margin: 2px;" alt="" />

				</td>
			</tr>
		</table>
		<table width="100%" cellpadding="0" cellspacing="0" border="0" >
			<tr>
				<td class="titlebg2" height="32">
					<span style="font-size: 130%;"> Hallo <b>[DooC]*Kissaki</b></span>

				</td>
				<td class="titlebg2" height="32" align="right">
					<span class="smalltext">18.02.2009, 01:05:59</span>
					<a href="#" onclick="shrinkHeader(!current_header); return false;"><img id="upshrink" src="http://www.clandooc.de/forum/Themes/default/images/upshrink2.gif" alt="*" title="Ein- oder Ausklappen der Kopfzeile" align="bottom" style="margin: 0 1ex;" /></a>
				</td>
			</tr>
			<tr id="upshrinkHeader" style="display: none;">
				<td valign="top" colspan="2">

					<table width="100%" class="bordercolor" cellpadding="8" cellspacing="1" border="0" style="margin-top: 1px;">
						<tr>
							<td class="windowbg" valign="middle"><img src="http://www.clandooc.de/forum/index.php?action=dlattach;attach=64;type=avatar" alt="" class="avatar" border="0" /></td>
							<td colspan="2" width="100%" valign="top" class="windowbg2"><span class="middletext">
								<a href="http://www.clandooc.de/forum/index.php?action=unread">Ungelesene Beitr&#228;ge seit Ihrem letzten Besuch.</a> <br />
								<a href="http://www.clandooc.de/forum/index.php?action=unreadreplies">Ungelesene Antworten zu Ihren Beitr&#228;gen.</a><br />

								Insgesamt eingeloggt: 1 Tage, 6 Stunden und 25 Minuten<br />				</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table id="upshrinkHeader2" style="display: none;" width="100%" cellpadding="4" cellspacing="0" border="0">

			<tr>
				<td class="titlebg2" align="right" nowrap="nowrap" valign="top">
					<form action="http://www.clandooc.de/forum/index.php?action=search2" method="post" accept-charset="UTF-8" style="margin: 0;">
						<a href="http://www.clandooc.de/forum/index.php?action=search;advanced"><img src="http://www.clandooc.de/forum/Themes/default/images/filter.gif" align="middle" style="margin: 0 1ex;" alt="" /></a>
						<input type="text" name="search" value="" style="width: 190px;" />&nbsp;
						<input type="submit" name="submit" value="Suche" style="width: 11ex;" />
						<input type="hidden" name="advanced" value="0" />
					</form>
				</td>

			</tr>
		</table>
	</div>
			<table cellpadding="0" cellspacing="0" border="0" style="margin-left: 10px;">
				<tr>
					<td class="maintab_first">&nbsp;</td><td class="maintab_active_first">&nbsp;</td>
				<td valign="top" class="maintab_active_back">
					<a href="http://www.clandooc.de/forum/index.php">&#220;bersicht</a>

				</td><td class="maintab_active_last">&nbsp;</td>
				<td valign="top" class="maintab_back">
					<a href="http://www.clandooc.de/forum/index.php?action=help">Hilfe</a>
				</td>
				<td valign="top" class="maintab_back">
					<a href="http://www.clandooc.de/forum/index.php?action=search">Suche</a>
				</td>
				<td valign="top" class="maintab_back">

					<a href="http://www.clandooc.de/forum/index.php?action=admin">Administrator</a>
				</td>
				<td valign="top" class="maintab_back">
					<a href="http://www.clandooc.de/forum/index.php?action=profile">Profil</a>
				</td>
				<td valign="top" class="maintab_back">
					<a href="http://www.clandooc.de/forum/index.php?action=pm">Meine Mitteilungen </a>

				</td>
				<td valign="top" class="maintab_back">
					<a href="http://www.clandooc.de/forum/index.php?action=calendar">Kalender</a>
				</td>
				<td valign="top" class="maintab_back">
					<a href="http://www.clandooc.de/forum/index.php?action=mlist">Mitglieder</a>
				</td>
				<td valign="top" class="maintab_back">

					<a href="http://www.clandooc.de/forum/index.php?action=logout;sesc=0437f3539922170e24ecfc9ede6d6993">Ausloggen</a>
				</td>
				<td class="maintab_last">&nbsp;</td>
			</tr>
		</table>
	<div id="bodyarea" style="padding: 1ex 0px 2ex 0px;">
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>

			<td valign="bottom"><div class="nav" style="font-size: smaller; margin-bottom: 2ex; margin-top: 2ex;"><b><a href="http://www.clandooc.de/forum/index.php" class="nav">DooC Forum</a></b></div></td>
			<td align="right">
			</td>
		</tr>
	</table>
	<div class="tborder" style="margin-top: 0;">
		<div class="catbg2" style="padding: 5px 5px 5px 10px;">
				<a href="http://www.clandooc.de/forum/index.php?action=collapse;c=1;sa=collapse;#1"><img src="http://www.clandooc.de/forum/Themes/default/images/collapse.gif" alt="-" border="0" /></a>

				<a name="1" href="http://www.clandooc.de/forum/index.php?action=collapse;c=1;sa=collapse;#1">Public-Board</a>
		</div>
		<table border="0" width="100%" cellspacing="1" cellpadding="5" class="bordercolor" style="margin-top: 1px;">
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=2.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>
				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=2.0" name="b2">Laberboard</a></b><br />

						
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">
					2348 Beitr&#228;ge <br />
					157 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">
					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=4">[DooC]*Kissaki</a><br />

						in <a href="http://www.clandooc.de/forum/index.php?topic=27.msg37244#new" title="Re: shortnews">Re: shortnews</a><br />
						am 17.02.2009, 17:20:26
					</span>
				</td>
			</tr>
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=3.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>

				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=3.0" name="b3">Games</a></b><br />
						
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">
					681 Beitr&#228;ge <br />
					76 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">

					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=38">[DooC]*Bongi</a><br />
						in <a href="http://www.clandooc.de/forum/index.php?topic=1625.msg37228#new" title="Re: Dystopia">Re: Dystopia</a><br />
						am 15.02.2009, 14:35:17
					</span>
				</td>

			</tr>
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=4.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>
				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=4.0" name="b4">Software</a></b><br />
						
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">

					158 Beitr&#228;ge <br />
					24 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">
					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=90">[DooC]*SIGnum</a><br />

						in <a href="http://www.clandooc.de/forum/index.php?topic=1609.msg36826#new" title="Office Programm">Office Programm</a><br />
						am 27.01.2009, 14:36:28
					</span>
				</td>
			</tr>
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=5.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>

				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=5.0" name="b5">Hardware</a></b><br />
						
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">
					227 Beitr&#228;ge <br />
					21 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">

					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=4">[DooC]*Kissaki</a><br />
						in <a href="http://www.clandooc.de/forum/index.php?topic=1524.msg36899#new" title="Festplatte zeigt zu wenig speicherplatz!">Festplatte zeigt zu weni...</a><br />
						am 15.01.2009, 16:36:47
					</span>
				</td>

			</tr>
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=14.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>
				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=14.0" name="b14">Helpboard</a></b><br />
						
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">

					639 Beitr&#228;ge <br />
					74 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">
					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=246">Vipera</a><br />

						in <a href="http://www.clandooc.de/forum/index.php?topic=1581.msg37003#new" title="Re: Lags auffer Kiffer">Re: Lags auffer Kiffer</a><br />
						am 01.02.2009, 11:18:15
					</span>
				</td>
			</tr>
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=15.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>

				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=15.0" name="b15">DooC-Server</a></b><br />
						
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">
					901 Beitr&#228;ge <br />
					31 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">

					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=271">[DooC]*Slide</a><br />
						in <a href="http://www.clandooc.de/forum/index.php?topic=607.msg36954#new" title="Re: Jumpserver!">Re: Jumpserver!</a><br />
						am 30.01.2009, 22:45:09
					</span>
				</td>

			</tr>
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=17.0"><img src="http://www.clandooc.de/forum/Themes/default/images/on.gif" alt="Neue Beitr&#228;ge" title="Neue Beitr&#228;ge" /></a>
				</td>
				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=17.0" name="b17">Spamboard</a></b><br />
						
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">

					22577 Beitr&#228;ge <br />
					49 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">
					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=403">[DooC]*Atlan</a><br />

						in <a href="http://www.clandooc.de/forum/index.php?topic=1.msg37247;boardseen#new" title="Re: Countingthread">Re: Countingthread</a><br />
						am 17.02.2009, 22:47:29
					</span>
				</td>
			</tr>
		</table>
	</div>
	<div class="tborder" style="margin-top: 1ex;">

		<div class="catbg" style="padding: 5px 5px 5px 10px;">
				<a href="http://www.clandooc.de/forum/index.php?action=collapse;c=6;sa=collapse;#6"><img src="http://www.clandooc.de/forum/Themes/default/images/collapse.gif" alt="-" border="0" /></a>
				<a name="6" href="http://www.clandooc.de/forum/index.php?action=collapse;c=6;sa=collapse;#6">DooC-Internal</a>
		</div>
		<table border="0" width="100%" cellspacing="1" cellpadding="5" class="bordercolor" style="margin-top: 1px;">
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=7.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>

				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=7.0" name="b7">ClanInternal</a></b><br />
						
					<div style="padding-top: 1px;" class="smalltext"><i>Moderatoren: <a href="http://www.clandooc.de/forum/index.php?action=profile;u=4" title="Moderator">[DooC]*Kissaki</a>, <a href="http://www.clandooc.de/forum/index.php?action=profile;u=5" title="Moderator">[DooC]*Henker</a>, <a href="http://www.clandooc.de/forum/index.php?action=profile;u=6" title="Moderator">[DooC]*BerSErker</a>, <a href="http://www.clandooc.de/forum/index.php?action=profile;u=162" title="Moderator">[DooC]*franky.fly</a></i></div>
				</td>

				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">
					2797 Beitr&#228;ge <br />
					257 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">
					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=4">[DooC]*Kissaki</a><br />

						in <a href="http://www.clandooc.de/forum/index.php?topic=1566.msg37246#new" title="Re: neuer Squad/Games, [bitte LESEN]">Re: neuer Squad/Games, [...</a><br />
						am 17.02.2009, 21:01:08
					</span>
				</td>
			</tr>
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=16.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>

				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=16.0" name="b16">DooC-Server-Internal</a></b><br />
						
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">
					307 Beitr&#228;ge <br />
					22 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">

					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=39">[DooC]*Gauki</a><br />
						in <a href="http://www.clandooc.de/forum/index.php?topic=952.msg36781#new" title="Kifferstube">Kifferstube</a><br />
						am 03.01.2009, 04:58:36
					</span>
				</td>

			</tr>
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=11.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>
				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=11.0" name="b11">Squadleader</a></b><br />
						
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">

					97 Beitr&#228;ge <br />
					18 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">
					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=4">[DooC]*Kissaki</a><br />

						in <a href="http://www.clandooc.de/forum/index.php?topic=77.msg36781#new" title="Server Passwords">Server Passwords</a><br />
						am 06.05.2008, 15:35:43
					</span>
				</td>
			</tr>
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=24.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>

				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=24.0" name="b24">Offiziere</a></b><br />
						
					<div style="padding-top: 1px;" class="smalltext"><i>Moderator: <a href="http://www.clandooc.de/forum/index.php?action=profile;u=4" title="Moderator">[DooC]*Kissaki</a></i></div>
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">
					195 Beitr&#228;ge <br />

					39 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">
					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=90">[DooC]*SIGnum</a><br />
						in <a href="http://www.clandooc.de/forum/index.php?topic=1604.msg37246#new" title="Re: Neue Offis?">Re: Neue Offis?</a><br />

						am 07.02.2009, 03:29:39
					</span>
				</td>
			</tr>
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=12.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>
				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=12.0" name="b12">Clan-Coleader</a></b><br />

						
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">
					311 Beitr&#228;ge <br />
					69 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">
					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=4">[DooC]*Kissaki</a><br />

						in <a href="http://www.clandooc.de/forum/index.php?topic=1573.msg37036#new" title="Mal anscheun pls XD">Mal anscheun pls XD</a><br />
						am 05.12.2008, 00:21:11
					</span>
				</td>
			</tr>
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=13.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>

				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=13.0" name="b13">Clanleader</a></b><br />
						
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">
					549 Beitr&#228;ge <br />
					150 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">

					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=6">[DooC]*BerSErker</a><br />
						in <a href="http://www.clandooc.de/forum/index.php?topic=1607.msg37120#new" title="Re: Forum Gruppen Rechte">Re: Forum Gruppen Rechte</a><br />
						am 07.02.2009, 03:23:10
					</span>
				</td>

			</tr>
		</table>
	</div>
	<div class="tborder" style="margin-top: 1ex;">
		<div class="catbg" style="padding: 5px 5px 5px 10px;">
				<a href="http://www.clandooc.de/forum/index.php?action=collapse;c=21;sa=collapse;#21"><img src="http://www.clandooc.de/forum/Themes/default/images/collapse.gif" alt="-" border="0" /></a>
				<a name="21" href="http://www.clandooc.de/forum/index.php?action=collapse;c=21;sa=collapse;#21">Squads intern</a>
		</div>

		<table border="0" width="100%" cellspacing="1" cellpadding="5" class="bordercolor" style="margin-top: 1px;">
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=10.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>
				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=10.0" name="b10">Guild Wars</a></b><br />
						
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">

					1853 Beitr&#228;ge <br />
					175 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">
					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=159">[DooC]*Rhyem</a><br />

						in <a href="http://www.clandooc.de/forum/index.php?topic=1627.msg37234#new" title="Re: Problem mit meinem Guild Wars Account">Re: Problem mit meinem G...</a><br />
						am 16.02.2009, 16:15:48
					</span>
				</td>
			</tr>
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=30.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>

				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=30.0" name="b30">CS:S grey</a></b><br />
						
					<div style="padding-top: 1px;" class="smalltext"><i>Moderator: <a href="http://www.clandooc.de/forum/index.php?action=profile;u=162" title="Moderator">[DooC]*franky.fly</a></i></div>
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">
					136 Beitr&#228;ge <br />

					33 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">
					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=236">[DooC]*TiMmAe</a><br />
						in <a href="http://www.clandooc.de/forum/index.php?topic=1421.msg36781#new" title="2. Mai Kein Training">2. Mai Kein Training</a><br />

						am 02.05.2008, 18:49:04
					</span>
				</td>
			</tr>
			<tr>
				<td  class="windowbg" width="6%" align="center" valign="top"><a href="http://www.clandooc.de/forum/index.php?action=unread;board=36.0"><img src="http://www.clandooc.de/forum/Themes/default/images/off.gif" alt="Keine neuen Beitr&#228;ge" title="Keine neuen Beitr&#228;ge" /></a>
				</td>
				<td class="windowbg2">
					<b><a href="http://www.clandooc.de/forum/index.php?board=36.0" name="b36">Black</a></b><br />

						ET Squad Black
				</td>
				<td class="windowbg" valign="middle" align="center" style="width: 12ex;"><span class="smalltext">
					28 Beitr&#228;ge <br />
					3 Themen
				</span></td>
				<td class="windowbg2" valign="middle" width="22%">
					<span class="smalltext">
						<b>Letzter Beitrag</b>  von <a href="http://www.clandooc.de/forum/index.php?action=profile;u=46">[DooC]*Heinzelmann</a><br />

						in <a href="http://www.clandooc.de/forum/index.php?topic=1620.msg37246#new" title="Re: Abmeldethread!">Re: Abmeldethread!</a><br />
						am 12.02.2009, 17:26:15
					</span>
				</td>
			</tr>
		</table>
	</div>
	<div class="tborder" style="margin-top: 1ex;">

		<div class="catbg" style="padding: 5px 5px 5px 10px;">
				<a href="http://www.clandooc.de/forum/index.php?action=collapse;c=18;sa=expand#18"><img src="http://www.clandooc.de/forum/Themes/default/images/expand.gif" alt="+" border="0" /></a>
				<a name="18" href="http://www.clandooc.de/forum/index.php?action=collapse;c=18;sa=expand#18">Garbage - Müllkippe</a>
		</div>
	</div>
	<table border="0" width="100%" cellspacing="0" cellpadding="5">
		<tr>
			<td align="left" class="smalltext">

				<img src="http://www.clandooc.de/forum/Themes/default/images/new_some.gif" alt="" align="middle" /> Neue Beitr&#228;ge
				<img src="http://www.clandooc.de/forum/Themes/default/images/new_none.gif" alt="" align="middle" style="margin-left: 4ex;" /> Keine neuen Beitr&#228;ge
			</td>
			<td align="right">
				<table cellpadding="0" cellspacing="0" border="0" style="position: relative; top: -5px;">
					<tr>
							 
		<td class="maintab_first">&nbsp;</td>
		<td class="maintab_back"><a href="http://www.clandooc.de/forum/index.php?action=markasread;sa=all;sesc=0437f3539922170e24ecfc9ede6d6993" >Alle gelesen</a></td>

		<td class="maintab_last">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table><br />
	<div class="tborder" >
		<div class="catbg" style="padding: 6px; vertical-align: middle; text-align: center; ">
			<a href="#" onclick="shrinkHeaderIC(!current_header_ic); return false;"><img id="upshrink_ic" src="http://www.clandooc.de/forum/Themes/default/images/collapse.gif" alt="*" title="Ein- oder Ausklappen der Kopfzeile" style="margin-right: 2ex;" align="right" /></a>

			DooC Forum - Info-Center
		</div>
		<div id="upshrinkHeaderIC">
			<table border="0" width="100%" cellspacing="1" cellpadding="4" class="bordercolor">
				<tr>
					<td class="titlebg" colspan="2">Zuk&#252;nftige Ereignisse</td>
				</tr><tr>
					<td class="windowbg" width="20" valign="middle" align="center">

						<a href="http://www.clandooc.de/forum/index.php?action=calendar"><img src="http://www.clandooc.de/forum/Themes/default/images/icons/calendar.gif" alt="Kalender" /></a>
					</td>
					<td class="windowbg2" width="100%">
						<span class="smalltext">
							<span style="color: #920AC4;">Zuk&#252;nftige Geburtstage:</span> 
							<a href="http://www.clandooc.de/forum/index.php?action=profile;u=25"><b>[DooC]*Dee</b> (17)</a>, 
							<a href="http://www.clandooc.de/forum/index.php?action=profile;u=342"><b>[DooC]*Ghost</b> (18)</a>, 
							<a href="http://www.clandooc.de/forum/index.php?action=profile;u=31">Mu7an7 (409)</a>, 
							<a href="http://www.clandooc.de/forum/index.php?action=profile;u=130">Mechtige (20)</a>, 
							<a href="http://www.clandooc.de/forum/index.php?action=profile;u=208">Bandido (20)</a>, 
							<a href="http://www.clandooc.de/forum/index.php?action=profile;u=38">[DooC]*Bongi (19)</a><br />

						</span>
					</td>
				</tr>
				<tr>
					<td class="titlebg" colspan="2">Forum-Statistiken</td>
				</tr>
				<tr>
					<td class="windowbg" width="20" valign="middle" align="center">

						<a href="http://www.clandooc.de/forum/index.php?action=stats"><img src="http://www.clandooc.de/forum/Themes/default/images/icons/info.gif" alt="Forum-Statistiken" /></a>
					</td>
					<td class="windowbg2" width="100%">
						<span class="middletext">
							35.053 Beitr&#228;ge in 1.362 Themen von 308 Mitglieder. Neuestes Mitglied: <b> <a href="http://www.clandooc.de/forum/index.php?action=profile;u=463">[DooC]*Destroyer</a></b>
							<br /> Letzter Beitrag: <b>&quot;<a href="http://www.clandooc.de/forum/index.php?topic=1.msg37247;boardseen#new" title="Re: Countingthread">Re: Countingthread</a>&quot;</b>  ( 17.02.2009, 22:47:29 )<br />

							<a href="http://www.clandooc.de/forum/index.php?action=recent">Anzeigen der neuesten Beitr&#228;ge</a><br />
							<a href="http://www.clandooc.de/forum/index.php?action=stats">[Weitere Statistiken]</a>
						</span>
					</td>
				</tr>
				<tr>
					<td class="titlebg" colspan="2">Benutzer Online</td>

				</tr><tr>
					<td rowspan="2" class="windowbg" width="20" valign="middle" align="center">
						<a href="http://www.clandooc.de/forum/index.php?action=who"><img src="http://www.clandooc.de/forum/Themes/default/images/icons/online.gif" alt="Benutzer Online" /></a>
					</td>
					<td class="windowbg2" width="100%">
						<a href="http://www.clandooc.de/forum/index.php?action=who">1 Gast, 1 Mitglied</a>
						<div class="smalltext">
							Aktive Benutzer in den letzten 15 Minuten:<br /><i><a href="http://www.clandooc.de/forum/index.php?action=profile;u=4" style="color: red;">[DooC]*Kissaki</a></i>

							<br />
							
						</div>
					</td>
				</tr>
				<tr>
					<td class="windowbg2" width="100%">
						<span class="middletext">
							Am meisten online (heute): <b>2</b>.
							Am meisten online (gesamt): 10 (08.02.2009, 18:25:31)
						</span>

					</td>
				</tr>
			</table>
		</div>
	</div>
	</div>

	<div id="footerarea" style="text-align: center; padding-bottom: 1ex;">
		<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
			function smfFooterHighlight(element, value)
			{
				element.src = smf_images_url + "/" + (value ? "h_" : "") + element.id + ".gif";
			}
		// ]]></script>

		<table cellspacing="0" cellpadding="3" border="0" align="center" width="100%">
			<tr>
				<td width="28%" valign="middle" align="right">
					<a href="http://www.mysql.com/" target="_blank"><img id="powered-mysql" src="http://www.clandooc.de/forum/Themes/default/images/powered-mysql.gif" alt="Powered by MySQL" width="54" height="20" style="margin: 5px 16px;" onmouseover="smfFooterHighlight(this, true);" onmouseout="smfFooterHighlight(this, false);" /></a>
					<a href="http://www.php.net/" target="_blank"><img id="powered-php" src="http://www.clandooc.de/forum/Themes/default/images/powered-php.gif" alt="Powered by PHP" width="54" height="20" style="margin: 5px 16px;" onmouseover="smfFooterHighlight(this, true);" onmouseout="smfFooterHighlight(this, false);" /></a>
				</td>
				<td valign="middle" align="center" style="white-space: nowrap;">
					
		<span class="smalltext" style="display: inline; visibility: visible; font-family: Verdana, Arial, sans-serif;"><a href="http://www.simplemachines.org/" title="Simple Machines Forum" target="_blank">Powered by SMF 1.1.8</a> |

<a href="http://www.simplemachines.org/about/copyright.php" title="Free Forum Software" target="_blank">SMF © 2006, Simple Machines LLC</a>
		</span>
				</td>
				<td width="28%" valign="middle" align="left">
					<a href="http://validator.w3.org/check/referer" target="_blank"><img id="valid-xhtml10" src="http://www.clandooc.de/forum/Themes/default/images/valid-xhtml10.gif" alt="Pr&#252;fe XHTML 1.0" width="54" height="20" style="margin: 5px 16px;" onmouseover="smfFooterHighlight(this, true);" onmouseout="smfFooterHighlight(this, false);" /></a>
					<a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank"><img id="valid-css" src="http://www.clandooc.de/forum/Themes/default/images/valid-css.gif" alt="Pr&#252;fe CSS" width="54" height="20" style="margin: 5px 16px;" onmouseover="smfFooterHighlight(this, true);" onmouseout="smfFooterHighlight(this, false);" /></a>
				</td>
			</tr>
		</table>

		<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
			window.addEventListener("load", smf_codeFix, false);
			function smf_codeFix()
			{
				var codeFix = document.getElementsByTagName ? document.getElementsByTagName("div") : document.all.tags("div");

				for (var i = 0; i < codeFix.length; i++)
				{
					if (codeFix[i].className == "code" && (codeFix[i].scrollWidth > codeFix[i].clientWidth || codeFix[i].clientWidth == 0))
						codeFix[i].style.overflow = "scroll";
				}
			}
		// ]]></script>
	</div><a href="http://piwik.org" title="Statistics web 2.0" onclick="window.open(this.href);return(false);">
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://www.clandooc.de/piwik/" : "http://www.clandooc.de/piwik/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
piwik_action_name = '';
piwik_idsite = 2;
piwik_url = pkBaseURL + "piwik.php";
piwik_log(piwik_action_name, piwik_idsite, piwik_url);
</script>
<object><noscript><p>Statistics web 2.0 <img src="http://www.clandooc.de/piwik/piwik.php?idsite=2" style="border:0" alt=""/></p></noscript></object></a>

	<div id="ajax_in_progress" style="display: none;">Lade...</div>
</body></html>
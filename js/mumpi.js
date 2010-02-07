/* Common Functions */

function showAjaxLoading(obj)
{
	if (obj==null)
		obj = jQuery('.mumpi_ajax_status');
	obj.html('<img src="../img/ajax-loader.gif" alt="loading…"/>');
}
function hideAjaxLoading(obj)
{
	if (obj==null)
		obj = jQuery('.mumpi_ajax_status');
	obj.find('img').remove();
}

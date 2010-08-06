<?php
/**
 * This is the main language file, containing general strings that will be used in more than one section
 */

	// General Functions
	$txt['edit'] = 'редактировать';			// Edit something
	$txt['cancel'] = 'отмена';		// Cancel, whatever you're doing (go back to the last page).
	$txt['update'] = 'обновить';		// Update the old item/key/var. Use the entered values as new values.
	$txt['remove'] = 'удалить';

	// General
	$txt['server'] = 'Сервер';		// Mumble Server
	$txt['info_serverversion'] = 'Версия сервера: %s';
	$txt['info_scriptexecutiontime'] = 'Время работы скрипта: %6.3fms | использование памяти: ~%s kByte';
	$txt['failed'] = 'ошибка';
	$txt['admin_area'] = 'Админ меню';

	// Account Information
	$txt['email'] = 'Email';
	$txt['username'] = 'Имя пользователя';
	$txt['password'] = 'Пароль';
	$txt['texture'] = 'Картинка пользователя';
	$txt['userid'] = 'ID пользователя';

	$txt['texture_none'] = 'нет картинки';
	$txt['texture_set'] = 'картинка установлена';

	// Profile
	$txt['help_profile_textur'] = 'Эта строка будет показана вместо имени пользователя, если включено в настройках.';

	//Errors
	$txt['error_noIceExtensionLoaded']	= 'Возможно ваша PHP конфигурация запущена без поддержки ICE<br/>Пожалуйста настройте ваш PHP для поддержки Ice.<br/><br/>Ice необходим для связки между <acronym title="Mumble Server">Murmur</acronym> и PHP/интерфейсом, для возможности PHP выполнять Murmur функции. Поэтому придется его установить.<br/>Для того что бы узнать как установить, обратитесь <a href="http://mumble.sourceforge.net/Ice">mumble.sf.net/Ice</a>.';
	$txt['error_noIceSliceLoaded']		= 'Вероятно файлы вашей конфигурации PHP неверно настроены.<br/>Инстукции по настройке вы найдете на <a href="http://mumble.sourceforge.net/Ice">mumble.sf.net/Ice</a>.<br/><br/>В конфигурациооном файле настраивается какие методы PHP доступны <acronym title="Mumble Server">Murmur</acronym>.';
	$txt['error_noIce']					= 'Немогу соединится с Ice.<br/>Или ваш сервер незапущен или неработает с Ice. Проверьте свою конфигурацию.';
	$txt['error_unknowninterface']		= 'Misconfiguration: Неизвестный тип интерфейса <acronym title="database">DB</acronym>!';
	$txt['unknownserver']				= 'Сервер не найден.';
	$txt['error_missing_values']		= 'Вероятно нехватает всех необходимых настроек.';
	$txt['error_db_unknowntype']		= 'Ваш тип базы данных (в ваших настройках) не доступен/определен';
	$txt['iceprofilealreadyloaded'] 	= 'Ice профиль уже был загружен!';
	$txt['error_dbmanager_couldnotopenadmins'] = 'Немогу открыть admins.dat файл.';
	$txt['error_invalidTexture']		= 'Неверная картинка. Проверьте файл картинки.';
	$txt['login_missing_data'] = 'Ошибка входа: Недостаточно введеных вами данных.';

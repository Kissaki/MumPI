<?php
/**
 * Language file for section: user, page: register
 */

	// Register
	$txt['register_title']	= 'Форма регистрации';
	$txt['password_repeat']	= 'повторите пароль';
	$txt['antispam']		= 'Анти-спам';

	$txt['register_mail_auth_subj'] = 'Активация аккаунта';
	$txt['register_mail_auth_body'] = 'Вы попытались зарегистрировать аккаунт %s (%s) на сервере %s.'."\n"
			.'Для активации вашего аккаунта, откройте следущую ссылку через браузер:'."\n"
			.'%s?page=register&action=activate&key=%s'."\n"
			.'Тогда вы сможете войти в интерфейс на сайте и на mumble сервере.';

	$txt['doregister_try']				= 'Пытаюсь зарегистрировать на выбраном сервере...';
	$txt['doregister_success']			= 'Вы были успешно зарегистрированы.';
	$txt['register_success']			=  'Вы были успешно зарегистрированы. Теперь можете <a href="?page=login">войти</a> (так же и в mumble).';
	$txt['register_success_toActivate']	= 'Вы были успешно зарегистрированы, но, ваш аккаунт ещё неактивирован.<br/>Дождитесь письма на email, в нем вы найдете ссылку для активации аккаунта.';
	$txt['register_fail_noserver']		= 'не выбран сервер!<br/><a onclick="history.go(-1); return false;" href="?page=register">вернутся назад</a>';
	$txt['register_fail_noNameFound']	= 'не выбрано имя!<br/><a onclick="history.go(-1); return false;" href="?page=register">вернутся назад</a>';
	$txt['register_fail_noPasswordFound']	= 'не введен пароль!<br/><a onclick="history.go(-1); return false;" href="?page=register">вернутся назад</a>';
	$txt['register_fail_passwordMatch']	= 'Ваши пароли не совпадают!<br/><a onclick="history.go(-1); return false;" href="?page=register">вернутся назад</a>';
	$txt['register_fail_noEmail']		= 'Вы не ввели адрес электронной почты, а это обязательно.<br/><a onclick="history.go(-1); return false;" href="?page=register">вернутся назад</a>';
	$txt['register_fail_emailinvalid']	= 'Вы ввели некоректный адрес электронной почты.<br/><a onclick="history.go(-1); return false;" href="?page=register">вернутся назад</a>';
	$txt['register_fail_wrongCaptcha']	= '<div class="error">Защитный код неверен.</div>';
	$txt['register_activate_success']	= 'Ваш аккаунт активирован. Попробуйте войти.';

	$txt['register_help_server']		= 'Выберите сервер на котором желаете зарегистироватся.';
	$txt['register_help_username']		= 'Придумайте имя пользователя для входа.<br/>Примечание: В зависимости от параметров настройки сервера, некоторые буквы или особенно специальные символы могут быть запрещены.';
	$txt['register_help_email']			= 'Введите адрес электронной почты.<br/>В зависимости от настроек сервера, вожможно получится войти на него, а возможно и нет, возможно сервер не получил активационное письмо для активации/создания вашего аккаунта.';
	$txt['register_help_password']		= 'Придумайте пароль.<br/>Будьте аккуратны: Безопасный пароль должен использовать и буквы и цифры.<br/>Обычные слова или даты могут быть подобраны.<br/>К примеру число более 8 цифр будет достаточно безопасным.';
	$txt['register_help_password2']		= 'Введите снова свой пароль, что бы убедится что вы неошиблись при его вводе.';
	$txt['register_help_captcha']		= 'Эта область, для того что бы предотвратить спам.<br/>Сосчитайте и введите решение этого примера.';

<?php
/**
 * Language file for section: user, page: register
 */

	// Register
	$txt['register_title']	= '����� �����������';
	$txt['password_repeat']	= '��������� ������';
	$txt['antispam']		= '����-����';

	$txt['register_mail_auth_subj'] = '��������� ��������';
	$txt['register_mail_auth_body'] = '�� ���������� ���������������� ������� %s (%s) �� ������� %s.'."\n"
			.'��� ��������� ������ ��������, �������� �������� ������ ����� �������:'."\n"
			.'%s?page=register&action=activate&key=%s'."\n"
			.'����� �� ������� ����� � ��������� �� ����� � �� mumble �������.';

	$txt['doregister_try']				= '������� ���������������� �� �������� �������...';
	$txt['doregister_success']			= '�� ���� ������� ����������������.';
	$txt['register_success']			=  '�� ���� ������� ����������������. ������ ������ <a href="?page=login">�����</a> (��� �� � � mumble).';
	$txt['register_success_toActivate']	= '�� ���� ������� ����������������, ��, ��� ������� �� �������������.<br/>��������� ������ �� email, � ��� �� ������� ������ ��� ��������� ��������.';
	$txt['register_fail_noserver']		= '�� ������ ������!<br/><a onclick="history.go(-1); return false;" href="?page=register">�������� �����</a>';
	$txt['register_fail_noNameFound']	= '�� ������� ���!<br/><a onclick="history.go(-1); return false;" href="?page=register">�������� �����</a>';
	$txt['register_fail_noPasswordFound']	= '�� ������ ������!<br/><a onclick="history.go(-1); return false;" href="?page=register">�������� �����</a>';
	$txt['register_fail_passwordMatch']	= '���� ������ �� ���������!<br/><a onclick="history.go(-1); return false;" href="?page=register">�������� �����</a>';
	$txt['register_fail_noEmail']		= '�� �� ����� ����� ����������� �����, � ��� �����������.<br/><a onclick="history.go(-1); return false;" href="?page=register">�������� �����</a>';
	$txt['register_fail_emailinvalid']	= '�� ����� ����������� ����� ����������� �����.<br/><a onclick="history.go(-1); return false;" href="?page=register">�������� �����</a>';
	$txt['register_fail_wrongCaptcha']	= '<div class="error">�������� ��� �������.</div>';
	$txt['register_activate_success']	= '��� ������� �����������. ���������� �����.';

	$txt['register_help_server']		= '�������� ������ �� ������� ������� ����������������.';
	$txt['register_help_username']		= '���������� ��� ������������ ��� �����.<br/>����������: � ����������� �� ���������� ��������� �������, ��������� ����� ��� �������� ����������� ������� ����� ���� ���������.';
	$txt['register_help_email']			= '������� ����� ����������� �����.<br/>� ����������� �� �������� �������, �������� ��������� ����� �� ����, � �������� � ���, �������� ������ �� ������� ������������� ������ ��� ���������/�������� ������ ��������.';
	$txt['register_help_password']		= '���������� ������.<br/>������ ���������: ���������� ������ ������ ������������ � ����� � �����.<br/>������� ����� ��� ���� ����� ���� ���������.<br/>� ������� ����� ����� 8 ���� ����� ���������� ����������.';
	$txt['register_help_password2']		= '������� ����� ���� ������, ��� �� �������� ��� �� ���������� ��� ��� �����.';
	$txt['register_help_captcha']		= '��� �������, ��� ���� ��� �� ������������� ����.<br/>���������� � ������� ������� ����� �������.';

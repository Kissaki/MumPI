<?php
/**
 * Language file for section: user, page: register
 */

	// Register
	$txt['register_title']	= 'Formulário de Registro';
	$txt['password_repeat']	= 'repita a senha';
	$txt['antispam']		= 'Anti-Spam';

	$txt['register_mail_auth_subj'] = 'Ativação da Conta';
	$txt['register_mail_auth_body'] = 'Você tentou registrar uma conta em %s (%s) no servidor %s.'."\n"
			.'Para ativar a sua conta acesse o seguinte endereço em seu navegador:'."\n"
			.'%s?page=register&action=activate&key=%s'."\n"
			.'Então você será capaz de autenticar na interface e no servidor mumble.';

	$txt['doregister_try']				= 'Registrando no servidor selecionado...';
	$txt['doregister_success']			= 'Registro efetuado.';
	$txt['register_success']			=  'Você foi registrado. Agora você pode <a href="?page=login">autenticar</a> (também no mumble).';
	$txt['register_success_toActivate']	= 'Você foi registrado com sucesso, no entanto, sua conta ainda está inativa.<br/>Você receberá um email logo com um endereço de ativação da conta.';
	$txt['register_fail_noserver']		= 'Nenhum servidor especificado!<br/><a onclick="history.go(-1); return false;" href="?page=register">voltar</a>';
	$txt['register_fail_noNameFound']	= 'Nenhum nome especificado!<br/><a onclick="history.go(-1); return false;" href="?page=register">voltar</a>';
	$txt['register_fail_noPasswordFound']	= 'Nenhuma senha especificada!<br/><a onclick="history.go(-1); return false;" href="?page=register">voltar</a>';
	$txt['register_fail_passwordMatch']	= 'Suas senhas não coincidem!<br/><a onclick="history.go(-1); return false;" href="?page=register">voltar</a>';
	$txt['register_fail_noEmail']		= 'Você não especificou um email, no entanto, isso não é exigido.<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_emailinvalid']	= 'Você não especificou um endereço de email correto.<br/><a onclick="history.go(-1); return false;" href="?page=register">voltar</a>';
	$txt['register_fail_wrongCaptcha']	= '<div class="error">Captcha Incorreto.</div>';
	$txt['register_activate_success']	= 'Sua conta deve estar ativa. Tente autenticar-se.';

	$txt['register_help_server']		= 'Selecione o servidor no qual deseja se registrar.';
	$txt['register_help_username']		= 'Especifique o usuário que deseja usar ao autenticar-se.<br/>Note que dependendo das configurações do servidor alguns caracteres, especialmente símbolos podem ser desativados.';
	$txt['register_help_email']			= 'Espefique seu endereço de email.<br/>Dependendo das configurações do servidor isso pode ser desnecessário, ou você deverá usá-lo para ativar/criar sua conta.';
	$txt['register_help_password']		= 'Escolha uma senha.<br/>Fique atento: Uma boa senha pode consistir de números e letras misturados aleatoriamente, ou melhor ainda com símbolos e caracteres especiais.<br/>Palavras normais ou números podem ser adivinhados ou obtidos com ataques de força-bruta.';
	$txt['register_help_password2']		= 'Repita seua senha para evitar erros.';
	$txt['register_help_captcha']		= 'Esse campo previne spam.<br/>Calcule e digite o resultado do cálculo dado na imagem.';

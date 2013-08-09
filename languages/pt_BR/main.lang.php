<?php
/**
 * This is the main language file, containing general strings that will be used in more than one section
 */

	// General Functions
	$txt['edit'] = 'editar';			// Edit something
	$txt['cancel'] = 'cancelar';		// Cancel, whatever you're doing (go back to the last page).
	$txt['update'] = 'atualizar';		// Update the old item/key/var. Use the entered values as new values.
	$txt['remove'] = 'remover';

	// General
	$txt['server'] = 'Servidor';		// Mumble Server
	$txt['info_serverversion'] = 'Servidor Versão: %s';
	$txt['info_scriptexecutiontime'] = 'Tempo de execução do script: %6.3fms | pico da memória: ~%s kByte';
	$txt['failed'] = 'falhou';
	$txt['admin_area'] = 'Admin';
	$txt['permission_denied'] = 'Permissão negada.';

	// Account Information
	$txt['email'] = 'Email';
	$txt['username'] = 'Nome de usuário';
	$txt['password'] = 'Senha';
	$txt['texture'] = 'Imagem de usuário';
	$txt['userid'] = 'ID de usuário';

	$txt['texture_none'] = 'sem imagem';
	$txt['texture_set'] = 'imagem escolhida';

	// Profile
	$txt['help_profile_textur'] = 'Esta textura de usuário será mostrada na sobreimpressão do mumble ao invés de um apelido, se ativado nas opções.';

	//Errors
	$txt['error_noIceExtensionLoaded']	= 'Parece que sua configuração do PHP não está executando com a extensão Ice.<br/>Por favor configure seu PHP para carregar a extensão Ice.<br/><br/>Ice é um middleware entre o <acronym title="Servidor Mumble">Murmur</acronym> e o PHP/a interface, permitindo ao PHP chamar funções do Murmur. Portanto, ele é necessário.<br/>Para instruções sobre como configurá-lo, veja <a href="http://mumble.sourceforge.net/Ice">mumble.sf.net/Ice</a>.';
	$txt['error_noIceSliceLoaded']			= 'Parece que a sua configuração do PHP não conhece o arquivo slice necessário.<br/>Para instruções sobre como configurá-lo, veja <a href="http://mumble.sourceforge.net/Ice">mumble.sf.net/Ice</a>.<br/><br/>O arquivo slice diz ao PHP quais métodos e dados estão disponíveis ao PHP, para acessar o <acronym title="Servidor Mumble">Murmur</acronym>.';
	$txt['error_noIce']									= 'Impossível conectar ao Ice.<br/>Ou seu servidor não está executando ou não está executando com Ice ativo. Verifique sua configuração.';
	$txt['error_iceConnectionRefused']	= 'Impossível conectar ao Ice.<br/>Ou seu servidor não está executando ou não está executando com Ice ativo. Verifique sua configuração.';
	$txt['error_unknowninterface']			= 'Má configuração: Tipo de interface <acronym title="base de dados">BD</acronym> desconhecido!';
    $txt['error_iceInclusionFileNotFound'] = 'O arquivo Ice.php não foi encontrado. Por favor certifique-se de que o dir de inclusão do arquivo php do ice está no phps include_path (verifique sua configuração PHP).'; 
    $txt['error_iceMurmurPHPFileNotFound'] = 'O arquivo Murmur.php gerado que foi configurado para ser usado não foi encontrado. O arquivo é gerado pelo servidor mumble pelo arquivo de definição slice, e alguns são distribuidos junto com o MumPI (veja arquivos <code>classes/Murmur_<em>[…]</em>.php</code>). O arquivo que deve ser usado é especificado através da configuração <code>$iceGeneratedMurmurPHPFileName</code> no arquivo <code>settings.inc.php</code> do MumPI.';
	$txt['unknownserver']								= 'Nenhum servidor encontrado.';
	$txt['error_missing_values']				= 'Parece que nem todos os valores necessários foram especificados.';
	$txt['error_db_unknowntype']				= 'O tipo de base de dados especificado (nas configurações) não está disponível/definido.';
	$txt['iceprofilealreadyloaded'] 		= 'Perfil Ice já foi carregado!';
	$txt['error_dbmanager_couldnotopenadmins'] = 'Impossível abrir o arquivo admins.dat.';
	$txt['error_invalidTexture']				= 'Dados de imagem inválidos. Por favor verifique seu arquivo de imagem.';
	$txt['login_missing_data'] 					= 'Falha de autenticação: Não forneceu todos os dados necessários.';

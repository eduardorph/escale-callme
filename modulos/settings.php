<?php
add_action( 'admin_menu', 'ecc_add_admin_menu' );
add_action( 'admin_init', 'ecc_settings_init' );


function ecc_add_admin_menu(  ) { 

	add_submenu_page( 'tools.php', 'Escale Callme', 'Escale Callme', 'manage_options', 'escale_claro_callme', 'ecc_options_page' );

}


function ecc_settings_init(  ) { 

	register_setting( 'pluginPage', 'ecc_settings' );

	// SECTIONS

	add_settings_section(
		'ecc_pluginPage_section_api', 
		__( 'Configuração da API callme', 'ecc' ), 
		'ecc_settings_section_callme', 
		'pluginPage'
	);

	add_settings_section(
		'ecc_pluginPage_section', 
		__( 'Formulário de Contato', 'ecc' ), 
		'ecc_settings_section_callback', 
		'pluginPage'
	);


	// CAMPOS
	add_settings_field( 
		'callme_api_url', 
		__( 'Callme API URL*', 'ecc' ), 
		'callme_api_url_render', 
		'pluginPage', 
		'ecc_pluginPage_section_api' 
	);

	add_settings_field( 
		'callme_api_key', 
		__( 'Callme API Key*', 'ecc' ), 
		'callme_api_key_render', 
		'pluginPage', 
		'ecc_pluginPage_section_api' 
	);

	add_settings_field( 
		'callme_api_secret', 
		__( 'Callme API Secret*', 'ecc' ), 
		'callme_api_secret_render', 
		'pluginPage', 
		'ecc_pluginPage_section_api' 
	);

	add_settings_field( 
		'callme_field_email', 
		__( 'Campo de E-mail', 'ecc' ), 
		'callme_field_email_render', 
		'pluginPage', 
		'ecc_pluginPage_section' 
	);

	add_settings_field( 
		'callme_field_cep', 
		__( 'Campo de Cep', 'ecc' ), 
		'callme_field_cep_render', 
		'pluginPage', 
		'ecc_pluginPage_section' 
	);

}

function callme_api_url_render(  ) { 

	$options = get_option( 'ecc_settings' );
	?>
	<input type='text' required="true" name='ecc_settings[callme_api_url]' value='<?php echo $options['callme_api_url']; ?>'>
	<?php

}


function callme_api_key_render(  ) { 

	$options = get_option( 'ecc_settings' );
	?>
	<input type='text' required="true" name='ecc_settings[callme_api_key]' value='<?php echo $options['callme_api_key']; ?>'>
	<?php

}


function callme_api_secret_render(  ) { 

	$options = get_option( 'ecc_settings' );
	?>
	<input type='text' required="true" name='ecc_settings[callme_api_secret]' value='<?php echo $options['callme_api_secret']; ?>'>
	<?php

}


function callme_field_email_render(  ) { 

	$options = get_option( 'ecc_settings' );
	?>
	<input type='checkbox' name='ecc_settings[callme_field_email]' <?php checked( $options['callme_field_email'], 1 ); ?> value='1'>
	<?php

}


function callme_field_cep_render(  ) { 

	$options = get_option( 'ecc_settings' );
	?>
	<input type='checkbox' name='ecc_settings[callme_field_cep]' <?php checked( $options['callme_field_cep'], 1 ); ?> value='1'>
	<?php

}



function ecc_settings_section_callme(  ) { 

	echo __( 'Informe as credenciais', 'ecc' );

}


function ecc_settings_section_callback(  ) { 

	echo __( 'Marque os campos que deseja exibir', 'ecc' );

}


function ecc_options_page(  ) { 

		?>
		<form action='options.php' method='post'>

			<h2>Escale Callme</h2>

			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );
			submit_button();
			?>

		</form>
		<?php

}

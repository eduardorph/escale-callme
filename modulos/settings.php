<?php
add_action( 'admin_menu', 'ecc_add_admin_menu' );
add_action( 'admin_menu', 'ecc_add_admin_submenu' );
add_action( 'admin_init', 'ecc_settings_init' );

function ecc_add_admin_menu() {
    add_menu_page( 'Escale Callme', 'Escale Callme', 'manage_options', 'escale_claro_callme_menu', 'ecc_options_page' );
}

function ecc_add_admin_submenu(  ) { 

	add_submenu_page( 'escale_claro_callme_menu', 'Leads', 'Leads', 'manage_options', 'escale_claro_callme_leads', 'ecc_options_page_leads' );

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
		'api_mediaId', 
		__( 'Callme API Media ID*', 'ecc' ), 
		'callme_api_mediaid_render', 
		'pluginPage', 
		'ecc_pluginPage_section_api' 
	);

	add_settings_field( 
		'api_channel', 
		__( 'Callme API Channel*', 'ecc' ), 
		'callme_api_channel_render', 
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

function callme_api_mediaid_render(  ) { 

	$options = get_option( 'ecc_settings' );
	?>
	<input type='text' required="true" name='ecc_settings[api_mediaId]' value='<?php echo $options['api_mediaId']; ?>'>
	<?php

}

function callme_api_channel_render(  ) { 

	$options = get_option( 'ecc_settings' );
	?>
	<input type='text' required="true" name='ecc_settings[api_channel]' value='<?php echo $options['api_channel']; ?>'>
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


function ecc_options_page_leads(  ) { 
	global $wpdb;

	$table_name = $wpdb->prefix . 'escale_callme_leads';
    $query = "SELECT * FROM {$table_name}";

    $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total = $wpdb->get_var( $total_query );

    $items_per_page = 30;
    $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
    $offset = ( $page * $items_per_page ) - $items_per_page;

    $leads = $wpdb->get_results( $query . " ORDER BY id DESC LIMIT ${offset}, ${items_per_page}", ARRAY_A );

	?>

	<style>
		.leads_table_callme{
			margin-bottom: 40px !important;
			border: 1px solid #ccc;
			width: 100%;
			min-width: 960px;
		}

		.leads_table_callme tr th, .leads_table_callme tr td{
			padding: 5px 10px;
			text-align: left;
			cursor:pointer;
		}

		.leads_table_callme tr:hover{
			background: #c7c7c7 !important;
		}

		.leads_table_callme tr:nth-child(odd) {background: #E6E6E6}
		.leads_table_callme tr:nth-child(even) {background: transparent}

		.need_overflow{
			max-width:100%;
			overflow: auto;
		}
	</style>
	
	<h2>LEADS</h2>
	<table class="leads_table_callme">
		<tr>
			<th>Data</th>
			<th>Nome</th>
			<th>Telefone</th>
			<th>CEP</th>
			<th>E-mail</th>
			<th>CPF</th>
			<th>Código Callme</th>
			<th>Mensagem Callme</th>
		</tr>
	<?php
	// $leads = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}escale_callme_leads ORDER BY id DESC", ARRAY_A );

	foreach ($leads as $lead) {
		echo "<tr>";
		echo "<td>".$lead["created_at"]."</td>";
		echo "<td>".$lead["name"]."</td>";
		echo "<td>".$lead["phone"]."</td>";
		echo "<td>".$lead["postcode"]."</td>";
		echo "<td>".$lead["email"]."</td>";
		echo "<td>".$lead["cpf"]."</td>";
		echo "<td>".$lead["status_code"]."</td>";
		echo "<td style='max-width:250px;'><div class='need_overflow'>".$lead["message"]."</div></td>";
		echo "</tr>";
	}
	echo "</table>";

	echo paginate_links( array(
        'base' => add_query_arg( 'cpage', '%#%' ),
        'format' => '',
        'prev_text' => __('&laquo;'),
        'next_text' => __('&raquo;'),
        'total' => ceil($total / $items_per_page),
        'current' => $page
    ));

}

<?php
function abrir_callme_modal_ctas(){

	$options = get_option( 'ecc_settings' );

	$base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
	$url = $base_url . $_SERVER["REQUEST_URI"];

	?>

	<div id="escale-callme-modal-ctas" class="escale-callme-modal"> <!-- callme_hide -->
	    <div class="escale-callme-modal-wrapper">
	        <div class="escale-callme-modal-header">
	            <div id="escale-callme-modal-ctas-fechar" class="escale-callme-modal-fechar">
	                <div class="escale-callme-modal-fechar-texto">X</div>
	            </div>
	        </div>
	        <div class="escale-callme-modal-box">
	        	<span class="escale-callme-modal-box-escolha-titulo">Como Deseja Contratar?</span>
	            <a id="escale-callme-modal-ctas-meligue" class="escale-callme-modal-ctas-btns" href="#">Me Ligue</a>
	            <a id="escale-callme-modal-ctas-carrinho" class="escale-callme-modal-ctas-btns escale-api-card-botao" data-modal-api href="#">Contratar Online</a>
	        </div>
	    </div>
	</div>

	<?php
}
add_action('wp_footer', 'abrir_callme_modal_ctas');
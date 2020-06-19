<?php
function abrir_callme_modal(){

	$options = get_option( 'ecc_settings' );

	$base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
	$url = $base_url . $_SERVER["REQUEST_URI"];

	?>

	<div id="escale-callme-modal-ctas" class="escale-callme-modal callme_hide"> <!-- callme_hide -->
	    <div class="escale-callme-modal-wrapper">
	        <div class="escale-callme-modal-header">
	            <a id="escale-callme-modal-ctas-fechar" class="escale-callme-modal-fechar">
	                <div class="escale-callme-modal-fechar-texto">X</div>
	            </a>
	        </div>
	        <div class="escale-callme-modal-box">
	            <form id="escale_callme_form" name="escale_callme_form" method="post" action="" class="escale-callme-form" enctype="multipart/form-data">
	            	<span class="escale-callme-modal-box-escolha-titulo">Ligamos para você</span>

				    <div class="escale-callme-form-div">
				        <input type="text" class="escale-callme-form-input" name="escale_callme_form_nome" placeholder="Nome" id="escale_callme_form_nome" required="">
				    </div>

				    <div class="escale-callme-form-div">
				        <input type="tel" class="escale-callme-form-input" name="escale_callme_form_telefone" placeholder="(DDD) Telefone" id="escale_callme_form_telefone">
				    </div>

				    <div class="escale-callme-form-div">
				        <input type="tel" class="escale-callme-form-input" name="escale_callme_form_cpf" placeholder="CPF" id="escale_callme_form_cpf" required="">
				    </div>

				    <?php if(isset($options['callme_field_email'])): ?>
				    <div class="escale-callme-form-div">
				        <input type="email" class="escale-callme-form-input" name="escale_callme_form_email" placeholder="E-mail" id="escale_callme_form_email" required="">
				    </div>
				    <?php endif; ?>

				    <?php if(isset($options['callme_field_cep'])): ?>
				    <div class="escale-callme-form-div">
				        <input type="tel" class="escale-callme-form-input" name="escale_callme_form_cep" placeholder="CEP" id="escale_callme_form_cep" required="">
				    </div>
					<?php endif; ?>
				    
				    <div class="escale-callme-form-div">
				    	<input type="hidden" name="escale_callme_url" value="<?php echo $url; ?>" id="escale_callme_url">
				    	<input type="hidden" name="escale_callme_campanha" value="<?php echo isset($_GET['utm_campaign']) ? isset($_GET['utm_campaign']) : 'Campanha'; ?>" id="escale_callme_campanha">
				    	<input type="hidden" name="escale_callme_cid" id="escale_callme_cid">
				    	<input type="submit" value="ME LIGUE" data-original="ME LIGUE" data-wait="Aguarde..." id="escale-callme-form-btn-submit" class="escale-callme-form-btn">
				   	</div>
				</form>

				<div class="escale-callme-modal-resposta">
					<h3>Contato Enviado!</h3>
					<p>Logo entraremos em contato.</p>
				</div>

	        </div>
	    </div>
	</div>

	<?php
}
add_action('wp_footer', 'abrir_callme_modal');
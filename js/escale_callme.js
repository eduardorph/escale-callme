jQuery(function($) {
	console.log("14");

	$(document).on('click', '#escale-callme-modal-ctas-fechar', function(event) {
		$("#escale-callme-modal-ctas").addClass('callme_hide');
		$('form#escale_callme_form').slideDown(); // volta o formulario
		$(".escale-callme-modal-resposta").removeClass('show'); // esconde mensagem
	});


	$(document).on('click', '.escale-callme-card-botao, [data-modal-form]', function(event) {
		event.preventDefault();
		var link = $(this).attr("href");

		$("#escale_callme_card_link").val(link);
		$("#escale-callme-modal-ctas").removeClass('callme_hide');
	});


	var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };

    $('#escale_callme_form_telefone').mask(SPMaskBehavior, spOptions);
	$('#escale_callme_form_cpf').mask('000.000.000-00');
	$('#escale_callme_form_cep').mask('00000-000');



	$('form#escale_callme_form').on('submit', function(e){
	    e.preventDefault();
	    var formulario = $(this);
	    var btn = formulario.find('#escale-callme-form-btn-submit');
		var nome = formulario.find('#escale_callme_form_nome');
		var telefone = formulario.find('#escale_callme_form_telefone');
		var cpf = formulario.find('#escale_callme_form_cpf');
		var email = formulario.find('#escale_callme_form_email');
		var cep = formulario.find('#escale_callme_form_cep');
		var url = formulario.find('#escale_callme_url');
		var campanha = formulario.find('#escale_callme_campanha');
		var cid = formulario.find('#escale_callme_cid');
	    

	    $.ajax({
	        url: ajax_object.ajax_url,
	        type:"POST",
	        dataType:'text',
	        data: {
	        	action:'escale_claro_callme',
	        	security: ajax_object.ajax_nonce,
	        	nome:nome.val(),
				telefone:telefone.val(),
				cpf:cpf.val(),
				email:email.val(),
				cep:cep.val(),
				url:url.val(),
				campanha:campanha.val(),
				cid:cid.val()
	        },
	    	beforeSend: function() {
	    		btn.val(btn.attr('data-wait'));
		    },
	    	success: function(response){
	    		console.log(response);
	    		var response = JSON.parse(response);
	    		
	    		if (response.error == 'telefone') {
	    			telefone.css('background-color', '#ff6055ad');
	    			telefone.focus();
	    		}

	    		if (response.error == 'cpf') {
	    			cpf.css('background-color', '#ff6055ad');
	    			cpf.focus();
	    		}

	    		if (response.error == 'callme') {
	    			btn.val("Erro ao enviar.");
	    		}

	    		if (response.success == true) {
	    			formulario.slideUp();
	    			$(".escale-callme-modal-resposta").addClass('show');
	    			formulario.trigger('reset');
	    			btn.val(btn.attr('data-original'));
	    		}
	     	}, 
	     	error: function(data){
	        	btn.val("Erro ao enviar.");
	     	},
	     	complete: function(){
	     	}
	    });

		return false;
	});

});
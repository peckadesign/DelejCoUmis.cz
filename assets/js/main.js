$(document).ready(function() {

	$(document)
		.on('focusin', '.inp-combined', function (e) {
			$(this).closest('.inp-combined').addClass('focus');
		})
		.on('focusout', '.inp-combined', function (e) {
			var $inpCombined = $(this);
			var $inp = $inpCombined.find('input');

			if ($inp.val().length) {
				$inpCombined.addClass('filled');
			} else {
				$inpCombined.removeClass('filled');
			}

			$inpCombined.removeClass('focus');
		});
	$('.inp-combined .inp-text').trigger('blur');

	var checkFilledInput = function() {
		$('.inp-combined .inp-text').each(function() {
			var $inpCombined = $(this).closest('.inp-combined');

			if ($(this).val().length) {
				$inpCombined.addClass('filled');
			} else {
				$inpCombined.removeClass('filled');
			}
		});
	};

	$(document).on('submit', 'form', function(e) {
		var $form = $(this);
		var $name = $form.find('input[name=name]');
		var $email = $form.find('input[name=email]');
		var send = true;
		var $p;

		$form.find('.error').removeClass('error');
		$form.find('.err-msg').remove();

		if(! isEmail($email.val())) {
			$p = $email.closest('p');
			send = false;
			if(! $p.find('.msg').length) {
				$p.find('label').append(' <span class="err-msg">/ Vyplňte</span>');
				$p.addClass('error animated bounce');
			}
		}
		if(!$name.val()) {
			$p = $name.closest('p');
			send = false;
			if(! $p.find('.message').length) {
				$p.find('label').append(' <span class="err-msg">/ Vyplňte</span>');
				$p.addClass('error animated bounce');
			}
		}

		if(!send) {
			e.preventDefault();
		}

		setTimeout(function(){
			$form.find('.animated').removeClass('animated bounce');
		}, 1000);
	});

	function isEmail(email) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}

});

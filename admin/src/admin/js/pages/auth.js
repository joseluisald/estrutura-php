const { Email, Password } = getSession('pearsonLogin');
$('input[name="Email"]').val(Email);
$('input[name="Password"]').val(Password);

if (logs) console.log('Email: ', Email);
if (logs) console.log('Password: ', Password);

const form = document.getElementById('formLogin');
if (form) {
	var validator = FormValidation.formValidation(form, {
		fields: {
			'Email': {
				validators: {
					notEmpty: {
						message: 'Este campo é obrigatório!'
					},
					// emailAddress: {
					//     message: 'Informe um e-mail válido!'
					// }
				}
			},
			'Password': {
				validators: {
					notEmpty: {
						message: 'Este campo é obrigatório!'
					}
				}
			}
		}, plugins: {
			trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({
				rowSelector: '.fv-row', eleInvalidClass: 'error', eleValidClass: 'valid'
			})
		}
	});

	const submitButton = document.getElementById('btnLogin');
	submitButton.addEventListener('click', function (e) {
		e.preventDefault();

		if (validator) {
			validator.validate().then(function (status) {
				if (status === 'Valid') {
					const action = form.action;
					const method = form.dataset.method;
					const formData = serializeFormObject(form);

					if (logs) console.log('action: ', action);
					if (logs) console.log('method: ', method);
					if (logs) console.log('formData: ', formData);

					ajaxLoad('open');

					HTTP(action, method, formData)
						.then(response => {
							ajaxLoad('close');
							showToastr(response.message.type, response.message.message);

							if (response.message.clear) {
								form.reset();
								$('.fv-row').removeClass('fv-plugins-icon-container fv-plugins-bootstrap5-row-valid');
							}

							if (response.message.status) {
								setSession('pearsonLogin', formData);
							}

							if (response.message.refresh) {
								setTimeout(function () {
									window.location.reload();
								}, 1000);
							}

							if (response.message.redirect) {
								window.location.href = response.message.redirect;
							}
						})
						.catch(error => {
							ajaxLoad('close');
							console.error('Error:', error);
						});
				}
			});
		}
	});
}
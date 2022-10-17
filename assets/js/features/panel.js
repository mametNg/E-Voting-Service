'use strict';

let login = (function() {
	let inputEmail = (method1, method2) => {

		let filter = filterMail(method1);

		if (filter) {
			$(method2).text('');
			$(method1).attr('class', 'form-control form-control-user is-valid');
		} else {
			$(method2).text("Email Isn't Valid!");
			$(method1).attr('class', 'form-control form-control-user is-invalid');
		}

		return filter;
	}

	let inputPassword = (method1, method2) => {

		let filter = filterLength(method1, 8);

		if (filter == true) {
			$(method2).text('');
			$(method1).attr('class', 'form-control form-control-user is-valid');
			return true;
		} else {
			$(method2).text(filter);
			$(method1).attr('class', 'form-control form-control-user is-invalid');
			return false;
		}
	}

	$("#input-email").keyup(function() {
		inputEmail("#input-email", "#msg-input-email");
	});

	$("#input-email").change(function() {
		inputEmail("#input-email", "#msg-input-email");
	});

	$("#show-input-password").click(function() {
		let password = $("#input-password");
		let confirmPassword = $("#confirm-input-password");
		if (password.attr('type') == "password") {
			$("#show-input-password").html('<i class="fa fa-fw fa-eye-slash"></i>');
			password.attr('type', 'text');
			if (confirmPassword) confirmPassword.attr('type', 'text');
		} else {
			$("#show-input-password").html('<i class="fa fa-fw fa-eye"></i>');
			password.attr('type', 'password');
			if (confirmPassword) confirmPassword.attr('type', 'password');
		}
	});

	$("#login").click(function() {
		let email = $("#input-email");
		let password = $("#input-password");
		let btn = $("#login");
		let allow = true;

		if (!inputEmail("#"+email.attr("id"), "#msg-"+email.attr("id"))) allow = false;
		if (!inputPassword("#"+password.attr("id"), "#msg-"+password.attr("id"))) allow = false;

		if (!allow) return false;

		email.attr("disabled", true);
		password.attr("disabled", true);
		btn.attr("disabled", true);
		$(".air-badge").html(loadingBackdrop());


		const params = {
			'email': email.val().trim().toLowerCase(),
			'password': password.val().trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/login");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				email.attr("disabled", false);
				password.attr("disabled", false);
				btn.attr("disabled", false);
			}
		});

		execute.fail(function() {
			email.attr("disabled", false);
			password.attr("disabled", false);
			btn.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});
});

let webSetting = (function() {

	$('[id^="web-setting"]').click(function() {
		const myData = $(this);
		const name = $("#setting-"+myData.attr("data-setting"));

		const WebStatus = $(".change-web-setting-status");
		const WebName = $(".change-web-setting-name");
		const WebButton = $("#save-web-setting");

		WebStatus.text((myData.attr("data-status") == 1 ? "Inactive":"Active").toLowerCase());
		WebName.text(name.text().trim().toLowerCase());
		WebButton.attr("data-setting", myData.attr("data-setting"));
		WebButton.attr("data-status", (myData.attr("data-status") == 1 ? "off":"on"));
		WebButton.text((myData.attr("data-status") == 1 ? "Inactive":"Active")+" Now");
	});

	$("#save-web-setting").click(function() {
		const modal = $("#modal-web-setting");
		const button = $("#save-web-setting");
		let allow = true;

		if (button.attr("data-setting").trim().length !== 5) allow = false;
		if (button.attr("data-status").trim().length < 2) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'code': button.attr("data-setting").trim(),
			'type': button.attr("data-status").trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/websetting");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				button.attr("disabled", false);
			}
		});

		execute.fail(function() {
			button.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});

	$("#create-new-code").click(function() {
		const modal = $("#modal-ceate-new-code");
		const button = $("#create-new-code");

		modal.modal('hide');
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'new-code': 1,
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/newcodeactivation");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				button.attr("disabled", false);
			}
		});

		execute.fail(function() {
			button.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});

});

let role = (function() {
	let inputName = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);

		let filter = filterChar(input, [" "], 3);
		if (filter.status) {
			msg.text('');
			input.attr('class', 'form-control form-control-user is-valid');
		}

		if (!filter.status) {
			msg.text(filter.msg);
			input.attr('class', 'form-control form-control-user is-invalid');
		}

		return filter.status ? true:false;
	}

	$("#new-role, #input-change-role").keyup(function() {
		inputName("#"+this.id, "#msg-"+this.id);
	});

	$("#add-role").click(function() {
		let role = $("#new-role");
		let btn = $("#add-role");
		let modal = $("#modal-add-role");
		let allow = true;

		if (!inputName("#"+role.attr("id"), "#msg-"+role.attr("id"))) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		role.attr("disabled", true);
		btn.attr("disabled", true);
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'role': role.val().trim().toLowerCase(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/newrole");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				role.attr("disabled", false);
				btn.attr("disabled", false);
			}
		});

		execute.fail(function() {
			role.attr("disabled", false);
			btn.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});	

	$("#input-delete-role").click(function() {
		let btn = $("#input-delete-role");
		let modal = $("#modal-delete-role");
		let allow = true;

		if (btn.attr("data-role").trim().length !== 5) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'role': btn.attr("data-role").trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/deleterole");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				btn.attr("disabled", false);
			}
		});

		execute.fail(function() {
			btn.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});

	$("#change-role").click(function() {
		let role = $("#input-change-role");
		let btn = $("#change-role");
		let modal = $("#modal-edit-role");
		let allow = true;

		if (!inputName("#"+role.attr("id"), "#msg-"+role.attr("id"))) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		role.attr("disabled", true);
		btn.attr("disabled", true);
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'role': role.val().trim().toLowerCase(),
			'code': role.attr("data-role").trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/changerole");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				role.attr("disabled", false);
				btn.attr("disabled", false);
			}
		});

		execute.fail(function() {
			role.attr("disabled", false);
			btn.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});

	$('[id^="edit-role"]').click(function() {
		let dataRole = $(this);
		let name = $("#name-"+dataRole.attr("data-role"));
		let role = $("#role-"+dataRole.attr("data-role"));
		let inputRole = $("#input-change-role");
		inputRole.val(name.text().trim());
		inputRole.attr("data-role", role.text().trim());

	});

	$('[id^="delete-role"]').click(function() {
		let dataRole = $(this);
		let name = $("#name-"+dataRole.attr("data-role"));
		let role = $("#role-"+dataRole.attr("data-role"));
		let inputRole = $("#input-delete-role");
		let roleDelete = $(".role-delete");
		inputRole.attr("data-role", role.text().trim());
		roleDelete.text(name.text().trim());
	});
});

let since = (function() {
	const filterCode = (method1, method2) => {
    let input = $(method1);
    let msg = $(method2);

    let filter = filterNumb(method1, true, 4, 4, 4);

    if (filter.status !== true) {
      input.attr('class', 'form-control form-control-user is-invalid');
      msg.text(filter.msg);
      return false;
    } else {
      input.attr('class', 'form-control form-control-user is-valid');
      msg.text("");
      return true;
    }
  }

	let inputName = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);

		let filter = filterChar(input, [" "], 3);
		if (filter.status) {
			msg.text('');
			input.attr('class', 'form-control form-control-user is-valid');
		}

		if (!filter.status) {
			msg.text(filter.msg);
			input.attr('class', 'form-control form-control-user is-invalid');
		}

		return filter.status ? true:false;
	}

	$("#new-since, #input-change-since").keyup(function() {
		filterCode("#"+this.id, "#msg-"+this.id);
	});

	$("#add-since").click(function() {
		let since = $("#new-since");
		let btn = $("#add-since");
		let modal = $("#modal-add-since");
		let allow = true;

		if (!filterCode("#"+since.attr("id"), "#msg-"+since.attr("id"))) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		since.attr("disabled", true);
		btn.attr("disabled", true);
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'since': since.val().trim().toLowerCase(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/newsince");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				since.attr("disabled", false);
				btn.attr("disabled", false);
			}
		});

		execute.fail(function() {
			since.attr("disabled", false);
			btn.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});	

	$("#input-delete-since").click(function() {
		let btn = $("#input-delete-since");
		let modal = $("#modal-delete-since");
		let allow = true;

		if (btn.attr("data-since").trim().length !== 5) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'since': btn.attr("data-since").trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/deletesince");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				btn.attr("disabled", false);
			}
		});

		execute.fail(function() {
			btn.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});

	$("#change-since").click(function() {
		let since = $("#input-change-since");
		let btn = $("#change-since");
		let modal = $("#modal-edit-since");
		let allow = true;

		if (!filterCode("#"+since.attr("id"), "#msg-"+since.attr("id"))) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		since.attr("disabled", true);
		btn.attr("disabled", true);
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'since': since.val().trim().toLowerCase(),
			'code': since.attr("data-since").trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/changesince");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				since.attr("disabled", false);
				btn.attr("disabled", false);
			}
		});

		execute.fail(function() {
			since.attr("disabled", false);
			btn.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});

	$('[id^="edit-since"]').click(function() {
		let datasince = $(this);
		let name = $("#name-"+datasince.attr("data-since"));
		let since = $("#since-"+datasince.attr("data-since"));
		let inputsince = $("#input-change-since");
		inputsince.val(name.text().trim());
		inputsince.attr("data-since", since.text().trim());

	});

	$('[id^="delete-since"]').click(function() {
		let datasince = $(this);
		let name = $("#name-"+datasince.attr("data-since"));
		let since = $("#since-"+datasince.attr("data-since"));
		let inputsince = $("#input-delete-since");
		let sinceDelete = $(".since-delete");
		inputsince.attr("data-since", since.text().trim());
		sinceDelete.text(name.text().trim());
	});
});

let major = (function() {
	const filterName = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);

		let filter = filterChar(input, [" "], 3);
		if (filter.status) {
			msg.text('');
			input.attr('class', 'form-control form-control-user is-valid');
		}

		if (!filter.status) {
			msg.text(filter.msg);
			input.attr('class', 'form-control form-control-user is-invalid');
		}

		return filter.status ? true:false;
	}

	$("#new-major-name, #change-major-name").keyup(function() {
		filterName("#"+this.id, "#msg-"+this.id);
	});

	$('[id^="edit-major"]').click(function() {
		const myData = $(this);
		const dataCode = $("#code-"+myData.attr("data-major"));
		const dataName = $("#name-"+myData.attr("data-major"));

		const code = $("#save-change-major");
		const major = $("#change-major-name");

		code.attr("data-major", myData.attr("data-major"));
		major.val(dataName.text().trim());
	});

	$('[id^="delete-major"]').click(function() {
		const myData = $(this);
		const dataCode = $("#code-"+myData.attr("data-major"));
		const dataName = $("#name-"+myData.attr("data-major"));

		const code = $("#save-delete-major");
		const major = $(".major-name-delete");

		code.attr("data-major", myData.attr("data-major"));
		major.text(dataName.text().trim());
	});

	$("#add-new-major").click(function() {
		const modal = $("#modal-add-major");
		const button = $("#add-new-major");
		const major = $("#new-major-name");
		let allow = true

		if (!filterName("#"+major.attr("id"), "#msg-"+major.attr("id"))) allow = false;

		if (!allow) return false;
		
		modal.modal('hide');
		major.attr("disabled", true);
		button.attr("disabled", true);
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'major': major.val().trim().toLowerCase(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/newmajor");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				major.attr("disabled", false);
				button.attr("disabled", false);
			}
		});

		execute.fail(function() {
			major.attr("disabled", false);
			button.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});

	$("#save-change-major").click(function() {
		const modal = $("#modal-change-major");
		const major = $("#change-major-name");
		const button = $("#save-change-major");
		let allow = true;

		if (!filterName("#"+major.attr("id"), "#msg-"+major.attr("id"))) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		major.attr("disabled", true);
		button.attr("disabled", true);
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'major': major.val().trim().toLowerCase(),
			'code': button.attr("data-major").trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/changemajor");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				major.attr("disabled", false);
				button.attr("disabled", false);
			}
		});

		execute.fail(function() {
			major.attr("disabled", false);
			button.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});

	$("#save-delete-major").click(function() {
		let modal = $("#modal-delete-major");
		let button = $("#save-delete-major");
		let allow = true;

		if (button.attr("data-major").trim().length < 3) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'major': button.attr("data-major").trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/deletemajor");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				button.attr("disabled", false);
			}
		});

		execute.fail(function() {
			button.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});
});

let cls = (function() {
	const filterName = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);

		let filter = filterLength(method1, 3, false);
		if (filter) {
			msg.text('');
			input.attr('class', 'form-control form-control-user is-valid');
		}

		if (filter !== true) {
			msg.text(filter);
			input.attr('class', 'form-control form-control-user is-invalid');
		}

		return (filter == true) ? true:false;
	}

	const filterMajor = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);


		if (input.val() && input.val().length !== 0) {
			input.attr('class', 'custom-select is-valid');
			msg.text("");
			return true;
		} else {
			input.attr('class', 'custom-select is-invalid');
			msg.text("Please choose a major!");
			return false;
		}
	}

	const filterRole = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);


		if (input.val() && input.val().length !== 0) {
			input.attr('class', 'custom-select is-valid');
			msg.text("");
			return true;
		} else {
			input.attr('class', 'custom-select is-invalid');
			msg.text("Please choose a role!");
			return false;
		}
	}

	const filterSince = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);


		if (input.val() && input.val().length !== 0) {
			input.attr('class', 'custom-select is-valid');
			msg.text("");
			return true;
		} else {
			input.attr('class', 'custom-select is-invalid');
			msg.text("Please choose a since!");
			return false;
		}
	}

	$("#new-class-name, #change-class-name").keyup(function() {
		filterName("#"+this.id, "#msg-"+this.id);
	});

	$('[id^="edit-class"]').click(function() {
		const myData = $(this);
		const dataCode = $("#code-"+myData.attr("data-class"));
		const dataClass = $("#class-"+myData.attr("data-class"));
		const code = $("#save-change-class");
		const cls = $("#change-class-name");

		code.attr("data-code", myData.attr("data-class"));
		cls.val(dataClass.text().trim());
	});

	$('[id^="delete-class"]').click(function() {
		const myData = $(this);
		const dataCode = $("#code-"+myData.attr("data-class"));
		const dataClass = $("#class-"+myData.attr("data-class"));
		const code = $("#save-delete-class");
		const cls = $(".class-name-delete");

		code.attr("data-class", myData.attr("data-class"));
		cls.text(dataClass.text().trim());
	});

	$("#add-new-class").click(function() {
		const name = $("#new-class-name");
		const major = $("#new-class-major");
		const role = $("#new-class-role");
		const since = $("#new-class-since");
		const button = $("#add-new-class");
		const modal = $("#modal-add-class");
		let allow = true;

		if (!filterName("#"+name.attr("id"), "#msg-"+name.attr("id"))) allow = false;
		if (!filterMajor("#"+major.attr("id"), "#msg-"+major.attr("id"))) allow = false;
		if (!filterRole("#"+role.attr("id"), "#msg-"+role.attr("id"))) allow = false;
		if (!filterSince("#"+since.attr("id"), "#msg-"+since.attr("id"))) allow = false;

		if (!allow) return false;

		$(".air-badge").html(loadingBackdrop());
		name.attr("disabled", true);
		major.attr("disabled", true);
		role.attr("disabled", true);
		since.attr("disabled", true);
		button.attr("disabled", true);
		modal.modal("hide");

		const PostFieldLogin = {
			'class': name.val().trim(),
			'major': major.val().trim(),
			'role': role.val().trim(),
			'since': since.val().trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(PostFieldLogin)),
		}

		const url = baseUrl("/auth/api/v2/newclass");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				window.location = window.location.href;
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				name.attr("disabled", false);
				major.attr("disabled", false);
				role.attr("disabled", false);
				since.attr("disabled", false);
				button.attr("disabled", false);
			}
		});

		execute.fail(function() {
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
			name.attr("disabled", false);
			major.attr("disabled", false);
			role.attr("disabled", false);
			since.attr("disabled", false);
			button.attr("disabled", false);
		});
	});

	$("#save-change-class").click(function() {
		const button = $("#save-change-class");
		const name = $("#change-class-name");
		const major = $("#change-class-major");
		const role = $("#change-class-role");
		const since = $("#change-class-since");
		const modal = $("#modal-change-class");
		let allow = true;

		if (!filterName("#"+name.attr("id"), "#msg-"+name.attr("id"))) allow = false;
		if (!filterMajor("#"+major.attr("id"), "#msg-"+major.attr("id"))) allow = false;
		if (!filterRole("#"+role.attr("id"), "#msg-"+role.attr("id"))) allow = false;
		if (!filterSince("#"+since.attr("id"), "#msg-"+since.attr("id"))) allow = false;

		if (!allow) return false;

		$(".air-badge").html(loadingBackdrop());
		name.attr("disabled", true);
		major.attr("disabled", true);
		role.attr("disabled", true);
		since.attr("disabled", true);
		button.attr("disabled", true);
		modal.modal("hide");

		const PostFieldLogin = {
			'code': button.attr("data-code").trim(),
			'class': name.val().trim(),
			'major': major.val().trim(),
			'role': role.val().trim(),
			'since': since.val().trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(PostFieldLogin)),
		}

		const url = baseUrl("/auth/api/v2/changeclass");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				window.location = window.location.href;
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				name.attr("disabled", false);
				major.attr("disabled", false);
				role.attr("disabled", false);
				since.attr("disabled", false);
				button.attr("disabled", false);
			}
		});

		execute.fail(function() {
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
			name.attr("disabled", false);
			major.attr("disabled", false);
			role.attr("disabled", false);
			since.attr("disabled", false);
			button.attr("disabled", false);
		});
	});

	$("#save-delete-class").click(function() {
		const modal = $("#modal-delete-class");
		const button = $("#save-delete-class");
		let allow = true;

		if (button.attr("data-class").trim().length !== 5) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'class': button.attr("data-class").trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/deleteclass");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				button.attr("disabled", false);
			}
		});

		execute.fail(function() {
			button.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});
})

let users = (function() {

	const filterCode = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);

		let filter = filterLength(method1, 13, 13);

		if (filter !== true) {
			input.attr('class', 'form-control form-control-user is-invalid');
			msg.text("Length must 13 numbers!");
			return false;
		} else {
			input.attr('class', 'form-control form-control-user is-valid');
			msg.text("");
			return true;
		}
	}
	
	const filterName = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);

		let filter = filterChar(input, [" "], 3);
		if (filter.status) {
			msg.text('');
			input.attr('class', 'form-control form-control-user is-valid');
		}

		if (!filter.status) {
			msg.text(filter.msg);
			input.attr('class', 'form-control form-control-user is-invalid');
		}

		return filter.status ? true:false;
	}

	const filterClass = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);


		if (input.val() && input.val().length !== 0) {
			input.attr('class', 'custom-select is-valid');
			msg.text("");
			return true;
		} else {
			input.attr('class', 'custom-select is-invalid');
			msg.text("Please choose a class!");
			return false;
		}
	}

	const filterRole = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);


		if (input.val() && input.val().length !== 0) {
			input.attr('class', 'custom-select is-valid');
			msg.text("");
			return true;
		} else {
			input.attr('class', 'custom-select is-invalid');
			msg.text("Please choose a role!");
			return false;
		}
	}

	$("#new-user-nim, #change-user-nim").keyup(function() {
		filterCode("#"+this.id, "#msg-"+this.id);
	});

	$("#new-user-nim, #change-user-nim").keypress(function() {
		return allowNumberic(this);
	});

	$("#new-user-name, #change-user-name").keyup(function() {
		filterName("#"+this.id, "#msg-"+this.id);
	});

	$('[id^="open-change-user"]').click(function() {
		const myData = $(this);
		const myNim = $("#nim-"+myData.attr("data-user"));
		const myName = $("#name-"+myData.attr("data-user"));
		const myRole = $("#role-"+myData.attr("data-user"));

		const dataNim = $("#change-data-nim");
		const name = $("#change-user-name");

		dataNim.attr("data-nim", myNim.text().trim());
		name.val(myName.text().trim());
	});

	$('[id^="open-delete-user"]').click(function() {
		const myData = $(this);
		const myNim = $("#nim-"+myData.attr("data-user"));
		const myName = $("#name-"+myData.attr("data-user"));

		const dataNim = $("#save-delete-user");
		const name = $(".user-delete-name");

		dataNim.attr("data-nim", myNim.text().trim());
		name.text(myName.text().trim());
	});

	$("#add-new-user").click(function() {
		const modal = $("#modal-add-user");
		const button = $("#add-new-user");
		const nim = $("#new-user-nim");
		const name = $("#new-user-name");
		const role = $("#new-user-role");
		const cls = $("#new-user-class");
		let allow = true;

		if (!filterCode("#"+nim.attr("id"), "#msg-"+nim.attr("id"))) allow = false;
		if (!filterName("#"+name.attr("id"), "#msg-"+name.attr("id"))) allow = false;
		if (!filterRole("#"+role.attr("id"), "#msg-"+role.attr("id"))) allow = false;
		if (!filterClass("#"+cls.attr("id"), "#msg-"+cls.attr("id"))) allow = false;

		if (!allow) return false;

		$(".air-badge").html(loadingBackdrop());
		button.attr("disabled", true);
		nim.attr("disabled", true);
		name.attr("disabled", true);
		role.attr("disabled", true);
		cls.attr("disabled", true);
		modal.modal("hide");

		const PostFieldLogin = {
			'nim': nim.val().trim(),
			'name': name.val().trim(),
			'role': role.val().trim(),
			'class': cls.val().trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(PostFieldLogin)),
		}

		const url = baseUrl("/auth/api/v2/newuser");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				window.location = window.location.href;
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				button.attr("disabled", false);
				nim.attr("disabled", false);
				name.attr("disabled", false);
				role.attr("disabled", false);
				cls.attr("disabled", false);
			}
		});

		execute.fail(function() {
			button.attr("disabled", false);
			nim.attr("disabled", false);
			name.attr("disabled", false);
			role.attr("disabled", false);
			cls.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});

	$("#save-change-user").click(function() {
		const modal = $("#modal-change-user");
		const button = $("#save-change-user");
		const dataNim = $("#change-data-nim");
		const name = $("#change-user-name");
		const role = $("#change-user-role");
		const cls = $("#change-user-class");
		let allow = true;

		if (!filterName("#"+name.attr("id"), "#msg-"+name.attr("id"))) allow = false;
		if (!filterRole("#"+role.attr("id"), "#msg-"+role.attr("id"))) allow = false;
		if (!filterClass("#"+cls.attr("id"), "#msg-"+cls.attr("id"))) allow = false;

		if (!allow) return false;

		$(".air-badge").html(loadingBackdrop());
		button.attr("disabled", true);
		name.attr("disabled", true);
		role.attr("disabled", true);
		cls.attr("disabled", true);
		modal.modal("hide");

		const PostFieldLogin = {
			'nim': dataNim.attr("data-nim").trim(),
			'name': name.val().trim(),
			'role': role.val().trim(),
			'class': cls.val().trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(PostFieldLogin)),
		}

		const url = baseUrl("/auth/api/v2/changeuser");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				window.location = window.location.href;
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				button.attr("disabled", false);
				name.attr("disabled", false);
				role.attr("disabled", false);
				cls.attr("disabled", false);
			}
		});

		execute.fail(function() {
			button.attr("disabled", false);
			name.attr("disabled", false);
			role.attr("disabled", false);
			cls.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	})

	$("#save-delete-user").click(function() {
		const modal = $("#modal-delete-user");
		const button = $("#save-delete-user");
		let allow = true;

		if (button.attr("data-nim").trim().length !== 13) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'nim': button.attr("data-nim").trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/deleteuser");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				btn.attr("disabled", false);
			}
		});

		execute.fail(function() {
			btn.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});
});

let campaign = (function() {
	let newFileCandidate = null;
	let changeFileCandidate = null;
	let newAvatar = null;
	let changeAvatar = null;
	let fileInput = null;
	let myFile = null;
	let image = document.getElementById('image-cropper');
	let thumbnail = null;
	let fileName = null;
	let modalCropper = $("#modal-crop-image");
	let cropper = null;
	let TypeAction = null;
	let saveFile = null;
	let options = {
		// aspectRatio: 1,
		// viewMode: 3,
		dragMode: 'move',
		aspectRatio: 1,
		autoCropArea: 1,
		restore: false,
		guides: false,
		center: true,
		highlight: true,
		cropBoxMovable: false,
		cropBoxResizable: false,
		toggleDragModeOnDblclick: false,

		ready: function (e) {
			console.log(e.type);
		},

		cropstart: function (e) {
			console.log(e.type, e.detail.action);
		},
		cropmove: function (e) {
			console.log(e.type, e.detail.action);
		},
		cropend: function (e) {
			console.log(e.type, e.detail.action);
		},
		zoom: function (e) {
			console.log(e.type, e.detail.ratio);
		},
		crop: function (e) {
			console.log(e.detail);
		},
	};

	let inputName = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);

		let filter = filterChar(input, [" "], 3);
		if (filter.status) {
			msg.text('');
			input.attr('class', 'form-control form-control-user is-valid');
		}

		if (!filter.status) {
			msg.text(filter.msg);
			input.attr('class', 'form-control form-control-user is-invalid');
		}

		return filter.status ? true:false;
	}

	const filterSelection = (method1, method2) => {
		let input = $(method1);
		let msg = $(method2);

		if (input.val() && input.val() !== null && input.val().length !== 0) {
			input.attr('class', 'custom-select is-valid');
			msg.text("");
			return true;
		} else {
			input.attr('class', 'custom-select is-invalid');
			msg.text("Please choose a class!");
			return false;
		}
	}

	const filterImage = (method1, method2, fname) => {
		let input = $(method1);
		let msg = $(method2);
		let _fname = $(fname);

		if (input && input.prop('files').length == 1) {
			msg.text('');
			input.removeClass('is-invalid');
			input.addClass('is-valid');
			return true;
		}

		if (!method1 || !input.prop('files').length == 1) {
			msg.text("Please choose a image!");
			_fname.text("Choose a image");
			input.removeClass('is-valid');
			input.addClass('is-invalid');
			return false;
		}
	}

	$("#new-candidate-name, #change-candidate-name").keyup(function() {
		inputName("#"+this.id, "#msg-"+this.id);
	});

	$("#new-choose-image, #change-choose-image").click(function() {
		const choose = $(this);
		TypeAction = choose.attr("data-choose");
		fileInput = choose;

		if (TypeAction == "new") {
			fileName = $(".new-file-name");
			thumbnail = $("#new-img-thumbnail");
		}

		if (TypeAction == "change") {
			fileName = $(".change-file-name");
			thumbnail = $("#change-img-thumbnail");
		}

		fileName.text("Choose a image");
		fileInput.val("");
	});

	$("#new-choose-image, #change-choose-image").change(function() {
		// fileInput = $("#new-choose-image");
		myFile = fileInput.prop('files')[0];
		let cropImage = $("#image-cropper");
		let modal = $('#modal-crop-image');

		fileName.text("Choose a image");

		if (imgExtension(myFile) == false ) {
			$(".air-badge").html(airBadge("The file must be an image!" , 'danger'));
			return false;
		}

		const reader = new FileReader();
		reader.onload = function() {

			const img = new Image;
			img.onload = function() {
				if (img.width > 5000 && img.height > 5000) {
					fileInput.val("");
					$(".air-badge").html(airBadge("Upload JPG or PNG image. 5000 x 5000 required!" , 'danger'));
				}
				cropImage.attr('src', reader.result);

				if (cropper) {
					cropper.destroy();
					cropper = null;
				}

				modal.modal('show');
			};

			img.onerror = function() {
				fileInput.val("");
				$(".air-badge").html(airBadge("Malicious files detected!" , 'danger'));
			};
			img.src = reader.result;
		}
		reader.readAsDataURL(myFile);
	});

	$("#rotate-l").click(function() {
		cropper.rotate(-90);
	});

	$("#rotate-r").click(function() {
		cropper.rotate(90);
	});

	$("#scale-l-r").click(function() {
		let dataScale = this.getAttribute('data-scale');

		if (this.getAttribute('data-scale') == "true") {
			cropper.scale(-1, 1);
			this.setAttribute('data-scale', false);
		} else {
			cropper.scale(1, 1);
			this.setAttribute('data-scale', true);
		}
	});

	$("#crop-image").click(function() {
		let finish = cropper.getCroppedCanvas({
			width: 1500,
			height: 1500,
			minWidth: 1000,
			minHeight: 1000,
			maxWidth: 1500,
			maxHeight: 1500,
			imageSmoothingEnabled: false,
			imageSmoothingQuality: 'high',
		});

		let blobBin = atob(finish.toDataURL().split(',')[1]);
		let array = [];
		for(let i = 0; i < blobBin.length; i++) {
			array.push(blobBin.charCodeAt(i));
		}
		let avatarFile = new Blob([new Uint8Array(array)], {type: 'image/png'});

		fileName.text(myFile.name);
		thumbnail.attr("src", finish.toDataURL());
		modalCropper.modal("hide");

		if (TypeAction == "new") {
			newFileCandidate = fileInput;
			newAvatar = avatarFile;
		}

		if (TypeAction == "change") {
			changeFileCandidate = fileInput;
			changeAvatar = avatarFile;
		}
	});

	modalCropper.on('shown.bs.modal', function () {
		cropper = new Cropper(image, options);
	});

	$("#open-new-candidate").click(function() {
		$("#page-candidate").addClass("d-none");
		$("#page-new-candidate").removeClass("d-none");
	});

	$("#close-new-candidate").click(function() {
		$("#page-candidate").removeClass("d-none");
		$("#page-new-candidate").addClass("d-none");
	});

	$("#close-change-candidate").click(function() {
		$("#page-candidate").removeClass("d-none");
		$("#page-change-candidate").addClass("d-none");
	});

	$('[id^="open-edit-candidate"]').click(function() {
		let openPage = $("#page-change-candidate");
		let closePage = $("#page-candidate");
		let dataCode = $(this);
		let candidateNumber = $("#number-"+dataCode.attr("data-candidate"));
		let candidateName = $("#name-"+dataCode.attr("data-candidate"));
		let candidateAs = $("#as-"+dataCode.attr("data-candidate"));
		let candidateAvatar = $("#avatar-"+dataCode.attr("data-candidate"));
		
		let changeNumber = $("#change-candidate-number");
		let changeName = $("#change-candidate-name");
		let changeAs = $("#change-as-candidate");
		let changeAvatar = $("#change-img-thumbnail");
		let changeCode = $("#candidate-code");

		changeCode.attr("data-code", dataCode.attr("data-candidate"));

		changeNumber.children("option").filter(":selected").removeAttr("selected");
		changeNumber.children('option:contains("'+candidateNumber.text().trim()+'")').attr("selected", true);

		changeAs.children("option").filter(":selected").removeAttr("selected")
		changeAs.children('option:text("'+candidateAs.text().trim()+'")').attr("selected", true);

		changeName.val(candidateName.text());
		changeAvatar.attr("src", candidateAvatar.attr("src"));

		closePage.addClass("d-none");
		openPage.removeClass("d-none");
	});

	$('[id^="open-delete-candidate"]').click(function() {
		let dataCode = $(this);
		let candidateName = $("#name-"+dataCode.attr("data-candidate"));

		let deltName = $(".candidate-delete");
		let deltCode = $("#candidate-delete");

		deltName.text(candidateName.text().trim());
		deltCode.attr("data-code", dataCode.attr("data-candidate"));
	});

	$("#turn-image").click(function() {
		let turn = $("#turn-image");
		let label = $("#label-turn-image");
		let change = $("#change-choose-image");
		let msg = $("#msg-change-choose-image");

		if (turn.prop('checked')) {
			label.text("Disabled change image");
			change.addClass("custom-input-file--2");
			change.attr("disabled", false);
			if (fileName) fileName.text("Choose a image");
		} else {
			label.text("Enable change image");
			change.removeClass("is-invalid");
			change.removeClass("custom-input-file--2");
			msg.text("");
			change.attr("disabled", true);
			change.val("");
		}
	});

	$("#add-new-candidate").click(function() {
		let newNumber = $("#new-candidate-number");
		let newName = $("#new-candidate-name");
		let newAs = $("#as-new-candidate");
		let newImage = $("#new-choose-image");
		let btn = $("#add-new-candidate");
		let nameFile = $(".new-file-name");
		let allow = true;

		if (!filterSelection("#"+newNumber.attr("id"), "#msg-"+newNumber.attr("id"))) allow = false;
		if (!inputName("#"+newName.attr("id"), "#msg-"+newName.attr("id"))) allow = false;
		if (!filterSelection("#"+newAs.attr("id"), "#msg-"+newAs.attr("id"))) allow = false;
		if (!filterImage("#"+newImage.attr("id"), "#msg-"+newImage.attr("id"), "."+nameFile.attr("class"))) allow = false;
		if (!newFileCandidate || !newFileCandidate.prop('files').length == 1) {
			$("#msg-"+newImage.attr("id")).text("Please choose a image!");
			nameFile.text("Choose a image");
			newImage.removeClass('is-valid');
			newImage.addClass('is-invalid');
			allow = false;
		}

		if (!allow) return false;

		newNumber.attr("disabled", true);
		newName.attr("disabled", true);
		newAs.attr("disabled", true);
		newImage.attr("disabled", true);
		btn.attr("disabled", true);
		$(".air-badge").html(loadingBackdrop());

		let params = {
			'number': newNumber.val().trim(),
			'name': newName.val().trim(),
			'as': newAs.val().trim(),
		};

		let formData = new FormData();
		formData.append('data', JEncrypt(JSON.stringify(params)));
		formData.append('original-avatar', newFileCandidate.prop('files')[0]);
		formData.append('avatar', newAvatar, newFileCandidate.prop('files')[0].name);

		const url = baseUrl("/auth/api/v2/newcandidate");

		const execute = postField(url, 'POST', formData, false, true);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				newNumber.attr("disabled", false);
				newName.attr("disabled", false);
				newAs.attr("disabled", false);
				newImage.attr("disabled", false);
				btn.attr("disabled", false);
			}
		});

		execute.fail(function() {
			newNumber.attr("disabled", false);
			newName.attr("disabled", false);
			newAs.attr("disabled", false);
			newImage.attr("disabled", false);
			btn.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});

	$("#save-change-candidate").click(function() {
		let changeNumber = $("#change-candidate-number");
		let changeName = $("#change-candidate-name");
		let changeAs = $("#change-as-candidate");
		let turnImage = $("#turn-image");
		let changeImage = $("#change-choose-image");
		let btn = $("#save-change-candidate");
		let nameFile = $(".change-file-name");
		let changeCode = $("#candidate-code");
		let allow = true;
		let onFile = null;
		let formData = null;

		if (!filterSelection("#"+changeNumber.attr("id"), "#msg-"+changeNumber.attr("id"))) allow = false;
		if (!inputName("#"+changeName.attr("id"), "#msg-"+changeName.attr("id"))) allow = false;
		if (!filterSelection("#"+changeAs.attr("id"), "#msg-"+changeAs.attr("id"))) allow = false;
		if (turnImage.prop("checked")) {
			if (!filterImage("#"+changeImage.attr("id"), "#msg-"+changeImage.attr("id"), "."+nameFile.attr("class"))) allow = false;
			if (!changeFileCandidate || !changeFileCandidate.prop('files').length == 1) {
				$("#msg-"+changeImage.attr("id")).text("Please choose a image!");
				nameFile.text("Choose a image");
				changeImage.removeClass('is-valid');
				changeImage.addClass('is-invalid');
				allow = false;
			}
		}

		if (!allow) return false;

		$(".air-badge").html(loadingBackdrop());
		changeNumber.attr("disabled", true);
		changeName.attr("disabled", true);
		changeAs.attr("disabled", true);
		// turnImage.attr("disabled", true);
		changeImage.attr("disabled", true);
		btn.attr("disabled", true);

		let params = {
			'code': changeCode.attr("data-code").toUpperCase().trim(),
			'number': changeNumber.val().trim(),
			'name': changeName.val().trim(),
			'as': changeAs.val().trim(),
		};

		if (turnImage.prop("checked")) {
			params['on-image'] = turnImage.prop("checked");
			formData = new FormData();
			formData.append('data', JEncrypt(JSON.stringify(params)));
			formData.append('original-avatar', changeFileCandidate.prop('files')[0]);
			formData.append('avatar', changeAvatar, changeFileCandidate.prop('files')[0].name);
			onFile = true;
		} else {
			formData = {
				'data' : JEncrypt(JSON.stringify(params)),
			}
			onFile = false;
		}

		const url = baseUrl("/auth/api/v2/changecandidate");

		const execute = postField(url, 'POST', formData, false, onFile);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				changeNumber.attr("disabled", false);
				changeName.attr("disabled", false);
				changeAs.attr("disabled", false);
				// turnImage.attr("disabled", false);
				changeImage.attr("disabled", false);
				btn.attr("disabled", false);
			}
		});

		execute.fail(function() {
			changeNumber.attr("disabled", false);
			changeName.attr("disabled", false);
			changeAs.attr("disabled", false);
			// turnImage.attr("disabled", false);
			changeImage.attr("disabled", false);
			btn.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});

	$("#save-delete-candidate").click(function() {
		let btn = $("#save-delete-candidate");
		let candidateCode = $("#candidate-delete");
		let modal = $("#modal-delete-candidate");
		let allow = true;

		if (candidateCode.attr("data-code").trim().length !== 5) allow = false;

		if (!allow) return false;

		modal.modal('hide');
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'role': candidateCode.attr("data-code").trim(),
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/deletecandidate");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
				setTimeout(function() {
					window.location = window.location.href;
				}, 5000);
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
				btn.attr("disabled", false);
			}
		});

		execute.fail(function() {
			btn.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});
});

let stats = (function() {
	let myOptions = options();

	const myChar = (options) => {
		let ctx = $("#myBarChart");
		let candidate = $('[id^="chart-name"]');
		let votes = $('[id^="chart-votes"]');
		let maxVote = $("#chart-total");
		let opt = options;

		let dataCandidate = [];
		for (let i = 0; i < candidate.length; i++) {
			dataCandidate.push(candidate[i].innerHTML);
		}

		let dataVotes = [];
		for (let i = 0; i < votes.length; i++) {
			dataVotes.push(votes[i].innerHTML);
		}

		opt.options.scales.yAxes[0].ticks.max = maxVote.text().trim();
		opt.data.labels = dataCandidate;
		opt.data.datasets[0].data = dataVotes;

		let myBarChart = new Chart(ctx, opt);
	}

	setInterval(function(){
		const url = baseUrl("/auth/api/v1/quiccount");

		const execute = postField(url, 'GET', false, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				let votes = $('[id^="chart-votes"]');
				for (var i = 0; i < votes.length; i++) {
					for (let x = 0; x < obj.result.length; x++) {
						if (votes[i].getAttribute("data-candidate") == obj.result[x].code) {
							votes[i].innerHTML = obj.result[x].votes;
						}
					}
				}
				myChar(myOptions);
			}
		});

		execute.fail(function() {
			myData.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	}, 3000);

	$("#myBarChart").ready(function() {
		myChar(myOptions);
	});

	$("#reset-votes").click(function() {
		let btn = $("#reset-votes");
		let modal = $("#modal-reset-votes");

		modal.modal('hide');
		$(".air-badge").html(loadingBackdrop());

		const params = {
			'reset': 1,
		};

		const executePost = {
			'data' : JEncrypt(JSON.stringify(params)),
		}

		const url = baseUrl("/auth/api/v2/resetvotes");

		const execute = postField(url, 'POST', executePost, false);

		execute.done(function(result) {
			let obj = JSON.parse(JSON.stringify(result));

			if (obj.code == 200) {
				$(".air-badge").html(airBadge(obj.msg , 'success'));
			} else {
				$(".air-badge").html(airBadge(obj.msg , 'danger'));
			}
			btn.attr("disabled", false);
		});

		execute.fail(function() {
			btn.attr("disabled", false);
			$(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
		});
	});

	$("#report-user-since").change(function() {
		const report = $("#modal-since");
		const modal = $("#modal-report");

		report.modal('hide');
		modal.modal('show');

		// window.open(baseUrl("/panel/report/users")+"/since/"+report.val(), '_blank').focus();
	});

	$("#report-user-class").change(function() {
		const report = $("#modal-class");
		const modal = $("#modal-report");

		report.modal('hide');
		modal.modal('show');

		// window.open(baseUrl("/panel/report/users")+"/class/"+report.val(), '_blank').focus();
	});

	$("#report-user-role").change(function() {
		const report = $("#modal-role");
		const modal = $("#modal-report");

		report.modal('hide');
		modal.modal('show');

		// window.open(baseUrl("/panel/report/users")+"/role/"+report.val(), '_blank').focus();
	});
});

let rptUsers = (function() {
	$("#report-user-since").change(function() {
		const report = $("#report-user-since");
		window.open(baseUrl("/panel/report/users")+"/since/"+report.val(), '_blank').focus();
	});

	$("#report-user-class").change(function() {
		const report = $("#report-user-class");
		window.open(baseUrl("/panel/report/users")+"/class/"+report.val(), '_blank').focus();
	});

	$("#report-user-role").change(function() {
		const report = $("#report-user-role");
		window.open(baseUrl("/panel/report/users")+"/role/"+report.val(), '_blank').focus();
	});
});

let main = (function() {
	let isOn = $(".main-cls").attr("main") || false;

	if (isOn == "login") login();
	if (isOn == "web-setting") webSetting();
	if (isOn == "campaign") campaign();
	if (isOn == "stats") stats();
	if (isOn == "usermanagement-role") role();
	if (isOn == "usermanagement-since") since();
	if (isOn == "usermanagement-major") major();
	if (isOn == "usermanagement-class") cls();
	if (isOn == "usermanagement-users") users();
	if (isOn == "report-users") rptUsers();
})();
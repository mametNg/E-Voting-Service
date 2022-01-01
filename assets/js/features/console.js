'use strict';

let register = (function() {

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

  let inputPassword = (method1, method2, method3) => {
    let password = $(method1);
    let msgPassword = $(method2);
    let confirm = $(method3);

    let filter = filterPass(method1, 8);

    if (!filter.status) {
      password.attr("class", "form-control form-control-user is-invalid");
      msgPassword.text(filter.msg);
      return false;
    }

    if (filter.status) {
      if (confirm.val().trim().length >= 1) {
        if (password.val().trim() == confirm.val().trim()) {
          password.attr("class", "form-control form-control-user is-valid");
          confirm.attr("class", "form-control form-control-user is-valid");
          msgPassword.text("");
          return true;
        }

        if (password.val().trim() !== confirm.val().trim()) {
          password.attr("class", "form-control form-control-user is-invalid");
          confirm.attr("class", "form-control form-control-user is-invalid");
          msgPassword.text("This password is not sync!");
          return false;
        }
      }

      if (confirm.val().trim().length <= 0) {
        password.attr("class", "form-control form-control-user is-valid");
        msgPassword.text("");
        return true;
      }
    }
  }

  let confirmPassowrd = (method1, method2, method3) => {
    let password = $(method1);
    let msgPassword = $(method2);
    let confirm = $(method3);

    let fPass = filterPass(method1, 8);

    if (!fPass.status) {
      password.attr("class", "form-control form-control-user is-invalid");
      msgPassword.text(fPass.msg);
      return false;
    }

    if (fPass.status) {
      if (password.val().trim() == confirm.val().trim()) {
        password.attr("class", "form-control form-control-user is-valid");
        confirm.attr("class", "form-control form-control-user is-valid");
        msgPassword.text("");
        return true;
      }

      if (password.val().trim() !== confirm.val().trim()) {
        password.attr("class", "form-control form-control-user is-invalid");
        confirm.attr("class", "form-control form-control-user is-invalid");
        msgPassword.text("Password is not sync!");
        return false;
      }
    }
  }

  $("#input-first-name, #input-last-name").keyup(function() {
    inputName("#"+this.id, "#msg-"+this.id);
  });

  $("#input-first-name, #input-last-name").change(function() {
    inputName("#"+this.id, "#msg-"+this.id);
  });

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

  $("#input-password").keyup(function() {
    inputPassword("#input-password", "#msg-input-password", "#confirm-input-password");
  });

  $("#confirm-input-password").keyup(function() {
    confirmPassowrd("#input-password", "#msg-input-password", "#confirm-input-password");
  });

  $("#register").click(function() {
    let fName = $("#input-first-name");
    let lName = $("#input-last-name");
    let email = $("#input-email");
    let password = $("#input-password");
    let confirmPassword = $("#confirm-input-password");
    let register = $("#register");
    let allow = true;

    if (!inputName("#"+fName.attr("id"), "#msg-"+fName.attr("id"))) allow = false;
    if (!inputName("#"+lName.attr("id"), "#msg-"+lName.attr("id"))) allow = false;
    if (!inputEmail("#"+email.attr("id"), "#msg-"+email.attr("id"))) allow = false;
    if (!inputPassword("#"+password.attr("id"), "#msg-"+password.attr("id"), "#"+confirmPassword.attr("id"))) allow = false;
    if (!confirmPassowrd("#"+password.attr("id"), "#msg-"+password.attr("id"), "#"+confirmPassword.attr("id"))) allow = false;

    if (!allow) return false;

    fName.attr("disabled", true);
    lName.attr("disabled", true);
    email.attr("disabled", true);
    password.attr("disabled", true);
    confirmPassword.attr("disabled", true);
    register.attr("disabled", true);
    $(".air-badge").html(loadingBackdrop());


    const params = {
      'first-name': fName.val().trim(),
      'last-name': lName.val().trim(),
      'email': email.val().trim().toLowerCase(),
      'password': password.val().trim(),
      'confirm-password': confirmPassword.val().trim(),
    };

    const headers = {
      "x-access-token": md5(theToken())
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const url = baseUrl("/auth/api/v2/register");

    const execute = postField(url, 'POST', executePost, headers);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
        setTimeout(function() {
          window.location = obj.result.url;
        }, 5000);
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
        fName.attr("disabled", false);
        lName.attr("disabled", false);
        email.attr("disabled", false);
        password.attr("disabled", false);
        confirmPassword.attr("disabled", false);
        register.attr("disabled", false);
      }
    });

    execute.fail(function() {
      fName.attr("disabled", false);
      lName.attr("disabled", false);
      email.attr("disabled", false);
      password.attr("disabled", false);
      confirmPassword.attr("disabled", false);
      register.attr("disabled", false);
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
  });
});

let verification = (function() {

  const filterCode = (method1, method2) => {
    let input = $(method1);
    let msg = $(method2);

    let filter = filterLength(method1, 6, 6);

    if (filter !== true) {
      input.attr('class', 'form-control form-control-user is-invalid');
      msg.text("Length must 6 numbers");
      return false;
    } else {
      input.attr('class', 'form-control form-control-user is-valid');
      msg.text("");
      return true;
    }
  }

  let countdown = () => {
    let countdown = $("#countdown");
    let btnCountdown = $("#resend");
    let seconds = 30;
    let countdownTimer = setInterval(
      function(){ let minutes = Math.round((seconds - 30)/60);
        let remainingSeconds = seconds % 60;
        if (remainingSeconds < 10) {
          remainingSeconds = "0" + remainingSeconds; 
        }
        countdown.text(remainingSeconds +" s");
        btnCountdown.attr("disabled", true);
        if (seconds == 0) {
          clearInterval(countdownTimer);
          countdown.text("");
          btnCountdown.attr("disabled", false);
        } else {
          seconds--;
        }
      } , 1000
      );
  }

  $("#countdown").ready(countdown());

  $("#resend").click(function() {
    let btnCountdown = $("#resend");
    let data = $(".clearfix").attr("contextmenu").trim();
    let arr = window.location.href.split("/");

    if (!arr.includes(data)) {
      $(".air-badge").html(airBadge("Error data. Please reaload this page!" , 'danger'));
      return false;
    }
    $(".air-badge").html(loadingBackdrop());

    const params = {
      'data': data,
    };

    const headers = {
      "x-access-token": md5(theToken())
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const url = baseUrl("/auth/api/v2/resend");

    const execute = postField(url, 'POST', executePost, headers);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
      }
      countdown();
    });

    execute.fail(function() {
      countdown();
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
  });

  $("#resend-second").click(function() {
    let btnCountdown = $("#resend-second");
    let data = $(".clearfix").attr("contextmenu").trim();
    let arr = window.location.href.split("/");

    if (!arr.includes(data)) {
      $(".air-badge").html(airBadge("Error data. Please reaload this page!" , 'danger'));
      return false;
    }
    $(".air-badge").html(loadingBackdrop());

    const params = {
      'data': data,
    };

    const headers = {
      "x-access-token": md5(theToken())
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const url = baseUrl("/auth/api/v2/resend");

    const execute = postField(url, 'POST', executePost, headers);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
        setTimeout(function() {
          window.location = window.location.href;
        }, 5000);
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
      }
    });

    execute.fail(function() {
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
  });

  $("#input-code").keyup(function() {
    filterCode("#"+this.id, "#msg-"+this.id);
  });

  $("#input-code").keypress(function() {
    return allowNumberic(this);
  });

  $("#verification").click(function() {
    let input = $("#input-code");
    let msg = $("#msg-input-code");
    let btn = $("#verification");
    let data = $(".clearfix").attr("contextmenu").trim();
    let arr = window.location.href.split("/");

    let allow = true;

    if (!filterCode("#"+input.attr("id"), "#"+msg.attr("id"))) allow = false;
    if (!allow) return false;
    if (!arr.includes(data)) {
      $(".air-badge").html(airBadge("Error data. Please reaload this page!" , 'danger'));
      return false;
    }

    input.attr("disabled", true);
    btn.attr("disabled", true);
    $(".air-badge").html(loadingBackdrop());

    const params = {
      'data': data,
      'code': input.val().trim(),
    };

    const headers = {
      "x-access-token": md5(theToken())
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const url = baseUrl("/auth/api/v2/verification");

    const execute = postField(url, 'POST', executePost, headers);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
        setTimeout(function() {
          window.location = obj.result.url;
        }, 5000);
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
        input.attr("disabled", false);
        btn.attr("disabled", false);
      }
    });

    execute.fail(function() {
      finput.attr("disabled", false);
      btn.attr("disabled", false);
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
  });
});

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

    const headers = {
      "x-access-token": md5(theToken())
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const url = baseUrl("/auth/api/v2/login");

    const execute = postField(url, 'POST', executePost, headers);

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

let reset = (function() {
  let inputPassword = (method1, method2, method3) => {
    let password = $(method1);
    let msgPassword = $(method2);
    let confirm = $(method3);

    let filter = filterPass(method1, 8);

    if (!filter.status) {
      password.attr("class", "form-control form-control-user is-invalid");
      msgPassword.text(filter.msg);
      return false;
    }

    if (filter.status) {
      if (confirm.val().trim().length >= 1) {
        if (password.val().trim() == confirm.val().trim()) {
          password.attr("class", "form-control form-control-user is-valid");
          confirm.attr("class", "form-control form-control-user is-valid");
          msgPassword.text("");
          return true;
        }

        if (password.val().trim() !== confirm.val().trim()) {
          password.attr("class", "form-control form-control-user is-invalid");
          confirm.attr("class", "form-control form-control-user is-invalid");
          msgPassword.text("This password is not sync!");
          return false;
        }
      }

      if (confirm.val().trim().length <= 0) {
        password.attr("class", "form-control form-control-user is-valid");
        msgPassword.text("");
        return true;
      }
    }
  }

  let confirmPassowrd = (method1, method2, method3) => {
    let password = $(method1);
    let msgPassword = $(method2);
    let confirm = $(method3);

    let fPass = filterPass(method1, 8);

    if (!fPass.status) {
      password.attr("class", "form-control form-control-user is-invalid");
      msgPassword.text(fPass.msg);
      return false;
    }

    if (fPass.status) {
      if (password.val().trim() == confirm.val().trim()) {
        password.attr("class", "form-control form-control-user is-valid");
        confirm.attr("class", "form-control form-control-user is-valid");
        msgPassword.text("");
        return true;
      }

      if (password.val().trim() !== confirm.val().trim()) {
        password.attr("class", "form-control form-control-user is-invalid");
        confirm.attr("class", "form-control form-control-user is-invalid");
        msgPassword.text("Password is not sync!");
        return false;
      }
    }
  }

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

  let countdown = () => {
    let countdown = $("#countdown");
    let btnCountdown = $("#resend");
    let seconds = 3;
    let countdownTimer = setInterval(
      function(){ let minutes = Math.round((seconds - 30)/60);
        let remainingSeconds = seconds % 60;
        if (remainingSeconds < 10) {
          remainingSeconds = "0" + remainingSeconds; 
        }
        countdown.text(remainingSeconds +" s");
        btnCountdown.attr("disabled", true);
        if (seconds == 0) {
          clearInterval(countdownTimer);
          countdown.text("");
          btnCountdown.attr("disabled", false);
        } else {
          seconds--;
        }
      } , 1000
      );
  }

  const filterCode = (method1, method2) => {
    let input = $(method1);
    let msg = $(method2);

    let filter = filterLength(method1, 6, 6);

    if (filter !== true) {
      input.attr('class', 'form-control form-control-user is-invalid');
      msg.text("Length must 6 numbers");
      return false;
    } else {
      input.attr('class', 'form-control form-control-user is-valid');
      msg.text("");
      return true;
    }
  }

  $("#countdown").ready(countdown());

  $("#input-email").keyup(function() {
    inputEmail("#input-email", "#msg-input-email");
  });

  $("#input-email").change(function() {
    inputEmail("#input-email", "#msg-input-email");
  });

  $("#resend").click(function() {
    let btnCountdown = $("#resend");
    let data = $(".clearfix").attr("contextmenu").trim();
    let arr = window.location.href.split("/");

    if (!arr.includes(data)) {
      $(".air-badge").html(airBadge("Error data. Please reaload this page!" , 'danger'));
      return false;
    }
    $(".air-badge").html(loadingBackdrop());

    const params = {
      'data': data,
    };

    const headers = {
      "x-access-token": md5(theToken())
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const url = baseUrl("/auth/api/v2/passresend");

    const execute = postField(url, 'POST', executePost, headers);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
      }
      countdown();
    });

    execute.fail(function() {
      countdown();
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
  });

  $("#reset").click(function() {
    let email = $("#input-email");
    let btn = $("#login");
    let allow = true;

    if (!inputEmail("#"+email.attr("id"), "#msg-"+email.attr("id"))) allow = false;
    if (!allow) return false;

    email.attr("disabled", true);
    btn.attr("disabled", true);
    $(".air-badge").html(loadingBackdrop());


    const params = {
      'email': email.val().trim().toLowerCase(),
    };

    const headers = {
      "x-access-token": md5(theToken())
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const url = baseUrl("/auth/api/v2/reset");

    const execute = postField(url, 'POST', executePost, headers);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
        setTimeout(function() {
          window.location = obj.result.url;
        }, 5000);
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
        email.attr("disabled", false);
        btn.attr("disabled", false);
      }
    });

    execute.fail(function() {
      email.attr("disabled", false);
      btn.attr("disabled", false);
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
  });

  $("#input-code").keyup(function() {
    filterCode("#"+this.id, "#msg-"+this.id);
  });

  $("#input-code").keypress(function() {
    return allowNumberic(this);
  });

  $("#reset-pass").click(function() {
    let input = $("#input-code");
    let msg = $("#msg-input-code");
    let btn = $("#verification");
    let data = $(".clearfix").attr("contextmenu").trim();
    let arr = window.location.href.split("/");

    let allow = true;

    if (!filterCode("#"+input.attr("id"), "#"+msg.attr("id"))) allow = false;
    if (!allow) return false;
    if (!arr.includes(data)) {
      $(".air-badge").html(airBadge("Error data. Please reaload this page!" , 'danger'));
      return false;
    }

    input.attr("disabled", true);
    btn.attr("disabled", true);
    $(".air-badge").html(loadingBackdrop());

    const params = {
      'data': data,
      'code': input.val().trim(),
    };

    const headers = {
      "x-access-token": md5(theToken())
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const url = baseUrl("/auth/api/v2/confirmreset");

    const execute = postField(url, 'POST', executePost, headers);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
        setTimeout(function() {
          window.location = obj.result.url;
        }, 5000);
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
        input.attr("disabled", false);
        btn.attr("disabled", false);
      }
    });

    execute.fail(function() {
      finput.attr("disabled", false);
      btn.attr("disabled", false);
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
  });

  $("#resend-second").click(function() {
    let btnCountdown = $("#resend-second");
    let data = $(".clearfix").attr("contextmenu").trim();
    let arr = window.location.href.split("/");

    if (!arr.includes(data)) {
      $(".air-badge").html(airBadge("Error data. Please reaload this page!" , 'danger'));
      return false;
    }
    $(".air-badge").html(loadingBackdrop());

    const params = {
      'data': data,
    };

    const headers = {
      "x-access-token": md5(theToken())
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const url = baseUrl("/auth/api/v2/passresend");

    const execute = postField(url, 'POST', executePost, headers);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
        setTimeout(function() {
          window.location = window.location.href;
        }, 5000);
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
      }
    });

    execute.fail(function() {
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
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

  $("#input-password").keyup(function() {
    inputPassword("#input-password", "#msg-input-password", "#confirm-input-password");
  });

  $("#confirm-input-password").keyup(function() {
    confirmPassowrd("#input-password", "#msg-input-password", "#confirm-input-password");
  });

  $("#reset-new-password").click(function() {
    let password = $("#input-password");
    let confirmPassword = $("#confirm-input-password");
    let btn = $("#reset-new-password");
    let btnCountdown = $("#resend");
    let dataFirst = $(".clearfix").attr("contextmenu").trim();
    let dataSeconds = $(".clearcode").attr("contextmenu").trim();
    let arr = window.location.href.split("/");
    let allow = true;


    if (!inputPassword("#"+password.attr("id"), "#msg-"+password.attr("id"), "#"+confirmPassword.attr("id"))) allow = false;
    if (!confirmPassowrd("#"+password.attr("id"), "#msg-"+password.attr("id"), "#"+confirmPassword.attr("id"))) allow = false;
    
    if (!arr.includes(dataFirst) || !arr.includes(dataSeconds)) {
      $(".air-badge").html(airBadge("Error data. Please reaload this page!" , 'danger'));
      allow = false;
    }

    if (!allow) return false;

    $(".air-badge").html(loadingBackdrop());
    password.attr("disabled", true);
    confirmPassword.attr("disabled", true);
    btn.attr("disabled", true);
    
    const params = {
      'email': dataFirst,
      'code': dataSeconds,
      'password': password.val().trim(),
      'confirm-password': confirmPassword.val().trim(),
    };

    const headers = {
      "x-access-token": md5(theToken())
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const url = baseUrl("/auth/api/v2/newpass");

    const execute = postField(url, 'POST', executePost, headers);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
        setTimeout(function() {
          window.location = obj.result.url;
        }, 5000);
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
        password.attr("disabled", false);
        confirmPassword.attr("disabled", false);
        btn.attr("disabled", false);
      }
    });

    execute.fail(function() {
      password.attr("disabled", false);
      confirmPassword.attr("disabled", false);
      btn.attr("disabled", false);
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });

  });
});

let account = (function() {
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

  $("#input-first-name, #input-last-name").keyup(function() {
    inputName("#"+this.id, "#msg-"+this.id);
  });

  $("#input-first-name, #input-last-name").change(function() {
    inputName("#"+this.id, "#msg-"+this.id);
  });

  $("#input-email").keyup(function() {
    inputEmail("#input-email", "#msg-input-email");
  });

  $("#input-email").change(function() {
    inputEmail("#input-email", "#msg-input-email");
  });

  $("#input-email").attr("disabled", true);

  $('[id^="eraser-preview"]').click(function(){

    const eraser = $('[id^="eraser-preview"]');

    if (parseInt(eraser.length) == 1) {
      $("#preview").addClass('d-none');
      $("#img-preview").attr('src', '');
      $("#drop-file").val("");
      $("#dropped").show();
    } else {
      const modal = $('div[modal-index]');
      let key = 0;

      for (var i = 0; i < modal.length; i++) {
        find = modal.eq(i).attr('class').split(' ');
        if (find.includes('show')) {
          key = modal.eq(i).attr('modal-index');
          break;
        }
      }
      $('[id^="preview"]').eq(key).addClass('d-none');
      $('[id^="img-preview"]').eq(key).attr('src', '');
      $('[id^="multiple-drop-file"]').eq(key).val("");
      $('[id^="dropped"]').eq(key).show();
    }
  });

  $('#drop-file').change(function(){
    const myFile = $("#drop-file").prop('files')[0];

    if (imgExtension(myFile) == false ) {
      $('#modal-avatar').modal('hide');
      $(".air-badge").html(airBadge("The file must be an image!" , 'danger'));
      return false;
    }

    const reader = new FileReader();
    reader.onload = function() {

      const img = new Image;
      img.onload = function() {
        if (img.width > 5000 && img.height > 5000) {
          $('#modal-avatar').modal('hide');
          $(".air-badge").html(airBadge("Upload JPG or PNG image. 5000 x 5000 required!" , 'danger'));
          $("#preview").addClass('d-none');
          $("#img-preview").attr('src', '');
          $("#drop-file").val("");
          $("#dropped").show();
          return false;
        }

        $("#img-preview").attr('src', reader.result);

        $("#dropped").hide();
        $("#preview").removeClass('d-none');
      };

      img.onerror = function() {
        $('#modal-avatar').modal('hide');
        $(".air-badge").html(airBadge("Malicious files detected!" , 'danger'));
        $("#preview").addClass('d-none');
        $("#img-preview").attr('src', '');
        $("#drop-file").val("");
        $("#dropped").show();
        return false;
      };
      img.src = reader.result;
    }
    reader.readAsDataURL(myFile);
  });

  $('[id^="multiple-drop-file"]').change(function() {

    const drop = $('[id^="multiple-drop-file"]');
    const key = this.attributes['data-key'].nodeValue;
    const modal = $('div[modal-index]').eq(key);

    const preview = $('[id^="preview"]').eq(key);
    const imgPreview = $('[id^="img-preview"]').eq(key);
    const dropped = $('[id^="dropped"]').eq(key);

    const data = drop.eq(key);
    const myFile = data.prop('files')[0];


    if (imgExtension(myFile) == false ) {
      modal.modal('hide');
      $(".air-badge").html(airBadge("The file must be an image!" , 'danger'));
      return false;
    }

    const reader = new FileReader();
    reader.onload = function() {

      const img = new Image;
      img.onload = function() {
        if (img.width > 5000 && img.height > 5000) {
          modal.modal('hide');
          $(".air-badge").html(airBadge("Upload JPG or PNG image. 5000 x 5000 required!" , 'danger'));
          preview.addClass('d-none');
          imgPreview.attr('src', '');
          data.val("");
          dropped.show();
          return false;
        }

        imgPreview.attr('src', reader.result);

        dropped.hide();
        preview.removeClass('d-none');
      };

      img.onerror = function() {
        modal.modal('hide');
        $(".air-badge").html(airBadge("Malicious files detected!" , 'danger'));
        preview.addClass('d-none');
        imgPreview.attr('src', '');
        data.val("");
        dropped.show();
        return false;
      };
      img.src = reader.result;
    }
    reader.readAsDataURL(myFile);
  });

  $('#change-avatar').click(function(){
    const myFile = $("#drop-file");

    $('#modal-avatar').modal('hide');
    if (myFile.prop('files')[0] == undefined) {
      $(".air-badge").html(airBadge("Please select an image before changing your avatar!" , 'danger'));
      return false;
    }

    $(".air-badge").html(loadingBackdrop());

    let params = {
      'x-token': xToken(),
    };

    let formData = new FormData();
    formData.append('data', JEncrypt(JSON.stringify(params)));
    formData.append('avatar', myFile.prop('files')[0]);

    const headers = {
      "x-access-token": md5(theToken())
    };

    const url = baseUrl("/auth/api/v2/account/avatar");

    const execute = postField(url, 'POST', formData, headers, true);

    execute.done(function(result) {
      const obj = JSON.parse(JSON.stringify(result));

      $("#preview").addClass('d-none');
      $("#img-preview").attr('src', '');
      $("#drop-file").val("");
      $("#dropped").show();
      $('#modal-avatar').modal('hide');
      if (obj.status == true) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
        setTimeout(function() {
          window.location = window.location.href;
        }, 5000);
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
      }
    });

    execute.fail(function() {
      $(".air-badge").html(airBadge("Request time out. Please try!" , 'danger'));
      $('#modal-avatar').modal('hide');
    });
  });

  $("#change-profile").click(function() {
    let btn = $("#change-profile");
    let fName = $("#input-first-name");
    let lName = $("#input-last-name");
    let allow = true;

    if (!inputName("#"+fName.attr("id"), "#msg-"+fName.attr("id"))) allow = false;
    if (!inputName("#"+lName.attr("id"), "#msg-"+lName.attr("id"))) allow = false;

    if (!allow) return false;

    fName.attr("disabled", true);
    lName.attr("disabled", true);
    btn.attr("disabled", true);
    $(".air-badge").html(loadingBackdrop());

    const params = {
      'first-name': fName.val().trim(),
      'last-name': lName.val().trim(),
      'x-token': xToken(),
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const headers = {
      "x-access-token": md5(theToken())
    };

    const url = baseUrl("/auth/api/v2/account/profile");

    const execute = postField(url, 'POST', executePost, headers);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
        setTimeout(function() {
          window.location = window.location.href;
        }, 5000);
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
        fName.attr("disabled", false);
        lName.attr("disabled", false);
        btn.attr("disabled", false);
      }
    });

    execute.fail(function() {
      fName.attr("disabled", false);
      lName.attr("disabled", false);
      btn.attr("disabled", false);
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
  });
});

let accountSettings = (function() {
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

  let inputOldPassword = (method1, method2) => {

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

  let inputPassword = (method1, method2, method3) => {
    let password = $(method1);
    let msgPassword = $(method2);
    let confirm = $(method3);

    let filter = filterPass(method1, 8);

    if (!filter.status) {
      password.attr("class", "form-control form-control-user is-invalid");
      msgPassword.text(filter.msg);
      return false;
    }

    if (filter.status) {
      if (confirm.val().trim().length >= 1) {
        if (password.val().trim() == confirm.val().trim()) {
          password.attr("class", "form-control form-control-user is-valid");
          confirm.attr("class", "form-control form-control-user is-valid");
          msgPassword.text("");
          return true;
        }

        if (password.val().trim() !== confirm.val().trim()) {
          password.attr("class", "form-control form-control-user is-invalid");
          confirm.attr("class", "form-control form-control-user is-invalid");
          msgPassword.text("This password is not sync!");
          return false;
        }
      }

      if (confirm.val().trim().length <= 0) {
        password.attr("class", "form-control form-control-user is-valid");
        msgPassword.text("");
        return true;
      }
    }
  }

  let confirmPassowrd = (method1, method2, method3) => {
    let password = $(method1);
    let msgPassword = $(method2);
    let confirm = $(method3);

    let fPass = filterPass(method1, 8);

    if (!fPass.status) {
      password.attr("class", "form-control form-control-user is-invalid");
      msgPassword.text(fPass.msg);
      return false;
    }

    if (fPass.status) {
      if (password.val().trim() == confirm.val().trim()) {
        password.attr("class", "form-control form-control-user is-valid");
        confirm.attr("class", "form-control form-control-user is-valid");
        msgPassword.text("");
        return true;
      }

      if (password.val().trim() !== confirm.val().trim()) {
        password.attr("class", "form-control form-control-user is-invalid");
        confirm.attr("class", "form-control form-control-user is-invalid");
        msgPassword.text("Password is not sync!");
        return false;
      }
    }
  }

  const filterCode = (method1, method2) => {
    let input = $(method1);
    let msg = $(method2);

    let filter = filterLength(method1, 6, 6);

    if (filter !== true) {
      input.attr('class', 'form-control form-control-user is-invalid');
      msg.text("Length must 6 numbers");
      return false;
    } else {
      input.attr('class', 'form-control form-control-user is-valid');
      msg.text("");
      return true;
    }
  }

  let countdown = () => {
    let btnCountdown = $("#get-code");
    let seconds = 30;
    let countdownTimer = setInterval(
      function(){ let minutes = Math.round((seconds - 30)/60);
        let remainingSeconds = seconds % 60;
        if (remainingSeconds < 10) {
          remainingSeconds = "0" + remainingSeconds; 
        }
        btnCountdown.text(remainingSeconds +" s");
        btnCountdown.attr("disabled", true);
        if (seconds == 0) {
          clearInterval(countdownTimer);
          btnCountdown.text("Get code");
          btnCountdown.attr("disabled", false);
        } else {
          seconds--;
        }
      } , 1000
      );
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

  $("#input-password").keyup(function() {
    inputPassword("#input-password", "#msg-input-password", "#confirm-input-password");
  });

  $("#confirm-input-password").keyup(function() {
    confirmPassowrd("#input-password", "#msg-input-password", "#confirm-input-password");
  });

  $("#input-code").keyup(function() {
    filterCode("#"+this.id, "#msg-"+this.id);
  });

  $("#input-code").keypress(function() {
    return allowNumberic(this);
  });

  $("#get-code").click(function() {
    let email = $("#input-email");
    let allow = true;

    if (!inputEmail("#"+email.attr("id"), "#msg-"+email.attr("id"))) allow = false;

    if (!allow) return false;
    
    email.attr("disabled", true);
    $(".air-badge").html(loadingBackdrop());
    
    const params = {
      'email': email.val().trim().toLowerCase(),
      'x-token': xToken(),
    };

    const headers = {
      "x-access-token": md5(theToken())
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const url = baseUrl("/auth/api/v2/account/get-code");

    const execute = postField(url, 'POST', executePost, headers);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
        countdown();
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
        email.attr("disabled", false);
      }
    });

    execute.fail(function() {
      email.attr("disabled", false);
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
  });

  $("#change-email").click(function() {
    let email = $("#input-email");
    let code = $("#input-code");
    let btnCode = $("#get-code");
    let btn = $("#change-email");
    let allow = true;

    if (!inputEmail("#"+email.attr("id"), "#msg-"+email.attr("id"))) allow = false;
    if (!filterCode("#"+code.attr("id"), "#msg-"+code.attr("id"))) allow = false;

    if (!allow) return false;

    email.attr("disabled", true);
    code.attr("disabled", true);
    btnCode.attr("disabled", true);
    btn.attr("disabled", true);
    $(".air-badge").html(loadingBackdrop());

    const params = {
      'code': code.val().trim().toLowerCase(),
      'email': email.val().trim().toLowerCase(),
      'x-token': xToken(),
    };

    const headers = {
      "x-access-token": md5(theToken())
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const url = baseUrl("/auth/api/v2/account/email");

    const execute = postField(url, 'POST', executePost, headers);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
        setTimeout(function() {
          window.location = window.location.href;
        }, 5000);
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
        code.attr("disabled", false);
        btnCode.attr("disabled", false);
        email.attr("disabled", false);
        btn.attr("disabled", false);
      }
    });

    execute.fail(function() {
      code.attr("disabled", false);
      btnCode.attr("disabled", false);
      email.attr("disabled", false);
      btn.attr("disabled", false);
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
  });

  $("#change-password").click(function() {
    let oldPassword = $("#input-password-old");
    let newPassword = $("#input-password");
    let conPassword = $("#confirm-input-password");
    let btn = $("#change-password");
    let allow = true;

    if (!inputOldPassword("#"+oldPassword.attr("id"), "#msg-"+oldPassword.attr("id"))) allow = false;
    if (!inputPassword("#"+newPassword.attr("id"), "#msg-"+newPassword.attr("id"), "#"+conPassword.attr("id"))) allow = false;
    if (!confirmPassowrd("#"+newPassword.attr("id"), "#msg-"+newPassword.attr("id"), "#"+conPassword.attr("id"))) allow = false;

    if (!allow) return false;
    
    oldPassword.attr("disabled", true);
    newPassword.attr("disabled", true);
    conPassword.attr("disabled", true);
    btn.attr("disabled", true);
    $(".air-badge").html(loadingBackdrop());

    const params = {
      'old-password': oldPassword.val().trim(),
      'new-password': newPassword.val().trim(),
      'confirm-password': conPassword.val().trim(),
      'x-token': xToken(),
    };

    const headers = {
      "x-access-token": md5(theToken())
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const url = baseUrl("/auth/api/v2/account/password");

    const execute = postField(url, 'POST', executePost, headers);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
        setTimeout(function() {
          window.location = window.location.href;
        }, 5000);
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
        oldPassword.attr("disabled", false);
        newPassword.attr("disabled", false);
        conPassword.attr("disabled", false);
        btn.attr("disabled", false);
      }
    });

    execute.fail(function() {
      oldPassword.attr("disabled", false);
      newPassword.attr("disabled", false);
      conPassword.attr("disabled", false);
      btn.attr("disabled", false);
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
  });
});

let main = (function() {
  let isOn = $(".main-cls").attr("main") || false;

  if (isOn == "register") register();
  if (isOn == "verification") verification();
  if (isOn == "login") login();
  if (isOn == "reset") reset();
  if (isOn == "account") account();
  if (isOn == "account-settings") accountSettings();
  // if (isOn) eval(isOn+"()");
})();
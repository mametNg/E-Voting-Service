let login = (function() {

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

  const filterClass = (method1, method2) => {
    let input = $(method1);
    let msg = $(method2);


    if (input.val() && input.val().length !== 0) {
      input.attr('class', 'custom-select is-valid');
      msg.text("");
      return true;
    } else {
      input.attr('class', 'custom-select is-invalid');
      msg.text("Please choose a login as!");
      return false;
    }
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

  $("#input-id").keyup(function() {
    filterCode("#"+this.id, "#msg-"+this.id);
  });
 
  $("#input-id").keypress(function() {
    return allowNumberic(this);
  });

  $("#login").click(function() {
    let nim = $("#input-id");
    let pass = $("#input-password");
    let as = $("#input-login-as");
    let btn = $("#login");
    let allow = true;

    if (!filterCode("#"+nim.attr("id"), "#msg-"+nim.attr("id"))) allow = false;
    if (!inputPassword("#"+pass.attr("id"), "#msg-"+pass.attr("id"))) allow = false;
    if (!filterClass("#"+as.attr("id"), "#msg-"+as.attr("id"))) allow = false;

    if (!allow) return false;

    nim.attr("disabled", true);
    as.attr("disabled", true);
    btn.attr("disabled", true);
    $(".air-badge").html(loadingBackdrop());

    const PostFieldLogin = {
      'nim': nim.val().trim(),
      'password': pass.val().trim(),
      'as': as.val().trim(),
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(PostFieldLogin)),
    }

    const url = baseUrl("/auth/api/v1/login");

    const execute = postField(url, 'POST', executePost, false);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        $(".air-badge").html(airBadge(obj.msg , 'success'));
        window.location = window.location.href;
      } else {
        $(".air-badge").html(airBadge(obj.msg , 'danger'));
        btn.attr("disabled", false);
        nim.attr("disabled", false);
        as.attr("disabled", false);
      }
    });

    execute.fail(function() {
      btn.attr("disabled", false);
      nim.attr("disabled", false);
      as.attr("disabled", false);
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
  });

})();
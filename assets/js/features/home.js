'use strict';
let home = (function() {

  $("#modal-user").modal("show");

  $("#modal-user").on('hidden.bs.modal', function () {
    $("#modal-rules").modal("show");
  });

  $('[id^="open-modal-vote"]').click(function() {
    let myData = $(this);
    let dataNumb = myData.attr("data-key").trim();
    let dataCode = myData.attr("data-candidate").trim();

    let candNumb = $(".candidate-numb");
    let candCode = $("#save-vote-candidate");
    candNumb.text(dataNumb);
    candCode.attr("data-cadidate", dataCode);
  });

  $("#save-vote-candidate").click(function() {
    let myData = $("#save-vote-candidate");
    let modal = $("#modal-vote-candidate");
    let allow = true;

    if (myData.attr("data-cadidate").trim().length !== 5) allow = false;

    if (!allow) return false;

    $(".air-badge").html(loadingBackdrop());
    modal.modal('hide');
    myData.attr("disabled", true);

    const params = {
      'code': myData.attr("data-cadidate").trim(),
    };

    const executePost = {
      'data' : JEncrypt(JSON.stringify(params)),
    }

    const url = baseUrl("/auth/api/v1/vote");

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
        myData.attr("disabled", false);
      }
    });

    execute.fail(function() {
      myData.attr("disabled", false);
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
  });
});

let quicCount = (function() {
  setInterval(function(){
    const url = baseUrl("/auth/api/v1/quiccount");

    const execute = postField(url, 'GET', false, false);

    execute.done(function(result) {
      let obj = JSON.parse(JSON.stringify(result));

      if (obj.code == 200) {
        for (var i = 0; i < obj.result.length; i++) {
          $("#"+obj.result[i].code).text(obj.result[i].votes);
        }
      }
    });

    execute.fail(function() {
      myData.attr("disabled", false);
      $(".air-badge").html(airBadge("Request Time Out. Please Try!" , 'danger'));
    });
  }, 3000);
})

let activation = (function() {

  const filterCode = (method1, method2) => {
    let input = $(method1);
    let msg = $(method2);

    let filter = filterLength(method1, 6, 6);

    if (filter !== true) {
      input.attr('class', 'form-control form-control-user is-invalid');
      msg.text("Length must 6 numbers!");
      $("#submit-code").attr("type", "button");
      return false;
    } else {
      input.attr('class', 'form-control form-control-user is-valid');
      msg.text("");
      $("#submit-code").attr("type", "submit");
      return true;
    }
  }

  $("#submit-code").click(function() {
    filterCode("#input-code", "#msg-input-code");
  });

  $("#input-code").keyup(function() {
    filterCode("#"+this.id, "#msg-"+this.id);
  });

});

let main = (function() {
  let isOn = $(".main-cls").attr("main") || false;

  if (isOn == "home-vote") home();
  if (isOn == "quic-count") quicCount();
  if (isOn == "activation") activation();
})();
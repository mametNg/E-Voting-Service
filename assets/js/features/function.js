const countTotal = (data) => {
  let array = $(data).val().trim().split("\n");
  let total = array.length;
  if (array.length === undefined) total = 0;
  if (total == 1 && array[0].length == 0) total = 0;
  $("#total-list").text(total);

  if (total !== 0) {
    $(data).attr('class', 'form-control is-valid');
    $("#msg-list").text('');
    $("#start").attr("disabled", false);
    $("#clear").attr("disabled", false);
  } else {
    $(data).attr('class', 'form-control');
    $("#msg-list").text('');
    $("#start").attr("disabled", true);
    $("#clear").attr("disabled", true);
  }
  $("#form-error").attr('class' ,'form-group col-md-2 d-none');
}

const removeDuplicate = (data, key) => {
  let array = $(data).val().split('\n');
  array = unique(array);
  for (i = 0; i < array.length; i++) {
    array[i] = array[i].trim();
    array[i] = array[i].replace('   ', '');
    if (array[i].length === 0) {
      array.splice(i, 1);
    }
  }
  $(key).val(array.join("\n"));
}

const unique = (array) => {
  return array.filter(function (el, index, arr) {
    return index == arr.indexOf(el);
  });
}

const openFile = (file, key) => {
  let reader = new FileReader();
  reader.onload = function(){
    let text = reader.result;
    $(key).val(text);
    countTotal(key);
  };
  reader.readAsText(file);
}

const replaceAll = (string, search, replace) => {
  return string.split(search).join(replace);
}

const JEncrypt = (field) => {
  const encrypt = new JSEncrypt();
  encrypt.setPublicKey(keyToken());

  let scriptInitTime = Math.round(+new Date()/1000);
  let serverTime = (+new Date().getTime());

  let submitTime = Math.round(+new Date()/1000);
  let timeDiff = serverTime + (submitTime - scriptInitTime);

  const result = encrypt.encrypt(field + "+" + timeDiff);

  return result;
}

const buildQuery = (arr) => {
  return  Object.keys(arr).map(k => encodeURIComponent(k) + '=' + encodeURIComponent(arr[k])).join('&');
}

const buildQueryMVC = (arr) => {
  return  Object.keys(arr).map(k => encodeURIComponent(arr[k])).join('/');
}

const theToken = () => {
  return atob($('meta[name="token"]').attr('content'));
}

const xToken = () => {
  return atob($('meta[name="x-token"]').attr('content'));
}

const keyToken = () => {
  return atob($('meta[name="access-token"]').attr('content'));
}

const baseUrl = (path="") => {
  return $('meta[property="og:url"]').attr('content') + path;
}

const postField = (url, type='GET', params=false, headers=false, opt=false) => {

  if (opt == true) {
    options = {
      url: url,
      type: type,
      data: params,
      headers: headers,
      cache: false,
      processData: false,
      contentType: false,
    };
  } else {
    options = {
      url: url,
      type: type,
      data: params,
      headers: headers,
    };
  }

  return $.ajax(options);
}

const allowNumberic = (evt) => {
  let charCode = (evt.which) ? evt.which : event.keyCode;

  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
  } else {
    return true;
  }
}

const hidde = (id) => {
  $(id).removeClass('d-block');
  $(id).removeClass('d-flex');
  $(id).addClass('d-none');
}

const showPasswd = (id) => {
  let input = $("#"+id);
  let btn = $("#btn-"+id);

  if (input.attr('type') == "password") {
    btn.html('<i class="fas fa-fw fa-eye-slash"></i>');
    input.attr('type', 'text');
  } else {
    btn.html('<i class="fas fa-fw fa-eye"></i>');
    input.attr('type', 'password');
  }
}

const filterLength = (data, min=false, max=false) => {
  const txt = $(data).val().trim();
  if (min && txt.length < min ) return `Minimum length ${min} characters`;
  if (max && txt.length > max ) return `Maximum length ${max} characters`;
  return true;
}

const filterMail = (ev) => {
  let email = $(ev).val();
  let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if(email.match(mailformat)) {
    return true;
  } else {
    return false; 
  }
}

const filterNumb = (ev, status=false, min=false, max=false, must=false) => {
  let numb = replaceAll($(ev).val().trim(), "   ", "");
  let array = numb.split("");

  let result = {
    'status' : false,
    'msg' : "length missing",
  };

  for (let i = 0; i < array.length; i++) {
    if (array[i] != " " && array[i] >= 0 && array[i] <= 9) {
      if (status == true) {

        if (must !== false) {
          if (array.length !== must ) {
            result.status = false;
            result.msg = 'Must '+ must +' digits!';
            break;
          } else {
            result.status = true;
            result.msg = '';
          }
        } else {
          if (min !== false) {
            if (array.length < min ) {
              result.status = false;
              result.msg = 'Minimum '+ min +' digits!';
              break;
            } else {
              result.status = true;
              result.msg = '';
            }
          }
          if (max !== false) {
            if (array.length > max ) {
              result.status = false;
              result.msg = 'Maximum '+ max +' digits!';
              break;
            } else {
              result.status = true;
              result.msg = '';
            }
          }
        }
        if (min == false && max == false && must == false) {
          console.log('error filter numb length min, max or must cannot be empty!');
        }
      } else {
        result.status = true;
        result.msg = '';
      }
    } else {
      result.status = false;
      result.msg = 'It can only be a number!';
      break;
    }
  }

  return result;
}

const filterChar = (ev, allow=[], min=false, max=false) => {
  let name = replaceAll($(ev).val().trim(), "   ", "");
  let array = name.split("");
  let txt = "";

  let response = {
    "status" : false,
    "msg" : "Cannot be empty!",
  };

  let newAllow = allow.filter((a) => a);

  if (newAllow.length !== 0) {
    for (let x = 0; x < newAllow.length; x++) {
      txt += (newAllow.length-1 == x ? " & "+newAllow[x].replace(" ", "spaces"):", "+newAllow[x].replace(" ", "spaces"));
    }
  }

  // if (array.length == 0) {
  //   response['status'] = false;
  //   response['msg'] = "Cannot be empty!";
  // }

  for (let i = 0; i < array.length; i++) {
    if (array[i] >= 'a' || array[i] < 'z' && array[i] >= 'A' || array[i] < 'Z' && newAllow.includes(array[i])) {
      response['status'] = true;
      response['msg'] = "";
      if (filterLength(ev, min, max) !== true) {
        response['status'] = false;
        response['msg'] = filterLength(ev, min, max);
        break;
      }
    } else {
      response['status'] = false;
      response['msg'] = "Can only be characters" + txt+"!";
      break;
    }
  }

  return response;
}

const filterPass = (ev, min=false, max=false) => {
  let text = $(ev).val().trim();
  let array = text.split("");

  let response = {
    "status" : false,
    "msg" : "Password must have capital letters, symbols and numbers!",
  };

  let symbol = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
  if (!symbol.test(text)) return response;

  let lowchar = /[a-z]/;
  if (!lowchar.test(text)) return response;

  let upchar = /[A-Z]/;
  if (!upchar.test(text)) return response;

  let number = /[0-9]/;
  if (!number.test(text)) return response;

  if (filterLength(ev, min, max) !== true) {
    response['msg'] = filterLength(ev, min, max);
    return response;
  }

  response['status'] = true;
  response['msg'] = "";

  return response;

}

const imgExtension = (file) => {
  const validExtension = /(\.jpg|\.jpeg|\.png|\.svg)$/i;
  if (!file) return false;
  return (!validExtension.exec(file.name) ? false : true);
}

const dangerousImg = (file) => {
  const dangerElementImg = [
  "?php",
  "?= ",
  "eval ",
  "eval(",
  "popen ",
  "popen(",
  "echo",
  "print ",
  "print(",
  "printf ",
  "printf(",
  "exec ",
  "exec(",
  "system ",
  "system(",
  "<html",
  "<script",
  "<link",
  "<body",
  "<p ",
  "</p>",
  "<span>",
  "<span ",
  "<input",
  "<img",
  "<a ",
  ];

  let isRealImg = true;
  for (let i = 0; i < dangerElementImg.length; i++) {
    let find = file.indexOf(dangerElementImg[i]);

    if (find >= 0) {
      console.log(dangerElementImg[i]);
      isRealImg = false;
      break;
    }
  }

  return isRealImg;
}

const openInNewTab = (url) => {
  let win = window.open(url, '_blank');
  win.focus();
}

const ratenow = (val) => {
  for (let i = 1; i <= val; i++) {
    $("#star-"+i).attr("class", "text-xl-1 mx-2 fa fa-star text-warning");
    $("#star-modal-"+i).attr("class", "text-xl-1 mx-2 fa fa-star text-warning");
    if (val == i) {
      $("#star-"+i).attr("data", "active");
      $("#star-modal-"+i).attr("data", "active");
      $("#rate-us").attr('disabled', false);
    } else {
      $("#star-"+i).attr("data", "");
      $("#star-modal-"+i).attr("data", "");
    }
  }
  for (let x = parseInt(val)+1; x <= 5; x++) {
    $("#star-"+x).attr("class", "text-xl-1 mx-2 fa fa-star text-secondary");
    $("#star-modal-"+x).attr("class", "text-xl-1 mx-2 fa fa-star text-secondary");
    $("#star-"+x).attr("data", "");
    $("#star-modal-"+x).attr("data", "");
  }
  $(".rateValue").attr("value",val);
}

const copy = (target) => {
  const copyText = $(target);
  copyText.select();
  document.execCommand("copy");
}

const saveAs = (target, name) => {
  const textToWrite = $(target).val();
  const textFileAsBlob = new Blob([ textToWrite ], { type: 'text/plain' });
  const fileNameToSaveAs = name + "-" + Date.now() + ".txt";
  let downloadLink = document.createElement("a");
  downloadLink.download = fileNameToSaveAs;
  downloadLink.innerHTML = "Download File";
  if (window.webkitURL != null) {
    downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
  } else {
    downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
    downloadLink.onclick = destroyClickedElement;
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
  }

  downloadLink.click();
}

const airBadge = (msg, type='success') => {
  return `<div id="close-badge" class="alert alert-${type} alert-animate backdrop alert-center position-fixed mt-5" role="alert"><div class="d-flex justify-content-between"><div class="position-relative mr-2"><p class="my-1">${msg} </p></div><button type="button" class="btn close close-rotate" data-dismiss="modal" aria-label="Close" onclick="hidde('#close-badge');"><span aria-hidden="true">&times;</span></button></div><div class="progress-alert"></div></div>`;
}

const modalFinish = () => {
  return `<div class="modal" id="modal-finish" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="bg-transition"></div>
  <div class="modal-dialog modal-sm shadow" role="document">
  <div class="modal-content bg-white">
  <div class="modal-body">
  <button type="button" class="btn close close-absolute close-rotate" data-dismiss="modal" aria-label="Close" onclick="hidde('#finish-success');">
  <span aria-hidden="true">&times;</span>
  </button>
  <div class="success-checkmark">
  <div class="check-icon check-icon-success">
  <span class="icon-line icon-line-success success-tip"></span>
  <span class="icon-line icon-line-success success-long"></span>
  <div class="icon-circle icon-circle-success"></div>
  <div class="icon-fix"></div>
  </div>
  </div>
  <h4 class="card-text text-center">
  Finish
  </h4>
  </div>
  </div>
  </div>
  </div>`;
}

const md5cycle = (x, k) => {
  let a = x[0], b = x[1], c = x[2], d = x[3];

  a = ff(a, b, c, d, k[0], 7, -680876936);
  d = ff(d, a, b, c, k[1], 12, -389564586);
  c = ff(c, d, a, b, k[2], 17,  606105819);
  b = ff(b, c, d, a, k[3], 22, -1044525330);
  a = ff(a, b, c, d, k[4], 7, -176418897);
  d = ff(d, a, b, c, k[5], 12,  1200080426);
  c = ff(c, d, a, b, k[6], 17, -1473231341);
  b = ff(b, c, d, a, k[7], 22, -45705983);
  a = ff(a, b, c, d, k[8], 7,  1770035416);
  d = ff(d, a, b, c, k[9], 12, -1958414417);
  c = ff(c, d, a, b, k[10], 17, -42063);
  b = ff(b, c, d, a, k[11], 22, -1990404162);
  a = ff(a, b, c, d, k[12], 7,  1804603682);
  d = ff(d, a, b, c, k[13], 12, -40341101);
  c = ff(c, d, a, b, k[14], 17, -1502002290);
  b = ff(b, c, d, a, k[15], 22,  1236535329);

  a = gg(a, b, c, d, k[1], 5, -165796510);
  d = gg(d, a, b, c, k[6], 9, -1069501632);
  c = gg(c, d, a, b, k[11], 14,  643717713);
  b = gg(b, c, d, a, k[0], 20, -373897302);
  a = gg(a, b, c, d, k[5], 5, -701558691);
  d = gg(d, a, b, c, k[10], 9,  38016083);
  c = gg(c, d, a, b, k[15], 14, -660478335);
  b = gg(b, c, d, a, k[4], 20, -405537848);
  a = gg(a, b, c, d, k[9], 5,  568446438);
  d = gg(d, a, b, c, k[14], 9, -1019803690);
  c = gg(c, d, a, b, k[3], 14, -187363961);
  b = gg(b, c, d, a, k[8], 20,  1163531501);
  a = gg(a, b, c, d, k[13], 5, -1444681467);
  d = gg(d, a, b, c, k[2], 9, -51403784);
  c = gg(c, d, a, b, k[7], 14,  1735328473);
  b = gg(b, c, d, a, k[12], 20, -1926607734);

  a = hh(a, b, c, d, k[5], 4, -378558);
  d = hh(d, a, b, c, k[8], 11, -2022574463);
  c = hh(c, d, a, b, k[11], 16,  1839030562);
  b = hh(b, c, d, a, k[14], 23, -35309556);
  a = hh(a, b, c, d, k[1], 4, -1530992060);
  d = hh(d, a, b, c, k[4], 11,  1272893353);
  c = hh(c, d, a, b, k[7], 16, -155497632);
  b = hh(b, c, d, a, k[10], 23, -1094730640);
  a = hh(a, b, c, d, k[13], 4,  681279174);
  d = hh(d, a, b, c, k[0], 11, -358537222);
  c = hh(c, d, a, b, k[3], 16, -722521979);
  b = hh(b, c, d, a, k[6], 23,  76029189);
  a = hh(a, b, c, d, k[9], 4, -640364487);
  d = hh(d, a, b, c, k[12], 11, -421815835);
  c = hh(c, d, a, b, k[15], 16,  530742520);
  b = hh(b, c, d, a, k[2], 23, -995338651);

  a = ii(a, b, c, d, k[0], 6, -198630844);
  d = ii(d, a, b, c, k[7], 10,  1126891415);
  c = ii(c, d, a, b, k[14], 15, -1416354905);
  b = ii(b, c, d, a, k[5], 21, -57434055);
  a = ii(a, b, c, d, k[12], 6,  1700485571);
  d = ii(d, a, b, c, k[3], 10, -1894986606);
  c = ii(c, d, a, b, k[10], 15, -1051523);
  b = ii(b, c, d, a, k[1], 21, -2054922799);
  a = ii(a, b, c, d, k[8], 6,  1873313359);
  d = ii(d, a, b, c, k[15], 10, -30611744);
  c = ii(c, d, a, b, k[6], 15, -1560198380);
  b = ii(b, c, d, a, k[13], 21,  1309151649);
  a = ii(a, b, c, d, k[4], 6, -145523070);
  d = ii(d, a, b, c, k[11], 10, -1120210379);
  c = ii(c, d, a, b, k[2], 15,  718787259);
  b = ii(b, c, d, a, k[9], 21, -343485551);

  x[0] = add32(a, x[0]);
  x[1] = add32(b, x[1]);
  x[2] = add32(c, x[2]);
  x[3] = add32(d, x[3]);

}

const cmn = (q, a, b, x, s, t) => {
  a = add32(add32(a, q), add32(x, t));
  return add32((a << s) | (a >>> (32 - s)), b);
}

const ff = (a, b, c, d, x, s, t) => {
  return cmn((b & c) | ((~b) & d), a, b, x, s, t);
}

const gg = (a, b, c, d, x, s, t) => {
  return cmn((b & d) | (c & (~d)), a, b, x, s, t);
}

const hh = (a, b, c, d, x, s, t) => {
  return cmn(b ^ c ^ d, a, b, x, s, t);
}

const ii = (a, b, c, d, x, s, t) => {
  return cmn(c ^ (b | (~d)), a, b, x, s, t);
}

const md51 = (s) => {
  txt = '';
  let n = s.length,
  state = [1732584193, -271733879, -1732584194, 271733878], i;
  for (i=64; i<=s.length; i+=64) {
    md5cycle(state, md5blk(s.substring(i-64, i)));
  }
  s = s.substring(i-64);
  let tail = [0,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0];
  for (i=0; i<s.length; i++)
    tail[i>>2] |= s.charCodeAt(i) << ((i%4) << 3);
  tail[i>>2] |= 0x80 << ((i%4) << 3);
  if (i > 55) {
    md5cycle(state, tail);
    for (i=0; i<16; i++) tail[i] = 0;
  }
tail[14] = n*8;
md5cycle(state, tail);
return state;
}

const md5blk = (s) => {
  let md5blks = [], i;
  for (i=0; i<64; i+=4) {
    md5blks[i>>2] = s.charCodeAt(i)
    + (s.charCodeAt(i+1) << 8)
    + (s.charCodeAt(i+2) << 16)
    + (s.charCodeAt(i+3) << 24);
  }
  return md5blks;
}

let hex_chr = '0123456789abcdef'.split('');

const rhex = (n) => {
  let s='', j=0;
  for(; j<4; j++)
    s += hex_chr[(n >> (j * 8 + 4)) & 0x0F]
  + hex_chr[(n >> (j * 8)) & 0x0F];
  return s;
}

const hex = (x) => {
  for (let i=0; i<x.length; i++)
    x[i] = rhex(x[i]);
  return x.join('');
}

const md5 = (s) => {
  return hex(md51(s));
}

const add32 = (a, b) => {
  return (a + b) & 0xFFFFFFFF;
}

const loadingBackdrop = () => {
  return `
  <div class="modal fade show d-block" id="finish-success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="bg-transition backdrop"></div>
  <div class="modal-dialog modal-sm pt-10 mt-10" role="document">
  <div class="modal-content bg-transparent border-0">
  <div class="modal-body p-0">
  <div class="mesh-loader">
  <div class="set-one">
  <div class="circle"></div>
  <div class="circle"></div>
  </div>
  <div class="set-two">
  <div class="circle"></div>
  <div class="circle"></div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>`;
}
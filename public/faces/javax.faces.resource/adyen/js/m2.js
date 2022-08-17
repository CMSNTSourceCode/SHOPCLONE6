var listISP = ["MOBI", "VIETTEL", "VINA", "GMOBILE", "VIETNAMMOBILE"];

var passwordRegex = '^[0-9_-]{6}$';
var numberRegex = "^[0-9]";
var emailRegex = '^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$';
var textRegex = '[A-Za-z]';
function regex(str, pattern) {
    var reg = new RegExp(pattern);
    return reg.test(str);
}

function isValidCardNumber(data) {
    if (/^\d{12,19}$/.test(data)) return true;
    return false;
}

function isValidAmountNumber(data) {
    if (!(/^[0-9]{5,8}$/.test(data))) return false;
    if (data < 10000 || data > 20000000) {
        return false;
    }
    return true;
}

function isValidPersonalId(data) {
    if (/^\d{9}$/.test(data) || /^\d{12}$/.test(data)) return true;
    return false;
}

function isValidCardName(data) {
    if (/^[a-zA-Z ]*$/.test(data)) return true;
    return false;
}

function validatePassword(input) {
    return regex(input, passwordRegex);
}
//**** Hidden POPUP ISO ****
function killPopup() {
    window.removeEventListener('pagehide', killPopup);
}

window.addEventListener('pagehide', killPopup);


function limit(element, max) {
    var max_chars = max;
    if (element.value.length > max_chars) {
        element.value = element.value.substr(0, max_chars);
    }
}

function smartOtp() {

}
function smartRegister() {
    var phoneNumber = $("#phoneNumber").val();
    var f = formatPhoneNumber(phoneNumber);
    var password = $("#password").val();
    var confirmPassword = $("#cpassword").val();
    showBtnRegister(f, password, confirmPassword);
}
function tooglePin(e) {

}
function showBtnRegister(phoneNumber, password, confirmPassword) {
    if (isValidPhoneNumber(phoneNumber) && isValidPassword(password)
        && isValidConfirmPassword(password, confirmPassword)) {
        $("#register").removeAttr("disabled");
    } else {
        $("#register").attr("disabled", true);
    }
}
function isValidPassword(password) {
    return validatePassword(password);
}
function isValidConfirmPassword(password, confirmPassword) {
    return password == confirmPassword;
}
function smartInput() {
    var inputs = $("input");
    for (var i = 0; i < inputs.length; i++) {
        $(inputs[i]).focusin(function (e) {
            errors.noError($(this));
        });
        $(inputs[i]).keypress(function (e) {
            //  errors.removeFocusState($(this));
        });
    }
}
var inputHandler = {
    focus: function (e) {
        var i = $(e), value = i.val();
        var els = i.parent().parent().find(".item-title.header.label").removeAttr("hidden");
    },
    removeFocus: function (e) {
        var i = $(e), value = i.val();
        var els = i.parent().parent().find(".item-title.header.label").attr("hidden", true);
    }
}
var errors = {
    notInputs: ['checkbox', 'button', 'submit', 'range', 'radio', 'image'],
    focusState: function (e, msg) {
        var i = $(e);
        var type = i.attr('type');
        if (this.notInputs.indexOf(type) >= 0) return;
        var els = i.add(i.parents('.item-input, .input-field')).add(i.parents('.item-inner').eq(0));
        els.addClass('focus-state-error');
        var err = els.parents('.form-group').children('.error');
        err.text(msg);
        err.show();

    },
    removeFocusState: function (e) {
        var i = $(e), value = i.val();
        var type = i.attr('type');
        if (this.notInputs.indexOf(type) >= 0) return;
        var els = i.add(i.parents('.item-input, .input-field')).add(i.parents('.item-inner').eq(0));
        els.removeClass('focus-state-error');
        //els.addClass('focus-state');
        if (value && value.trim() !== '') {
            els.addClass('not-empty-state-error');
            els.children('.header').css('color', '');
        } else {
            els.removeClass('focus-state not-empty-state-error');
            els.children('.header').css('color', '');
        }
        var error = els.parents('.form-group').children('.error');
        error.text('');
        error.show();
    },
    watchChangeState: function (e) {
        var input = $(e), value = input.val();
        var type = input.attr('type');
        if (this.notInputs.indexOf(type) >= 0) return;
        var els = input.add(input.parents('.item-input, .input-field')).add(input.parents('.item-inner').eq(0));
        if (els.length === 0) return;
        if (
            (value && (typeof value === 'string' && value.trim() !== '')) || (Array.isArray(value) && value.length > 0)
        ) {
            els.addClass('not-empty-state-error');
        } else {
            els.removeClass('not-empty-state-error');
        }
    },
    noError: function (e) {
        var i = $(e), value = i.val();
        var type = i.attr('type');
        if (this.notInputs.indexOf(type) >= 0) return;
        var els = i.add(i.parents('.item-input, .input-field')).add(i.parents('.item-inner').eq(0));
        var parent = i.parent('.item-input, .input-field');
        var elsP = i.parent('.item-input, .input-field').find("item-title label");
        parent.removeClass('focus-state-error');
        parent.addClass('focus-state');
        els.removeClass('focus-state-error');
        els.addClass('focus-state');
        elsP.css({ display: 'block' });
        // elsP.children('.header').css('color', 'rgba(0, 0, 0, 0.65)');
        els.removeAttr("hidden");
        if (value) {
            els.addClass('focus-state not-empty-state-error');
        } else {

        }
        error = $(els).find('.item-title.error');
        error.text('');
        error.show();
    },
}

function isValidPhoneNumber(phoneNumber) {
    var regex = {
        "MOBI": "^(089|090|093|0120|0121|0122|0126|0128|070|079|077|076|078)\\d{7}$",
        "VIETTEL": "^(096|097|098|0162|0163|0164|0165|0166|0167|0168|0169|086|032|033|034|035|036|037|038|039)\\d{7}$",
        "VINA": "^(091|094|0123|0124|0125|0127|0129|088|083|084|085|081|082|087)\\d{7}$",
        "GMOBILE": "^(099|0199|059)\\d{7}$",
        "VIETNAMMOBILE": "^(092|0186|0188|056|0186|058|052)\\d{7}$"
    };
    var length = listISP.length;
    for (var i = 0; i < length; i++) {
        var pattern = new RegExp(regex[listISP[i]]);
        if (pattern.test(phoneNumber))
            return true;
    }
    return false;
}
function sValidPhoneNumber(e) {
    // var c = String.fromCharCode(e.keyCode);
    // var value = e.target.value;
    // console.log("KeyCode", e.keyCode);
    // console.log("Key", e.key);
    // // if (element.value.length > max_chars) {
    // //     element.value = element.value.substr(0, max_chars);
    // // }
    // var validCharacter = ['(', ')', '+', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    // if (validCharacter.indexOf(c) < 0) {
    //     e.target.value = value.substr(0, value.length - 1);
    //     // Register
    //     if (c === ' ') {
    //         console.log("Vlue", value);
    //         e.target.value = value.substr(0, value.length - 2);
    //     }
    //     return;
    // }
}
function showPannelNotify(isError, msg) {
    var cls = isError ? "alert-danger" : "alert-success";
    var clzz = !isError ? "alert-danger" : "alert-success";
    $("#msg-momo").css("display", "block");
    $("#msg-momo").find(".alert").addClass(cls);
    $("#msg-momo").find(".alert").removeClass(clzz);
    $("#msg-momo").find(".alert").text(msg);
}
function offPannelNotify() {
    $("#msg-momo").attr("hidden", "hidden");
    $("#msg-momo").find(".alert").text("");
}

var xoayxoay = {
    start: function (elsLoading, btn) {
        $(elsLoading).removeAttr("hidden");
        $(btn).attr("disabled", true);
    },
    stop: function (elsLoading, btn) {
        $(elsLoading).attr("hidden", true);
        $(btn).removeAttr("disabled");
    }
}
function isMatchedPassword(password, currentPasword) {
    return password == currentPasword;
};
function formatPhoneNumber(input) {
    if (!input) return;
    var value = input.trim().replace(" ", "");
    // value = value.replace("(", "").replace(")", "").replace(" ", "");
    // If phoneNumber invald
    value = value.replace(/[^\d\.]/g, '');
    if (value.indexOf("840")==0) {
        value = value.replace("840", "0");
    }
    else if (value.indexOf("84")==0) {
        value = value.substring(2, value.length);
        value = "0" + value;
    }
    else if (value.indexOf("9") ==0
        || value.indexOf("1")==0) {
        value = "0" + value;
    }
    return value;
};
function redirectToBank(bank) {
    var link = '';
    switch (bank) {
        case 'vcb':
            link = 'https://www.vietcombank.com.vn/IBanking2015/55c3c0a782b739e063efa9d5985e2ab4/Account/Login';
            break;
        case 'ocb':
            link = 'https://ebanking.ocb.com.vn/corp/home.ocb';
            break;
        case 'vpb':
            link = "https://online.vpbank.com.vn/cb/pages/jsp-ns/login-cons.jsp";
            break;
        case 'vtb':
            link = 'https://ebanking.vietinbank.vn/rcas/portal/web/retail/bflogin';
            break;
        case 'exb':
            link = 'https://ebanking.eximbank.vn/ibcn/faces/login.jspx;';
            break;
        case 'tpb':
            link = 'https://ebank.tpb.vn/retail/v8/';
            break;
        case 'acb':
            link = 'https://online.acb.com.vn/acbib/Request';
            break;
        case 'bidv':
            link = 'https://www.bidv.vn:81/EntlWeb/IbsJsps/orbilogin.jsp?Source=NewLogin';
            break;
        case 'scb':
            var currentUrl = window.location.href;
            link = currentUrl + "&page=mapbankcard&bank_code=2000";
            break;
        case 'sgb':
            var currentUrl = window.location.href;
            link = currentUrl + "&page=mapbankcard&bank_code=114";
            break;
        case 'guide-map-bank':
            var currentUrl = window.location.href;
            link = currentUrl + "&page=guide-map-bank&bank_code=guide-map-bank";
            break;
        default:
            break;
    }
    if (bank === 'sgb' || bank === 'scb' || bank === 'guide-map-bank') {
        window.location.href = link;
    } else {
        tracking(bank, bank);
        openPopupWindow(link, "Liên kết ngân hàng", 800, 800);
    }
};

function tracking(bankCode, bankName) {
    $.ajax({
        url: '/gw_payment/signup/bank',
        dataType: 'text',
        type: 'post',
        contentType: 'application/json; charset=utf-8',
        data: JSON.stringify({
            bankCode: bankCode,
            bankName: bankName,
            requestType: "tracking"
        }),
        success: function (data, textStatus, jQxhr) {
        },
        error: function (jqXhr, textStatus, errorThrown) {
        }
    });
}
function openPopupWindow(url, title, w, h) {
    var left = (screen.width / 2) - (w / 2);
    var top = (screen.height / 2) - (h / 2);
    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
}

String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

function replaceVnChars(str) {
    if (!str) {
        str = "";
    }
    str = str.replaceAll("[áàãảạâấầẩẫậăắằẳẵặ]", "a").replaceAll("[óòỏõọôốồổỗộơớờởỡợ]", "o")
        .replaceAll("[íìĩỉị]", "i").replaceAll("[ýỳỷỹỵ]", "y").replaceAll("[éèẻẽẹêếềểễệ]", "e")
        .replaceAll("[úùủũụưứừửữự]", "u").replaceAll("[đ]", "d");
    str = str.replaceAll("[ÁÀẢÃẠĂẮẰẲẴẶÂẤẦẨẪẬ]", "A").replaceAll("[ÓÒỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢ]", "O")
        .replaceAll("[ÍÌỈĨỊ]", "I").replaceAll("[ÝỲỶỸỴ]", "Y").replaceAll("[ÉÈẺẼẸÊẾỀỂỄỆ]", "E")
        .replaceAll("[ÚÙỦŨỤƯỨỪỬỮỰ]", "U").replaceAll("[Đ]", "D");
    return str;
}

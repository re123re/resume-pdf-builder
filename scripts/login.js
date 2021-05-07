function getCode() {
    $.ajax({
        url: "api/request_code.php",
        type: "POST",
        data: {
            phone_number: $("#phone_number").val(),
        },
        cache: false,
        success: function (result) {
            if (result.is_success) {
                if (result.ucaller_id) {
                    alert("Код отправлен");
                    $("#ucaller_id").val(result.ucaller_id);
                }
            } else {
                alert(result.error_message);
            }
        },
        error: function (result) {
            console.log(result);
        },
    });
}

function login() {
    $.ajax({
        url: "api/login.php",
        type: "POST",
        data: {
            phone_number: $("#phone_number").val(),
            ucaller_id: $("#ucaller_id").val(),
            code: $("#code").val(),
        },
        cache: false,
        success: function (result) {
            if (result.is_success) {
                alert('Пользователь есть и подписка проплачена');
            } else {
                alert(result.error_message);
            }
        },
        error: function (result) {
            var a = 0;
        },
    });
}

function activate() {
    $.ajax({
        url: "api/activate_subscription.php",
        type: "POST",
        data: {
            phone_number: $("#phone_number_reg").val(),
        },
        cache: false,
        success: function (result) {
            if (result) {
                var a= 0;
            }
        },
        error: function (result) {
            var a = 0;
        },
    });
}

function logout() {
    $.ajax({
        url: "api/logout.php",
        type: "POST",
        data: {
        },
        cache: false,
        success: function (result) {
        },
        error: function (result) {
            var a = 0;
        },
    });
}
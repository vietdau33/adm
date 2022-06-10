window.toggleInputLabel = function (el) {
    if ($(el).val().trim() == '') {
        $(el).closest('.form-group').removeClass("input-valid");
    } else {
        $(el).closest('.form-group').addClass("input-valid");
    }
}

const numberOnly = function (el) {
    $(el).attr('type', 'number').on("beforeinput", function (e) {
        const text = e.originalEvent.data;
        if (text == null) {
            return;
        }
        return $.inArray(text.toLowerCase(), ['e', '+', '-']) == -1;
    });
}

window.addEventListener('DOMContentLoaded', (event) => {
    $('.number-only').each(function () {
        numberOnly(this);
    });
});

$.prototype.removeClassPattern = function (pattern) {
    if(pattern instanceof RegExp) {
        return this.removeClass (function (index, className) {
            return (className.match(pattern) || []).join(' ');
        });
    }
    return this;
}

$.prototype.removeClassStartWith = function (str_start) {
    const regex = new RegExp('(^|\\s)' + str_start + '\\S+', 'g');
    return this.removeClassPattern(regex);
}

if(typeof alertify != 'undefined') {
    alertify.alertSuccess = function(...params) {
        this.alert(...params);
        $('.alertify').removeClassStartWith('alertify--').addClass('alertify--success');
    }
    alertify.alertDanger = function(...params) {
        this.alert(...params);
        $('.alertify').removeClassStartWith('alertify--').addClass('alertify--danger');
    }
}


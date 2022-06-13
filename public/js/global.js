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

    if(typeof $.fn.datepicker != 'undefined') {
        $(".bs-datepicker").datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,
            clearBtn: true,
            disableTouchKeyboard: true,
        });
    }

    $('[type="reset"]').on('click', function() {
        setTimeout(() => {
            const $form = $(this).closest('form');
            $form.find('input').each(function() {
                this.value = null;
            });
            $form.trigger('submit');
        }, 100)
    })
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

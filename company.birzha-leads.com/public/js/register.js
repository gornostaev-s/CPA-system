document.addEventListener('DOMContentLoaded', function () {
    jQuery('.js-authForm').on('submit', (e) => {
        e.preventDefault();
        var form = jQuery('.js-authForm');

        jQuery.ajax({
            type: 'post',
            url: form.attr('action'),
            data : form.serialize(),
            success: function(data){
                // console.log(data)
                if(!data.success){
                    var text = '';
                    for (var prop in data.errors) {
                        text += '<p>'+data.errors[prop]+'</p>';
                    }
                    if (!text) {
                        jQuery('.response-errors').html("Возникла ошибка!")
                    } else {
                        jQuery('.response-errors').html(text)
                    }
                } else {
                    form[0].reset();
                    form.find('button[type=submit]').hide();
                    form.find('.response-success').html('<p>Вы успешно авторизованы</p>');
                    window.location.href = '/';
                }
            },
        })
    })
})
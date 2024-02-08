<?php
include __DIR__ . '/header.php';
?>

    <div class="login-section">
        <form class="login-form js-authForm" action="/v1/register">
            <div class="login-logo">
                <img class="login-logo__img" src="/assets/images/logo.png" alt="">
            </div>
            <div class="input-group">
                <input required class="input-group__text" type="text" name="name" placeholder="Введите ваше имя">
            </div>
            <div class="input-group">
                <input required class="input-group__text" type="text" name="email" placeholder="Введите email">
            </div>
            <div class="input-group">
                <input required class="input-group__text" type="password" name="password" placeholder="Введите пароль">
            </div>
            <div class="input-group">
                <input required class="input-group__text" type="password" name="passwordConfirm" placeholder="Повторите пароль">
            </div>
            <div class="input-group">
                <button type="submit" class="button-primary">Зарегистрироваться</button>
            </div>
            <div class="input-group">
                <div class="input-group__links">
                    <a class="link-secondary" href="/login">Вход</a>
                </div>
            </div>
            <div class="input-group">
                <div class="response-errors">

                </div>
            </div>
        </form>
    </div>
    <script   src="https://code.jquery.com/jquery-3.6.0.min.js"   integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="   crossorigin="anonymous"></script>
    <script>
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
    </script>

<?php
include __DIR__ . '/../footer.php';
?>
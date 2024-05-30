<script src="/assets/vendor/jquery/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="/js/moment.min.js"></script>
<script type="text/javascript" src="/js/daterangepicker.min.js"></script>
<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="/js/jquery.maskedinput.min.js" integrity="sha512-d4KkQohk+HswGs6A1d6Gak6Bb9rMWtxjOa0IiY49Q3TeFd5xAzjWXDCBW9RS7m86FQ4RzM2BdHmdJnnKRYknxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/js/register.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        jQuery('.js-phone').mask('+7 (999) 999-99-99')
        jQuery('.js-logout').on('click', function (e) {
            e.preventDefault();
            jQuery.ajax({
                type: 'post',
                url: '/v1/logout',
                success: function(){
                    window.location.href = '/login';
                },
            })
        })
    })
</script>

</body>
</html>
<script src="/assets/vendor/jquery/jquery-3.6.0.min.js"></script>
<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="/js/register.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
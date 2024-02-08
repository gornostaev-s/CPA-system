<?php
/** @var array $data */
include __DIR__ . '/header.php';
?>

    <div class="login-section">
        <div class="login-form">
            <div class="login-logo">
                <img class="login-logo__img" src="/assets/images/logo.png" alt="">
            </div>

            <h1 class="text-center">
                <?= $data['message']?>
            </h1>
        </div>
    </div>
    <script   src="https://code.jquery.com/jquery-3.6.0.min.js"   integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="   crossorigin="anonymous"></script>

<?php
include __DIR__ . '/../footer.php';
?>
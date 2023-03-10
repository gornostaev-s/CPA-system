<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/slick.css">
    <link rel="stylesheet" type="text/css" href="css/slick-theme.css">
    <link rel="stylesheet" href="css/style.css?t=<?= time()?>">
    <title>Лиды</title>
</head>
<body>
<section>
    <header>
        <div  class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="header-logo">
                        <a href="#" class="header-logo__link">
                            <img class="logo-img" src="img/birzha-leads.png" alt="">
                        </a>
                        <!-- кнопка бургер -->
                        <div class="burger-menu pc-none">
                            <a href="" class="burger-menu_button">
                                <spun class="burger-menu_lines"></spun>
                            </a>
                            <nav class="burger-menu_nav">
                                <a href="#section-1" class="burger-menu_link">Наши услуги</a>
                                <a href="#section-2" class="burger-menu_link">О лидах</a>
                                <a href="#section-3" class="burger-menu_link">Оставьте заявку</a>
                                <a href="#section-4" class="burger-menu_link">Отзывы</a>
                                <a href="#section-5" class="burger-menu_link">FAQ</a>
                            </nav>
                            <div class="burger-menu_overlay"></div>
                        </div>
                        <!-- кнопка бургер -->
                    </div>
                </div>
                <div class="col-md-3 mob-none">
                    <div class="header-address">
                            <span class="header-contacts__link">
                                г.Москва, ул.им. Калинина, 228
                            </span>
                        <a href="mailto:mail@example.com" class="header-contacts__link header-link">
                            mail@example.com
                        </a>
                    </div>
                </div>
                <div class="col-md-3 mob-none">
                    <div class="header-phone">
                        <a href="tel:+78002553535" class="header-contacts__link header-contacts__link__bold">+7 (900) 999-99-99</a><br>
                        <a href="tel:+78002553535" class="header-contacts__link header-link">+7 (900) 888-88-88</a>
                    </div>
                </div>
                <div class="col-md-3 text-right mob-none">
                    <a href="" class="button-primary">Личный кабинет</a>
                </div>
                <div class="col-md-12 header-underline mob-none"> <hr> </div>
                <div class="col-md-12 mob-none">
                    <div class="header-block-menu">
                        <ul class="header-menu">
                            <li class="header-menu__item"><a href="#" class="header-menu__link">Главная</a></li>
                            <li class="header-menu__item"><a href="#" class="header-menu__link">Купить лиды</a></li>
                            <li class="header-menu__item"><a href="#" class="header-menu__link">Продать лиды</a></li>
                            <li class="header-menu__item"><a href="#" class="header-menu__link">О нас</a></li>
                            <li class="header-menu__item"><a href="#" class="header-menu__link">Контакты</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
</section>

<section class="main-slide animate-hidden" id="section-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 ">
                <div class="main-slide__content">
                    <h1 class="main-slide__title">
                        Приводим клиентов
                    </h1>
                    <p class="main-slide__paragraph">
                        Купить лиды – это значит сэкономить бюджет и увеличить поток клиентов. Услуга заключается в поиске, сборе информации и привлечении.
                    </p>
                    <div class="button-wrapper">
                        <a href="" class="button-primary">Личный кабинет</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ourservices animate-hidden">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ourservices-title">
                    <h2 class="title-primary text-center">
                        Наши услуги
                    </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card-wrapper">
                    <a class="ourservices-card" href="#">
                        <div class="ourservices-card__img">
                            <img class="ourservices-card__pic" src="img/dbt.jpeg" alt="">
                            <div class="ourservices-card__overflow"></div>
                        </div>
                        <div class="ourservices-card__title">
                            Кредиты и займы
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-wrapper">
                    <a class="ourservices-card" href="#">
                        <div class="ourservices-card__img">
                            <img class="ourservices-card__pic" src="img/law.jpeg" alt="">
                            <div class="ourservices-card__overflow"></div>
                        </div>
                        <div class="ourservices-card__title">
                            Юриспрунденция общий поток и банкроство физ. лиц
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-wrapper">
                    <a class="ourservices-card" href="#">
                        <div class="ourservices-card__img">
                            <img class="ourservices-card__pic" src="img/rpr.jpeg" alt="">
                            <div class="ourservices-card__overflow"></div>
                        </div>
                        <div class="ourservices-card__title">
                            Ремонт квартир
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-wrapper">
                    <a class="ourservices-card" href="#">
                        <div class="ourservices-card__img">
                            <img class="ourservices-card__pic" src="img/elrpr.jpeg" alt="">
                            <div class="ourservices-card__overflow"></div>
                        </div>
                        <div class="ourservices-card__title">
                            Ремонт электроники
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-wrapper">
                    <a class="ourservices-card" href="#">
                        <div class="ourservices-card__img">
                            <img class="ourservices-card__pic" src="img/mdc.jpeg" alt="">
                            <div class="ourservices-card__overflow"></div>
                        </div>
                        <div class="ourservices-card__title">
                            Медицина
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-wrapper">
                    <a class="ourservices-card" href="#">
                        <div class="ourservices-card__img">
                            <img class="ourservices-card__pic" src="img/service.png" alt="">
                            <div class="ourservices-card__overflow"></div>
                        </div>
                        <div class="ourservices-card__title">
                            Услуга1
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="leads animate-hidden" id="section-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-6 mob-none992">
                <img src="img/leads.png" alt="">
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="main-slide__content">
                    <h2 class="title-primary">
                        Лиды
                    </h2>
                    <p class="leads__paragraph">
                        Купить лиды – это значит сэкономить бюджет и увеличить поток клиентов. Услуга заключается в поиске, сборе информации и привлечении.
                    </p>
                    <div class="button-wrapper">
                        <a href="" class="button-primary">Личный кабинет</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="ads-section animate-hidden">
    <div class="container">
        <div class="row">
            <div class="col-md-6 align-center">
                <div>
                    <h2 class="title-primary text-center">
                        Лиды
                    </h2>
                    <p class="leads__paragraph text-center">
                        Купить лиды – это значит сэкономить бюджет и увеличить поток клиентов. Услуга заключается в поиске, сборе информации и привлечении.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-wrapper">
                            <div class="card-primary flex_center">
                                <img src="./img/traf1.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-wrapper">
                            <div class="card-primary flex_center">
                                <img src="./img/traf1.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-wrapper">
                            <div class="card-primary flex_center">
                                <img src="./img/traf1.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-wrapper">
                            <div class="card-primary flex_center">
                                <img src="./img/traf1.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="form-section animate-hidden" id="section-3">
    <div class="container justify-content-center">
        <div class="col-md-8 text-center">
            <form action="#">
                <h2 class="title-primary text-white">
                    Оставьте заявку
                </h2>
                <p class="text-white form-section__text">
                    И мы обязательно с вами свяжемся!
                </p>
                <div class="row">
                    <div class="col-md-4 form-section__wrapper">
                        <input class="form-section__input" type="text" name="phone" placeholder="+7 (999) 999-99-99">
                    </div>
                    <div class="col-md-4 form-section__wrapper">
                        <input class="form-section__input" type="text" name="email" placeholder="mail@example.com">
                    </div>
                    <div class="col-md-4 form-section__wrapper">
                        <input type="submit" class="form-section__submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<section class="advantages-section animate-hidden">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="advantages-title">
                    <h3 class="title-primary">Наши преимущества</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="advantage-wrapper">
                    <div class="advantage">
                        <div class="advantage__overflow"></div>
                        <div class="advantage__content">
                            <div class="advantage-wrapperImg">
                                <img src="img/advantage.png" alt="">
                            </div>
                            <h4 class="advantage__title">Заголовок</h4>
                            <p class="advantage__text">Текст 1Текст 1Текст 1Текст 1Текст 1 Текст 1Текст 1Текст 1Текст 1Текст 1</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="advantage-wrapper">
                    <div class="advantage">
                        <div class="advantage__overflow"></div>
                        <div class="advantage__content">
                            <div class="advantage-wrapperImg">
                                <img src="img/advantage.png" alt="">
                            </div>
                            <h4 class="advantage__title">Заголовок</h4>
                            <p class="advantage__text">Текст 1Текст 1Текст 1Текст 1Текст 1 Текст 1Текст 1Текст 1Текст 1Текст 1</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="advantage-wrapper">
                    <div class="advantage">
                        <div class="advantage__overflow"></div>
                        <div class="advantage__content">
                            <div class="advantage-wrapperImg">
                                <img src="img/advantage.png" alt="">
                            </div>
                            <h4 class="advantage__title">Заголовок</h4>
                            <p class="advantage__text">Текст 1Текст 1Текст 1Текст 1Текст 1 Текст 1Текст 1Текст 1Текст 1Текст 1</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="comments-section animate-hidden" id="section-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="title-primary comments-title">Почему мы?</h4>
            </div>
        </div>

        <div class="slider-section">
            <div class="slider-card-wrapper">
                <div class="slider-card">
                    <div class="slider-card__content">
                        <div class="slider-card__avatar">
                            <img src="img/avatar.png" alt="">
                        </div>
                        <p class="slider-card__text">Since I started using WordPress, I always felt tired of reading through the documentation. No more now, thanks to AeroLand.</p>
                        <span class="slider-card__name" >Имя Фамилия</span>
                    </div>
                </div>
            </div>
            <div class="slider-card-wrapper">
                <div class="slider-card">
                    <div class="slider-card__content">
                        <div class="slider-card__avatar">
                            <img src="img/avatar.png" alt="">
                        </div>
                        <p class="slider-card__text">Since I started using WordPress, I always felt tired of reading through the documentation. No more now, thanks to AeroLand.</p>
                        <span class="slider-card__name" >Имя Фамилия</span>
                    </div>
                </div>
            </div>
            <div class="slider-card-wrapper">
                <div class="slider-card">
                    <div class="slider-card__content">
                        <div class="slider-card__avatar">
                            <img src="img/avatar.png" alt="">
                        </div>
                        <p class="slider-card__text">Since I started using WordPress, I always felt tired of reading through the documentation. No more now, thanks to AeroLand.</p>
                        <span class="slider-card__name" >Имя Фамилия</span>
                    </div>
                </div>
            </div>
            <div class="slider-card-wrapper">
                <div class="slider-card">
                    <div class="slider-card__content">
                        <div class="slider-card__avatar">
                            <img src="img/avatar.png" alt="">
                        </div>
                        <p class="slider-card__text">Since I started using WordPress, I always felt tired of reading through the documentation. No more now, thanks to AeroLand.</p>
                        <span class="slider-card__name" >Имя Фамилия</span>
                    </div>
                </div>
            </div>
            <div class="slider-card-wrapper">
                <div class="slider-card">
                    <div class="slider-card__content">
                        <div class="slider-card__avatar">
                            <img src="img/avatar.png" alt="">
                        </div>
                        <p class="slider-card__text">Since I started using WordPress, I always felt tired of reading through the documentation. No more now, thanks to AeroLand.</p>
                        <span class="slider-card__name" >Имя Фамилия</span>
                    </div>
                </div>
            </div>
            <div class="slider-card-wrapper">
                <div class="slider-card">
                    <div class="slider-card__content">
                        <div class="slider-card__avatar">
                            <img src="img/avatar.png" alt="">
                        </div>
                        <p class="slider-card__text">Since I started using WordPress, I always felt tired of reading through the documentation. No more now, thanks to AeroLand.</p>
                        <span class="slider-card__name" >Имя Фамилия</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="faq-section animate-hidden" id="section-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <h4 class="title-primary faq-title">
                    Часто задаваемые вопросы
                </h4>
                <div class="faq-main">
                    <div class="faq-card-wrapper">
                        <div class="faq-card js-faqCard">
                            <div class="faq-card__head js-faqCard">
                                <h5 class="faq-card__title">Что такое лиды?</h5>
                            </div>
                            <div class="faq-card__body"  style="display:none;">
                                <p class="faq-card__content">
                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni deserunt vel repellat dolore molestias. Quod nihil molestiae vero consequatur consectetur delectus, eum, tenetur cupiditate modi expedita voluptate eius dolorem illo.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="faq-card-wrapper">
                        <div class="faq-card js-faqCard">
                            <div class="faq-card__head">
                                <h5 class="faq-card__title">Как вы приведёте нам клиентов?</h5>
                            </div>
                            <div class="faq-card__body" style="display:none;">
                                <p class="faq-card__content">
                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni deserunt vel repellat dolore molestias. Quod nihil molestiae vero consequatur consectetur delectus, eum, tenetur cupiditate modi expedita voluptate eius dolorem illo.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6  mob-none992">
                <img src="img/faq.png" alt="" class="faq-img">
            </div>
        </div>
    </div>
</section>
<footer class="footer-section">
    <div class="container">
        <footer>
            <div class="row">
                <div class="col-md-4">
                    <a href="#">
                        <img src="img/birzha-leads.png" alt="" class="logo-img logo-footer">
                    </a><br>
                </div>
                <div class="col-6 col-sm-6 col-md-4">
                    <a href="#" class="footer-font">
                        Купить лиды
                    </a><br>
                    <a href="#" class="footer-font">
                        Продать лиды
                    </a><br>
                    <a href="#" class="footer-font">
                        О нас
                    </a><br>
                    <a href="#" class="footer-font">
                        Контакты
                    </a><br>
                </div>
                <div class="col-6 col-sm-6 col-md-4">
                    <a href="tel:+78002553535" class="header-contacts__link header-link">+7 (900) 888-88-88</a><br>
                    <span class="footer-comments">Время когда звонить</span><br>
                    <a href="mailto:mail@example.com" class="header-contacts__link header-link">
                        mail@example.com
                    </a><br>
                    <span class="footer-comments">
                        Для решения любых проблем
                    </span>
                </div>
                <div class="footer-undersection">
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="footer-copyright">
                                Copyright© 2023 Birzha-leads
                            </span>
                        </div>
                        <div class="col-md-6">
                            <span class="footer-line">
                                Копирование материалов сайта только с разрешения
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="js/slick.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="js/slick.min.js"></script>
<script type="text/javascript">
    $('.slider-section').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        dots: false,
        prevArrow: false,
        nextArrow: false,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            }
        ]
});
</script>
<script type="text/javascript">
    jQuery('.js-faqCard').on('click', function(){
        jQuery(this).toggleClass('active')
        jQuery(this).find('.faq-card__body').slideToggle()
    })
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var $win = $(window);
        var $marker = $('.animate-hidden');

        $marker.each(function (i, e) {
            if($win.scrollTop() + $win.height() >= jQuery(e).offset().top) {
                jQuery(e).addClass('fade-in')
            }
        })

//отслеживаем событие прокрутки страницы
        $win.scroll(function() {
            //Складываем значение прокрутки страницы и высоту окна, этим мы получаем положение страницы относительно нижней границы окна, потом проверяем, если это значение больше, чем отступ нужного элемента от верха страницы, то значит элемент уже появился внизу окна, соответственно виден

            $marker.each(function (i, e) {
                if($win.scrollTop() + $win.height() >= jQuery(e).offset().top) {
                    jQuery(e).addClass('fade-in')
                }
            })
        });
    })
</script>
<!-- бургер кнопка -->
<script>
        function burgerMenu(selector) {
    let menu = $(selector);
    let button = menu.find('.burger-menu_button', '.burger-menu_lines');
    let links = menu.find('.burger-menu_link');
    let overlay = menu.find('.burger-menu_overlay');
    
    button.on('click', (e) => {
        e.preventDefault();
        toggleMenu();
    });
    
    links.on('click', () => toggleMenu());
    overlay.on('click', () => toggleMenu());
    
    function toggleMenu(){
        menu.toggleClass('burger-menu_active');
        
        if (menu.hasClass('burger-menu_active')) {
        $('body').css('overlow', 'hidden');
        } else {
        $('body').css('overlow', 'visible');
        }
    }
    }

    burgerMenu('.burger-menu');
</script>
<!-- бургер кнопка -->
</body>
</html>
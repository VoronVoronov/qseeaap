<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Бесконтактное QR меню для заведений</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Put your description here.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/critical.css"><!-- критически -->
    <link rel="stylesheet" href="/css/grid.css">
    <link rel="stylesheet" href="/css/styles.css">
    <style> /* <!-- критически --> */
        body {font-family: 'Inter', sans-serif;}.header .lang__active {font-weight: 600;} h1 {font-weight: 700;}.banner__description {font-weight: 400;}.primary-btn, .secondary-btn {font-weight: 600;}
        @media (max-width: 576px) {
            #wrapper::after {content: "";position: absolute;top: 0;left: 0;width: 100%;height: 100%;background-image: url(..//img/lines-mob-bg.webp);background-repeat: no-repeat;mix-blend-mode: soft-light;pointer-events: none;z-index: -2;opacity: 0.5;}
        }
    </style>
    <!-- Preload Swiper CSS -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" as="style" onload="this.rel='stylesheet'">
    <!-- Preload images -->
    <link fetchpriority="high" rel="preload" href="logo.svg" as="image">
    <link fetchpriority="high" rel="preload" href="/img/banner-mobile-img.webp" as="image">
    <link fetchpriority="high" rel="preload" href="/img/banner-desktop-img.webp" as="image">
</head>
<body>

<div id="wrapper">
    <!-- хедер  -->
    <header class="header">
        <div class="header__container container-fluid">
            <div class="header__wrap">
                <div class="header__logo">
                    <img width="44" src="logo.svg" alt="Лого">
                </div>
                <nav class="nav">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="#banner" class="nav__link nav__link-scroll">Главная</a>
                        </li>
                        <li class="nav__item">
                            <a href="#clients" class="nav__link nav__link-scroll">О нас</a>
                        </li>
                        <li class="nav__item">
                            <a href="#advantages" class="nav__link nav__link-scroll">Преимущества</a>
                        </li>
                        <li class="nav__item">
                            <a href="#tariffs" class="nav__link nav__link-scroll">Тарифы</a>
                        </li>
                        <li class="nav__item d-mx-lg">
                            <a href="#">Темная тема</a>/<a href="#">Светлая тема</a>
                        </li>
                    </ul>
                </nav>
                <div class="theme d-mn-lg">
                    <span class="theme__text">Тема</span>
                    <div class="theme__list">
                        <div class="theme__item theme__item_dark theme__item_active"></div>
                        <div class="theme__item theme__item_light"></div>
                    </div>
                </div>
                <div class="lang">
                    <span class="lang__active">RUS</span>
                    <div class="lang__list">
                        <a class="lang__link" href="#">KZ</a>
                        <a class="lang__link" href="#">ENG</a>
                    </div>
                </div>
                <div class="burger d-mx-lg">
                    <span></span>
                </div>
            </div>
        </div>
    </header>
    <!-- баннер  -->
    <section class="banner" id="banner">
        <div class="banner__container container-fluid">
            <div class="banner__content">
                <h1 class="banner__title">Бесконтактное QR меню для заведений</h1>
                <p class="banner__description">QR-меню - это уникальный проект,
                    направленный на цифровизацию
                    услуг кафе и ресторанов.</p>
            </div>
            <div class="banner__img">
                <img class="banner__img-mobile" width="390" height="304" src="/img/banner-mobile-img.webp" alt="смартфон и ноутбук">
                <img class="banner__img-desktop d-mn-lg" src="/img/banner-desktop-img.webp" alt="смартфон и ноутбук" loading="lazy">
            </div>
            <div class="banner__buttons">
                <a href="#" class="banner__button primary-btn">Попробовать</a>
                <a href="#" class="banner__button secondary-btn">Демо</a>
            </div>
        </div>
    </section>
    <!-- Наши клиенты  -->
    <section class="clients" id="clients">
        <div class="clients__container container">
            <h2 class="clients__title title" data-inviewport="obs__slide-up">Наши клиенты</h2>
            <div class="clients__list">
                <div class="clients__item" data-inviewport="obs__scale">
                    <img loading="lazy" src="/img/pizza-hut.svg" alt="pizza-hut">
                </div>
                <div class="clients__item" data-inviewport="obs__scale">
                    <img loading="lazy" src="/img/lanzhou.svg" alt="lanzhou">
                </div>
                <div class="clients__item" data-inviewport="obs__scale">
                    <img loading="lazy" src="/img/dodo.svg" alt="dodo">
                </div>
                <div class="clients__item" data-inviewport="obs__scale">
                    <img loading="lazy" src="/img/hardees.svg" alt="hardees">
                </div>
                <div class="clients__item" data-inviewport="obs__scale">
                    <img loading="lazy" src="/img/bk.svg" alt="burger king">
                </div>
                <div class="clients__item" data-inviewport="obs__scale">
                    <p class="clients__item-info"><span>1300+</span><br> довольных<br> клиентов</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Тарифы  -->
    <section class="tariffs" id="tariffs">
        <div class="tariffs__container container">
            <h2 class="tariffs__title title" data-inviewport="obs__slide-up">Тарифы</h2>
            <div class="tariffs__list">
                <div class="tariffs__item" data-inviewport="obs__slide-down">
                    <div class="tariffs__item-wrap">
                        <h3 class="tariffs__item-title">Стандарт <strong>Бесплатно</strong></h3>
                        <ul class="tariffs__item-list">
                            <li class="tariffs__item-plan tariffs__item-plan_included">1 месяц бесплатно</li>
                            <li class="tariffs__item-plan tariffs__item-plan_excluded">Онлайн редактор меню</li>
                            <li class="tariffs__item-plan tariffs__item-plan_excluded">Вызов персонала</li>
                            <li class="tariffs__item-plan tariffs__item-plan_excluded">Количество столов - без ограничений</li>
                            <li class="tariffs__item-plan tariffs__item-plan_excluded">50 тейбл тентов с QR кодом (платно)</li>
                            <li class="tariffs__item-plan tariffs__item-plan_excluded">100 магнитик для холо-дильника с QR кодом</li>
                            <li class="tariffs__item-plan tariffs__item-plan_excluded">Без рекламы</li>
                            <li class="tariffs__item-plan tariffs__item-plan_excluded">Поддержка 24/7</li>
                        </ul>
                    </div>
                    <a href="#" class="tariffs__item-button primary-btn">Попробовать</a>
                </div>
                <div class="tariffs__item" data-inviewport="obs__slide-down">
                    <div class="tariffs__item-wrap">
                        <h3 class="tariffs__item-title">Месяц <strong>10 000₸</strong></h3>
                        <ul class="tariffs__item-list">
                            <li class="tariffs__item-plan tariffs__item-plan_included">1 месяц бесплатно</li>
                            <li class="tariffs__item-plan tariffs__item-plan_included">Онлайн редактор меню</li>
                            <li class="tariffs__item-plan tariffs__item-plan_included">Вызов персонала</li>
                            <li class="tariffs__item-plan tariffs__item-plan_excluded">Количество столов - без ограничений</li>
                            <li class="tariffs__item-plan tariffs__item-plan_excluded">50 тейбл тентов с QR кодом (платно)</li>
                            <li class="tariffs__item-plan tariffs__item-plan_excluded">100 магнитик для холо-дильника с QR кодом</li>
                            <li class="tariffs__item-plan tariffs__item-plan_included">Без рекламы</li>
                            <li class="tariffs__item-plan tariffs__item-plan_included">Поддержка 24/7</li>
                        </ul>
                    </div>
                    <a href="#" class="tariffs__item-button primary-btn">Попробовать</a>
                </div>
                <div class="tariffs__item" data-inviewport="obs__slide-down">
                    <div class="tariffs__item-wrap">
                        <h3 class="tariffs__item-title">Годовой <strong>90 000₸</strong></h3>
                        <ul class="tariffs__item-list">
                            <li class="tariffs__item-plan tariffs__item-plan_included">1 месяц бесплатно</li>
                            <li class="tariffs__item-plan tariffs__item-plan_included">Онлайн редактор меню</li>
                            <li class="tariffs__item-plan tariffs__item-plan_included">Вызов персонала</li>
                            <li class="tariffs__item-plan tariffs__item-plan_included">Количество столов - без ограничений</li>
                            <li class="tariffs__item-plan tariffs__item-plan_included">50 тейбл тентов с QR кодом (платно)</li>
                            <li class="tariffs__item-plan tariffs__item-plan_included">100 магнитик для холо-дильника с QR кодом</li>
                            <li class="tariffs__item-plan tariffs__item-plan_included">Без рекламы</li>
                            <li class="tariffs__item-plan tariffs__item-plan_included">Поддержка 24/7</li>
                        </ul>
                    </div>
                    <a href="#" class="tariffs__item-button primary-btn">Попробовать</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Преимущества  -->
    <section class="advantages" id="advantages">
        <div class="advantages__container container">
            <h2 class="advantages__title title" data-inviewport="obs__slide-up">Преимущества</h2>
            <div class="advantages__list">
                <div class="advantages__item" data-inviewport="obs__slide-down">
                    <div class="advantages__item-icon">
                        <img loading="lazy" src="/img/adaptive-icon.svg" alt="Адаптивность">
                    </div>
                    <div class="advantages__item-info">
                        Адаптивность под
                        любые устройства
                    </div>
                </div>
                <div class="advantages__item" data-inviewport="obs__slide-down">
                    <div class="advantages__item-icon">
                        <img loading="lazy" src="/img/mob-app-icon.svg" alt="Мобильное приложение">
                    </div>
                    <div class="advantages__item-info">
                        Мобильное приложение
                    </div>
                </div>
                <div class="advantages__item" data-inviewport="obs__slide-down">
                    <div class="advantages__item-icon">
                        <img loading="lazy" src="/img/booking-icon.svg" alt="Бронирование столиков">
                    </div>
                    <div class="advantages__item-info">
                        Бронирование столиков
                    </div>
                </div>
                <div class="advantages__item" data-inviewport="obs__slide-down">
                    <div class="advantages__item-icon">
                        <img loading="lazy" src="/img/online-payment-icon.svg" alt="Онлайн прием оплаты">
                    </div>
                    <div class="advantages__item-info">
                        Онлайн прием оплаты
                    </div>
                </div>
                <div class="advantages__item" data-inviewport="obs__slide-down">
                    <div class="advantages__item-icon">
                        <img loading="lazy" src="/img/telegram-icon.svg" alt="Telegram бот">
                    </div>
                    <div class="advantages__item-info">
                        Telegram бот
                    </div>
                </div>
                <div class="advantages__item" data-inviewport="obs__slide-down">
                    <div class="advantages__item-icon">
                        <img loading="lazy" src="/img/multilang-icon.svg" alt="Мультиязычность">
                    </div>
                    <div class="advantages__item-info">
                        Мульти<wbr>язычность
                    </div>
                </div>
                <div class="advantages__item" data-inviewport="obs__slide-down">
                    <div class="advantages__item-icon">
                        <img loading="lazy" src="/img/analitics-icon.svg" alt="Аналитика">
                    </div>
                    <div class="advantages__item-info">
                        Аналитика
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- слайдер  -->
    <div class="slider slider__stores" data-inviewport="obs__slide-up">
        <div class="slider__container container">
            <div class="sliderStores slider__swiper swiper">
                <div class="slider__wrapper swiper-wrapper">
                    <div class="slider__slide swiper-slide">
                        <img loading="lazy" src="/img/slide-1.webp" alt="slider">
                    </div>
                    <div class="slider__slide swiper-slide">
                        <img loading="lazy" src="/img/slide-2.webp" alt="slider">
                    </div>
                    <div class="slider__slide swiper-slide">
                        <img loading="lazy" src="/img/slide-2.webp" alt="slider">
                    </div>
                    <!-- дубликаты  -->
                    <div class="slider__slide swiper-slide">
                        <img loading="lazy" src="/img/slide-1.webp" alt="slider">
                    </div>
                    <div class="slider__slide swiper-slide">
                        <img loading="lazy" src="/img/slide-2.webp" alt="slider">
                    </div>
                    <div class="slider__slide swiper-slide">
                        <img loading="lazy" src="/img/slide-2.webp" alt="slider">
                    </div>
                </div>
                <div class="slider__arrows">
                    <div class="slider__arrow slider__arrow_prev"></div>
                    <div class="slider__arrow slider__arrow_next"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Часто задаваемые вопросы  -->
    <section class="faqs">
        <div class="faqs__container container">
            <h2 class="faqs__title title" data-inviewport="obs__slide-up">Часто задаваемые вопросы</h2>
            <div class="faqs__list">
                <div class="faqs__item active" data-inviewport="obs__slide-up">
                    <div class="faqs__item-title">
                        Вопрос 1
                    </div>
                    <div class="faqs__item-content">
                        Ответ 1
                    </div>
                </div>
                <div class="faqs__item" data-inviewport="obs__slide-up">
                    <div class="faqs__item-title">
                        Вопрос 2
                    </div>
                    <div class="faqs__item-content">
                        Ответ 2
                    </div>
                </div>
                <div class="faqs__item" data-inviewport="obs__slide-up">
                    <div class="faqs__item-title">
                        Вопрос 3
                    </div>
                    <div class="faqs__item-content">
                        Ответ 3
                    </div>
                </div>
                <div class="faqs__item" data-inviewport="obs__slide-up">
                    <div class="faqs__item-title">
                        Вопрос 4
                    </div>
                    <div class="faqs__item-content">
                        Ответ 4
                    </div>
                </div>
                <div class="faqs__item" data-inviewport="obs__slide-up">
                    <div class="faqs__item-title">
                        Вопрос 5
                    </div>
                    <div class="faqs__item-content">
                        Ответ 5
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Наши контакты  -->
    <section class="contacts">
        <div class="contacts__container container">
            <h2 class="contacts__title title">Наши контакты</h2>
            <div class="contacts__info">
                <div class="contacts__info-item">
                    <div class="contacts__info-text">
                        ИП «Жолдас»<br>
                        ИИН: 001101550576
                    </div>
                    <div class="contacts__info-text">
                        <a href="+77066011100">+7 (706) 601-11-00</a>
                        <a href="mailto:ip@zholdas.icu">ip@zholdas.icu</a>
                    </div>
                </div>
                <div class="contacts__info-item">
                    <div class="contacts__info-text">
                        Служба поддержки
                        <a href="mailto:support@qsee.kz"><strong>support@qsee.kz</strong></a>
                    </div>
                    <div class="contacts__info-text">
                        Отдел продаж
                        <a href="mailto:sales@qsee.kz"><strong>sales@qsee.kz</strong></a>
                    </div>
                </div>
                <div class="contacts__info-item">
                    <div class="contacts__info-text">
                        Отдел контроля качества
                        <a href="mailto:abuse@qsee.kz"><strong>abuse@qsee.kz</strong></a>
                    </div>
                    <div class="contacts__info-text">
                        <a href="#"><strong>Поддержка пользователей</strong></a>
                    </div>
                </div>
                <div class="contacts__info-cards">
                    <img loading="lazy" src="/img/mastercard-logo.svg" alt="mastercard">
                    <img loading="lazy" src="/img/visa-logo.svg" alt="visa">
                </div>
            </div>
        </div>
    </section>
    <!-- футер  -->
    <footer class="footer">
        <div class="footer__container container">
            <div class="footer__wrap">
                <div class="footer__copyright footer__col">
                    ИП «Жолдас»
                </div>
                <div class="footer__socials footer__col">
                    <a href="#" class="footer__social">
                        <img loading="lazy" src="/img/instagram.svg" alt="instagram">
                    </a>
                    <a href="https://t.me/qseekz" class="footer__social">
                        <img loading="lazy" src="/img/telegram.svg" alt="telegram">
                    </a>
                    <a href="mailto:support@qsee.kz" class="footer__social">
                        <img loading="lazy" src="/img/mail.svg" alt="mail">
                    </a>
                </div>
                <div class="footer__logo footer__col d-mn-md">
                    <img loading="lazy" src="logo-white.svg" alt="logo">
                </div>
            </div>
        </div>
    </footer>

    <!-- line bg  -->
    <div class="lineBg">
        <img loading="lazy" src="/img/lines-mob-bg.webp" alt="lines-bg">
    </div>
</div>

<script src="/js/script.js"></script>
</body>
</html>


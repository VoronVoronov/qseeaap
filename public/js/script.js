document.addEventListener('DOMContentLoaded', function(){
        /*Easy selector helper function */
        const select = (el, all = false) => {
                el = el.trim()
                if (all) {
                return [...document.querySelectorAll(el)]
                } else {
                return document.querySelector(el)
                }
        }
        /* Easy event listener function */
        const on = (type, el, listener, all = false) => {
                let selectEl = select(el, all)
                if (selectEl) {
                if (all) {
                selectEl.forEach(e => e.addEventListener(type, listener))
                } else {
                selectEl.addEventListener(type, listener)
                }
                }
        }
        /* Easy on scroll event listener  */
        const onscroll = (el, listener) => {
        el.addEventListener('scroll', listener)
        }
        
        // хедер при при скролле 
        let selectHeader = select('.header')
        if (selectHeader) {
        const headerScrolled = () => {
        if (window.scrollY > 60) {
                selectHeader.classList.add('scrolling')
        } else {
                selectHeader.classList.remove('scrolling')
        }
        }
        window.addEventListener('load', headerScrolled)
        onscroll(window, headerScrolled)
        }
        // якоря 
        on('click', '.nav__link-scroll', function(e) {
                if (select(this.hash)) {
                        e.preventDefault();
                        const href = e.target.getAttribute("href");
                        const offsetTop = select(href).offsetTop - 70;
                
                        scroll({
                                top: offsetTop,
                                behavior: "smooth"
                        });
                }
        }, true)
        // бургер
        on('click', '.burger', function(e){
                select('.burger').classList.toggle('clicked');
                select('nav').classList.toggle('show');
        })
        on('click', '.nav__overlay, .nav__link',  function(e){
                e.preventDefault();
                select('.burger').classList.remove('clicked');
                select('nav').classList.remove('show');
        }, true)

                // Function to load the Swiper script
        // Function to load the Swiper script
        function loadSwiperScript() {
        return new Promise((resolve) => {
            const existingScript = document.querySelector('script[src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"]');
            if (existingScript) {
                resolve(); // If already loaded, resolve immediately
                return;
            }
    
            const swiperScript = document.createElement('script');
            swiperScript.src = 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js';
            swiperScript.async = true;
    
            swiperScript.onload = () => {
                resolve(); // Resolve the promise when the script is loaded
            };
    
            document.body.appendChild(swiperScript);
        });
        }
    
        // Observer callback
        const swiperObserverCallback = (entries) => {
                entries.forEach(entry => {
                if (entry.isIntersecting) {
                        loadSwiperScript().then(() => {
                        // Initialize Swiper after the script has loaded
                        new Swiper(".sliderStores", {
                                slidesPerView: 'auto',
                                loop: true,
                                centeredSlides: true,
                                spaceBetween: 30,
                                navigation: {
                                nextEl: ".slider__arrow_next",
                                prevEl: ".slider__arrow_prev",
                                },
                                breakpoints: {
                                300: {
                                        spaceBetween: 0,
                                },
                                768: {
                                        spaceBetween: 30,
                                },
                                1024: {
                                        spaceBetween: 30,
                                },
                                },
                        });
                        });
                        swiperObserver.disconnect(); // Stop observing after loading
                }
                });
        };
    
        // Create the observer
        const swiperObserver = new IntersectionObserver(swiperObserverCallback);
        
        // Target the Swiper container
        const swiperContainer = document.querySelector('.sliderStores'); // Adjust this selector as needed
        if (swiperContainer) {
                swiperObserver.observe(swiperContainer);
        }
        
        // faq accordion
        on('click', '.faqs__item-title', function(e) {
                e.target.closest('.faqs__item').classList.toggle('active');
        }, true)
        // observer, анимация на скролле 
        const inViewport = (element, observer) => {
        element.forEach(entry => {
                entry.target.classList.toggle("is-inViewport", entry.isIntersecting);
                element.forEach(item => {
                if(item.target.classList.contains('is-inViewport') && !item.target.classList.contains('watched')){
                item.target.classList.add("watched");
                }
                })
        });
        };
        let ioConfiguration = {
        rootMargin: '0% 0% 0% 0%',
        threshold: 0.2
        };
        const Obs = new IntersectionObserver(inViewport, ioConfiguration);
        const obsOptions = {}; //See: https://developer.mozilla.org/en-US/docs/Web/API/Intersection_Observer_API#Intersection_observer_options
        const ELs_inViewport = document.querySelectorAll('[data-inviewport]');
        ELs_inViewport.forEach(EL => {
        Obs.observe(EL, obsOptions);
        });

})

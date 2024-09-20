const navTrigger = document.getElementById("nav_toggle");
const navMenu = document.getElementById("nav_menu");
const navIcon = document.getElementById("nav_icon");

navTrigger.addEventListener("click", () => {
    navMenu.classList.toggle("nav-is-open");
    // Mengubah ikon berdasarkan status nav-is-open
    if (navMenu.classList.contains("nav-is-open")) {
        navIcon.classList.remove("ri-menu-3-line");
        navIcon.classList.add("ri-close-fill");
    } else {
        navIcon.classList.remove("ri-close-fill");
        navIcon.classList.add("ri-menu-3-line");
    }
});

// swiper slider
let swiper = new Swiper('.swiper', {
    effect: 'coverflow',
    grabCursor: true,
    centerSlider: true,
    coverflowEffect: {
        rotate: 0,
        stretch: 0,
        depth: 100,
        modifier: 3,
        slideShadows: true
    },
    loop: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true
    },
    breakpoints: {
        640: {
        slidesPerView: 2
        },
        768: {
        slidesPerView: 1
        },
        1024: {
        slidesPerView: 2
        },
        1560: {
        slidesPerView: 3
        }
    }
});
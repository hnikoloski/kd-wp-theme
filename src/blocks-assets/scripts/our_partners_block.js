import Swiper from 'swiper';
import { Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
// import Swiper and modules styles

jQuery(document).ready(function ($) {
    // init Swiper:
    const swiper = new Swiper('.kd-partnes-block-slider', {
        modules: [Autoplay],
        slidesPerView: 2,
        loop: true,
        // Autoplay settings
        autoplay: {
            delay: 2000, // 200 delay for continuous play 0 buggs out sometimes
            disableOnInteraction: false, // Keep autoplaying when the slider is interacted with
        },
        speed: 5000,
        spaceBetween: 50,
        freeMode: true,
        freeModeMomentum: false,
        freeModeMomentumRatio: 0.5,
        freeModeMomentumVelocityRatio: 0.5,
        // Disable interactivity
        allowTouchMove: false,
        breakpoints: {
            768: {
                slidesPerView: 5.5,
                spaceBetween: 20 // Adjust space between slides if necessary
            }
        }
    });
});
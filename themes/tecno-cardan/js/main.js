import '../scss/main.scss';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'swiper/css';
import 'swiper/css/a11y';
import 'swiper/css/pagination';

import { ExperienceCarousel } from './components/experience-carousel.js';

document.addEventListener( 'DOMContentLoaded', () => {
	document
		.querySelectorAll( '[data-js-experience-carousel]' )
		.forEach( ( root ) => new ExperienceCarousel( root ).init() );
} );

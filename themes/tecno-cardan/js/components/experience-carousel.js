import Swiper from 'swiper';
import { A11y, Pagination } from 'swiper/modules';

export class ExperienceCarousel {
	constructor( root ) {
		this.root = root;
		this.swiper = null;
	}

	init() {
		const swiperElement = this.root.querySelector(
			'[data-carousel-swiper]'
		);

		if ( ! swiperElement ) {
			return;
		}

		const paginationElement = this.root.querySelector(
			'[data-carousel-pagination]'
		);

		this.swiper = new Swiper( swiperElement, {
			modules: [ A11y, Pagination ],
			allowTouchMove: true,
			pagination: paginationElement
				? {
						el: paginationElement,
						clickable: true,
				  }
				: false,
			on: {
				slideChange: () => this.updateControls(),
				resize: () => this.updateControls(),
			},
		} );
		this.updateControls();

		this.root.addEventListener( 'click', ( event ) => {
			const previousButton = event.target.closest(
				'[data-carousel-prev]'
			);
			const nextButton = event.target.closest( '[data-carousel-next]' );

			if ( previousButton && this.root.contains( previousButton ) ) {
				this.swiper.slidePrev();
			}

			if ( nextButton && this.root.contains( nextButton ) ) {
				this.swiper.slideNext();
			}
		} );
	}

	updateControls() {
		const activeSlide = this.swiper.slides[ this.swiper.activeIndex ];
		const stage = this.root.querySelector( '[data-carousel-stage]' );
		const controls = this.root.querySelector( '[data-carousel-controls]' );
		const mediaFrame = activeSlide?.querySelector(
			'.experience-carousel__media-frame'
		);

		if ( stage && controls && mediaFrame ) {
			const stageRect = stage.getBoundingClientRect();
			const swiperRect = this.swiper.el.getBoundingClientRect();
			const mediaRect = mediaFrame.getBoundingClientRect();
			const mediaLeft = swiperRect.left - stageRect.left;

			controls.style.setProperty(
				'--carousel-media-left',
				`${ mediaLeft }px`
			);
			controls.style.setProperty(
				'--carousel-media-right',
				`${ mediaLeft + mediaRect.width }px`
			);
			controls.style.setProperty(
				'--carousel-media-center',
				`${ mediaRect.top - stageRect.top + mediaRect.height / 2 }px`
			);
		}

		this.root
			.querySelectorAll( '[data-carousel-prev]' )
			.forEach( ( button ) => {
				button.disabled = this.swiper.isBeginning;
			} );

		this.root
			.querySelectorAll( '[data-carousel-next]' )
			.forEach( ( button ) => {
				button.disabled = this.swiper.isEnd;
			} );
	}
}

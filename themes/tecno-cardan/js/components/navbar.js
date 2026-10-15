export class Navbar {
	constructor( root ) {
		this.root = root;
		this.toggle = root.querySelector( '[data-js-navbar-toggle]' );
		this.panel = root.querySelector( '[data-js-navbar-panel]' );
		this.menu = root.querySelector( '#tc-navbar-menu' );
	}

	init() {
		if ( ! this.toggle || ! this.panel || ! this.menu ) {
			return;
		}

		this.syncForViewport();
		this.toggle.addEventListener( 'click', () => this.toggleMenu() );
		this.menu.querySelectorAll( 'a' ).forEach( ( link ) => {
			link.addEventListener( 'click', () => this.closeMenu() );
		} );
		document.addEventListener( 'keydown', ( event ) => {
			if ( event.key === 'Escape' ) {
				this.closeMenu();
			}
		} );
		window.addEventListener( 'resize', () => this.syncForViewport() );
	}

	syncForViewport() {
		if ( window.matchMedia( '(min-width: 801px)' ).matches ) {
			this.root.classList.remove( 'is-open' );
			this.toggle.setAttribute( 'aria-expanded', 'false' );
			this.menu.setAttribute( 'aria-hidden', 'false' );
			return;
		}

		this.menu.setAttribute( 'aria-hidden', this.root.classList.contains( 'is-open' ) ? 'false' : 'true' );
	}

	toggleMenu() {
		const isOpen = this.root.classList.contains( 'is-open' );

		if ( isOpen ) {
			this.closeMenu();
			return;
		}

		this.root.classList.add( 'is-open' );
		this.toggle.setAttribute( 'aria-expanded', 'true' );
		this.toggle.setAttribute( 'aria-label', 'Cerrar menú' );
		this.menu.setAttribute( 'aria-hidden', 'false' );
	}

	closeMenu() {
		this.root.classList.remove( 'is-open' );
		this.toggle.setAttribute( 'aria-expanded', 'false' );
		this.toggle.setAttribute( 'aria-label', 'Abrir menú' );
		this.menu.setAttribute( 'aria-hidden', 'true' );
	}
}

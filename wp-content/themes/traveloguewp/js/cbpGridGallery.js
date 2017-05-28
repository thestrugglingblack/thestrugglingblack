/**
 * cbpGridGallery.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */
;( function( window ) {
	
	'use strict';

	var docElem = window.document.documentElement,
		transEndEventNames = {
			'WebkitTransition': 'webkitTransitionEnd',
			'MozTransition': 'transitionend',
			'OTransition': 'oTransitionEnd',
			'msTransition': 'MSTransitionEnd',
			'transition': 'transitionend'
		},
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		support = {
			transitions : Modernizr.csstransitions,
			support3d : Modernizr.csstransforms3d
		};

	function setTransform( el, transformStr ) {
		el.style.WebkitTransform = transformStr;
		el.style.msTransform = transformStr;
		el.style.transform = transformStr;
	}

	// from http://responsejs.com/labs/dimensions/
	function getViewportW() {
		var client = docElem['clientWidth'],
			inner = window['innerWidth'];
		
		if( client < inner )
			return inner;
		else
			return client;
	}

	function extend( a, b ) {
		for( var key in b ) { 
			if( b.hasOwnProperty( key ) ) {
				a[key] = b[key];
			}
		}
		return a;
	}

	function CBPGridGallery( el, options ) {
		this.el = el;
		this.options = extend( {}, this.options );
  		extend( this.options, options );
  		//console.log(this.options.isotope);
  		this._init();
	}

	CBPGridGallery.prototype.options = {

	};

	CBPGridGallery.prototype._init = function() {

		//page body
		this.page_body = document.getElementsByTagName('body')[0];
		//page container
		this.page_container = document.getElementById('container');
		// main grid
		this.grid = this.el.querySelector( 'section.grid-wrap > div.grid' );
		// main grid items
		this.gridItems = [].slice.call( this.grid.querySelectorAll( 'figure' ) );
		// items total
		this.itemsCount = this.gridItems.length;
		// slideshow grid
		this.slideshow = this.el.querySelector( 'section.slideshow > ul' );
		this.nextItems = [].slice.call( this.el.querySelectorAll( '.nex-container > ul > li' ) );
		this.prevItems = [].slice.call( this.el.querySelectorAll( '.prev-container > ul > li' ) );
		// slideshow grid items
		this.slideshowItems = [].slice.call( this.slideshow.children );
		// index of current slideshow item
		this.current = -1;
		// slideshow control buttons
		this.ctrlPrev = this.el.querySelector( 'section.slideshow > nav span.nav-prev' );
		this.ctrlNext = this.el.querySelector( 'section.slideshow > nav span.nav-next' );
		this.ctrlClose = this.el.querySelector( 'section.slideshow > nav > span.nav-close' );

		this.currentFilter = '*';
		if ( this.options.isotope ) { 
			this.isotopeContainer = document.getElementById('isotope-container');
			imagesLoaded( this.isotopeContainer, this._initIsotope() );
			//this._initIsotope(); 
		}

		this._initEvents();
	};

	CBPGridGallery.prototype._initIsotope = function() {
		var self = this;
	  	var width = jQuery('#isotope-container').width();
		jQuery('#isotope-container').css('width',width+'px');
		this.iso = new Isotope( this.isotopeContainer, {
		  // options
		  itemSelector: '.single-item-effect',
		  layoutMode: 'fitRows'
		});
		jQuery('#isotope-container').css('width','auto');
	}


	CBPGridGallery.prototype._initEvents = function() {
		var self = this;

		if ( this.options.isotope ) {
			this.isotopeFilterContainer = document.getElementById('filter-main-nav');
			this.isotopeFilterTrigger = [].slice.call( this.isotopeFilterContainer.querySelectorAll( 'ul li a' ) );
			this.isotopeFilterTrigger.forEach( function( item, idx ) {
				item.addEventListener( 'click', function( ev ) {
					ev.preventDefault();
					self._filterItems( item.getAttribute("data-filter") );
				} );
			} );
		};


		// open the slideshow when clicking on the main grid items
		this.gridItems.forEach( function( item, idx ) {
			item.setAttribute("data-idx",idx)
			item.addEventListener( 'click', function() {self._openSlideshow( this.getAttribute("data-idx") );} );

		} );

		// slideshow controls
		this.ctrlPrev.addEventListener( 'click', function() { self._navigate( 'prev' ); } );
		this.ctrlNext.addEventListener( 'click', function() { self._navigate( 'next' ); } );
		this.ctrlClose.addEventListener( 'click', function() { self._closeSlideshow(); } );

		// window resize
		window.addEventListener( 'resize', function() { self._resizeHandler(); } );

		// keyboard navigation events
		document.addEventListener( 'keydown', function( ev ) {
			if ( self.isSlideshowVisible ) {
				var keyCode = ev.keyCode || ev.which;

				switch (keyCode) {
					case 37:
						self._navigate( 'prev' );
						break;
					case 39:
						self._navigate( 'next' );
						break;
					case 27:
						self._closeSlideshow();
						break;
				}
			}
		} );

		// trick to prevent scrolling when slideshow is visible
		window.addEventListener( 'scroll', function() {
			if ( self.isSlideshowVisible ) {
				window.scrollTo( self.scrollPosition ? self.scrollPosition.x : 0, self.scrollPosition ? self.scrollPosition.y : 0 );
			}
			else {
				self.scrollPosition = { x : window.pageXOffset || docElem.scrollLeft, y : window.pageYOffset || docElem.scrollTop };
			}
		});
	};

	CBPGridGallery.prototype._filterItems = function( filter ) {
		var self = this;
		this.iso.arrange({ filter: filter });
		this.currentFilter = filter;
			
		if ( this.currentFilter == '*' ) {
			var selector = 'section.slideshow > ul > li';
			var gridItemsSelector = 'figure';
			var nextItemsSelector = '.nex-container > ul > li';
			var prevItemsSelector = '.prev-container > ul > li';
		}else{
			var selector = 'section.slideshow > ul > li'+this.currentFilter;
			var gridItemsSelector = 'figure'+this.currentFilter;
			var nextItemsSelector = '.nex-container > ul > li'+this.currentFilter;
			var prevItemsSelector = '.prev-container > ul > li'+this.currentFilter;
		}
		
		this.slideshowItems = [].slice.call( this.el.querySelectorAll(selector) );
		this.gridItems = [].slice.call( this.grid.querySelectorAll( gridItemsSelector ) );

		this.gridItems.forEach( function( item, idx ) {
			item.setAttribute("data-idx",idx);
		} );

		this.nextItems = [].slice.call( this.el.querySelectorAll( nextItemsSelector ) );
		this.prevItems = [].slice.call( this.el.querySelectorAll( prevItemsSelector ) );

		this.itemsCount = this.gridItems.length;

	}

	CBPGridGallery.prototype._openSlideshow = function( pos ) {
		pos = parseInt(pos);
		console.log(pos);
		this.isSlideshowVisible = true;
		this.current = pos;
		var currentNextItem = this.el.querySelector( '.nex-container > ul > li.current' );
		if (currentNextItem) {classie.removeClass( currentNextItem, 'current' );}
		var currentPrevItem = this.el.querySelector( '.prev-container > ul > li.current' );	
		if (currentPrevItem) {classie.removeClass( currentPrevItem, 'current' );}

		if ( (pos+1) < this.nextItems.length ) {	
			classie.addClass( this.nextItems[pos+1], 'current' );
		}

		if ( (pos) > 0 ) {			
			classie.addClass( this.prevItems[pos-1], 'current' );
		}

		classie.addClass( this.el, 'slideshow-open' );
		classie.addClass( this.page_container, 'gallery-open' );
		classie.addClass( this.page_body, 'gallery-open' );
		/* position slideshow items */

		// set viewport items (current, next and previous)
		this._setViewportItems();
		
		// add class "current" and "show" to currentItem
		classie.addClass( this.currentItem, 'current' );
		classie.addClass( this.currentItem, 'show' );

		// add class show to next and previous items
		// position previous item on the left side and the next item on the right side
		if( this.prevItem ) {
			classie.addClass( this.prevItem, 'show' );
			var translateVal = Number( -1 * ( getViewportW() / 2 + this.prevItem.offsetWidth / 2 ) );
			setTransform( this.prevItem, support.support3d ? 'translate3d(' + translateVal + 'px, 0, -150px)' : 'translate(' + translateVal + 'px)' );
		}
		if( this.nextItem ) {
			classie.addClass( this.nextItem, 'show' );
			var translateVal = Number( getViewportW() / 2 + this.nextItem.offsetWidth / 2 );
			setTransform( this.nextItem, support.support3d ? 'translate3d(' + translateVal + 'px, 0, -150px)' : 'translate(' + translateVal + 'px)' );
		}
	};

	CBPGridGallery.prototype._navigate = function( dir ) {
		if( this.isAnimating ) return;
		if( dir === 'next' && this.current === this.itemsCount - 1 ||  dir === 'prev' && this.current === 0  ) {
			this._closeSlideshow();
			return;
		}

		var pos;
		if ( dir === 'next' ) {
			pos = this.current+1;
		}else if ( dir === 'prev' ) {
			pos = this.current-1;
		}
		var currentNextItem = this.el.querySelector( '.nex-container > ul > li.current' );
		if (currentNextItem) {classie.removeClass( currentNextItem, 'current' );}	
		if ( (pos+1) < this.nextItems.length ) {
			var next = this.nextItems[pos+1];
			setTimeout(function(){classie.addClass( next , 'current' )}, 300);				
		}

		var currentPrevItem = this.el.querySelector( '.prev-container > ul > li.current' );	
		if (currentPrevItem) {classie.removeClass( currentPrevItem, 'current' );}
		if ( (pos) > 0 ) {	
			var prev = this.prevItems[pos-1];
			setTimeout(function(){classie.addClass( prev , 'current' )}, 300);	
		}


		this.isAnimating = true;
		
		// reset viewport items
		this._setViewportItems();

		var self = this,
			itemWidth = this.currentItem.offsetWidth,
			// positions for the centered/current item, both the side items and the incoming ones
			transformLeftStr = support.support3d ? 'translate3d(-' + Number( getViewportW() / 2 + itemWidth / 2 ) + 'px, 0, -150px)' : 'translate(-' + Number( getViewportW() / 2 + itemWidth / 2 ) + 'px)',
			transformRightStr = support.support3d ? 'translate3d(' + Number( getViewportW() / 2 + itemWidth / 2 ) + 'px, 0, -150px)' : 'translate(' + Number( getViewportW() / 2 + itemWidth / 2 ) + 'px)',
			transformCenterStr = '', transformOutStr, transformIncomingStr,
			// incoming item
			incomingItem;

		if( dir === 'next' ) {
			transformOutStr = support.support3d ? 'translate3d( -' + Number( (getViewportW() * 2) / 2 + itemWidth / 2 ) + 'px, 0, -150px )' : 'translate(-' + Number( (getViewportW() * 2) / 2 + itemWidth / 2 ) + 'px)';
			transformIncomingStr = support.support3d ? 'translate3d( ' + Number( (getViewportW() * 2) / 2 + itemWidth / 2 ) + 'px, 0, -150px )' : 'translate(' + Number( (getViewportW() * 2) / 2 + itemWidth / 2 ) + 'px)';
		}
		else {
			transformOutStr = support.support3d ? 'translate3d( ' + Number( (getViewportW() * 2) / 2 + itemWidth / 2 ) + 'px, 0, -150px )' : 'translate(' + Number( (getViewportW() * 2) / 2 + itemWidth / 2 ) + 'px)';
			transformIncomingStr = support.support3d ? 'translate3d( -' + Number( (getViewportW() * 2) / 2 + itemWidth / 2 ) + 'px, 0, -150px )' : 'translate(-' + Number( (getViewportW() * 2) / 2 + itemWidth / 2 ) + 'px)';
		}

		// remove class animatable from the slideshow grid (if it has already)
		classie.removeClass( self.slideshow, 'animatable' );

		if( dir === 'next' && this.current < this.itemsCount - 2 || dir === 'prev' && this.current > 1 ) {
			// we have an incoming item!
			incomingItem = this.slideshowItems[ dir === 'next' ? this.current + 2 : this.current - 2 ];
			setTransform( incomingItem, transformIncomingStr );
			classie.addClass( incomingItem, 'show' );
		}

		var slide = function() {
			// add class animatable to the slideshow grid
			classie.addClass( self.slideshow, 'animatable' );

			// overlays:
			classie.removeClass( self.currentItem, 'current' );
			var nextCurrent = dir === 'next' ? self.nextItem : self.prevItem;
			classie.addClass( nextCurrent, 'current' );

			setTransform( self.currentItem, dir === 'next' ? transformLeftStr : transformRightStr );

			if( self.nextItem ) {
				setTransform( self.nextItem, dir === 'next' ? transformCenterStr : transformOutStr );
			}

			if( self.prevItem ) {
				setTransform( self.prevItem, dir === 'next' ? transformOutStr : transformCenterStr );
			}

			if( incomingItem ) {
				setTransform( incomingItem, dir === 'next' ? transformRightStr : transformLeftStr );
			}

			var onEndTransitionFn = function( ev ) {
				if( support.transitions ) {
					if( ev.propertyName.indexOf( 'transform' ) === -1 ) return false;
					this.removeEventListener( transEndEventName, onEndTransitionFn );
				}

				if( self.prevItem && dir === 'next' ) {
					classie.removeClass( self.prevItem, 'show' );
				}
				else if( self.nextItem && dir === 'prev' ) {
					classie.removeClass( self.nextItem, 'show' );
				}

				if( dir === 'next' ) {
					self.prevItem = self.currentItem;
					self.currentItem = self.nextItem;
					if( incomingItem ) {
						self.nextItem = incomingItem;
					}
				}
				else {
					self.nextItem = self.currentItem;
					self.currentItem = self.prevItem;
					if( incomingItem ) {
						self.prevItem = incomingItem;
					}
				}

				self.current = dir === 'next' ? self.current + 1 : self.current - 1;
				self.isAnimating = false;
			};

			if( support.transitions ) {
				self.currentItem.addEventListener( transEndEventName, onEndTransitionFn );
			}
			else {
				onEndTransitionFn();
			}
		};

		setTimeout( slide, 25 );
	}

	CBPGridGallery.prototype._closeSlideshow = function( pos ) {
		// remove class slideshow-open from the grid gallery elem
		classie.removeClass( this.el, 'slideshow-open' );
		classie.removeClass( this.page_container, 'gallery-open' );
		classie.removeClass( this.page_body, 'gallery-open' );
		// remove class animatable from the slideshow grid
		classie.removeClass( this.slideshow, 'animatable' );

		var self = this,
			onEndTransitionFn = function( ev ) {
				if( support.transitions ) {
					if( ev.target.tagName.toLowerCase() !== 'ul' ) return;
					this.removeEventListener( transEndEventName, onEndTransitionFn );
				}
				// remove classes show and current from the slideshow items
				classie.removeClass( self.currentItem, 'current' );
				classie.removeClass( self.currentItem, 'show' );
				
				if( self.prevItem ) {
					classie.removeClass( self.prevItem, 'show' );
				}
				if( self.nextItem ) {
					classie.removeClass( self.nextItem, 'show' );
				}

				// also reset any transforms for all the items
				self.slideshowItems.forEach( function( item ) { setTransform( item, '' ); } );

				self.isSlideshowVisible = false;
			};

		if( support.transitions ) {
			this.el.addEventListener( transEndEventName, onEndTransitionFn );
		}
		else {
			onEndTransitionFn();
		}
	};

	CBPGridGallery.prototype._setViewportItems = function() {
		this.currentItem = null;
		this.prevItem = null;
		this.nextItem = null;

		if( this.current > 0 ) {
			this.prevItem = this.slideshowItems[ this.current - 1 ];
		}
		if( this.current < this.itemsCount - 1 ) {
			this.nextItem = this.slideshowItems[ this.current + 1 ];
		}
		this.currentItem = this.slideshowItems[ this.current ];			

		
	}

	// taken from https://github.com/desandro/vanilla-masonry/blob/master/masonry.js by David DeSandro
	// original debounce by John Hann
	// http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
	CBPGridGallery.prototype._resizeHandler = function() {
		var self = this;
		function delayed() {
			self._resize();
			self._resizeTimeout = null;
		}
		if ( this._resizeTimeout ) {
			clearTimeout( this._resizeTimeout );
		}
		this._resizeTimeout = setTimeout( delayed, 50 );
	}

	CBPGridGallery.prototype._resize = function() {
		if ( this.isSlideshowVisible ) {
			// update width value
			if( this.prevItem ) {
				var translateVal = Number( -1 * ( getViewportW() / 2 + this.prevItem.offsetWidth / 2 ) );
				setTransform( this.prevItem, support.support3d ? 'translate3d(' + translateVal + 'px, 0, -150px)' : 'translate(' + translateVal + 'px)' );
			}
			if( this.nextItem ) {
				var translateVal = Number( getViewportW() / 2 + this.nextItem.offsetWidth / 2 );
				setTransform( this.nextItem, support.support3d ? 'translate3d(' + translateVal + 'px, 0, -150px)' : 'translate(' + translateVal + 'px)' );
			}
		}
	}

	// add to global namespace
	window.CBPGridGallery = CBPGridGallery;

})( window );


//Since WP
var navigationContainer = jQuery('#filter-nav'),
mainNavigation = navigationContainer.find('#filter-main-nav ul');

jQuery('.filter-nav-trigger').on('click', function(event){
    event.preventDefault();
    jQuery(this).toggleClass('menu-is-open');
    mainNavigation.off('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend').toggleClass('is-visible');
});

new CBPGridGallery( document.getElementById( 'grid-gallery' ),{isotope:true} );
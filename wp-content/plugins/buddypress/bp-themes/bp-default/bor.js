$(document).ready(function() {
	centerOverlay();
	isTermsChecked();
	addReportAbuseTitle();
	contentPrimaryWidth();

	// setTimeout(function() {
	//     hpBookOpen();
	// }, 2000);


	$('.policy-link').click(function() {
		$('.overlay').hide();
		$('#page-fade').show();
		$('#policy-overlay').fadeIn();
	});

	$('.faq-link').click(function() {
		$('.overlay').hide();
		$('#page-fade').show();
		$('#faq-overlay').fadeIn();
	});

	$('.member-link').click(function() {
		$('.overlay').hide();
		$('#page-fade').show();
		$('#member-overlay').fadeIn();
	});

	$('.report-abuse').click(function() {
		$('.overlay').hide();
		$('#page-fade').show();
		$('#report-abuse-overlay').fadeIn();
	});

	$('.x-close').click(function() {
		$('.overlay').fadeOut();
		$('#page-fade').fadeOut();
	});

	$('.agree-checkbox').click(function() {
		var c = this.checked ? '#f00' : '#09f';
		if (c == '#f00') {
			$('#cover-submit').css('display', 'none');
		} else {
			$('#cover-submit').css('display', 'block');
		}
	});

	$('#blog-search .product').each(function() {
		$('#blog-search .product .continue-reading-post').html('Visit Bookstore...');
		$('#blog-search .product .continue-reading-post').css('bottom', 23+'px');
	});

	$('.left-nav-link').mouseenter(function() {
		$(this).find('.book-front').animate({'width':0});
		$(this).find('.left-top-text').animate({'width':0})
	}).mouseleave(function() {
		$(this).find('.book-front').animate({'width':70});
		$(this).find('.left-top-text').animate({'width':70})
	});

	$('.mp_cart_col_thumb a img').attr('alt', '');
	$('.mp_product_content a img').attr('alt', '');
	
});

$(window).resize(function() {
	centerOverlay();
	contentPrimaryWidth();

});

function addReportAbuseTitle() {
	var title = 'Report Post: '+$('.posttitle').html();
	$('#report-abuse-overlay input#report-title').val(title);
}

function centerOverlay() {
	var wH = $(window).height(),
		wW = $(window).width(),
		newTop = (wH - 400) / 2,
		newLeft = (wW - 800) /2;
	if($(window).height() > 420) {
		$('.overlay').css({'left':newLeft, 'top':newTop});
	}
}

function isTermsChecked() {
	var c = this.checked ? '#f00' : '#09f';
	if (c == '#f00') {
		$('#cover-submit').css('display', 'none');
	} else {
		$('#cover-submit').css('display', 'block');
	}
}

function contentPrimaryWidth() {
	var wW = $(window).width();
		newWidth = (wW - 325);
	$('#primary').css({'width':newWidth});
	$('div#content').css({'width':newWidth});
}

function centerBookContainer() {
	var wW = $(window).width();
		newLeft = (wW - 1020)/2;
	$('#oldbook-text-container').css({'margin-left':newLeft});
}

// function hpBookOpen() {
// 	$('.page-template-addhistory-php .left-page').fadeIn();
// 	$('.page-template-addhistory-php .right-page').fadeIn();
// 	$('#oldbook').css({'height':568})
// 	$('#bookcover').animate({'width':0}, 2000);
// 	$('.home-page .left-page.hp').delay(2000).animate({'width':365}, 2000);
// 	$('.home-page .left-page.hp').delay(2000).css({'right':410}, 2000);
// }

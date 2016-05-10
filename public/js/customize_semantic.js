$('.dropdown')
	.dropdown({
		transition: 'drop'
	})
;

$('.ui .item').on('click', function() {
	$('.ui .item').removeClass('active');
	$(this).addClass('active');
});
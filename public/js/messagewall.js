/**
 * Created by kamielklumpers on 22/04/16.
 */
$('document').ready(function() {

	$('.vote').click(function(){
		$(this).closest('.poll').find('.vote').removeClass('active');
		$(this).addClass('active');
	});

	$('#pollButton').click(function(){
		$("#messageForm").hide();
		$("#pollForm").show();
	});

	$('#messageButton').click(function(){
		$('#pollForm').hide();
		$('#messageForm').show();
	});
});
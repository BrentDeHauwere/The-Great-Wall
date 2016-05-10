/**
 * Created by kamielklumpers on 22/04/16.
 */
$('document').ready(function() {
	// initial hide of poll form
	$("#pollForm").hide();
	$(".messageButton").addClass("active");

	$('.vote').click(function(){
		$(this).closest('.poll').find('.vote').removeClass('active');
		$(this).addClass('active');
	});

	$('.pollButton').click(function(){
		$("#messageForm").hide();
		$("#pollForm").show();
		$(".messageButton").removeClass("active");
		$(".pollButton").addClass("active");
	});

	$('.messageButton').click(function(){
		$('#pollForm').hide();
		$('#messageForm').show();
		$(".pollButton").removeClass("active");
		$(".messageButton").addClass("active");
	});
});
/**
 * Created by kamielklumpers on 22/04/16.
 */
$('document').ready(function() {

	$("#pollButton").click(function(){
		$("#messageForm").hide();
		$("#pollForm").show();
	});

	$("#messageButton").click(function(){
		$("#pollForm").hide();
		$("#messageForm").show();
	});
});
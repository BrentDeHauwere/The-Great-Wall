/**
 * Created by kamielklumpers on 22/04/16.
 */
$('document').ready(function ()
{
	// initial hide of poll form
	$("#pollForm").hide();
	$(".messageButton").addClass("active");

	$('.vote').click(function ()
	{
		$(this).closest('.poll').find('.vote').removeClass('active');
		$(this).addClass('active');
	});

	$('.pollButton').click(function ()
	{
		$("#messageForm").hide();
		$("#pollForm").show();
		$(".messageButton").removeClass("active");
		$(".pollButton").addClass("active");
	});

	$('.messageButton').click(function ()
	{
		$('#pollForm').hide();
		$('#messageForm').show();
		$(".pollButton").removeClass("active");
		$(".messageButton").addClass("active");
	});

	var numberOfPollChoices = 0;

	// poll choices toevoegen
	$('#addPollChoice').click(function ()
	{
		if ($('#pollChoiceText').val().trim() != "")
		{
			var txt = $('#pollChoiceText').val().trim();

			var a = document.createElement('div');
			a.textContent = $('#pollChoiceText').val().trim();

			$('#pollChoices').append('<li class="list-group-item poll-choice">'
				+ a.innerHTML
				+ '<a class = "removebutton"><span class = "glyphicon glyphicon-remove pull-right"></span></a>'
				+ '<input type="hidden" name="choices[]" value="' + a.innerHTML + '">'
				+ '</li>');
			$('#pollChoiceText').val('');

			numberOfPollChoices += 1;

			// poll choice verwijderen
			$('.removebutton').click(function ()
			{
				$(this).closest('.poll-choice').remove();
				numberOfPollChoices -= 1;
			});
		}
	});


});


/*
 *
 * // using jQuery Form Plugin
 $('#formPoll').ajaxForm(function ()
 {
 alert("Thank you for your poll!");

 // ATM --> reload
 location.reload();
 });

 * */
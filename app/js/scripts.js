$(document).ready(function() {
  //Mobile slideout menu
  $('.toggle-nav').on('click', function() {
    $('#nav').toggleClass('show-nav');
    $('body').toggleClass('overflow-hidden');
  });

  //If a link in the slideout nav is clicked
  $('#nav li a').click(function() {
    $('#nav').removeClass('show-nav');
    $('body').removeClass('overflow-hidden');
  });

  //Countdown clock
  function getTimeRemaining(endtime) {
  var t = Date.parse(new Date()) - Date.parse(endtime);
  var days = Math.floor(t / (1000 * 60 * 60 * 24));
    return {
      'total': t,
      'days': days
    };
  }

  function initializeClock(id, endtime) {
    var clock = document.getElementById(id);
    var daysSpan = clock.querySelector('.days');

    function updateClock() {
      var t = getTimeRemaining(endtime);

      daysSpan.innerHTML = t.days;

      if (t.total <= 0) {
        clearInterval(timeinterval);
      }
    }

    updateClock();
    var timeinterval = setInterval(updateClock, 1000);
  }

  var deadline = '2017-09-23';
  initializeClock('clockdiv', deadline);

  //Form submit
	var form = $('#ajax-contact');
	var formMessages = $('#form-messages');

	// Set up an event listener for the contact form.
	$('button').click(function(event) {
		event.preventDefault();

		var formData = $(form).serialize();

		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			url: $(form).attr('action'),
			data: formData
		})
		.done(function(response) {
			$(formMessages).text(response);
			$('#name, #email, #message').val('');

      $('#form-messages').addClass('success');
      $('#form-messages').removeClass('error');

      //Replace form on submit
      $('.rsvp-form').html(formMessages);
		})
		.fail(function(data) {
      $('#form-messages').addClass('error');
      $('#form-messages').removeClass('success');
			if (data.responseText !== '') {
				$(formMessages).text(data.responseText);
			} else {
				$(formMessages).text('Oops! An error occured and your message could not be sent.');
			}
		});
	});
});

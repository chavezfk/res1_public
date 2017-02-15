$(function () {
    // activate the timepickers
    $('input.type-time').timepicker({
      interval: 30,
      minTime: '8',
      maxTime: '23:30'
    });

    // activate the datepickers
    $('input.type-date').datepicker({minDate: 0, maxDate: '4M'});

    // enable/disable the repeat choice based on the recurring event input
    $('input[name=recur]').change(function () {
      $('select[name=repeats]').prop('disabled', $('input[name=recur]:checked').val() === 'false');
    });

    // enable/disable days of the week based on the repeat choice input
    $('select[name=repeats]').change(function () {
      if ($('select[name=repeats]').val() === 'weekly') {
        $('#days').show();
      }
      else {
        $('#days').hide();
      }
    });
    //This block restricts access to rooms based on the size of the group.
    $('#numberofattendees').change(function () {
      var numberOfAttendees = $('#numberofattendees').val();

      if (numberOfAttendees === 'large' || numberOfAttendees === 'xlarge') {
        $("option[value='Study Room 8']").prop('disabled', true);
        $("option[value='Study Room 5']").prop('disabled', true);
      }
      else {
        $("option[value='Study Room 8']").prop('disabled', false);
        $("option[value='Study Room 5']").prop('disabled', false);
      }
      if (numberOfAttendees === 'xlarge') {
        $("option[value='Room 208']").prop('disabled', true);
      }
      else {
        $("option[value='Room 208']").prop('disabled', false);
      }
    });


    $('select[name=room]').change(function () {
      var roomSelected = $('select[name=room]').val();

      if (roomSelected === "Room 212") {
        $("input[name=needsdvd]").prop('disabled', false);
        $("input[name=needscomputer]").prop('disabled', false);
        $("input[name=needsprojector]").prop('disabled', false);
        $("input[name=needsphone]").prop('disabled', false);
      }

      if (roomSelected === "Room 208") {
        $("input[name=needsdvd]").prop('disabled', false);
        $("input[name=needscomputer]").prop('disabled', false);
        $("input[name=needsprojector]").prop('disabled', false);
        $("input[name=needsphone]").prop('disabled', true);
      }

      if (roomSelected === "Study Room 8") {
        $("input[name=needsdvd]").prop('disabled', false);
        $("input[name=needscomputer]").prop('disabled', true);
        $("input[name=needsprojector]").prop('disabled', true);
        $("input[name=needsphone]").prop('disabled', true);
      }

      if (roomSelected === "Study Room 5") {
        $("input[name=needsdvd]").prop('disabled', false);
        $("input[name=needscomputer]").prop('disabled', true);
        $("input[name=needsprojector]").prop('disabled', true);
        $("input[name=needsphone]").prop('disabled', true);
      }

    });

    $('input[name=tech], input[name=federal], input[name=state]').change(function () {
      var isTech = $('input[name=tech]:checked').val() === 'true';
      var isFed = $('input[name=federal]:checked').val() === 'true';
      var isState = $('input[name=state]:checked').val() === 'true';

      $('#fee-warning').toggle(!isTech && !isFed && !isState);
      $('#fee-waived').toggle(isTech || isFed || isState);
    });

    $('input[name=commercial]').change(function () {
      $('#commercial-warning').toggle($('input[name=commercial]:checked').val() === 'true');
    });

    $('input').change(function() {
      var canSubmit = true;

      // do the other form validation stuff here
      // DON'T assign canSubmit = true, just assign false!
      if ($('input[name=commercial]:checked').val() === 'true')
        canSubmit = false;

      if ($('input[name=agree]:checked').val() !== 'true')
        canSubmit = false;
        
      if($('input[name=rezdate]').val() === '')
        canSubmit = false;
        
      if($('input[name=arr_time]').val() === '')
        canSubmit = false;
      
      if($('input[name=dep_time]').val() === '')
        canSubmit = false;
        
      if($('input[name=email]').val() === '')
        canSubmit = false;
        
     
      if($('select[name=room]').val() === 'Default')
        canSubmit = false;
        
      if (canSubmit)
        console.log('you should be able to submit');
      else
        console.log('you should not be able to submit');

      $('#submit').prop('disabled', !canSubmit);
    });

  });
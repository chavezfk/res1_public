function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function checkIsTech(email) {
    //return email.includes('nmt.edu');
    var host = email.split('@');
    var nmt = host[1].split('.');
    var i = nmt.length - 1;
    if( nmt[i] === 'edu')
      if(nmt[i-1] === 'nmt')
        return true;

    return false;
}

function affiliationChange () {
      var isTech = $('input[name=tech]:checked').val() === 'true';
      var isFed = $('input[name=federal]:checked').val() === 'true';
      var isState = $('input[name=state]:checked').val() === 'true';

      $('#fee-warning').toggle(!isTech && !isFed && !isState);
      $('#fee-waived').toggle(isTech || isFed || isState);
    }
    
function timeChange(){
    var req = ['arr_time', 'dep_time'];
    if(!checkTimes())
      return;

    for(var x in req){
      if($('input[name='+ req[x] + ']').val() === ''){
        $('label[for=' + req[x] + ']').attr('class', 'required');
        canSubmit = false;
      }
      else
        $('label[for='+ req[x] +']').attr('class', 'unrequired');
    }
}

//returns false if there is an error in the times picked
function checkTimes(){
    if($('input[name=arr_time]').val() === '' || $('input[name=dep_time]').val() === '')
      return;
    if($('input[name=arr_time]').val() === $('input[name=dep_time]').val()){
      timeError("You cannot arrive and depart at the same time! Please enter different times.");
      return false;
    }
    var a = $('input[name=arr_time]').val().split(':');
      a = a.concat(a[1].split(' '));
      a.splice(1, 1);
    var b = $('input[name=dep_time]').val().split(':');
      b = b.concat(b[1].split(' '));
      b.splice(1, 1);
      
    if((a[0] > b[0] || ( a[1] > b[1] && a[0] === b[0] ))&& a[2] === b[2] && b[2] !== 'PM'){
      timeError("You cannot arrive after you depart! Please enter different times.");
      return false;
    }
}

function timeError(msg){
      alert(msg);
      $('input[name=arr_time]').timepicker('hide');
      $('input[name=dep_time]').timepicker('hide');
      $('input[name=arr_time]').val('');
      $('input[name=dep_time]').val('');   
      return;
}

$(function () {
      // activate the timepickers
      $('input.type-time').timepicker({
        timeFormat: 'h:i A',
        interval: 30,
        minTime: '8',
        maxTime: '23:30'
      });
    // activate the datepickers
    $('input.type-date').datepicker({minDate: 1, maxDate: '4M'});

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

    //room select on change
    $('select[name=room]').change(function () {

      if($('select[name=room]').val() === 'Default'){
        $('label[for=room]').attr('class', 'required');
        canSubmit = false;
      }
      else
        $('label[for=room]').attr('class', 'unrequired');
      
      var roomSelected = $('select[name=room]').val();
      if (roomSelected === "Default") {
        $("input[name=needsdvd]").prop('disabled', true);
        $("input[name=needscomputer]").prop('disabled', true);
        $("input[name=needsprojector]").prop('disabled', true);
        $("input[name=needsphone]").prop('disabled', true);
      }
      
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
    //affiliation checkboxes on change event
    $('input[name=tech], input[name=federal], input[name=state]').change(function () {
      affiliationChange();
    });
    
    //commercial use on change event
    $('input[name=commercial]').change(function () {
      $('#commercial-warning').toggle($('input[name=commercial]:checked').val() === 'true');
    });
    
    //email on change event
    $('input[name=email]').change(function () {
      if($('input[name=email]').val() === ''){
        $('label[for=email]').attr('class', 'required');
        canSubmit = false;
      }
      else{
        $('label[for=email]').attr('class', 'unrequired');
        var valid = validateEmail($('input[name=email]').val());
        if(valid){
          var isTech = checkIsTech($('input[name=email]').val());
          $('input[name=tech]').prop('checked',isTech);
        affiliationChange();
        }
        $('#valid-email').toggle(!valid);
      }
    });
    
    $('input[name=arr_time]').on('selectTime', function() {
      timeChange();
    });
    $('input[name=dep_time]').on('selectTime', function() {
      timeChange();
    });
    
    //other simple change events can be combined in one call
    $('input').change(function() {
      var canSubmit = true;

      // do the other form validation stuff here
      // DON'T assign canSubmit = true, just assign false!
      if ($('input[name=commercial]:checked').val() === 'true')
        canSubmit = false;

      if ($('input[name=agree]:checked').val() !== 'true')
        canSubmit = false;
      
      //required inputs with blank defaults and only need to check if it is blank
      var reqIn = ['rezdate', 'arr_time', 'dep_time']; 
      for(var x in reqIn){
        if($('input[name='+ reqIn[x] + ']').val() === ''){
          $('label[for=' + reqIn[x] + ']').attr('class', 'required');
          canSubmit = false;
        }
        else
          $('label[for=' + reqIn[x] + ']').attr('class', 'unrequired');
      }
        
      if (canSubmit)
        console.log('you should be able to submit');
      else
        console.log('you should not be able to submit');

      $('#submit').prop('disabled', !canSubmit);
    });

  });
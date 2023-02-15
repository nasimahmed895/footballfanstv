/* 
 _____   _           _         _                        _                  
|_   _| | |         | |       | |                      | |                 
  | |   | |__   __ _| |_ ___  | |_ ___  _ __ ___   __ _| |_ ___   ___  ___ 
  | |   | '_ \ / _` | __/ _ \ | __/ _ \| '_ ` _ \ / _` | __/ _ \ / _ \/ __|
 _| |_  | | | | (_| | ||  __/ | || (_) | | | | | | (_| | || (_) |  __/\__ \
 \___/  |_| |_|\__,_|\__\___|  \__\___/|_| |_| |_|\__,_|\__\___/ \___||___/

Oh nice, welcome to the js file of dreams.
Enjoy responsibly!
@ihatetomatoes

*/

$(document).ready(function() {
	
	
});



(function($) {
  "use strict";
  $('.input100').each(function() {
      $(this).on('blur', function() {
          if ($(this).val().trim() != "") {
              $(this).addClass('has-val');
          } else {
              $(this).removeClass('has-val');
          }
      })
  })
  var input = $('.validate-input .input100');
  $('.validate-form').on('submit', function() {
      var check = true;
      for (var i = 0; i < input.length; i++) {
          if (validate(input[i]) == false) {
              showValidate(input[i]);
              check = false;
          }
      }
      return check;
  });
  $('.validate-form .input100').each(function() {
      $(this).focus(function() {
          hideValidate(this);
      });
  });

  function validate(input) {
      if ($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
          if ($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
              return false;
          }
      } else {
          if ($(input).val().trim() == '') {
              return false;
          }
      }
  }

  function showValidate(input) {
      var thisAlert = $(input).parent();
      $(thisAlert).addClass('alert-validate');
  }

  function hideValidate(input) {
      var thisAlert = $(input).parent();
      $(thisAlert).removeClass('alert-validate');
  }
  var showPass = 0;
  $('.btn-show-pass').on('click', function() {
      if (showPass == 0) {
          $(this).next('input').attr('type', 'text');
          $(this).addClass('active');
          showPass = 1;
      } else {
          $(this).next('input').attr('type', 'password');
          $(this).removeClass('active');
          showPass = 0;
      }
  });
})(jQuery);
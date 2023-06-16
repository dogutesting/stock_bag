$(document).ready(function() {
    var st1, st2;
    
    $('.boxForGenders').on('click', function () {
        $(this).find('.radioInput input').prop('checked', true);
    });

    $("#submitBtn").click(function(e) {
        var valid = this.form.checkValidity(); 
        
        if (valid) {
          e.preventDefault();
          //e.stopImmediatePropagation();
          
          var formData = {
            "login_email": $('#login_email').val(),
            "login_password": $('#login_password').val(),
          };
          
          $.ajax({
            type: 'POST',
            url: 'php/loginForm.php',
            data: formData,
            dataType: "text",
            success: function(data) {
                if(data === "notFound") {
                    redNotSet("Benutzername oder Passwort ist falsch", 3500);
                }
                else {
                  window.location.href = data.split(':')[1];
                }
            },
            error: function(data) {
                errorLog(data);
            }
          });
        }
      });

      $("#registerButton").click(function(e) {
        var valid = this.form.checkValidity();
        
        if (valid) {
          e.preventDefault();
          
          var dayOfBirth = $('#days').val()
            +"."+$('#months').val()+"."
            +$('#years').val();
          var gender = $("input[type=radio][name=gender]:checked").val();        

          var formData = {
            "name_ajx": $('#modal_name').val(),
            "lastname_ajx": $('#modal_lastname').val(),
            "email_ajx": $('#modal_email').val(),
            "password_ajx": $('#modal_password').val(),
            "phoneNumber_ajx": $('#telnumber').val(),
            "humanid_ajx": $('#nationalorpassport').val(),
            "dateOfBirth_ajx": dayOfBirth,
            "gender_ajx": gender
          };
          
          $.ajax({
            type: 'POST',
            url: 'php/registerForm.php',
            data: formData,
            success: function(data) {
                if(data == "email") {
                    alert("Böyle bir email zaten var. //update-after");
                }
                if(data == "new_record") {
                    $('#myModal').css("display", "none");
                    
                    greenNotSet("Account erstellt. Sie können sich jetzt anmelden.", 4000);
                    
                    $('#myModal form')[0].reset();
                }
            },
            error: function(data) {
                errorLog(data);
            }
          });
        }
      });

      function redNotSet(text, time) {
        $(".alert").addClass("alert-red");
        
        $(".msg").addClass("msg-red");

        $('.close-btn').addClass('close-btn-red');

        $('.alert #alert_icon').attr("class", "msg-red fa-solid fa-circle-xmark fa-2xl");
        $('.msg').html(text);

        //next
        $('.alert').addClass("show");
        $('.alert').removeClass("hide");
        $('.alert').addClass("showAlert");
        
         st1 = setTimeout(function(){
           $('.alert').removeClass("show");
           $('.alert').addClass("hide");
        }, time);
     }

     function greenNotSet(text, time) {
        $(".alert").removeClass("alert-red");
        
        $(".msg").removeClass("msg-red");

        $('.close-btn').removeClass('close-btn-red');

        $('.alert #alert_icon').attr("class", "msg-suc fa-solid fa-circle-check fa-2xl");
        $('.msg').html(text);

        //next
        $('.alert').addClass("show");
        $('.alert').removeClass("hide");
        $('.alert').addClass("showAlert");
        
        st2 = setTimeout(function(){
           $('.alert').removeClass("show");
           $('.alert').addClass("hide");
        }, time);
     }

     $('.close-btn').click(function(){
      $(".alert").removeClass("show");
      $(".alert").addClass("hide");

      clearTimeout(st1);
      clearTimeout(st2);
    });

     function errorLog(er) {
      var log = "Document.title = " + document.title + "\n" +
      "Data = " + er + "\n" +
      "---------------------\n";
      $.post({
          url: 'php/errorWrite.php',
          data: {"errorLog":log},
      });
  }

});
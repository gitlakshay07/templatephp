(function ($) {
  "use strict";

  var signin = {
    formElm: $("#signinform"),
    submit: function () {
      this.formElm.on("submit", function (e) {
        e.preventDefault();
        if (signin.formElm.valid()) {
          let formData = signin.formElm.serializeArray();
          formData.push({
            name: "action",
            value: "signin"
          })
          $.ajax({
            type: "POST",
            url: "/sign-in",
            data: formData,
            dataType: "json",
            success: function (result) {
                console.log(result);
                if(!isJson(result)){
                    result = $.parseJSON(result);
                }
                if(result.success){
                    $("#submitbtn")
                    .html("Successfully Signed In!")
                    .removeClass("bg-gradient-dark")
                    .addClass("bg-success")
                    .addClass("text-white")

                    window.location.href = '/dashboard';
                }else{
                    $("label.error[for=signinform]").html(result.message).show();
                }
            }
          });
        }
        console.log("signin called");
        console.log($("label.error[for=signinform]"));
      });
    },
    validation: function () {
      this.formElm.validate({
        rules: {
          email: {
            required: true,
            email: true,
          },
          password: {
            required: true,
            minlength: 5,
          }
        },
        messages: {
          email: {
            required: "Please enter an email",
          },
          password: {
            required: "Please provide a password",
            minlength: "Your password mustbe atleast 5 char long",
          }
        },
      });
    },
    init: function () {
      this.validation();
      this.submit();
      console.log("Signin Form");
    }
  };
  var signup = {
    formElm: $("#signupform"),

    submit: function () {
      this.formElm.on("submit", function (e) {
        e.preventDefault();
        if (signup.formElm.valid()) {
          let formData = signup.formElm.serializeArray();
          formData.push({
            name: "action",
            value: "signup"
          })
          $.ajax({
            type: "POST",
            url: "/sign-up",
            data: formData,
            dataType: "json",
            success: function (result) {
                console.log(result);
                if(!isJson(result)){
                    result = $.parseJSON(result);
                }
                if(result.success){
                    $("#submitbtn")
                    .html("Successfully Signed up!")
                    .removeClass("bg-gradient-dark")
                    .addClass("bg-success")
                    .addClass("text-white")

                    window.location.href = result.data.redirect_url;
                }else{
                    $("#submitbtn")
                    .html("Oops! Error!")
                    .removeClass("bg-gradient-dark")
                    .addClass("bg-danger")
                    .addClass("text-white")
                }
            }
          });
        }
        console.log("signup called");
      });
    },
    validation: function () {
      this.formElm.validate({
        rules: {
          name: {
            required: true,
            minlength: 3,
          },
          email: {
            required: true,
            email: true,
          },
          password: {
            required: true,
            minlength: 5,
          },
          conf_password: {
            equalTo: "#password",
          },
        },
        messages: {
          name: {
            required: "Please enter your name",
            minlength: "name must be atleast 3 char long",
          },
          email: {
            required: "Please enter an email",
          },
          password: {
            required: "Please provide a password",
            minlength: "Your password mustbe atleast 5 char long",
          },
          conf_password: {
            equalTo: "Password do not match",
          },
        },
      });
    },
    init: function () {
      this.validation();
      this.submit();
    },
  };

  function isJson(str){
    if(typeof str === 'object'){
        return true;
    }else{
        try{
            JSON.parse(str);
        }catch (e){
            console.log(e);
            return false;
        }
        return true;
    }
  }
  $(document).ready(function () {
    if($("#signupform").length > 0){
      signup.init();
    }

    if($("#signinform").length > 0){
      signin.init();
    }
  });
})(jQuery);

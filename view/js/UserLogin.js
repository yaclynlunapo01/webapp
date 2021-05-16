function RegistrarNuevoUsuario()
{
    console.log("Nuevo Ususario")

    $('#login_container').fadeOut('slow', function() {
        $('#register_container').fadeIn('slow');
      })
}

function ValidarRegistro()
{
    var user_name = $('#user_name_register').val()
    var user_surname = $('#user_surname_register').val()
    var user_patronimic = $('#user_patronimic_register').val()
    var user_email = $('#user_email_register').val()
    var user_password = $('#user_password_register').val()    
    var user_dob = $('#user_dob_register').val()

    var mail_part = user_email.split("@")
    console.log(mail_part.length)
    if (user_name == "" || user_surname == "" || user_patronimic == "" 
    || user_email == "" || user_password == "" || user_dob == "")
    {
      alertMessages("warning", "Введите все данные", "Внимание!")
    }
    else if (mail_part.length != 2)
    {
      alertMessages("warning", "Введите почту правильно!", "Внимание!")      
    }
    else 
    {
      var dir_part = mail_part[1].split('.')
      if (dir_part.length !=2)
      {
        alertMessages("warning", "Введите почту правильно!", "Внимание!")
      }
      else
      {
        RegistrarUsuario()
      }
    }

}

function RegistrarUsuario()
{
  var user_name = $('#user_name_register').val()
  var user_surname = $('#user_surname_register').val()
  var user_patronimic = $('#user_patronimic_register').val()
  var user_email = $('#user_email_register').val()
  var user_password = $('#user_password_register').val()    
  var user_dob = $('#user_dob_register').val()

$.ajax({
      url: 'index.php?controller=UserLogin&action=InsertUser',
      type: 'POST',
      data: {        
       user_name: user_name,
       user_surname: user_surname,
       user_patronimic: user_patronimic,
       user_dob: user_dob,
       user_password: user_password,
       user_mail: user_email
      },
  })
  .done(function(x) {
    x=x.trim()
     if (x=="0")
      {
        alertMessages("warning", "Данная почта уже зарегистрирована!", "Внимание!")
      }
    else if (x.includes("<b>Warning</b>"))
      {
        alertMessages("error", "Произошла ошибка: "+x, "Ошибка!")
      }
      else if (x=="1")
      {
        alertMessages("success", "Пользователь зарегистрирован!", "Успех!")
        CancelRegister()
      }
      else
      {
        alertMessages("warning", x, "Внимание!")
      }
    
    
  })
  .fail(function() {
      console.log("error");
  });
}

function CancelRegister()
{
    
    $('#register_container').fadeOut('slow', function() {
        $('#login_container').fadeIn('slow');
      })

    $('#user_name_register').val('')
    $('#user_surname_register').val('')
    $('#user_patronimic_register').val('')
    $('#user_email_register').val('')
    $('#user_password_register').val('')    
    $('#user_dob_register').val('')

}

function LoginUsuario()
{
  var login =$('#login_usuario').val();
  var password =$('#password_usuario').val();

  if (login == "" || password =="")
  {
    alertMessages("warning", "Введите логин и пароль", "Внимание!")
  }
  else
  {
    $.ajax({
      url: 'index.php?controller=UserLogin&action=GetLoginInfo',
      type: 'POST',
      data: {
        
        login_user:login,
        password_user:password
      },
  })
  .done(function(x) {
    x=x.trim()
     if (x=="0")
      {
        alertMessages("warning", "Данный пользователь не существует!", "Внимание!")
      }
    else if (x.includes("<b>Warning</b>"))
      {
        alertMessages("error", "Произошла ошибка: "+x, "Ошибка!")
      }
      else if (x=="2")
      {
        alertMessages("warning", "Неправильный логин или пароль!", "Внимание!")
      }
      else if (x=="1")
      {
       RedirectToFeed()
      }
      else
      {
        alertMessages("warning", x, "Внимание!")
      }
    
    
  })
  .fail(function() {
      console.log("error");
  });
  }

}

function RedirectToFeed()
{
  console.log("redirecting")
  $.ajax({
    url: 'index.php?controller=UserLogin&action=RedirectToFeed',
    type: 'POST',
    data: {
    },
})
.done(function(x) {
  x=x.trim()
  console.log(x)
    if (x=="admin")
    {
      window.location.href = "index.php?controller=AdminFeed&action=feed"
    }
    else if (x=="user")
    {
      window.location.href = "index.php?controller=ConcertFeed&action=feed"
    }
})
.fail(function() {
    console.log("error");
});

}

function alertMessages(tipo, mensaje, titulo)
{
	Swal.fire({
		  icon: tipo,
		  title: titulo,
		  text: mensaje
		})
}
$(document).ready(function(){

  GetUserName()
  GetConcertFeed()
  getEventType()
  })

  function getEventType()
  {
     $.ajax({
          url: 'index.php?controller=ManageEvents&action=GetEventType',
          type: 'POST',
          data: {},
      })
      .done(function(x) {
        x=JSON.parse(x)						
        
         var select = document.getElementById('concert_type_search');
  
      for (var i = 0; i<x.length; i++){
          var opt = document.createElement('option');
          opt.value = x[i]['id_tipo_evento'];
          opt.innerHTML = x[i]['nombre_tipo_evento'];
          
          select.appendChild(opt);
      }
      })
      .fail(function() {
          console.log("error");
      });
  }

function GetUserName()
{
  console.log("get user name")
  $.ajax({
    url: 'index.php?controller=ConcertFeed&action=GetUserName',
    type: 'POST',
    data: {
    },
})
.done(function(x) {
  x=x.trim()
  console.log(x)
   $('#nombre_usuario_actual').html(x)  
})
.fail(function() {
    console.log("error");
});
}

function GetConcertFeed()
{
  var search = $("#search_event").val()
	var type = $("#concert_type_search").val()
  var date = $("#search_date_event").val()

  $.ajax({
    url: 'index.php?controller=ConcertFeed&action=GetConcertFeed',
    type: 'POST',
    data: {
      search:search,
		    	type:type,
          date:date
    },
})
.done(function(x) {
  x=x.trim()
   $("#conciertos_feed").html(x)
})
.fail(function() {
    console.log("error");
});

}

function RegistrarNuevoUsuario()
{
    console.log("Nuevo Ususario")

    $('#login_container').fadeOut('slow', function() {
        $('#register_container').fadeIn('slow');
      })
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

function salirSesion()
{
  $.ajax({
    url: 'index.php?controller=AdminFeed&action=SalirSesion',
    type: 'POST',
    data: {
    },
})
.done(function(x) {

      window.location.href = "index.php?controller=UserLogin&action=index"
})
.fail(function() {
    console.log("error");
});

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

function ComprarBoleto(id_evento)
{
  window.location.href = "index.php?controller=ComprarBoleto&action=feed&id_evento="+id_evento
}

function alertMessages(tipo, mensaje, titulo)
{
	Swal.fire({
		  icon: tipo,
		  title: titulo,
		  text: mensaje
		})
}


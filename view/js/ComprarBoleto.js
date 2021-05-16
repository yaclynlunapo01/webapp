$(document).ready(function(){

  GetUserName()
  GetConcertInfo()
  //etEventType()
  })
  
function GetUserName()
{
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

function GetConcertInfo()
{
  $.ajax({
    url: 'index.php?controller=ComprarBoleto&action=GetConcertInfo',
    type: 'POST',
    data: {
    },
})
.done(function(x) {
  //console.log(x)
  x=x.trim()
  x=JSON.parse(x)
  console.log(x)
   $('#info_concierto').html(x['cabeza'])
   $('#boletos_concierto').html(x['esquema'])  
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

function alertMessages(tipo, mensaje, titulo)
{
	Swal.fire({
		  icon: tipo,
		  title: titulo,
		  text: mensaje
		})
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

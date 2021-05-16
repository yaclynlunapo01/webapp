<nav class="navbar navbar-expand-md navbar-light bg-white sticky-top">
	<div class="container-fluid">
		<a id="nombre_usuario_actual" class="text-muted" href="#"></a>
		<h3 style="text-align: center;" class="text-dark">
              <font style="color: #F9FF2C;">V</font><font style="color: #2836fe;">E</font><font style="color: #FE3C28;">N</font>
              TICKET</h3>
		<a class="btn btn-sm btn-outline-secondary" href="#" onclick="salirSesion()">Выйти</a>
	</div>
</nav>
<nav class="navbar navbar-expand-md navbar-light bg-white sticky-top">
	<div class="container">
	<?php
	if (!isset($_SESSION['id_rol_usuario']))
	{
		session_start();
	}
	if ($_SESSION['id_rol_usuario']==1)
	{
		echo '<a class="p-2 text-muted" href="index.php?controller=AdminFeed&action=feed">Мероприятия</a>
			<a class="p-2 text-muted" href="index.php?controller=ManageEvents&action=index">Регистрация мероприятий</a>
			<a class="p-2 text-muted" href="#">Отчеты</a>';
	} else
	{
		echo '<a class="p-2 text-muted" href="index.php?controller=ConcertFeed&action=feed">Мероприятия</a>
			<a class="p-2 text-muted" href="#">Мои билеты</a>
			<a class="p-2 text-muted" href="#">Моя страница</a>';
	}

	?>
          
	</div>
</nav>
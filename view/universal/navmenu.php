<ul class="navbar-nav ml-auto">
	<li class="nav-item <?php if ($pageName == "MainPage") {echo "active";}?>">
		<a class="nav-link" href="index.php?controller=MainPage&action=DueToday">Главная</a>
	</li>
	<li class="nav-item <?php if ($pageName == "Appointments") {echo "active";}?>">
		<a class="nav-link" href="index.php?controller=Appointments&action=index">Записи</a>
	</li>
	<li class="nav-item <?php if ($pageName == "Procedures") {echo "active";}?>">
		<a class="nav-link" href="index.php?controller=Procedures&action=index">Процедуры</a>
	</li>
	<li class="nav-item <?php if ($pageName == "Patients") {echo "active";}?>">
		<a class="nav-link" href="index.php?controller=Patients&action=index">Пациенты</a>
	</li>
	<li class="nav-item <?php if ($pageName == "Reports") {echo "active";}?>">
		<a class="nav-link" href="index.php?controller=Reports&action=index">Отчеты</a>
	</li>
</ul>
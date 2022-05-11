<div class="navbar">
  <?php if ($_SESSION['rolid'] === 1) { ?>
    <div class="dropdown">
    <button class="dropbtn">Admin 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="onderhoud.php">Onderhoud</a>
      <a href="gebruiksbeheer.php">Gebruiksbeheer</a>
    </div>
  </div> 
  <?php } ?>

  <?php if ($_SESSION['rolid'] === 2) { ?>
    <div class="dropdown">
    <button class="dropbtn">Applicatie beheerder 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="innames.php">Inname</a>
      <a href="#">Verwerking</a>
      <a href="#">Uitgifte</a>
      <a href="#">Rapportage</a>
      <a href="#">Onderhoud</a>
    </div>
  </div> 
  <?php } ?>

  <?php if ($_SESSION['rolid'] === 3) { ?>
    <div class="dropdown">
    <button class="dropbtn">Medewerker uitgifte
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="#">Uitgifte</a>
      <a href="#">Rapportage</a>
    </div>
  </div> 
  <?php } ?>

  <?php if ($_SESSION['rolid'] === 4) { ?>
    <div class="dropdown">
    <button class="dropbtn">Medewerker verwerking
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="#">Verwerking</a>
      <a href="#">Rapportage</a>
    </div>
  </div> 
  <?php } ?>

  <?php if ($_SESSION['rolid'] === 5) { ?>
    <div class="dropdown">
    <button class="dropbtn">Medewerker inname
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="#">Inname</a>
      <a href="#">Rapportage</a>
    </div>
  </div> 
  <?php } ?>

  <?php if ($_SESSION['rolid'] === 6) { ?>
    <div class="dropdown">
    <button class="dropbtn">Algemene medewerker 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="#">Rapportage</a>
    </div>
  </div> 
  <?php } ?>

  <a href="uitloggen.php">Uitloggen</a>
</div>
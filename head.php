<?php
  //link clic logo definir a donde va para cada rol
  $rutaLogo=$ruta."inicio";
?>
  <?php
   $sw_h=false;
   if ($sw_h) {
     # code...
   
  ?>
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>
  <?php
  }



  ?>
  <header id="header" class="page-topbar">
    <div class="navbar-fixed">
        <nav class="navbar-color">
            <div class="nav-wrapper">
                <ul class="left">                      
                  <li><h1 class="logo-wrapper"><a href="<?php echo $rutaLogo ?>" class="brand-logo darken-1"><img style="border-radius: 4px;" src="<?php echo $ruta ?>recursos/images/materialize-logo.png" alt="materialize logo"></a> <span class="logo-text"><?php echo $_SESSION["short"] ;?></span></h1></li>
                </ul>
                <ul class="right hide-on-med-and-down" style="font-weight: bold; color:#002248;">
                    <li> <?php echo $_SESSION["short"] ;?></li>
                    <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen"><i class="mdi-action-settings-overscan" style="color:#002248;"></i></a>
                    </li>     
                    <li><a href="<?php echo $ruta ?>session/salir.php"  style="font-weight: bold; color:#002248;"><i class="fa fa-sign-out"></i> Cerrar Sesion</a>
                    </li>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp; </li>
                </ul>
                <!-- notifications-dropdown -->
                <ul id="notifications-dropdown" class="dropdown-content">
                  <li>
                    <a href="#!"><i class="fa fa-print"></i> IMPRIMIR</a>
                  </li>
                  <li>
                    <a href="#!"><i class="mdi-action-add-shopping-cart"></i> PROCESAR BALANCE</a>
                  </li>
                </ul>
            </div>
        </nav>
    </div>
  </header>
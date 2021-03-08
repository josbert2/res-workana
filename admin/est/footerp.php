
<!-- Footer -->
<!--
<footer>

  <div style="  
   left: 0;
   width: 100%;  
   display: flex;
   overflow: hidden;
   background-color: #d7e811;
   color: black;
   text-align: center;
   position: absolute;
   bottom: 0;">
      Contacto:
    <a href="tel:+56229023011"> +56 2 2902 3011 (Opción 1) </a> - <a href="tel:+56229023011"> - +56 2 2902 3011 (Opción 2)</a>
  </div>

</footer>
Footer -->

<style>
.footer {
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: #0049a2;
    padding: 15px;
}
    
.franja-footer {
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: #d7e811;
    padding-top: 7px !important;
    
}
</style>

<div class="franja-footer">
</div>
<div class="footer">
    <div style="text-align: right; color: white;">
    
    <?php //echo $_SESSION['usuario'] ?>
    <div class="container">
      <div class="row">
          <div class="col-md-4">
              <h2 class="main-title-footer">Mapas de cobertura</h2>
              <ul class="footer-list">
                  <li>
                    <a href="">
                    Antofagasta
                    </a>
                  </li>
                  <li>
                    <a href="">
                    Calama
                    </a>
                  </li>
                  <li>
                    <a href="">
                    Copiapó
                    </a>
                  </li>
                  <li>
                    <a href="">
                    Coquimbo
                    </a>
                  </li>
                  <li>
                    <a href="">
                    La Serena
                    </a>
                  </li>
              </ul>
          </div> 
          <div class="col-md-4">
              <h2 class="main-title-footer">Contáctanos</h2>
              <ul class="footer-list">
                  <li>
                    <span>
                    Consultas del servicio a: <a href="">comercial@rest911.cl</a>
                    </span>
                  </li>
                  <li>
                    <span>
                    Servicios al Cliente a: <a href="">sac@rest911.cl</a>
                    </span>
                  </li>
                  <li>
                    <span>
                    Teléfono +56 22 90 23 011 opción 2
                    </span>
                  </li>

                  <li>
                    <span>
                    Sitio Web: www.rest911.cl
                    </span>
                  </li>
                  
              </ul>
          </div> 
          <div class="col-md-4">
              <div class="d-flex align-items-center" style="height:100%">
                <img id="rest_logo" src="img/logob.png" width="230" height="80" alt="">
              </div>
          </div>
        </div>  
      </div>
    </div>
</div>
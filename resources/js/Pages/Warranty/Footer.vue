<template>
  <div class="warranty-footer">
    <div class="footer-sections">
      <div class="container">
        <div class="row py-5 mb-4 align-items-start">
          <!-- Company Column -->
          <div class="col-12 col-sm-6 col-lg-3 mb-4 mb-lg-0">
            <h6 class="fw-bold mb-3">Who we are</h6>
            <ul class="list-unstyled footer-links">
              <li><a href="https://rayzonsolar.com/about" class="footer-link" target="_blank">About Us</a></li>
              <li><a href="https://rayzonsolar.com/products" class="footer-link" target="_blank">Products</a></li>
              <li><a href="https://rayzonsolar.com/events" class="footer-link" target="_blank">Events</a></li>
              <li><a href="https://rayzonsolar.com/gujarat-titans" class="footer-link" target="_blank">Renewable Partners</a></li>
              <li><a href="https://rayzonsolar.com/contact-us" class="footer-link" target="_blank">Contact</a></li>
            </ul>
          </div>

          <!-- Navigation Column -->
          <div class="col-12 col-sm-6 col-lg-3 mb-4 mb-lg-0">
            <h6 class="fw-bold mb-3">Our Companies</h6>
            <ul class="list-unstyled footer-links">
              <li><a href="https://rayzonsolar.com/" class="footer-link" target="_blank">Rayzon Solar</a></li>
              <li><a href="https://rayzongreen.com/" class="footer-link" target="_blank">Rayzon Green</a></li>
              <li><a href="https://rayzonindustries.com/" class="footer-link" target="_blank">Rayzon Industries</a></li>
              <li><a href="#" class="footer-link" target="_blank">Rayzon Energy</a></li>
              <li><a href="https://rayzongreen.com/" class="footer-link" target="_blank">Rayzon Engineering</a></li>
              <li><a href="https://www.delucecare.com/" class="footer-link" target="_blank">Rayzon Bio Care</a></li>
            </ul>
          </div>

          <!-- Contact Column -->
          <div class="col-12 col-sm-6 col-lg-3 mb-4 mb-lg-0">
            <h6 class="fw-bold mb-3">Contact</h6>

            <div class="d-flex align-items-center gap-2 mb-3 contact-item">
              <i class="bi bi-envelope-paper"></i>
              <span>contact@rayzonenergies.com</span>
            </div>

            <div class="d-flex align-items-center gap-2 mb-3 contact-item">
              <i class="bi bi-telephone"></i>
              <span>+91 96380 00461 / 62</span>
            </div>

            <div class="d-flex align-items-center gap-2 contact-item">
              <i class="bi bi-geo-alt"></i>
              <span>Surat, Gujarat - India</span>
            </div>
          </div>

          <!-- Language & Social Icons Column -->
          <div class="col-12 col-sm-6 col-lg-3 mb-4 mb-lg-0 d-flex flex-column align-items-lg-end align-items-start">
            <!-- Social icons -->
            <div class="d-flex gap-3 contact-item">
              <a href="https://www.linkedin.com/company/rayzonsolar" class="social-icon"><i class="bi bi-linkedin fs-5"></i></a>
              <a href="https://www.instagram.com/rayzon_solar" class="social-icon"><i class="bi bi-instagram fs-5"></i></a>
              <a href="https://www.facebook.com/RayzonSolar/" class="social-icon"><i class="bi bi-facebook fs-5"></i></a>
              <a href="https://www.youtube.com/@rayzon-solar" class="social-icon"><i class="bi bi-youtube fs-5"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer">
      <BContainer>
        <BRow>
          <BCol col sm="6">{{ new Date().getFullYear() }} © Rayzon.</BCol>
          <BCol col sm="6">
            <div class="text-sm-end d-none d-sm-block">Design & Develop by Rayzon</div>
          </BCol>
        </BRow>
      </BContainer>
    </footer>
  </div>
</template>

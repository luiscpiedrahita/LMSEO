<?php
$out.='
<a class="anchor" id="projects"></a>
<section class="projects container-fluid overflow-hidden">
  <div class="">
    <div class="">
     <h1 class="projects-title">Recent Projects</h1>
      <div class="">
      <hr class="my-5">
        <div class="container">
          <div class="row project-item">
            <div class="col-lg-6" 
                data-aos="fade-right"
                data-aos-offset="0">
                <img src="'. get_stylesheet_directory_uri(). '/dist/images/projects/eopiates/eopiates.png"
                class="img-fluid"
                width="617"
                height="339"
                alt="eOpiates redesign"
                title="eOpiates redesign"> 
            </div>
            <div class="col-lg-6"
                data-aos="fade-left"
                data-aos-offset="0">
              <h2>eOpiates.com</h2>
              <ul class="project-description-list">
                <li><h3>Back-end</h3> <ul>
                  <li>eOpiates back-end is built with a custom content management system using MySQL, PHP and Zend Framework.</li>
                </ul> </li>
                <li class="project-description-list-item"><h3>Front-end</h3> <ul>
                  <li>eOpiates front-end presents a responsive design, mobile-first aproach. Mobile-first, responsive, adaptive experiences and structured HTML in order to optimize performance and prioritize flexibility. Larger screens are targeted with media queries.</li>
                </ul> </li>
              </ul>
            </div>
          </div>
        </div>
        <hr class="my-5">
        <div class="container">
         <div class="row project-item">
            <div class="col-lg-6" 
                data-aos="fade-right"
                data-aos-offset="0">
                <h2>eOpiates Instant Search</h2>
              <ul class="project-description-list">
                <li class="project-description-list-item">PHP</li>
                <li class="project-description-list-item">MySQL</li>
                <li class="project-description-list-item">jQuery, Ajax</li>
                <li class="project-description-list-item">Mustache.js</li>
              </ul>
            </div>
            <div class="col-lg-6 columns"
                data-aos="fade-left"
                data-aos-offset="0">
                <img src="'.get_stylesheet_directory_uri().'/dist/images/projects/eopiates/instant-search.jpg"
                class="img-fluid"
                width="686"
                height="338"
                alt="eOpiates instant search"
                title="eOpiates instant search">
            </div>
          </div>
        </div>
        <hr class="my-5">
        <div class="container">
          <div class="row project-item">
            <div class="col-lg-6" 
                data-aos="fade-right"
                data-aos-offset="0">
                <img src="'.get_stylesheet_directory_uri().'/dist/images/projects/lmseo/home.jpg"
                class="img-fluid"
                width="686"
                height="338"
                alt="LMSEO redesign"
                title="LMSEO redesign">
            
            </div>
            <div class="col-lg-6" 
                data-aos="fade-left"
                data-aos-offset="0">       
              <h2>LMSeo.com</h2>
              <ul class="project-description-list">
                <li class="project-description-list-item"><h3>Back-end</h3>
                <ul>
                  <li>LMSEO currently runs on WordPress and Genesis Framework.</li>
                </ul></li>
                <li class="project-description-list-item"><h3>Front-end</h3>
                <ul>
                  <li>The front-end uses Foundation Zurb framework for faster coding and prototyping.</li>
                   <li class="project-description-list-item">SCSS, an extension of CSS that adds power and elegance to the basic language. It allows to use variables, nested rules, mixins, inline imports, and more. EMMET for faster coding and REM(Root em) units to enhanced user experience even further.</li>
                </ul></li>
              </ul>
             </div>
          </div>
        </div>
        <hr>
        <div class="row my-5">
            <div class="col text-center">
              <a href="/services/" class="home-button xlarge-button">More Projects</a>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>';
<?php
$out .= '<header class="sticky">
  <nav class="top-bar animated fadeInUp delay-300" data-topbar>
    <ul class="title-area">
      <li class="name">';
$inside .= sprintf('<a href="/" title="%s" class="logo">%s</a>', esc_attr(get_bloginfo('name')), get_bloginfo('name'));
$out .= sprintf('<h1 class="site-title">%1$s</h1>', $inside);
$out .= '
      </li>
       <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
      <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
    </ul>
    <section class="top-bar-section">
    <ul class="primary-links">
        <li><a href="/team/">Team</a></li>
        <li><a href="/contact/">Contact</a></li>
        <li><a href="/blog/">Blog</a></li>
        <li class="has-dropdown">
          <a href="#">Services</a>
          <ul class="dropdown">
            <li class="has-dropdown"><a href="/services/">Marketing</a>
              <ul class= "dropdown">
                <li><a href="/services/design/consulting/">UI/UX consulting</a></li>
              </ul>
            </li>
            <li class="has-dropdown"><a href="/services/programming/">Web Development</a>
              <ul class= "dropdown">
                <li><a href="/services/design/consulting/">UI/UX consulting</a></li>
              </ul>
            </li>
            <li class="has-dropdown"><a href="/services/design/">UI/UX Design</a>
              <ul class= "dropdown">
                <li><a href="/services/design/consulting/">UI/UX consulting</a></li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
     <ul class="right topbar-more-info-nav hide-for-medium-down">
     <li><a href="tel:+6262325218">626.232.5218</a></li>
        <li class="has-form top-form">
          <div class="row collapse">
            <div class="col-lg-8 col-sm-9 columns"><input type="text" placeholder="Find Something"></div>
              <div class="col-lg-4 col-sm-3 columns"><a href="/" class="home-button expand">Search</a></div>
          </div>
        </li>
      </ul>
      <!-- Right Nav Section -->
      <!-- Left Nav Section 
      <ul class="left">
        <li><a href="#">Left Nav Button</a></li>
      </ul>-->
    </section>
  </nav>
</header>';

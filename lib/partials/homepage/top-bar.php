<?php
$out = '<nav class="top-bar" data-topbar role="navigation"><ul class="title-area"><li class="name">';
$inside .= sprintf('<a href="/" title="%s" class="logo">%s</a>', esc_attr(get_bloginfo('name')), get_bloginfo('name'));
$out .= sprintf('<h1 class="site-title">%1$s</h1>', $inside);
//<a class="logo" href="/">lmseo</a></h1>
$out .= '</li>
<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
</ul>
<section class="top-bar-section">
	<ul class="primary-links">
		<li><a href="/team/">Team</a></li>
		<li class="has-dropdown"><a href="/shop/category/services/">Services</a>
			<ul class="dropdown">
				<li class="has-dropdown"><a href="/shop/category/services/marketing/">Marketing</a>
					<ul class= "dropdown">
						<li><a href="/shop/information-architecture/">Information Architecture</a></li>
						<li><a href="/shop/search-engine-optimization/">Search Engine Optimization</a></li>
						<li><a href="/shop/email/">Email Marketing</a></li>
						<li><a href="/shop/social-media/">Social Media</a></li>
						<li><a href="/shop/pay-per-click-and-media-buying/">Pay Per Click and Media Buying</a></li>
						<li><a href="/shop/press-releases/">Press Releases</a></li>
						<li><a href="/shop/website-performance-testing-and-optimization/">Website Performance Testing and Optimization</a></li>
						<li><a href="/shop/schema-markup-set-up-and-optimization/">Schema Markup Set up and Optimization</a></li>
					</ul>
				</li>
				<li class="has-dropdown"><a href="/shop/category/services/web-development/">Web Development</a>
        <ul class= "dropdown">
          <li class="has-dropdown"><a href="/shop/category/services/web-development/">Front-end Development</a>
            <ul class= "dropdown">
              <li><a href="/shop/web-design/">Web Design (UI/UX)</a></li>
              <li><a href="/shop/css3-html5-javascript/">CSS3, HTML5, Javascript and Javascript Frameworks</a></li>
              <li><a href="/shop/logo-and-business-cards/">Logo and Business Cards</a></li>
              <li><a href="/shop/email-and-white-paper/">Email and White Paper</a></li>
            </ul>
          </li>
          <li class="has-dropdown"><a href="/shop/category/services/web-development/back-end-development/">Back-end Development</a>
            <ul class= "dropdown"><li><a href="/shop/php-custom-applications/">PHP Custom Applications</a></li>
              <li><a href="/shop/content-management-system">Content Management System (Wordpress, Drupal)</a></li>
              <li class="has-dropdown"><a href="/shop/">Database Management</a>
                <ul class= "dropdown">
                  <li><a href="/shop/database-set-up/">Mysql, PostgreSQL, SQL Server or NoSQL Set up</a></li>
                  <li><a href="/shop/database-design/">Database Design</a></li>
                  <li><a href="/shop/database-testing-optimization/">Database Testing and Optimization</a></li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="has-dropdown"><a href="/shop/category/services/google-services/">Google Services</a>
        <ul class= "dropdown">
          <li><a href="/shop/google-analytics/">Google Analytics</a></li>
          <li><a href="/shop/adwords/">Adwords</a></li>
          <li><a href="/shop/google-merchant-center/">Google Merchant Center</a></li>
          <li><a href="/shop/google-my-business/">Google My Business</a></li>
          <li><a href="/shop/google-webmaster-tools/">Google Webmaster Tools</a></li>
          <li><a href="/shop/adsense/">Adsense</a></li>
          <li><a href="/shop/google-apis/">Google APIs and Tools</a></li>
        </ul>
      </li>
      <li class="has-dropdown"><a href="/shop/category/services/hosting/">Hosting</a>
        <ul class= "dropdown">
          <li><a href="/shop/hosting-set-up/">Virtual, Shared or Dedicated Hosting Setup</a></li>
          <li><a href="/shop/amazon-web-services-setup/">Amazon Web services Setup</a></li>
          <li><a href="/shop/local-development-environment-setup/">Local Development Environment Setup</a></li>
          <li><a href="/shop/managed-hosting/">Managed Hosting and Support</a></li>
          <li class="has-dropdown"><a href="/shop/category/services/hosting/ssl-certificates/">SSL Certificates</a>
            <ul class= "dropdown">
              <li><a href="/shop/standard-ssl/">Standard SSL Certificate</a></li>
              <li><a href="/shop/deluxe-ssl/">Deluxe SSL Certificate</a></li>
              <li><a href="/shop/premium-ssl/">Premium SSL Certificate</a></li>
            </ul>
          </li>
          <li><a href="/shop/content-delivery-network/">Content Delivery Network(CDN)</a></li>
        </ul>
      </li>
      <li class="has-dropdown"><a href="/shop/category/services/ecommerce/">Ecommerce</a>
        <ul class= "dropdown">
          <li><a href="/shop/ecommerce-store-set-up/">Ecommerce Store Set Up</a></li>
          <li><a href="/shop/google-merchant-center/">Google Merchant Center</a></li>
          <li><a href="/shop/structured-data-markup-testing-setup-and-optimization/">Structured Data Markup Testing, Set up and Optimization</a></li>
        </ul>
      </li>
			</ul>
		</li>
		<li><a href="/contact/">Contact</a></li>
		<li><a href="/blog/">Blog</a></li>
</ul> 
<ul class="right topbar-more-info-nav hide-for-col-md-down">
	<li><a href="tel:+18183966868">818.396.6868</a></li>
	<li class="has-form top-form"><div class="row collapse"><div class="col-lg-8 col-sm-9 columns"><input type="text" placeholder="Search LMSEO"></div><div class="col-lg-4 col-sm-3 columns"><a href="/" class="top-button expand">Search</a></div></div>
	</li>
</ul>
</section>
</nav>';

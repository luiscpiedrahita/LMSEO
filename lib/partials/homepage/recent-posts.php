<?php
$out .= '
<a class="anchor" id="recent-posts"></a>
<section class="recent-posts container-fluid overflow-hidden">
  <div class="">
    <div class="container recent-post-wrapper">
      <h1 class="recent-posts-title">Recent Posts</h1>
      <div class="recent-posts-content">
        <div class="recent-posts-list">
          <div class="rounded">
          <div class="row">
          ';
$the_query = new WP_Query('showposts=2');
$count = 0;
$fades = array(
  'fade-right',
  'fade-up',
  'fade-left'
);
while ($the_query->have_posts()) {
  $the_query->the_post();
  $out .= '<div class="col-sm-12 col-lg-4 columns" 
            data-aos="' . $fades[$count] . '"
            data-aos-offset="300">';
  $out .= '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>
     <hr>
     <p data-equalizer-watch>' .  wp_trim_words(get_the_content(), 100, '') . ' […]</p>
     <p class="entry-meta">
        By <span class="entry-author" itemprop="author" itemscope="itemscope" itemtype="https://schema.org/Person">
          <a href="' . get_author_posts_url(get_the_author_meta('ID')) . '" class="entry-author-link" itemprop="url" rel="author">
            <span class="entry-author-name" itemprop="name">
             ' . get_the_author() . '
            </span>
          </a>
        </span> 
        <time class="entry-time" itemprop="datePublished" datetime="' . get_the_date('c') . '">'
    . get_the_date() .
    '</time><!-- <div class="entry-comments-link">
          <a href="' . get_permalink() . '#respond">Leave a Comment</a>
        </div>-->';
  if (is_admin_bar_showing()) {
    $out .= '<a class="post-edit-link" href="' . get_edit_post_link() . '">(Edit)</a>';
  }
  //$out.='<p>'. get_the_excerpt(__('(more…)')).'</p>';

  $out .= '</p>

    </div>';
  $count++;
}

/*$out.='<h4>Post #1</h4><hr/>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit velit non voluptatum ut illum numquam inventore nulla quaerat maiores possimus, sint molestiae vitae voluptates tempora aut dolor fugit nisi unde autem debitis omnis laborum consequatur iusto ab! Veritatis, molestias, optio!Risus ligula, aliquam nec fermentum vitae, sollicitudin eget urna. Donec dignissim nibh fermentum odio ornare sagittis.
            </p>';*/
$out .= '</div>
        </div>
        </div>
      </div>
      <div class="col text-center mt-5  ">
        <a href="/blog/" class="home-button xlarge-button grey-button">More Posts</a>
      </div>
    </div>
   
  </div>
  </section>';

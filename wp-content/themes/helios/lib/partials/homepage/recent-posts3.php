<?php
$out .= '<a class="anchor" id="recent-posts"></a><section class="recent-posts">
  <div class="row" data-equalizer>
    <div class="col-lg-8 columns recent-post-wrapper" data-equalizer-watch>
      <h1 class="recent-posts-title">Recent Posts</h1>
      <div class="row  recent-posts-content">
        <div class="col-lg-12 columns recent-posts-list">
          <div class="radius">
          <div class="row">
          ';
$the_query = new WP_Query('showposts=2');

while ($the_query->have_posts()) {
  $the_query->the_post();
  $out .= '<div class="col-lg-6 col-sm-12 columns"><h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>
      <hr>
       <p class="entry-meta">
        <span class="entry-author" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
          <a href="' . get_author_posts_url(get_the_author_meta('ID')) . '" class="entry-author-link" itemprop="url" rel="author">
            <span class="entry-author-name" itemprop="name">
             ' . get_the_author() . '
            </span>
          </a>
        </span> 
        <time class="entry-time" itemprop="datePublished" datetime="' . get_the_date('c') . '">'
    . get_the_date() .
    '</time> <span class="entry-comments-link">
          <a href="' . get_permalink() . '#respond">Leave a Comment</a>
        </span>';
  if (is_admin_bar_showing()) {
    $out .= '<a class="post-edit-link" href="' . get_edit_post_link() . '">(Edit)</a>';
  }
  $out .= '</p>
      <p>' . get_the_excerpt(__('(more…)')) . '</p>
     
    </div>';
}

/*$out.='<h4>Post #1</h4><hr/>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit velit non voluptatum ut illum numquam inventore nulla quaerat maiores possimus, sint molestiae vitae voluptates tempora aut dolor fugit nisi unde autem debitis omnis laborum consequatur iusto ab! Veritatis, molestias, optio!Risus ligula, aliquam nec fermentum vitae, sollicitudin eget urna. Donec dignissim nibh fermentum odio ornare sagittis.
            </p>';*/
$out .= '</div>
        </div>
        </div>
      </div>
      <div class="col align-self-center">
        <a href="/services/" class="home-button recent-posts-button">More Posts</a>
      </div>
    </div>
    <div class="col-lg-4 columns comments" data-equalizer-watch>
          <h4>Recent Comments</h4><hr>
          <ul class="comment-list">';
$commments_defaults = array(
  'author_email' => '',
  'author__in' => '',
  'author__not_in' => '',
  'include_unapproved' => '',
  'fields' => '',
  'ID' => '',
  'comment__in' => '',
  'comment__not_in' => '',
  'karma' => '',
  'number' => '10',
  'offset' => '',
  'orderby' => '',
  'order' => 'DESC',
  'parent' => '',
  'post_author__in' => '',
  'post_author__not_in' => '',
  'post_ID' => '',
  'post_id' => 0,
  'post__in' => '',
  'post__not_in' => '',
  'post_author' => '',
  'post_name' => '',
  'post_parent' => '',
  'post_status' => '',
  'post_type' => '',
  'status' => 'approve',
  'type' => '',
  'user_id' => '',
  'search' => '',
  'count' => false,
  'meta_key' => '',
  'meta_value' => '',
  'meta_query' => '',
  'date_query' => null, // See WP_Date_Query
);
$comments = get_comments($commments_defaults);
foreach ($comments as $comment) {
  $out .= '<li><a href="' . get_comment_link($comment) . '">' . $comment->comment_content . '</a></li>';
}
$out .= '</ul>
    </div>
  </div>
  </section>';

<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<?php get_header(); ?>
<div id="page">
	<div class="article">
		<div id="content_box">
			<?php if (is_home() && !is_paged()) { ?>
				<?php if($mts_options['mts_featured_slider'] == '1') { ?>
					<div class="slider-container">
						<div class="flex-container loading">
							<div id="slider" class="flexslider">
								<ul class="slides">
                                    <?php if (empty($mts_options['mts_custom_slider'])) { ?>
    									<?php 
                                            // prevent implode error
                                            if (empty($mts_options['mts_featured_slider_cat']) || !is_array($mts_options['mts_featured_slider_cat'])) {
                                                $mts_options['mts_featured_slider_cat'] = array('0');
                                            }
                                            
                                            $slider_cat = implode(",", $mts_options['mts_featured_slider_cat']); $my_query = new WP_Query('cat='.$slider_cat.'&posts_per_page='.$mts_options['mts_featured_slider_num']);
    										while ($my_query->have_posts()) : $my_query->the_post();
                                        ?>
    									<li> 
    										<a href="<?php the_permalink() ?>">
    											<?php the_post_thumbnail('slider',array('title' => '')); ?>
    											<div class="flex-caption">
    												<h2 class="slidertitle"><?php the_title(); ?></h2>
    											</div>
    										</a> 
    									</li>
    									<?php endwhile; wp_reset_query(); ?>
                                    <?php } else { ?>
                                        <?php foreach($mts_options['mts_custom_slider'] as $slide) : ?>
                                            <li>
                                                <a href="<?php echo $slide['mts_custom_slider_link']; ?>">
    											<?php echo wp_get_attachment_image($slide['mts_custom_slider_image'], 'slider', false, array('title' => '')); ?>
    											<div class="flex-caption">
    												<h2 class="slidertitle"><?php echo $slide['mts_custom_slider_title']; ?></h2>
    											</div>
    										</a> 
    									</li>
                                        <?php endforeach; ?>
                                    <?php } ?>
								</ul>
							</div>
						</div>
					</div>
					<!-- slider-container -->
				<?php } ?>
			<?php } ?>
            
            <?php if (!is_paged()) { ?>
            <?php $featured_categories = array();
                if (!empty($mts_options['mts_featured_categories'])) {
                    foreach ($mts_options['mts_featured_categories'] as $section) {
                        $category_id = $section['mts_featured_category'];
                        $featured_categories[] = $category_id;
                        $posts_num = $section['mts_featured_category_postsnum'];
                        if ($category_id == 'latest') { ?>
            
            <?php $j = 0; if (have_posts()) : while (have_posts()) : the_post(); ?>
				<article class="latestPost excerpt  <?php echo (++$j % 3 == 0) ? 'last' : ''; ?>" itemscope itemtype="http://schema.org/BlogPosting">
					<header>
						<h2 class="title front-view-title" itemprop="headline"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
						<?php mts_the_postinfo(); ?>
					</header>
                    <?php if ( has_post_thumbnail() ) {
                        if($mts_options['mts_thumb_layout'] == 'large_home_thumb') {
                            $featured_thumb = 'featured';
                        } else {
                            $featured_thumb = 'widgetfull';
                        }
                    ?>
    					<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail" class="<?php echo $featured_thumb; ?>">
    					    <?php echo '<div class="featured-thumbnail">'; the_post_thumbnail($featured_thumb, array('title' => '')); echo '</div>'; ?>
                            <?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'latestPost-review-wrapper'); ?>                            
    					</a>
                    <?php } ?>
                    
                    <?php if (empty($mts_options['mts_full_posts'])) : ?>
    					<div class="front-view-content">
                            <?php echo mts_excerpt(40); ?>
    					</div>
					    <?php mts_readmore(); ?>
				    <?php else : ?>
                        <div class="front-view-content full-post">
                            <?php the_content(); ?>
                        </div>
                        <?php if (mts_post_has_moretag()) : ?>
                            <?php mts_readmore(); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </article><!--.post excerpt-->
			<?php endwhile; endif; ?>
			
            <!--Start Pagination-->
            <?php if (isset($mts_options['mts_pagenavigation_type']) && $mts_options['mts_pagenavigation_type'] == '1' ) { ?>
                <?php mts_pagination(); ?> 
			<?php } else { ?>
				<div class="pagination">
					<ul>
						<li class="nav-previous"><?php next_posts_link( __( '&larr; '.'Older posts', 'mythemeshop' ) ); ?></li>
						<li class="nav-next"><?php previous_posts_link( __( 'Newer posts'.' &rarr;', 'mythemeshop' ) ); ?></li>
					</ul>
				</div>
			<?php } ?>
			<!--End Pagination-->
            
            <?php } else { // if $category_id != 'latest': ?>
            <h3 class="featured-category-title"><a href="<?php echo esc_url( get_category_link($category_id) ); ?>" title="<?php echo esc_attr( get_cat_name($category_id) ); ?>"><?php echo get_cat_name($category_id); ?></a></h3>
            <?php $j = 0; $cat_query = new WP_Query('cat='.$category_id.'&posts_per_page='.$posts_num); if ($cat_query->have_posts()) : while ($cat_query->have_posts()) : $cat_query->the_post(); ?>
				<article class="latestPost excerpt  <?php echo (++$j % 3 == 0) ? 'last' : ''; ?>" itemscope itemtype="http://schema.org/BlogPosting">
					<header>
						<h2 class="title front-view-title" itemprop="headline"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
						<?php mts_the_postinfo(); ?>
					</header>
					<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail">
					    <?php echo '<div class="featured-thumbnail">'; the_post_thumbnail('featured',array('title' => '')); echo '</div>'; ?>
                        <?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'latestPost-review-wrapper'); ?>
					</a>
                    
                    <?php if (empty($mts_options['mts_full_posts'])) : ?>
    					<div class="front-view-content">
                            <?php echo mts_excerpt(29); ?>
    					</div>
					    <?php mts_readmore(); ?>
				    <?php else : ?>
                        <div class="front-view-content full-post">
                            <?php the_content(); ?>
                        </div>
                        <?php if (mts_post_has_moretag()) : ?>
                            <?php mts_readmore(); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </article><!--.post excerpt-->
			<?php endwhile; endif; wp_reset_query(); ?>
            
            <?php } } } ?>
            <?php } else { ?>
                <!-- Paged -->
			<?php $j = 0; if (have_posts()) : while (have_posts()) : the_post(); ?>
				<article class="latestPost excerpt  <?php echo (++$j % 3 == 0) ? 'last' : ''; ?>" itemscope itemtype="http://schema.org/BlogPosting">
					<header>
						<h2 class="title front-view-title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
						<?php mts_the_postinfo(); ?>
					</header>
					<?php if ( has_post_thumbnail() ) {
                        if($mts_options['mts_thumb_layout'] == 'large_home_thumb') {
                            $featured_thumb = 'featured';
                        } else {
                            $featured_thumb = 'widgetfull';
                        }
                    ?>
                        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail" class="<?php echo $featured_thumb; ?>">
                            <?php echo '<div class="featured-thumbnail">'; the_post_thumbnail($featured_thumb, array('title' => '')); echo '</div>'; ?>
                            <?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'latestPost-review-wrapper'); ?>                            
                        </a>
                    <?php } ?>
                    <?php if (empty($mts_options['mts_full_posts'])) : ?>
    					<div class="front-view-content">
                            <?php echo mts_excerpt(29); ?>
    					</div>
					    <?php mts_readmore(); ?>
				    <?php else : ?>
                        <div class="front-view-content full-post">
                            <?php the_content(); ?>
                        </div>
                        <?php if (mts_post_has_moretag()) : ?>
                            <?php mts_readmore(); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </article><!--.post excerpt-->
			<?php endwhile; endif; ?>
			
            <!--Start Pagination-->
            <?php if (isset($mts_options['mts_pagenavigation_type']) && $mts_options['mts_pagenavigation_type'] == '1' ) { ?>
                <?php mts_pagination(); ?> 
			<?php } else { ?>
				<div class="pagination">
					<ul>
						<li class="nav-previous"><?php next_posts_link( __( '&larr; '.'Older posts', 'mythemeshop' ) ); ?></li>
						<li class="nav-next"><?php previous_posts_link( __( 'Newer posts'.' &rarr;', 'mythemeshop' ) ); ?></li>
					</ul>
				</div>
			<?php } ?>
			<!--End Pagination-->
            <?php } ?>
		</div>
	</div>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>
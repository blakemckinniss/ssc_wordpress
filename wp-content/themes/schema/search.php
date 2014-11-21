<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<?php get_header(); ?>
<div id="page">
	<div class="article">
		<div id="content_box">
			<h1 class="postsby">
				<span><?php _e("Search Results for:", "mythemeshop"); ?></span> <?php the_search_query(); ?>
			</h1>
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
			<?php endwhile; else: ?>
				<div class="no-results">
					<h2><?php _e('We apologize for any inconvenience, please hit back on your browser or use the search form below.', 'mythemeshop'); ?></h2>
					<?php get_search_form(); ?>
				</div><!--noResults-->
			<?php endif; ?>

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
		</div>
	</div>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>
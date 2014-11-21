<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<?php 
      // default = 3
      $top_footer_num = (!empty($mts_options['mts_top_footer_num']) && $mts_options['mts_top_footer_num'] == 4) ? 4 : 3;
      $bottom_footer_num = (!empty($mts_options['mts_bottom_footer_num']) && $mts_options['mts_bottom_footer_num'] == 4) ? 4 : 3;
?>
	</div><!--#page-->
</div><!--.main-container-->
<footer class="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
    <?php if ($mts_options['mts_top_footer']) : ?>
		<div class="footer-widgets top-footer-widgets widgets-num-<?php echo $top_footer_num; ?>">
			<div class="container">
                <div class="f-widget f-widget-1">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-top') ) : ?><?php endif; ?>
				</div>
				<div class="f-widget f-widget-2">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-top-2') ) : ?><?php endif; ?>
				</div>
				<div class="f-widget f-widget-3 <?php echo ($top_footer_num == 3) ? 'last' : ''; ?>">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-top-3') ) : ?><?php endif; ?>
				</div>
                <?php if ($top_footer_num == 4) : ?>
                <div class="f-widget f-widget-4 last">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-top-4') ) : ?><?php endif; ?>
				</div>
                <?php endif; ?>
            </div>
		</div><!--.top-footer-widgets-->
    <?php endif; ?>
    <div class="copyrights">
        <div class="container">
			<?php mts_copyrights_credit(); ?>
		</div><!--.container-->
    </div>
</footer><!--footer-->
<?php mts_footer(); ?>
<?php wp_footer(); ?>
</div><!--.main-container-wrap-->
</body>
</html>
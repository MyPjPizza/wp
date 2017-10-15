<?php get_header(); ?>	
	<?php while (have_posts() ) : the_post(); ?>
		<style type="text/css">
			#ts-widgets-preview-wrapper {
				display: block;
				width: 100%;
				height: 100%;
				margin: 0;
				padding: 0;
				background: #ffffff;
			}
			#ts-widgets-preview-holder {
				display: block;
				width: 100%;
				margin: 0 auto;
				padding: 20px;
				background: #ffffff;
			}
			#ts-widgets-preview-title {
				display: block;
				margin: 0 0 20px 0;
				padding: 0;
				width: 100%;
				padding: 0 0 20px 0;
				border-bottom: 1px solid #ededed;
				text-align: center;
			}
			#ts-widgets-preview-switch {
				display: block;
				width: 80%;
				max-width: 1280px;
				margin: 0 auto 20px auto;
			}
			#ts-widgets-preview-switch #ts-widgets-preview-toggle {
				display: block;
				padding: 10px 10px;
				margin: 0 auto;
				cursor: pointer;
				text-align: center;
				border: 1px solid #cccccc;
				width: 30%;
				max-width: 360px;
				background: #f7f7f7;
				-webkit-transition: all 0.2s ease;
				-moz-transition: all 0.2s ease;
				transition: all 0.2s ease;
			}
			#ts-widgets-preview-switch #ts-widgets-preview-toggle:hover {
				background: #cccccc;
				color: #ffffff;
				border-color: #f7f7f7;
			}
			#ts-widgets-preview-message {
				display: block;
				width: 80%;
				max-width: 1280px;
				margin: 0 auto 20px auto;								
				text-align: justify;
				font-size: 14px;
				border-bottom: 1px solid #ededed;
				padding: 0 0 20px 0;	
			}
			#ts-widgets-preview-content {
				margin: 0 auto;
				padding: 0;		
			}
			#ts-widgets-preview-content.ts-widgets-preview-full {
				width: 80%;
				max-width: 1280px;
				border-top: 1px solid #ededed;
				padding: 20px 0 0 0;	
			}
			#ts-widgets-preview-content.ts-widgets-preview-sidebar {
				width: 30%;
				max-width: 360px;
			}
		</style>
		<script type="text/javascript">
			(function ($) {
				$(document).ready(function () {
					jQuery(document).on("click", '#ts-widgets-preview-toggle', function() {
						if (jQuery(this).attr("data-layout") == "sidebar") {
							jQuery(this).attr("data-layout", "full");
							jQuery(this).html(jQuery(this).attr("data-text-full"));
                            jQuery("#ts-widgets-preview-content").removeClass("ts-widgets-preview-sidebar").addClass("ts-widgets-preview-full");
							jQuery("#ts-widgets-preview-message").hide();
                        } else if (jQuery(this).attr("data-layout") == "full") {
							jQuery(this).attr("data-layout", "sidebar");
							jQuery(this).html(jQuery(this).attr("data-text-sidebar"));
							jQuery("#ts-widgets-preview-content").removeClass("ts-widgets-preview-full").addClass("ts-widgets-preview-sidebar");
							jQuery("#ts-widgets-preview-message").show();
						};
                        window.resizeBy(0,0);
                        jQuery(window).trigger("debouncedresize");
                        window.dispatchEvent(new Event('resize'));
					});
				})
			})(jQuery);
		</script>
		<div id="ts-widgets-preview-wrapper" class="ts-widgets-preview-wrapper">
			<div id="ts-widgets-preview-holder" class="ts-widgets-preview-holder">
				<div id="ts-widgets-preview-title" class="ts-widgets-preview-title">
					<h2><?php the_title(); ?></h2>
				</div>
				<div id="ts-widgets-preview-switch" class="ts-widgets-preview-switch">
					<div id="ts-widgets-preview-toggle" class="ts-widgets-preview-toggle" data-layout="sidebar" data-text-full="Switch to Sidebar View" data-text-sidebar="Switch to Full View">Switch to Full View</div>
				</div>
				<div id="ts-widgets-preview-message" class="ts-widgets-preview-message">
					<?php echo "This is an approximate rendering of a 'VC Templates' custom post type, using 30% of the available page width (or 360px maximum) to better emulate a sidebar. Depending upon your theme,
					the actual width of your sidebar might be more or less than that, but this should still give you a good idea as to how your widgets will look like. Not all theme styling usually applied
					to standard pages or posts will be applied to this custom post type."; ?>
				</div>
				<div id="ts-widgets-preview-content" class="ts-widgets-preview-content ts-widgets-preview-sidebar">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
<?php get_footer(); ?>
<?php //include get_stylesheet_directory() . '/single.php'; ?>
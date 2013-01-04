<?php
/*
Template Name: Add History
*/
?>

<?php get_header(); ?>

		<div id="primary">
			<div id="content" role="main">
				<div id="lamp-cont">
					<img id="lamp" src="/wp-content/images/content/lamp.png" />
				</div>

				<?php while ( have_posts() ) : the_post(); ?>

					<div id="oldbook-text-container">
						<img id="oldbook" class="hp" src="/wp-content/images/content/fullbook.png" />
						<div class="add-your-chapter">
							<div class="add-form-descr">
								Write your own chapter in the Book of Relations...
							</div>
							<div class="add-form-content">
								<?php echo do_shortcode('[wpuf_addpost redirect_after="/membership-options/dashboard/"]'); ?>
							</div>
						</div>
					</div>





<!-- 					<div id="add-post-form" class="form-descr-container">
						<div class="form-descr">
							Write your own chapter in the Book of Relations...
						</div>
						
						<?php echo do_shortcode('[wpuf_addpost redirect_after="/membership-options/dashboard/"]'); ?>
					</div>
					
					<div class="post-form-divider"></div>

					<div class="form-descr-container">
						<div class="form-descr">
							Submit your genealogy to Book of Relations ...
						</div>
						<?php echo do_shortcode('[contact-form-7 id="32" title="Add Your History"]') ?><br/>
						
					</div> -->
				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
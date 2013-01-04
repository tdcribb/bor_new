<?php
/*
Template Name: Edit Post
*/
?>

<?php get_header(); ?>

		<div id="primary">
			<div id="content" role="main">
				<div id="lamp-cont">
					<img id="lamp" src="/wp-content/images/content/lamp.png" />
				</div>

				<div id="oldbook-text-container">
						<img id="oldbook" class="hp" src="/wp-content/images/content/fullbook.png" />
						<div class="add-your-chapter">
							<div class="add-form-descr">
								Edit your own chapter in the Book of Relations...
							</div>
							<div class="add-form-content">
								<?php echo do_shortcode('[wpuf_edit]'); ?>
							</div>
						</div>
					</div>
					
					


			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
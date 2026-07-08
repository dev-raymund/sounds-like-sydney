<?php
/**
 * The site footer: widget columns + newsletter, then the bottom bar.
 *
 * @package SoundsLikeSydney2026
 */

?>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php
		get_template_part( 'template-parts/footer/footer-widgets' );
		get_template_part( 'template-parts/footer/footer-bottom' );
		?>
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>

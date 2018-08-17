</main>

<footer>

    <div class="content">


        <a href="<?php echo pll_home_url(); ?>" class="logo">
            <span class="txt">Yoann Gern</span>
            <span class="underline"></span>
        </a>

        <nav>

			<?php

			wp_nav_menu( array(
				'theme_location' => 'footer'
			) );

			?>
        </nav>
    </div>

    <ul class="social">
        <li class="instagram"><a target="_blank" href="https://www.instagram.com/yoann_gern/"></a></li>
        <li class="facebook"><a target="_blank" href="https://www.facebook.com/yoanngern"></a></li>
        <li class="twitter"><a target="_blank" href="https://twitter.com/YoannGern"></a></li>
    </ul>
</footer>

<?php wp_footer(); ?>


</body>
</html>

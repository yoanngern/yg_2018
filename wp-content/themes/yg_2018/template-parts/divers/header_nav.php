<header>


    <div class="content">


        <a href="<?php echo pll_home_url(); ?>" class="logo">
            <span class="txt">Yoann Gern</span>
            <span class="underline"></span>
        </a>

        <div id="burger">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>

        <nav>
			<?php

			wp_nav_menu( array(
				'theme_location' => 'principal'
			) );

			?>

			<?php
			$languages = pll_the_languages( array(
				'raw' => 1,
				//'hide_if_empty' => 0,
			) );

			if ( sizeof( $languages ) > 1 ) :?>
                <div id="language">

                    <a id="open_lang" href="<?php echo pll_home_url() ?>">
                        <span><?php echo pll_current_language( 'slug' ) ?></span>
                        <div class="arrow">
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <ul id="lang_switch">
						<?php

						foreach ( $languages as $lang ) :

							$class = '';

							if ( $lang['current_lang'] ) {
								$class .= ' selected';
							}

							$slug = $lang['slug'];
							$url  = $lang['url'];
							$name = $lang['name'];

							echo "<li class='$class'><a id='$slug' href='$url'>$name</a></li>";


						endforeach;

						?>
                    </ul>
                </div>
			<?php endif; ?>
        </nav>

    </div>


</header>

<nav class="mobile_nav">
	<?php

	wp_nav_menu( array(
		'theme_location' => 'footer'
	) );

	?>
</nav>
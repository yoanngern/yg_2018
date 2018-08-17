<?php


?>

<article class="section content-page">
    <div class="content">
        <div class="center">
			<?php if ( $title != null ): ?>
                <h1>
                    <span class="txt"><?php echo $title ?></span>
                    <span class="underline"></span>
                </h1>
			<?php endif; ?>
			<?php echo $content ?>

			<?php if ( $button != null ): ?>
                <a class="button" target="<?php echo $button['target'] ?>"
                   href="<?php echo $button['url'] ?>"><?php echo $button['title']; ?></a>
			<?php endif; ?>
        </div>
    </div>
	<?php if ( $image != null ): ?>
        <div class="image">
            <img src="<?php echo $image ?>" alt="">
            <div class="bg"></div>
        </div>
	<?php endif; ?>
</article>
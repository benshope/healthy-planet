<?php if (is_active_sidebar('footerleft') || is_active_sidebar('footerright')) : ?>
    <footer class="wrapper-footer row">
        <div class="main main-footer_sidebar">
            <div class="block-inner block-inner_first">
                <div class="row">
                    <?php dynamic_sidebar( 'footerleft' ); ?>
                </div>
            </div>
        </div>
        <div class="side side-footer_sidebar">
            <div class="block-inner block-inner_last">
                <?php dynamic_sidebar( 'footerright' ); ?>
            </div>
        </div>
    </footer>
<?php endif;
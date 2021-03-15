<?php $PopularCatImg1 = get_field('category_1_image');?>
<?php $PopularCatImg2 = get_field('category_2_image');?>
<?php $PopularCatImg3 = get_field('category_3_image');?>
<?php $PopularCatImg4 = get_field('category_4_image');?>



<section class="popular-categories">
    <h1><?php echo get_field('popular_products_title'); ?></h1>
    <span class="popular-categories__heading-underline"></span>
    <div class="container">
        <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 text-center">
                <a href="#" class="popular-categories__imgbg">
                    <img id="imgcat1" class="popular-categories__img" alt="<?php echo $PopularCatImg1['alt'] ?>" src="<?php echo $PopularCatImg1['url'] ?>">
                </a>
                <h5 class="popular-categories__title"><?php echo get_field('category_1_title'); ?></h5>
                <span class="popular-categories__heading-underline-sml"></span>
                <a id="cat1" class="btn popular-categories__btn-vcm" href="<?php echo get_field('category_1_link'); ?>"><?php echo get_field('category_1_button'); ?></a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 text-center">
                <a href="#" class="popular-categories__imgbg">
                <img id="imgcat2" class="popular-categories__img" alt="<?php echo $PopularCatImg2['alt'] ?>" src="<?php echo $PopularCatImg2['url'] ?>">
                </a>
                <h5 class="popular-categories__title"><?php echo get_field('category_2_title'); ?></h5>
                <span class="popular-categories__heading-underline-sml"></span>
                <a id="cat2" class="btn popular-categories__btn-vcm" href="<?php echo get_field('category_2_link'); ?>"><?php echo get_field('category_2_button'); ?></a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 text-center">
                <a href="#" class="popular-categories__imgbg">
                <img id="imgcat3" class="popular-categories__img" alt="<?php echo $PopularCatImg3['alt'] ?>" src="<?php echo $PopularCatImg3['url'] ?>">
                </a>
                <h5 class="popular-categories__title"><?php echo get_field('category_3_title'); ?></h5>
                <span class="popular-categories__heading-underline-sml"></span>
                <a id="cat3" class="btn popular-categories__btn-vcm" href="<?php echo get_field('category_3_link'); ?>"><?php echo get_field('category_3_button'); ?></a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 text-center">
                <a href="#" class="popular-categories__imgbg">
                <img id="imgcat4" class="popular-categories__img" alt="<?php echo $PopularCatImg4['alt'] ?>" src="<?php echo $PopularCatImg4['url'] ?>">
                </a>
                <h5 class="popular-categories__title"><?php echo get_field('category_4_title'); ?></h5>
                <span class="popular-categories__heading-underline-sml"></span>
                <a id="cat4" class="btn popular-categories__btn-vcm" href="<?php echo get_field('category_4_link'); ?>"><?php echo get_field('category_4_button'); ?></a>
            </div>

        </div>
    </div>
</section>
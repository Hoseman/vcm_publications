<?php $backgroundImg = get_field('carousel_image');?>

<div id="myCarousel" class="carousel-small slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                    <img src="<?php echo $backgroundImg['url'] ?>" alt="<?php echo $backgroundImg['alt'] ?>" class="carousel-item__image">
                    <div class="container">
                        <div class="carousel-caption text-center">
                            <h1><?php the_title(); ?></h1>
                        </div>
                    </div>
            </div>
        </div>
</div>
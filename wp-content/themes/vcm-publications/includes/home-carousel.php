<?php $backgroundImg = get_field('home_carousel_image');?>
<?php $backgroundImg2 = get_field('home_carousel_image_2');?>
<?php $backgroundImg3 = get_field('home_carousel_image_3');?>



<div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">

          <div class="carousel-item active">
            <img src="<?php echo $backgroundImg['url'] ?>" alt="<?php echo $backgroundImg['alt'] ?>" class="carousel-item__image">
            <div class="container">
              <div class="carousel-caption text-center">
                <h1><?php the_field('home_carousel_title') ?></h1>
                <p><?php the_field('home_carousel_subtitle') ?></p>
                <p><a class="btn btn-vcm" href="<?php the_field('home_carousel_button_url') ?>"><?php the_field('home_carousel_button') ?></a></p>
              </div>
            </div>
          </div>


          <div class="carousel-item">
            <img src="<?php echo $backgroundImg2['url'] ?>" alt="<?php echo $backgroundImg2['alt'] ?>" class="carousel-item__image">
            <div class="container">
              <div class="carousel-caption text-center">
                <h1><?php the_field('home_carousel_title_2') ?></h1>
                <p><?php the_field('home_carousel_subtitle_2') ?></p>
                <p><a class="btn btn-vcm" href="<?php the_field('home_carousel_button_url_2') ?>"><?php the_field('home_carousel_button_2') ?></a></p>
              </div>
            </div>
          </div>


          <div class="carousel-item">
            <img src="<?php echo $backgroundImg3['url'] ?>" alt="<?php echo $backgroundImg3['alt'] ?>" class="carousel-item__image">
            <div class="container">
              <div class="carousel-caption text-center">
                <h1><?php the_field('home_carousel_title_3') ?></h1>
                <p><?php the_field('home_carousel_subtitle_3') ?></p>
                <p><a class="btn btn-vcm" href="<?php the_field('home_carousel_button_url_3') ?>"><?php the_field('home_carousel_button_3') ?></a></p>
              </div>
            </div>
          </div>

        </div>

        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true">
            <i class="fas fa-chevron-left"></i>
          </span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true">
            <i class="fas fa-chevron-right"></i>
          </span>
        </a>
      </div>
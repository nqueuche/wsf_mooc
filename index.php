<?php get_header(); ?>
<div class="container">
        <div class="row">
            <div class="col-md-12">

            <a href="/quest-ce-que-cette-plateforme/">
                <div class="announcement">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mooc-img.png"  class="announcement__image"/>
                </div>
            </a>
            </div>


        </div>


    <div class="menu">
        <div class="container-fluid button-group">
            <div class="row">
                <?php
				$taxonomyTypes = get_object_taxonomies( 'course' );
				$fieldTypes = acf_get_fields_by_id( 21 );
				//retourne un array key => value des fields du groupe de champs "information"
				?>

                <?php if ( count( $taxonomyTypes ) > 0 ) : ?>
					<?php foreach ( $taxonomyTypes as $taxonomyType ) : ?>
						<?php $taxonomyTerms = get_terms( $taxonomyType ) ?>
                        <ul class="filters menu__list col-sm-4" data-filter-group="<?php echo $taxonomyType ?>">
                            <b class="menu__title"><?php echo ucwords(str_replace('_', ' ', $taxonomyType)); ?></b>
                            <li>
                                <button data-filter="" class="item menu__list__item selected">
                                    Tout
                                </button>
                            </li>

							<?php if ( count( $taxonomyTerms ) > 0 ) : ?>
								<?php foreach ( $taxonomyTerms as $taxonomyTerm ) : ?>

                                    <li>
                                        <button class="item menu__list__item"
                                                data-filter='.<?php echo $taxonomyTerm->slug ?>'>
											<?php echo $taxonomyTerm->name ?>
                                        </button>
                                    </li>

								<?php endforeach; ?>
							<?php endif; ?>

                        </ul>

					<?php endforeach; ?>
				<?php endif; ?>
            </div>
            <div class="row menu__details hidden">
				<?php if ( count( $fieldTypes ) > 0 ) : ?>
					<?php foreach ( $fieldTypes as $fieldType ) : ?>
						<?php $fieldTerms = $fieldType['choices'];?>
                        <ul class="filters menu__list col-sm-3" data-filter-group="<?php echo $fieldType['name'] ?>">
                            <b class="menu__title"><?php echo $fieldType['label'] ?></b>
                            <li>
                                <button data-filter="" class="item menu__list__item selected">
                                    Tout
                                </button>
                            </li>

							<?php foreach ( $fieldTerms as $fieldTerm ) : ?>
                                <li>
                                    <button class="item menu__list__item"
                                            data-filter='.<?php echo $fieldTerm ?>'>
										<?php echo $fieldTerm ?>
                                    </button>
                                </li>

							<?php endforeach; ?>

                        </ul>

					<?php endforeach; ?>
				<?php endif; ?>

            </div>
            <div class="menu__hook">&nbsp;</div>
        </div>
    </div>
</div>




<div class="container">
    <div class="col-sm-12 showcase__container">
		<?php $the_query = new WP_Query( array(
			'post_type' => 'course',
			'posts_per_page=-1'
		) ); ?>
		<?php if ( $the_query->have_posts() ) : ?>
        <div class="grid">
			<?php while ( $the_query->have_posts() ) : $the_query->the_post();
				$taxonomyTypes = get_object_taxonomies( $post );
				$fieldTypes = get_field_objects( $post );
				$postTerms = array();
				$postClass = "";

				?>
				<?php if ( count( $taxonomyTypes ) > 0 ) : ?>
					<?php foreach ( $taxonomyTypes as $taxonomyType ) : ?>
                        <?php $item = wp_get_post_terms($post->ID, $taxonomyType); ?>
                        <?php $item2 = $item[0]; ?>
						<?php array_push($postTerms, $item2->slug); ?>
					<?php endforeach; ?>
				<?php endif; ?>

				<?php if ( count( $fieldTypes ) > 0 ) : ?>
					<?php foreach ( $fieldTypes as $fieldType ) : ?>
						<?php array_push($postTerms, $fieldType["value"]); ?>

					<?php endforeach; ?>
				<?php endif; ?>

				<?php foreach ( $postTerms as $postTerm ) {
					$postClass .= $postTerm . " ";
				} ?>
                <div class="<?php echo $postClass; ?> item courses col-sm-3">
                    <div class="course card showcase__item showcase__colour center-block">
                        <div class="card-img-top">
							<?php if ( has_post_thumbnail() ) {
								the_post_thumbnail();
							} ?>
                        </div>
                        <div class="card-block">
                            <h4 class="card-title showcase__item__title">
                                <a href="<?php the_permalink() ?>">
									<?php the_title() ?>
                                </a>
                            </h4>
                            <div class="card-text showcase__item__description">
								<?php the_excerpt(); ?>
                            </div>
                        </div>
                    </div>
                </div><!-- end item -->
			<?php endwhile; ?>
			<?php endif; ?>
        </div> <!-- end isotope-list -->

    </div>
</div>

<?php get_footer(); ?>



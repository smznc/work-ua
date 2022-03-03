<?php
$block_id = ! empty( $block[ 'anchor' ] ) ? $block[ 'anchor' ] : $block[ 'id' ];

$class_list = 'wu-search';
! $block[ 'className' ] ?: $class_list .= ' ' . $block[ 'className' ];

$heading     = get_field( 'heading' );
$description = get_field( 'description' );
?>

<section class="<?php echo $class_list ?>" id="<?php echo $block_id ?>">
    <div class="container">
        <div class="wu-search__inner">
            <h1 class="wu-search__heading"><?php echo $heading ?></h1>
            <div class="wu-search__description"><?php echo $description ?></div>
            <form class="wu-search__form" action="/search" method="GET">
                <input class="wu-input wu-input--size-2 wu-search__input" type="text" name="job"
                       placeholder="<?php _e( 'Job', 'work-ua' ) ?>" required>
                <input class="wu-input wu-input--size-2 wu-search__input" type="text" name="city"
                       placeholder="<?php _e( 'City', 'work-ua' ) ?>" required>
                <button class="wu-button wu-button--fill wu-button--size-2 wu-search__submit"
                        type="submit"><?php _e( 'Search', 'work-ua' ) ?></button>
            </form>
        </div>
    </div>
</section>

<?php
$block_id = ! empty( $block[ 'anchor' ] ) ? $block[ 'anchor' ] : $block[ 'id' ];

$class_list = 'wu-give-the-job';
! $block[ 'className' ] ?: $class_list .= ' ' . $block[ 'className' ];

$heading     = get_field( 'heading' );
$description = get_field( 'description' );
?>

<section class="<?php echo $class_list ?>" id="<?php echo $block_id ?>">
    <div class="container">
        <div class="wu-give-the-job__inner">
            <h1 class="wu-give-the-job__heading"><?php echo $heading ?></h1>
            <p class="wu-give-the-job__description"><?php echo $description ?></p>

            <form class="wu-give-the-job__form" action="/">
                <div class="wu-give-the-job__row">
                    <div class="wu-give-the-job__col">
                        <label class="wu-give-the-job__label" for="title"><?php _e( 'Job Title', 'work-ua' ) ?></label>
                        <input class="wu-input wu-give-the-job__input" id="title" type="text" name="title" required>

                        <label class="wu-give-the-job__label"
                               for="description"><?php _e( 'Job Description', 'work-ua' ) ?></label>
                        <textarea class="wu-textarea wu-give-the-job__textarea" name="description" id="description"
                                  required></textarea>

                        <label class="wu-give-the-job__label"
                               for="workload"><?php _e( 'Workload', 'work-ua' ) ?></label>
                        <select class="wu-select wu-give-the-job__select" id="workload" type="text" name="workload" required>
                            <option value="full"><?php _e( 'Full time', 'work-ua' ) ?></option>
                            <option value="part"><?php _e( 'Part time', 'work-ua' ) ?></option>
                            <option value="additional"><?php _e( 'Additional', 'work-ua' ) ?></option>
                        </select>

                        <label class="wu-give-the-job__label"
                               for="contract-type"><?php _e( 'Contract type', 'work-ua' ) ?></label>
                        <select class="wu-select wu-give-the-job__select" id="contract-type" type="text" name="contract-type" required>
                            <option value="permanent"><?php _e( 'Permanent', 'work-ua' ) ?></option>
                            <option value="mandate"><?php _e( 'Mandate', 'work-ua' ) ?></option>
                            <option value="other"><?php _e( 'Other', 'work-ua' ) ?></option>
                        </select>

                        <label class="wu-give-the-job__label" for="location"><?php _e( 'Location', 'work-ua' ) ?></label>
                        <input class="wu-input wu-give-the-job__input" id="location" type="text" name="location" required>

                        <label class="wu-give-the-job__label" for="email"><?php _e( 'Email', 'work-ua' ) ?></label>
                        <input class="wu-input wu-give-the-job__input" id="email" type="text" name="email" required>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

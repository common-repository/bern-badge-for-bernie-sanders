<?php

/** @var \BernBadge\Badge $this */

/** @var \BernBadge\Badge[] $bern_badges */
$bern_badges = $this->get_bern_badges();

/** @var \BernBadge\Badge $my_badge */
$my_badge = $this->get_bern_badge();

?>

<div class='wrap'>

	<h2>
		Bern Badge <?php _e( 'Settings', 'bern-badge' ); ?>
	</h2>

	<form method="post" action="<?php echo 'options.php'; /* your move, PhpStorm! */ ?>" autocomplete="off" class="bern-badge-form">

		<?php

		settings_fields( 'bern_badge_settings' );
		do_settings_sections( 'bern_badge_settings' );

		?>

		<input type="hidden" name="bern_badge" id="bern_badge" value="<?php echo esc_attr( $my_badge->getName() ); ?>">

		<p>
			<label for="bern-badge-hide">
				<?php _e( 'Hide on Mobile', 'bern-badge' ); ?>:
			</label>
			<select id="bern-badge-hide" name="bern_badge_is_hidden_on_mobile">
				<option value="N">
					<?php _e( 'No', 'bern-badge' ); ?>
				</option>
				<option value="Y"<?php if ( $this->isHiddenOnMobile() ) { ?> selected<?php } ?>>
					<?php _e( 'Yes', 'bern-badge' ); ?>
				</option>
			</select>
			<?php submit_button(); ?>
		</p>

		<table class="form-table">
			<tr>
				<td>
					<label for="bern-badge-position">
						<?php _e( 'Position', 'bern-badge' ); ?>:
					</label>
					<select id="bern-badge-position">
						<?php foreach ( $this->get_positions() as $index => $position ) { ?>
							<option value="<?php echo $index; ?>"<?php if ( $index == $my_badge->getPosition() ) { ?> selected<?php } ?>>
								<?php echo $position; ?>
							</option>
						<?php } ?>
					</select>
				</td>
				<td>
					<label for="bern-badge-color">
						<?php _e( 'Color', 'bern-badge' ); ?>:
					</label>
					<select id="bern-badge-color">
						<?php foreach ( $this->get_colors() as $index => $color ) { ?>
							<option value="<?php echo $index; ?>"<?php if ( $index == $my_badge->getColor() ) { ?> selected<?php } ?>>
								<?php echo $color; ?>
							</option>
						<?php } ?>
					</select>
				</td>
				<td>
					<label for="bern-badge-language">
						<span style="color:red;">**</span>
						<?php _e( 'Language', 'bern-badge' ); ?>:
					</label>
					<select id="bern-badge-language">
						<?php foreach ( $this->get_languages() as $index => $language ) { ?>
							<option value="<?php echo $index; ?>"<?php if ( $index == $my_badge->getLanguage() ) { ?> selected<?php } ?>>
								<?php echo $language; ?>
							</option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<label for="bern-badge-language">
						<?php _e( 'Badges (click to choose)', 'bern-badge'); ?>:
					</label>
					<div class="bern-badge-container">

						<?php foreach ( $bern_badges as $bern_badge ) { ?>

							<div
								class="bern-badge<?php if ( $my_badge->getName() == $bern_badge->getName() ) { ?> selected<?php } ?>"
								data-position="<?php echo $bern_badge->getPosition(); ?>"
								data-color="<?php echo $bern_badge->getColor(); ?>"
								data-language="<?php echo $bern_badge->getLanguage(); ?>"
								data-name="<?php echo $bern_badge->getName(); ?>"
								style="background-image:url(<?php echo $bern_badge->getFileName(); ?>)"></div>

						<?php } ?>

					</div>
				</td>
			</tr>
		</table>

	</form>

	<p>
		<span style="color:red;">**</span>
		<?php _e( 'If you would like to help us translate this plugin, please', 'bern-badge' ); ?>
		<a href="http://spokanewp.com" target="_blank"><?php _e( 'contact us', 'bern-bage' ); ?></a>!
	</p>

</div>
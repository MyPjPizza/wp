<?php $rand = rand( 100000, 999999 ); ?>
<div class="pum-age-form-fields">
	<?php if ( ! $atts['disable_date_input'] ) : ?>
		<div class="pum-date-input">
			<div class="pum-field pum-field-date pum-field-birthdate">
				<?php if ( ! $atts['disable_labels'] ) : ?>
					<label for="pum_avm_age_birthdate_<?php echo $rand; ?>"><?php esc_html_e( $atts['label_birthdate'] ); ?></label>
				<?php endif; ?>
				<input type="date" name="birthdate" id="pum_avm_age_birthdate_<?php echo $rand; ?>" required/>
			</div>
		</div>
	<?php endif; ?>

	<div class="pum-date-input-fallback">
		<div class="pum-field pum-field-select pum-field-age_month age-month">
			<?php if ( ! $atts['disable_labels'] ) : ?>
				<label for="pum_avm_age_month_<?php echo $rand; ?>"><?php esc_html_e( $atts['label_month'] ); ?></label>
			<?php endif; ?>
			<select id="pum_avm_age_month_<?php echo $rand; ?>" name="birth_month" class='age-verify-month' required>
				<?php foreach ( range( 1, 12 ) as $month ) : ?>
					<option value='<?php echo $month; ?>'><?php echo $month; ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="pum-field pum-field-select pum-field-age_day age-day">
			<?php if ( ! $atts['disable_labels'] ) : ?>
				<label for="pum_avm_age_day_<?php echo $rand; ?>"><?php esc_html_e( $atts['label_day'] ); ?></label>
			<?php endif; ?>
			<select id="pum_avm_age_day_<?php echo $rand; ?>" name="birth_day" class='age-verify-day' required>
				<?php foreach ( range( 1, 31 ) as $day ) : ?>
					<option value='<?php echo $day; ?>'><?php echo $day; ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="pum-field pum-field-select pum-field-age_year age-year">
			<?php if ( ! $atts['disable_labels'] ) : ?>
				<label for="pum_avm_age_year_<?php echo $rand; ?>"><?php esc_html_e( $atts['label_year'] ); ?></label>
			<?php endif; ?>
			<select id="pum_avm_age_year_<?php echo $rand; ?>" name="birth_year" class='age-verify-year' required><?php
				$current_year = date( 'Y', strtotime( '-1 year' ) );
				foreach ( range( 1901, date( 'Y', strtotime( '-1 year' ) ) ) as $year ) : ?>
					<option value='<?php echo $year; ?>' <?php selected( $year, $current_year ); ?>><?php echo $year; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
</div>
<div class="pum-field pum-field-button age-verify">
	<button type="button" class="pum-age-button pum-age-button-enter age-enter" aria-label="<?php esc_attr_e( $atts['label_enter'] ); ?>"><?php esc_attr_e( $atts['label_enter'] ); ?></button>
</div>

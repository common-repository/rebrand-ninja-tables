<div class="ntp-wl-settings-header">
	<?php if( is_plugin_active(BZNTP_NINJAPRO_PLUGIN_FILE) ) {?>
	<h3>Rebrand NinjaTables Pro </h3>
	<?php 
		} else { ?>
			<h3>Rebrand NinjaTables </h3>
		<?php }
	?>
</div>
<div class="ntp-wl-settings-wlms">

	<div class="ntp-wl-settings">
		<form method="post" id="form" enctype="multipart/form-data">

			<?php wp_nonce_field( 'ntp_wl_nonce', 'ntp_wl_nonce' ); ?>

			<div class="ntp-wl-setting-tabs-content">

				<div id="ntp-wl-branding" class="ntp-wl-setting-tab-content active">
					<h3 class="bzntp-section-title"><?php esc_html_e('Branding', 'bzntp'); ?></h3>
					<p><?php esc_html_e('You can white label the plugin as per your requirement.', 'bzntp'); ?></p>
					<table class="form-table ntp-wl-fields">
						<tbody>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="ntp_wl_plugin_name"><?php esc_html_e('Plugin Name', 'bzntp'); ?></label>
								</th>
								<td>
									<input id="ntp_wl_plugin_name" name="ntp_wl_plugin_name" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_name']); ?>" placeholder="" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="ntp_wl_plugin_desc"><?php esc_html_e('Plugin Description', 'bzntp'); ?></label>
								</th>
								<td>
									<input id="ntp_wl_plugin_desc" name="ntp_wl_plugin_desc" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_desc']); ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="ntp_wl_plugin_author"><?php esc_html_e('Developer / Agency', 'bzntp'); ?></label>
								</th>
								<td>
									<input id="ntp_wl_plugin_author" name="ntp_wl_plugin_author" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_author']); ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="ntp_wl_plugin_uri"><?php esc_html_e('Website URL', 'bzntp'); ?></label>
								</th>
								<td>
									<input id="ntp_wl_plugin_uri" name="ntp_wl_plugin_uri" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_uri']); ?>"/>
								</td>
							</tr>							
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="ntp_menu_icon"><?php esc_html_e('Menu Icon', 'bzntp'); ?></label>
								</th>
								<td>
									<input class="regular-text" name="ntp_menu_icon" id="ntp_menu_icon" type="text" value="" disabled />
									<input class="button dashicons-picker" type="button" value="Choose Icon" data-target="#ntp_menu_icon" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
						
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="ntp_wl_hide_help_menu"><?php echo esc_html_e('Hide Help Menu & Tab', 'bzntp'); ?></label>
							</th>
							<td>
								<input id="ntp_wl_hide_help_menu" name="ntp_wl_hide_help_menu" type="checkbox" class="" value="on" disabled />
								<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
							</td>
						</tr>
							
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="ntp_wl_hide_tools_menu"><?php echo esc_html_e('Hide Tools Menu & Tab', 'bzntp'); ?></label>
							</th>
							<td>
								<input id="ntp_wl_hide_tools_menu" name="ntp_wl_hide_tools_menu" type="checkbox" class="" value="on" disabled />
								<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
							</td>
						</tr>
							
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="ntp_wl_hide_footer_text"><?php echo esc_html_e('Hide Footer text', 'bzntp'); ?></label>
							</th>
							<td>
								<input id="ntp_wl_hide_footer_text" name="ntp_wl_hide_footer_text" type="checkbox" class="" value="on" disabled />
								<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
							</td>
						</tr>
		
					<?php 
						if( is_plugin_active(BZNTP_NINJAPRO_PLUGIN_FILE) ) {
						} else { ?>
						
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="ntp_wl_hide_footer_text"><?php echo esc_html_e('Hide Go Pro Menu', 'bzntp'); ?></label>
							</th>
							<td>
								<input id="ntp_wl_hide_pro_menu" name="ntp_wl_hide_pro_menu" type="checkbox" class="" value="on" disabled />
								<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
							</td>
						</tr>
						
					<?php }	?>
						
						</tbody>
					</table>
				</div>
				
				<div class="ntp-wl-setting-footer">
					<p class="submit">
						<input type="submit" name="ntp_submit" id="ntp_save_branding" class="button button-primary bzntp-save-button" value="<?php esc_html_e('Save Settings', 'bzntp'); ?>" />
					</p>
				</div>
				
			</div>
		</form>
	</div>
</div>

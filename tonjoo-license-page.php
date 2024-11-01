<?php

/**
 * Default options values
 */
function tonjoo_plugin_sample_load_default(&$options)
{
	if(!isset($options['license_key'])){
		$options['license_key']="";
	}

	return $options;
}

/**
 * Save options
 */
if($_POST)
{
	/**
	 * Tonjoo License
	 */
	if(class_exists('TonjooPluginLicenseSIMPLE_ADS'))
	{
		$PluginLicense = new TonjooPluginLicenseSIMPLE_ADS($_POST['tonjoo_simple_ads']['license_key']);
		$_POST = $PluginLicense->license_on_save($_POST);
	}

	/**
	 * Update options
	 */
	update_option('tonjoo_simple_ads', $_POST['tonjoo_simple_ads']);
	
	/**
	 * Redirect
	 */
	$location = $PluginLicense->data['admin_url'] . '&settings-updated=true';
	echo "<meta http-equiv='refresh' content='0;url=$location' />";
	echo "<h2>Loading...</h2>";
	exit();
}

$options = get_option('tonjoo_simple_ads'); 

tonjoo_plugin_sample_load_default($options);
?>

<style type="text/css">
	#license_status input {
		width: 200px;
	}

	table {
		width: 100%;
		padding-top: 10px;
	}

	th {
		font-weight: normal;
		text-align: left;
		width: 170px;
		padding-bottom: 20px;
	}
</style>

<div class="wrap">
	<?php echo "<h2>License For " . TONJOO_SIMPLE_ADS_TITLE . "</h2>"; ?>
	<p>
		<?php 
			_e('Register your license code here to get all benefit of ' . TONJOO_SIMPLE_ADS_TITLE . '. ',TONJOO_SIMPLE_ADS);
			_e('<br/><b>Remove Ads</b> by register your license code. ',TONJOO_SIMPLE_ADS);
			_e('<br/>Find your license code at ',TONJOO_SIMPLE_ADS);
		?>		
		<a href="https://tonjoostudio.com/manage/plugin" target="_blank">https://tonjoostudio.com/manage/plugin</a>
	</p>
	<hr />

	<form method="post" action="">
		<?php
		/** 
		 * license status 
		 */	
		$license = isset($options['license_status']) ? unserialize($options['license_status']) : false;	

		$license_status = "<span style='color:red'>Unregistered</span>";
		$license_email = "<span style='color:red'>None</span>";
		$license_date = "<span style='color:red'>Not checked</span>";
		$license_site = "<span style='color:red'>None</span>";

		if($license)
		{
			// status
			if($license['status'])
			{
				$license_status = "<span style='color:blue'>";
				$license_status.= __('Registered',TONJOO_SIMPLE_ADS);
				$license_status.= "</span>";
			} else {
				$license_status = "<span style='color:red'>";
				$license_status.= __($license['message'],TONJOO_SIMPLE_ADS);
				$license_status.= "</span>";
			}

			// email
			if(isset($license['email']) && $license['email'] != 'false')
			{
				$license_email = "<span style='font-weight:bold'>{$license['email']}</span>";
			}
			else
			{
				$license_email = "<span style='color:red'>none</span>";
			}

			// date
			if(isset($license['date']) && $license['date'])
			{
				$license_date = $license['date'];
			}
			else
			{
				$license_date = "<span style='color:red'>not checked</span>";
			}

			// site
			if(isset($license['site']) && is_array($license['site']))
			{
				foreach ($license['site'] as $key => $value) 
				{
					$pos = strpos(home_url(), $value);

					if($pos !== false)
					{
						$license_site = $value;

						break;
					}
				}
			}

			// end license if true
		}
		?>

		<table>

		<tr valign="top" id="license_status">
			<th scope="row">Your License Code</th>
			<td style="width: 300px;" colspan="2">
				<input type="password" name="tonjoo_simple_ads[license_key]" value="<?php echo $options['license_key'] ?>" style="width:300px;">
				<input type="submit" name="save_status_license" class="button-primary" value="Register / Check Status" />
			</td>
		</tr>

		<tr valign="top" id="license_status">
			<th scope="row">Last Checked</th>
			<td style="width: 300px;" colspan="2">
				<?php echo $license_date ?>
			</td>
		</tr>

		<tr valign="top" id="license_status">
			<th scope="row">Last Status</th>
			<td style="width: 300px;" colspan="2">
				<?php echo $license_status ?>
			</td>
		</tr>

		<?php if($license['status']): ?>
		<tr valign="top" id="license_status">
			<th scope="row">Licensed To</th>
			<td style="width: 300px;" colspan="2">
				<?php echo $license_email ?>
			</td>
		</tr>

		<tr valign="top" id="license_status">
			<th scope="row">Registered Sites</th>
			<td style="width: 300px;" colspan="2">
				<?php echo $license_site ?>
			</td>
		</tr>

		<tr valign="top" id="license_status">
			<th scope="row" colspan="3">
				<input type="submit" name="unset_license" class="button" value="Unregister this site" />
			</th>
		</tr>
		<?php endif ?>

		</table>
	</form>
</div>

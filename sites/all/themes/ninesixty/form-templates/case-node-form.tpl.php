<?php 
	drupal_add_js("sites/all/themes/ninesixty/js/forms/case-form-manipulation.js");
        drupal_add_js("sites/all/themes/ninesixty/js/forms/click-limiter.js");
	drupal_add_css("sites/all/themes/ninesixty/styles/forms/forms.css");
	global $user;
	$url_arr = explode('/', $_SERVER['REDIRECT_URL']);
	if(strstr($_SERVER['REDIRECT_URL'], 'add'))$prefix = ucfirst($url_arr[2]);
	else $prefix = ucfirst($url_arr[3]);
?>
<form action="<?php print $form['#action']; ?>" method="post"></form>
<div class="clear-block"></div>
<div class="case-node-form  grid-16">
	<div class="add-label"><h6><?php print $prefix.' Case'; ?></h6></div>
	<div class="left-form-container grid-7 alpha">
		<div id="case-details-form-left">
			
			<div class="case-title left-case">
				<?php 
				unset($vars['form']['title']['#printed']);
				$form['title']['#size']=36;
				print drupal_render($form['title']); ?>
				<div class="form-clear" ></div>
			</div>
			<div class="case-app left-case">
				<?php print drupal_render($form['field_case_applicant_name']); ?>
				<div class="form-clear" ></div>
			</div>
			
			<div class="case-date left-case">	
            
				<?php
        jquery_ui_add( 'ui.datepicker' );				 
				print drupal_render($form['field_case_date']); ?>
				<div class="form-clear" ></div>
			</div>
			<div class="case-staff left-case">
				<?php print drupal_render($form['field_user']); ?>
				<div class="form-clear" ></div>
			</div>
			
			<div class="case-reason left-case">	
				<?php print drupal_render($form['taxonomy'][7]); ?>
				<div class="form-clear" ></div>
			</div>
			<div class="case-reason left-case">	
				<?php print drupal_render($form['taxonomy'][3]); ?>
				<div class="form-clear" ></div>
			</div>
			<div class="case-staus left-case">
				<?php $code=drupal_render($form['taxonomy']['2']);
				print $code; ?>
				<div class="form-clear" ></div>
			</div>
			<div class="case-contact left-case">	
				<?php print drupal_render($form['field_case_contact_details']); ?>
				<div class="form-clear" ></div>
			</div>
			<div class="case-gmap left-case">	
				<?php print drupal_render($form['field_map_ref']); ?>
				<div class="form-clear" ></div>
			</div>
			
			<div class="case-resources">
				<?php print drupal_render($form['field_allocated_resources']); ?>
				<div class="form-clear" ></div>
			</div>
			<div class="case-plan-of-action">	
				<?php print drupal_render($form['field_plan_of_action']); ?>
				<div class="form-clear" ></div>
			</div>
			
			<div class="case-staus ">
				<?php 
			$grps = drupal_render($form['og_nodeapi']);
			if(sizeof($user->og_groups)>1){
				print $grps;
			}

?>
			</div>
		</div>
	</div>
		
			
			
		
		
	
	<div class="right-form-container grid-8 omega">
		<div id="case-details-form-right">
			<div class="case-description">
				<?php print drupal_render($form['body_field']); ?>
			</div>
			
		</div>
		<div id="processing-form-right">
			
		</div>
	</div>

</div>
<div class="report-field alpha grid-16">
	<div id="report-field">
		<?php print drupal_render($form['field_report']); ?>
	</div>
</div>

<div class="hide-field alpha grid-16" style="display:none;">
	<?php /* assign the buttons to a variable */
$buttons = drupal_render($form['buttons']);

/* print the rest of the form, which will be without buttons because we have already 'printed'
* them when assigning them to the variable, and print the variable right after
* the rest of the form
*/
print drupal_render($form);
?>
</div>
<div class="report-field alpha grid-16">
<?php
print $buttons;
?>

</div>


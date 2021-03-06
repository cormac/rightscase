<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
/**
 * add the javascript required to switch between processing and report
 */
//dpm()

drupal_add_js($directory."/js/case-display/case-display-switcher.js");
?>

<div id="case-details-container">
	
	<!-- information for left hand side-->
	<div id="left-case-details-case" class="left-case-details grid-7">
		
		<!-- Date of intervention -->
		<div class="left-case-field-wrapper grid-7 alpha omega">
			<div class = "case-details-label grid-3 alpha ">
				<?php print t($fields['field_case_date_value']->label); ?> : 
			</div>
			<div class = "case-details-text grid-4  omega">
				<?php	print $fields['field_case_date_value']->content; ?>
			</div>
		</div>
		<!-- Reason for intervention -->
		<div class="left-case-field-wrapper grid-7 alpha omega">
			<div class = "case-details-label grid-3 alpha ">
				<?php	print $fields['tid_2']->label; ?> :
			</div>
			<div class = "case-details-text grid-4  omega">
				<?php	print $fields['tid_2']->content; ?>
			</div>
		</div>
		<!-- Assigned Staff -->
		<div class="left-case-field-wrapper grid-7 alpha omega">
			<div class = "case-details-label grid-3 alpha ">
				<?php print $fields['field_user_uid']->label; ?> : 
			</div>
			<div class = "case-details-text grid-4  omega">
				<?php	print $fields['field_user_uid']->content; ?>
			</div>
		</div>
		<!-- Case Name -->
		<div class="left-case-field-wrapper grid-7 alpha omega">
			<div class = "case-details-label grid-3 alpha ">
				<?php	print $fields['title']->label; ?>
			</div>
			<div class = "case-details-text grid-4  omega">
				<?php	print $fields['title']->content; ?>
			</div>
		</div>
		<!-- Case Status -->
		<div class="left-case-field-wrapper grid-7 alpha omega">
			<div class = "case-details-label grid-3 alpha ">
				<?php	print $fields['tid_1']->label; ?> :
			</div>
			<div class = "case-details-text grid-4  omega">
				<?php	print $fields['tid_1']->content; ?>
			</div>
		</div>
		<!-- Location 
		<div class="left-case-field-wrapper grid-7 alpha omega">
			<div class = "case-details-label grid-3 alpha ">
				<?php print $fields['tid']->label ?>
			</div>
			<div class = "case-details-text grid-4  omega">
				<?php	print $fields['tid']->content; ?>
			</div>
		</div>
		<!-- Applicant name -->
		<div class="left-case-field-wrapper grid-7 alpha omega">
			<div class = "case-details-label grid-3 alpha ">
				<?php print $fields['field_case_applicant_name_value']->label ?>
			</div>
			<div class = "case-details-text grid-4  omega">
				<?php	print $fields['field_case_applicant_name_value']->content; ?>
			</div>
		</div>
		
		<!-- Applicant contact_details -->
		<div class = "case-textarea-label plan grid-7 alpha omega">
			<?php print t('Applicant ') . $fields['field_case_contact_details_value']->label; ?>
		</div>
		<div class = "case-textarea-small-content plan-content grid-7 alpha ">
			<?php print $fields['field_case_contact_details_value']->content; ?>
		</div>
		
		
		
		
		
	</div>
	<!-- information for right hand side-->
	<div id="right-case-details-case" class="grid-8 omega right-case-details">
		<div class="clear-block"></div>
		<div class = "case-textarea-label grid-8">
			<?php print $fields['body']->label; ?>
		</div>
		<div class = "case-textarea-small-content grid-8">
			<?php print $fields['body']->content; ?>
		</div>
		
		<div class = "case-textarea-label plan grid-8">
			<?php print $fields['field_plan_of_action_value']->label; ?>
		</div>
		<div class = "case-textarea-small-content plan-content grid-8">
			<?php print $fields['field_plan_of_action_value']->content; ?>
		</div>
	
		<div class = "case-textarea-label resources grid-8">
			<?php print $fields['field_allocated_resources_value']->label; ?>
		</div>
		<div class = "case-textarea-small-content grid-8">
			<?php print $fields['field_allocated_resources_value']->content; ?>
		</div>
	
	
	</div>
	<div id="right-internal-case" class="grid-8 right-case-details">
		<div class="clear-block"></div>
		<div class = "case-textarea-label grid-8">
			<?php print $fields['field_allocated_resources_value']->label; ?>
		</div>
		<div class = "case-textarea-small-content grid-8">
			<?php print $fields['field_allocated_resources_value']->content; ?>
		</div>
	</div>
	<div id="right-report-case" class="grid-8  right-case-details">
		
		<div class = "case-textarea-label grid-8">
			<?php print $fields['field_report_value']->label; ?>
		</div>
		<div class = "case-textarea-large-content grid-8">
			<?php print $fields['field_report_value']->content; ?>
		</div>
	</div>
	
</div>

<div class = "case-details-footer grid-16">
	<div class = "edit-button-spacer grid-7 omega"></div>
	<div class="case-button-holder grid-8">
		<div class = "edit-button  omega edit">
			<?php 
				$out = $fields['edit_node']->content;
				if(strstr($_SERVER['REQUEST_URI'], 'report')){
					
					$out = str_replace( t('Edit Case') , t('Edit Report'), $out); 
				}
				print $out;
			?>
		</div>
		
		<div class="edit-button add">
				
					<?php if(!strstr($_SERVER['REQUEST_URI'], report)):?>
						<a href="/node/add/case">
							<?=t('Add Case'); ?>
						</a>
					<?php endif;?>
				
			</div>
		<div class="edit-button ">
				<a href="/print<?php print $_SERVER['REDIRECT_URL']; ?>" target="_blank">
					<?=t('Printer View'); ?>
				</a>
			</div>
	</div>
</div>
<div class="clear-block"></div>

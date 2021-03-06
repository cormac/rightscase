<?php

drupal_add_js("sites/all/themes/ninesixty/js/button.js");
// $Id: template.php,v 1.1.2.3 2009/07/18 17:48:55 dvessel Exp $


/**
 * Preprocessor for page.tpl.php template file.
 */
function ninesixty_preprocess_page(&$vars, $hook)
{
  // For easy printing of variables.
  //dprint_r("<!--".$vars."-->");
  $vars['logo_img'] = $vars['logo'] ? theme('image', substr($vars['logo'], strlen(base_path())), t('Home'), t('Home'))
    : '';
  $vars['linked_logo_img'] = $vars['logo_img']
    ? l($vars['logo_img'], '<front>', array('attributes' => array('rel' => 'home'), 'title' => t('Home'), 'html' => TRUE))
    : '';
  $vars['linked_site_name'] = $vars['site_name']
    ? l($vars['site_name'], '<front>', array('attributes' => array('rel' => 'home'), 'title' => t('Home'))) : '';
  $vars['main_menu_links'] = theme('links', $vars['primary_links'], array('class' => 'links main-menu'));
  $vars['secondary_menu_links'] = theme('links', $vars['secondary_links'], array('class' => 'links secondary-menu'));

  // Make sure framework styles are placed above all others.
  $vars['css_alt'] = ninesixty_css_reorder($vars['css']);
  $vars['styles'] = drupal_get_css($vars['css_alt']);
  
  // $vars['styles'] .= '<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/ninesixty/styles/ui-lightness/jquery-ui-1.8.12.custom.css" />';

  /*
  if (arg(0) == 'node') {
    $node = node_load(arg(1));
    if($node->type == 'violation') {
      // dprint_r($vars);
      $scripts = $vars['scripts'];
      dprint_r($scripts);
      $control = 'C';
      $not_wanted = array(
        '<script type="text/javascript" src="/sites/all/modules/jquery_ui/jquery.ui/ui/minified/ui.core.min.js?'.$control.'"></script>',
        '<script type="text/javascript" src="/sites/all/modules/jquery_ui/jquery.ui/ui/minified/effects.core.min.js?'.$control.'"></script>',
        '<script type="text/javascript" src="/sites/all/modules/jquery_ui/jquery.ui/ui/minified/effects.drop.min.js?'.$control.'"></script>',
        '<script type="text/javascript" src="/sites/all/modules/jquery_ui/jquery.ui/ui/minified/ui.datepicker.min.js?'.$control.'"></script>',
      );
      $scripts = str_replace($not_wanted, '', $scripts);
      $scripts .= '<script type="text/javascript" src="/sites/all/themes/ninesixty/js/jquery-ui-1.8.12.custom.min.js"></script>';
      dprint_r($scripts); 
      $vars['scripts'] = $scripts; 
    }
  }
  */

  if (arg(0) == 'node') {
    $node = node_load(arg(1));
    if($node->type == 'violation') {
      // dprint_r('>>>>>>>>>>>>>>>>>>>>>>> variable scripts <<<<<<<<<<<<<<<<<<<<<<<<<<<');
      // dprint_r($variables['scripts']);
      $scripts = drupal_add_js();
      // dprint_r('>>>>>>>>>>>>>>>>>>>>>>>>>>>>> scripts <<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
      // dprint_r($scripts);
      if ( !empty($variables['scripts']) ) {
        $path = drupal_get_path('module', 'jquery_ui');
        unset($scripts['module'][$path . '/jquery.ui/ui/minified/ui.core.min.js']);
        unset($scripts['module'][$path . '/jquery.ui/ui/minified/effects.core.min.js']);
        unset($scripts['module'][$path . '/jquery.ui/ui/minified/effects.drop.min.js']);
        unset($scripts['module'][$path . '/jquery.ui/ui/minified/ui.datepicker.min.js']);
        // $scripts['theme']["/sites/all/themes/ninesixty/js/jquery-ui-1.8.12.custom.min.js"];
        dprint_r('>>>>>>>>>>>>>>>>>>>>>>>>>> scripts <<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
        dprint_r($scripts);
        $variables['scripts'] = drupal_get_js('header', $scripts);
        dprint_r('>>>>>>>>>>>>>>>>>>>>>>>>>>>>> variables scripts <<<<<<<<<<<<<<<<<<<<<<<');
        dprint_r($variables['scripts']);
        // $variables['scripts'] = $scripts;
      }
    }
  }
  
  if(drupal_is_front_page){
    $vars['scripts'] .= '<script type="text/javascript" src="/sites/all/themes/ninesixty/js/AC_OETags.js"></script>';
    $vars['scripts'] .= '<script type="text/javascript" src="/sites/all/themes/ninesixty/js/flash-check.js"></script>';

    // $vars['scripts'] .= '<script type="text/javascript" src="/sites/all/themes/ninesixty/js/jquery-ui-1.8.12.custom.min.js"></script>';

  }
  $vars['scripts'] .= '<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>';  
}

function ninesixty_preprocess_case_node_form(&$vars) {
  drupal_add_css( drupal_get_path('module', 'jquery_ui') . '/jquery.ui/themes/base/jquery-ui.css' );
}

function ninesixty_preprocess_violation_node_form(&$vars){
  $markers = array();
  if (isset($vars['form']['field_markers'][0]["#value"]['value'])) {
    $markers = @unserialize($vars['form']['field_markers'][0]["#value"]['value']);
    if (!is_array($markers)) {
      $markers = array();
    }
  }

  if (isset($_GET['destination'])) {
    list(,$case_id,) = explode('/', $_GET['destination']);
    if ((int) $case_id > 0) {
      $vars['form']['field_case']['nid']['nid']['#value'] = $case_id;
    }
  }
  //jquery_ui_add( 'ui.datepicker' );
//  drupal_add_js('sites/all/themes/ninesixty/js/jquery-ui-1.8.12.custom.min.js', 'theme');
 
  $data['data'] = array(
    'markers' => $markers,
  );
  drupal_add_js($data, 'setting');
  // drupal_add_js('sites/all/themes/ninesixty/js/jquery.autocomplete.js', 'theme');
  drupal_add_js('sites/all/themes/ninesixty/js/violations.map.js', 'theme');
  
   // drupal_add_css( drupal_get_path('module', 'jquery_ui') . '/jquery.ui/themes/base/jquery-ui.css' );

  // $vars['data'] 
}

/**
 * Contextually adds 960 Grid System classes.
 *
 * The first parameter passed is the *default class*. All other parameters must
 * be set in pairs like so: "$variable, 3". The variable can be anything available
 * within a template file and the integer is the width set for the adjacent box
 * containing that variable.
 *
 *  class="<?php print ns('grid-16', $var_a, 6); ?>"
 *
 * If $var_a contains data, the next parameter (integer) will be subtracted from
 * the default class. See the README.txt file.
 */
function ns()
{
  $args = func_get_args();
  $default = array_shift($args);
  // Get the type of class, i.e., 'grid', 'pull', 'push', etc.
  // Also get the default unit for the type to be procesed and returned.
  list($type, $return_unit) = explode('-', $default);

  // Process the conditions.
  $flip_states = array('var' => 'int', 'int' => 'var');
  $state = 'var';
  foreach ($args as $arg) {
    if ($state == 'var') {
      $var_state = !empty($arg);
    }
    elseif ($var_state) {
      $return_unit = $return_unit - $arg;
    }
    $state = $flip_states[$state];
  }

  $output = '';
  // Anything below a value of 1 is not needed.
  if ($return_unit > 0) {
    $output = $type . '-' . $return_unit;
  }
  return $output;
}

/**
 * This rearranges how the style sheets are included so the framework styles
 * are included first.
 *
 * Sub-themes can override the framework styles when it contains css files with
 * the same name as a framework style. This can be removed once Drupal supports
 * weighted styles.
 */
function ninesixty_css_reorder($css)
{
  global $theme_info, $base_theme_info;

  // Dig into the framework .info data.
  $framework = !empty($base_theme_info) ? $base_theme_info[0]->info : $theme_info->info;

  // Pull framework styles from the themes .info file and place them above all stylesheets.
  if (isset($framework['stylesheets'])) {
    foreach ($framework['stylesheets'] as $media => $styles_from_960) {
      // Setup framework group.
      if (isset($css[$media])) {
        $css[$media] = array_merge(array('framework' => array()), $css[$media]);
      }
      else {
        $css[$media]['framework'] = array();
      }
      foreach ($styles_from_960 as $style_from_960) {
        // Force framework styles to come first.
        if (strpos($style_from_960, 'framework') !== FALSE) {
          $framework_shift = $style_from_960;
          $remove_styles = array($style_from_960);
          // Handle styles that may be overridden from sub-themes.
          foreach ($css[$media]['theme'] as $style_from_var => $preprocess) {
            if ($style_from_960 != $style_from_var && basename($style_from_960) == basename($style_from_var)) {
              $framework_shift = $style_from_var;
              $remove_styles[] = $style_from_var;
              break;
            }
          }
          $css[$media]['framework'][$framework_shift] = TRUE;
          foreach ($remove_styles as $remove_style) {
            unset($css[$media]['theme'][$remove_style]);
          }
        }
      }
    }
  }

  return $css;
}

function ninesixty_date_all_day($field, $which, $date1, $date2, $format, $node, $view = NULL)
{

  return substr($node->node_data_field_case_date_field_case_date_value, 0, 10);
}


/*function ninesixty_preprocess_views_exposed_form(&$vars, $hook){
	$vars['form']['title']['#size'] = 30;
	$vars['form']['body']['#size'] = 30;
	$vars['form']['field_actor_name_value']['#size'] = 30;
	$vars['form']['submit']['#value'] = "Refine Search";
	
	unset($vars['form']['title']['#printed']);
	unset($vars['form']['body']['#printed']);
	unset($vars['form']['field_actor_name_value']['#printed']);
	unset($vars['form']['submit']['#printed']);
	
	
    $vars['widgets']['filter-title']->widget = drupal_render($vars['form']['title']);
	$vars['widgets']['filter-body']->widget = drupal_render($vars['form']['body']);
	$vars['widgets']['filter-field_actor_name_value']->widget = drupal_render($vars['form']['field_actor_name_value']);
	$vars['button'] = drupal_render($vars['form']['submit']);
	
	
}*/
/*************************************************** CASE FILE FORMATTING ************************************************/

function ninesixty_filefield_item($file)
{
  global $row_flag;
  $myfile = $file;
  $node = node_load($file['nid']);
  $type = str_ireplace('application/', '', $file['filemime']);
  $size = intval($file['filesize'] / 1000);
  $description = "" . $file['data']['description'];
  if ($size) {
    if (!$row_flag) {
      $tr_class = "odd";
      $row_flag = TRUE;
    }
    else {
      $tr_class = "even";
      $row_flag = FALSE;
    }
    $output =
      '<tr class="' . $tr_class . '">
		<td>' . $node->field_actor_name[0]['value'] . '</td>
		<td><a href="/system/files/' . $file['filename'] . '" class="actor-link" >' . $file['filename'] . '</a></td>
		<td>' . $type . '</td>
		<td>' . $size . 'k</td>
		<td>' . $description . '</td>
		<!--<td><a href="/system/files/' . $file['filename'] . '" target="_blank">Download</a></td>-->
	</tr>';
  }
  return $output;
}

/*************************************************************************************************************************/

/************************************************** INPUT FORM FORMATTING ************************************************/

function ninesixty_theme()
{
  return array(
    'case_node_form' => array(
      'arguments' => array('form' => NULL),
      'template' => 'form-templates/case-node-form',
    ),
    'actor_node_form' => array(
      'arguments' => array('form' => NULL),
      'template' => 'form-templates/actor-node-form',
    ),
    'violation_node_form' => array(
      'arguments' => array('form' => NULL),
      'template' => 'form-templates/violation-node-form',
    ),
    'debaser2_reports_statistics_form' => array(
      'arguments' => array('form' => NULL),
      'template' => 'form-templates/statistics-form',
    ),
    'statistics_form' => array(
      'arguments' => array('form' => NULL),
      'template' => 'form-templates/statistics-form',
    ),
    'correlative_statistics_form' => array(
      'arguments' => array('form' => NULL),
      'template' => 'form-templates/correlative-statistics-form',
    ),
    'debaser2_reports_victims_violations_filter_form' => array(
      'arguments' => array('form' => NULL),
      'template' => 'form-templates/victims-violations-filter-form',
    ),

  );
}

/**
 * search form theming
 * @param object $vars
 * @param object $hook
 * @return
 */

function ninesixty_preprocess_search_theme_form(&$vars, $hook)
{

  // Modify elements of the search form
  $vars['form']['search_theme_form']['#title'] = t('');

  // Set a default value for the search box
  $vars['form']['search_theme_form']['#value'] = t('Search this Site');

  // Add a custom class to the search box
  $vars['form']['search_theme_form']['#attributes'] = array('class' => 'NormalTextBox txtSearch',
                                                            'onfocus' => "if (this.value == 'Search this Site') {this.value = '';}",
                                                            'onblur' => "if (this.value == '') {this.value = 'Search this Site';}");

  // Change the text on the submit button
  //$vars['form']['submit']['#value'] = t('Go');

  // Rebuild the rendered version (search form only, rest remains unchanged)
  unset($vars['form']['search_theme_form']['#printed']);
  $vars['search']['search_theme_form'] = drupal_render($vars['form']['search_theme_form']);

  $vars['form']['submit']['#type'] = 'image_button';
  $vars['form']['submit']['#src'] = path_to_theme() . '/images/search.jpg';
  $vars['form']['submit']['#attributes'] = array(
    'style' => 'display:none;');
  // Rebuild the rendered version (submit button, rest remains unchanged)
  unset($vars['form']['submit']['#printed']);
  $vars['search']['submit'] = drupal_render($vars['form']['submit']);

  // Collect all form elements to make it easier to print the whole form.
  $vars['search_form'] = implode($vars['search']);
}

/*************************************************************************************************************************/
function ninesixty_preprocess_date_views_filter_form(&$vars)
{
  $form = $vars['form'];
  /*$form['min']['date']['#attributes'] = array(
  'class'=>'grid-3');*/

  $vars['date'] = drupal_render($form['value']);
  unset($vars['mindate']);
  unset($vars['maxdate']);

  $vars['mindate'] = drupal_render($form['min']);

  $vars['maxdate'] = drupal_render($form['max']);

  $vars['description'] = drupal_render($form['description']) . drupal_render($form);
}

/*
function ninesixty_date_views_filter_form(&$form){
  $form=NULL;
  $form['min']['date']['#attributes'] = array(
  'class'=>'grid-3');
  $form['mindate'] = "nuts";
}

function ninesixty_preprocess_actor_node_form(&$vars) {


}*/


/*************************************************************************************************************************/


function phptemplate_preprocess(&$vars, $hook)
{
  switch ($hook) {
    case 'page':
      // Add a content-type page template in second to last.
      if ('node' == arg(0)) {
        $node_template = array_pop($vars['template_files']);
        $vars['template_files'][] = 'page-' . $vars['node']->type;
        $vars['template_files'][] = $node_template;
      }
      break;
  }
  return $vars;
}


/**
 * Return a themed set of links.
 *
 * @param $links
 *   A keyed array of links to be themed.
 * @param $attributes
 *   A keyed array of attributes
 * @return
 *   A string containing an unordered list of links.
 */
function ninesixty_links($links, $attributes = array('class' => 'links'))
{
  global $language;
  $output = '';
  $classes = array('one', 'two', 'three', 'four', 'five');
  if (count($links) > 0) {
    $output = '<!-- menu--><ul' . drupal_attributes($attributes) . '>';

    $num_links = count($links);
    $i = 1;

    foreach ($links as $key => $link) {
      $class = $key . ' ' . $classes[$i - 1];

      // Add first, last and active classes to the list of links to help out themers.
      if ($i == 1) {
        $class .= ' first';
      }
      if ($i == $num_links) {
        $class .= ' last';
      }
      if (isset($link['href']) && ($link['href'] == $_GET['q'] || ($link['href'] == '<front>' && drupal_is_front_page()))
          && (empty($link['language']) || $link['language']->language == $language->language)
      ) {
        $class .= ' active';
      }
      $output .= '<li' . drupal_attributes(array('class' => $class)) . '>';

      if (isset($link['href'])) {
        // Pass in $link as $options, they share the same keys.
        $output .= l($link['title'], $link['href'], $link);
      }
      else if (!empty($link['title'])) {
        // Some links are actually not links, but we wrap these in <span> for adding title and class attributes
        if (empty($link['html'])) {
          $link['title'] = check_plain($link['title']);
        }
        $span_attributes = '';
        if (isset($link['attributes'])) {
          $span_attributes = drupal_attributes($link['attributes']);
        }
        $output .= '<span' . $span_attributes . '>' . $link['title'] . '</span>';
      }

      $i++;
      $output .= "</li>\n";
    }

    $output .= '</ul>';
  }

  return $output;
}

function ninesixty_menu_item_link($link)
{
  if (empty($link['localized_options'])) {
    $link['localized_options'] = array();
  }
  return '<a href="' . base_path() . $link['href'] . '"><span></span>' . $link['title'] . '</a>';

  return l($link['title'], $link['href'], $link['localized_options']);
}

function ninesixty_menu_local_tasks()
{
  $output = '';
  $node = new stdClass();
  if (arg(0) == 'node' && is_numeric(arg(1))) {
    $node = node_load(arg(1));
  }
  if (in_array($node->type, array('case', 'violation', 'actor'))) {
    return;
  }
  if ($primary = menu_primary_local_tasks()) {
    $output .= '<div id="primary-tab-wrapper" class="container-16 clear-block">
					<div id="primary-tab-container" >
						<div class="prmary-tabs-inner-wrapper" >
							<div class="primary_tabs  grid-11">
								<ul class="tabs primary">' . $primary . '</ul>
							</div>
						</div>
						<div class="grid-5 omega case-name"><h6>' . get_case_name_from_id() . '</h6></div>
					</div>';
  }
  if ($secondary = menu_secondary_local_tasks()) {
    $output .= '<div id="secondary-tab-wrapper" class=" alpha omega grid-16 clear-block">
						<div class="secondary_tabs ">
							<div class="grid-4"></div>
								<div class = "grid-12">
								<ul class="tabs secondary">' . $secondary . '</ul>
								</div>
						</div>
					</div>';
  }
  $output .= "</div>";

  return $output;
}

function get_case_name_from_id()
{
  $url = $_GET['q'];
  $tok = strtok($url, '/');
  $id = strtok('/');
  if ($id) {
    $node = node_load($id);
    if ($node->type == 'case') return t('Case') . ': ' . $node->title;
  }
}

/********************************* ACTOR THEMING **************************************************************/

function ninesixty_preprocess_views_cycle(&$vars, $hook)
{

  // Some nice aliases to make the code easier to read.
  $view = $vars['view'];
  $options = $view->style_plugin->options;
  $handler = $view->style_plugin;
  $fields = &$view->field;

  $rows = $vars['rows'];

  // Generate a unique ID for this cycle instance that we can pass to JS.
  $vars['cycle_id'] = 'views-cycle-' . $view->name . '-' . $view->style_plugin->display->id;

  // The $settings array is passed forward to Javascript to inform the code how
  // to build the cycle slideshow.  We'll convert this to full Drupal.settings
  // format below.
  $settings = array(
    'params' => $options['params'],
  );

  // Javascript, or at least the cycle plugin, gets very cranky if you pass it
  // a string version of a number.  We therefore have to force all numeric
  // values to actually be numeric data types so that they are passed as such
  // to Javascript.  Fortunately we know that all of the numeric values that
  // cycle takes are integers.
  foreach ($settings['params'] as $key => $value) {
    if (is_numeric($value)) {
      $settings['params'][$key] = (int)$value;
    }
  }

  // If there are thumbnails, we need to build that list as well as fully rendered
  // HTML and pass it to Javascript.  Technically the JS needs to "generate" the
  // HTML for the thumbnails for the cycle plugin to work, but we'll pre-theme
  // that server side and then just look it up on demand in the browser.
  if ($options['thumbnail_field']) {
    foreach ($view->result as $num => $row) {
      $label = $view->field[$options['thumbnail_field']]->theme($row);
      if ($hook != 'views_cycle__case_violations') {
        if (strlen($label) > 9) $label = substr($label, 0, 20) . "...";
      }
      $settings['thumbnails'][$num] = $label;
    }
    $settings['params']['pager'] = '#' . $vars['cycle_id'] . '-nav';
    $settings['use_pager_callback'] = 1;
    $settings['params']['pagerEvent'] = $options['pager']['event'];
  }

  // Enqueue any stylesheets set for the skin on this view are added.
  drupal_add_css(drupal_get_path('module', 'views_cycle') . '/views_cycle.css');
  $skin_path = drupal_get_path('module', $options['skin_info']['module']);
  if ($options['skin_info']['path']) {
    $skin_path .= '/' . $options['skin_info']['path'];
  }
  foreach ($options['skin_info']['stylesheets'] as $stylesheet) {
    drupal_add_css($skin_path . '/' . $stylesheet);
  }

  // If this is an AHAH request, we have to forward the updated thumbnail
  // thumbnail information manually.  We assume that jQuery, the cycle plugin,
  // and so forth are already on the page so we don't add them again.
  if (isset($_GET['pager_element'])) {
    $thumbnails = drupal_to_js($settings['thumbnails']);

    // I'm pretty sure that Drupal.settings will not exist at all if this is called
    // via an AHAH request, but just to be on the safe side we'll go through the
    // process of checking each level.  Why can't Javascript just be like PHP
    // and lazy create all down the line?  *sigh*
    $vars['js_settings'] = <<<JS
<script type="text/javascript">
  <!--//--><![CDATA[//><!--
    if (!Drupal) {
      var Drupal = {};
    }
    if (!Drupal.settings) {
      Drupal.settings = {};
    }
    if (!Drupal.settings.views_cycle) {
      Drupal.settings.views_cycle = {};
    }
    if (!Drupal.settings.views_cycle['{$vars['cycle_id']}']) {
      Drupal.settings.views_cycle['{$vars['cycle_id']}'] = {};
    }
    Drupal.settings.views_cycle['{$vars['cycle_id']}'].thumbnails = {$thumbnails};
  //--><!]]>
</script>

JS;
  }
  else {
    // For a normal page request, we need to pass data through the normal Drupal
    // Javascript handling routines.

    // Set up the necessary JS.
    drupal_add_js(drupal_get_path('module', 'views_cycle') . '/jquery.cycle.js', 'module', 'footer');
    drupal_add_js(drupal_get_path('module', 'views_cycle') . '/views_cycle.js', 'module', 'footer');

    // Key the settings for each instance of the cycle plugin by its cycle id.
    drupal_add_js(array('views_cycle' => array($vars['cycle_id'] => $settings)), 'setting', 'footer');
  }
}

function ninesixty_defield_formatter_filetable($filetable)
{
  $flag = false;

  $output = '<div id="actor-file-display"  class = "">';

  foreach ($filetable as $key => $row) {
    if (is_array($row)) {

      $output .= '<a href="/system/files/' . $row['#item']['filename'] . '" >' . $row['#item']['filename'] . '</a><br>';
      if ($row['#item']['filename'] != NULL) $flag = true;
    }
  }
  $output .= '</div>';
  return $output;
  if ($flag) return $output;
  else return "";
}

function ninesixty_get_last_edited_by( $nid ){
  $update_author_uid = db_result(db_query('SELECT nr.uid FROM {node_revisions} nr INNER JOIN {node} n ON n.vid = nr.vid WHERE n.nid = %d', $nid));
  $update_author = '';
  $update_author_output = '';
  if ($update_author_uid == '0') { // Check if author is anonymous
    $update_author_output = variable_get('anonymous', 'Anonymous');
  }
  else {
    $update_author = user_load(array('uid' => $update_author_uid));
    $update_author_output = $update_author->name;
  }
  return $update_author_output;
}


function ninesixty_preprocess(&$variables, $hook)
{

}


<?php
/*
Plugin Name: Techtunes Widget
Plugin URI: http://bdweblab.com/plugins/techtunes-widget/
Description: Customizable widget which displays the latest technology tune from Techtunes.com.bd
Version: 1.0
Author: Cx Rana
Author URI: http://bdweblab.com/about-us
*/
/*
	GNU General Public License version 3

	Copyright (c) 2012 Cx Rana

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
function ttcx()
{
  $options = get_option("widget_ttcx");
  if (!is_array($options)){
    $options = array(
      'title' => 'Techtunes Widget',
      'tune' => '5',
      'chars' => '30'
    );
  }

  // RSS Feed 
  $rss = simplexml_load_file( 
  'http://techtunes.com.bd/feed'); 
  // RSS Feed 
  $rss1 = simplexml_load_file( 
  'http://www.techtunes.com.bd/category/featured/feed'); 
  ?> 
  
  <ul> 
  
  <?php 
  // max number of tune slots, with 0 (zero) all display
  $max_tune = $options['tune'];
  // maximum length to which a title may be reduced if necessary,
  $max_length = $options['chars'];
  
  // RSS Elements 
  $cnt = 0;
  foreach($rss->channel->item as $i) { 
    if($max_tune > 0 AND $cnt >= $max_tune){
        break;
    }
    
	?> 
   
    <li>
    <?php
    // Title
    $title = $i->title;
    // Length of title
    $length = strlen($title);
    // if the title is longer than the previously defined maximum length,
    // it'll he shortened and "..." added, or it'll output normaly
    if($length > $max_length){
      $title = substr($title, 0, 455)."..."; 
	  
    }
    
	?>
	
   <a href="<?=$i->link?>"><?=$title?></a> </span>

	</li> 
    <?php 
    $cnt++;
  } 
  ?> 	
<ul>
  
  <?php 
  // max number of tune slots, with 0 (zero) all display
  $max_tune = $options['tune'];
  // maximum length to which a title may be reduced if necessary,
  $max_length = $options['chars'];
  
  // RSS Elements 
  $cnt = 0;
  foreach($rss1->channel->item as $i) { 
    if($max_tune > 1 AND $cnt >= 1){
        break;
    }
    ?> 
    
    <li>
    <?php
    // Title
    $title = $i->title;
    // Length of title
    $length = strlen($title);
    // if the title is longer than the previously defined maximum length,
    // it'll he shortened and "..." added, or it'll output normaly
    if($length > $max_length){
      $title = substr($title, 0, 455)."...";
    
	}
    ?>
	
   <a href="<?=$i->link?>"><?=$title?><span style="color: #008000;">(নির্বাচিত টিউন,<?php the_time('M d Y'); ?>)</span></a> 
<p style="text-align: right;"><img src="http://bdweblab.com/wp-content/uploads/2012/05/tt-widget.png" alt="" /></p>

	</li> 

    <?php 
    $cnt++;
  } 
  ?> 
 <?php  
}

function widget_ttcx($args)
{
  extract($args);
  
  $options = get_option("widget_ttcx");
  if (!is_array($options)){
    $options = array(
      'title' => 'Techtunes Widget',
      'tune' => '5',
      'chars' => '30'
    );
  }
  
  echo $before_widget;
  echo $before_title;
  echo $options['title'];
  echo $after_title;
  ttcx();
  echo $after_widget;
}

function ttcx_control()
{
  $options = get_option("widget_ttcx");
  if (!is_array($options)){
    $options = array(
      'title' => 'Techtunes Widget',
      'tune' => '5',
      'chars' => '30'
    );
  }
  
  if($_POST['ttcx-Submit'])
  {
    $options['title'] = htmlspecialchars($_POST['ttcx-Widgettcxitle']);
    $options['tune'] = htmlspecialchars($_POST['ttcx-tuneCount']);
    $options['chars'] = htmlspecialchars($_POST['ttcx-CharCount']);
    update_option("widget_ttcx", $options);
  }
?> 
  <p>
    <p style="text-align: center;"><em><span style="color: #ff0000;">D</span>eveloped <span style="color: #000000;">by <span style="color: #008000;">C</span>x R</span>an<span style="color: #000000;">a</span></em></p>
	</br>
	<label for="ttcx-Widgettcxitle">Widget Title: </label>
    <input type="text" id="ttcx-Widgettcxitle" name="ttcx-Widgettcxitle" value="<?php echo $options['title'];?>" />
    <br /><br />
    <label for="ttcx-tuneCount">Max. Tune: </label>
    <input type="text" id="ttcx-tuneCount" name="ttcx-tuneCount" value="<?php echo $options['tune'];?>" />
    <br /><br />
    <label for="ttcx-CharCount">Max. Characters: </label>
    <input type="text" id="ttcx-CharCount" name="ttcx-CharCount" value="<?php echo $options['chars'];?>" />
    <br /><br />
    <input type="hidden" id="ttcx-Submit"  name="ttcx-Submit" value="1" />
  </p>
  
<?php
}

function ttcx_init()
{
  register_sidebar_widget(__('Techtunes Widget'), 'widget_ttcx');    
  register_widget_control('Techtunes Widget', 'ttcx_control', 300, 200);
}
add_action("plugins_loaded", "ttcx_init");
?>
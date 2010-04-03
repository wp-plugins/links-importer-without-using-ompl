<?php

/*
Plugin Name: Simple Links Importer
Description: A links importer for all the blogs.
Version: 1.1
Author: Leebird
Plugin URI: http://wordpress.org/extend/plugins/links-importer-without-using-ompl/
Author URI: http://misland.org
*/
	
class LinksImporter	
	{	
		function header() 
		{
			echo '<div class="wrap">';
			screen_icon();
			echo '<h2>'.__('Import Links Online').'</h2><br />';
		}

		function footer() 
		{
			echo '</div>';
		}
		
		function greet()
		{	
			if($_POST["site"]=='') 
			{	
				echo 'Hi, this tool can help you to copy your links from your old blog online. <br \><br \>'.
				     'Please input the URL <b>(including "http://")</b> <br \><br \>'.
					 'The filter will do some optimization of the obtained list. <br \>'.
					 'If you are not sure, just untick the option and get the entire list.<br \><br \>';
				echo '<form action="admin.php?import=links_import_online&amp;step=1" method="post">'.
					 'URL: <input type="text" name="site" size="50"><br \><br \>'.
					 'Links Filter: '.
					 '<input type="checkbox" name="filter" value="filter"><br \><br \>'.
					 '<input type="submit" value="get links"/>'.
					 '</form>';	
			}
			//------test block------
			//echo $_POST["site"];	
			//----------------------
		}
		
		function get_links()
		{	
			
			$url = $_POST["site"];
			if ((stripos($url,'http://')) === false)
			{
				echo 'Please add "http://" before the domain name.';
				exit;
			}
			
			$filter = $_POST["filter"];
			$contents = file_get_contents($url); 
			//iconv("utf-8", "ansi",$contents); 
			$pattern_for_all_links="'href\=[\"|\']http\:\/\/(.+?)<\/a>'";
			$pattern_for_one_link="'href=[\'|\"](.+?)[\'|\"]'";
			$pattern_for_link_name="'[\'|\"]>(.+?)<\/a>'";
			$pattern_for_self_filter_front="'http\:\/\/(.+?)\.'";
			$pattern_for_self_filter_back ="'[^\/]\/[^\/](.+)'";

			preg_match($pattern_for_self_filter_front,$url,$domain_1);
			preg_match($pattern_for_self_filter_back,$url,$domain_2);


			if ($domain_2[1] != '')
				$domain = $domain_2[1];
			else
				$domain = $domain_1[1];
			
			preg_match_all($pattern_for_all_links,$contents,$array);

			$links_num = count($array,1)/2;
			$links_count = 0;
			$links_real_count=0;
			echo 'Please select the links you need: <br /><br /><form action="admin.php?import=links_import_online&amp;step=2" method="post">';
			foreach ($array as $links)
			{
				foreach ($links as $link)
				{	if ($links_count < $links_num)
					{	
						if ((strpos($link,$domain)) && ($filter=='filter'))
						{	
							$links_count++;
							continue;
						}
						else
						{
						preg_match($pattern_for_one_link,$link,$site);
						preg_match($pattern_for_link_name,$link,$name);
						if ($site[1] | $name[1])
						{
						$site_array[$links_real_count] = $site[1];
						$name_array[$links_real_count] = $name[1];
						
						echo '<input type="checkbox" name="'.
							 $links_real_count.
							 '" value="'.
							 $links_real_count.
							 '" checked="checked" />'.
							 $name_array[$links_real_count].
							 '&nbsp;&nbsp;&nbsp;&nbsp;'.
							 $site_array[$links_real_count].
							 '<br \>';
						$links_real_count++;
						}
						}
					$links_count++;
					}
					else
						break;
				}
			}

				if ( file_put_contents('./import/name_cache.tmp',serialize($name_array)) == 'false')
					echo 'Name cache cann\'t be set up, please check if you have the authority to write in wp-admin/import/. ';
				if ( file_put_contents('./import/site_cache.tmp',serialize($site_array)) == 'false')
					echo 'Site cache cann\'t be set up, please check if you have the authority to write in wp-admin/import/. ';
				
				//-----test block------
				//$a=serialize($name_array);
				//$b=unserialize($a);
				//echo $name_array[0];
				//-------------------
				
				echo '<br \><input type="submit" value="Add links"/></form>';
		}
		
		function insert_links()
		{	
			$site_array = unserialize( file_get_contents("./import/site_cache.tmp"));
			$name_array = unserialize( file_get_contents("./import/name_cache.tmp"));
			$check_bound = count($site_array);
			$insert_count = 0;
			
			//-------test block--------
			//echo 'Adding Links...';
			//echo $site_array[0];
			//echo count($site_array);
			//$check_count=0;
			//--------------------------
			
			for ( $check_count = 0; $check_count < $check_bound; $check_count++ )
			{
				if ($_POST["$check_count"])
				{	
					global $wpdb;
					{	
						$link_url = array( 'link_url' => $site_array[$_POST["$check_count"]],
										   'link_name' => $name_array[$_POST["$check_count"]], 
										   'link_category' => '1', 'link_description' => '', 
										   'link_owner' => '', 
										   'link_rss' => '');
						wp_insert_link($link_url);
						echo $name_array[$_POST["$check_count"]].' ('.$site_array[$_POST["$check_count"]].')<br \>';
						$insert_count++;
					}
				}
			}
			echo '<br \>'.$insert_count.' links has been added.';
			
			if ( (unlink("./import/site_cache.tmp"))&&(unlink("./import/name_cache.tmp")) )
				return true;
			else 
				return false;
		}
		
		function dispatch() 
		{	
			if (empty ($_GET['step']))
				$step = 0;
			else
				$step = (int) $_GET['step'];

			$this->header();			
			switch ($step) 
			{
				case 0:
				$this->greet();
				break;

				case 1:
				$this->get_links();
				break;

				case 2:
				$this->insert_links();
				break;
			}
			$this->footer();
		}
		
		function LinksImporter()
		{	//nothing	
		}
	}

	$links_import = new LinksImporter();	
	register_importer('links_import_online', __('Import Links Online'), 'Import Links Online', array ($links_import, 'dispatch'));
	
?>
<?php // Show Support Ribbon - Show Support Panel

if (!function_exists('add_action')) die();

function show_support_ribbon_wp_resources() {
	
	$plugin_project = esc_html__('Show Support Ribbon', 'show-support-ribbon');
	
	$plugin_url = esc_url(plugin_dir_url(__FILE__));
	
	$array = array(
		
		0  => '<a target="_blank" rel="noopener noreferrer" href="https://digwp.com/" title="Take your WP skills to the next level"><img width="125" height="125" src="'. $plugin_url .'images/250x250-digging-into-wordpress.jpg" alt="Digging Into WordPress"></a>',
		
		1  => '<a target="_blank" rel="noopener noreferrer" href="https://htaccessbook.com/" title="Secure and optimize your website"><img width="125" height="125" src="'. $plugin_url .'images/250x250-htaccess-made-easy.jpg" alt=".htaccess made easy"></a>',
		
		2  => '<a target="_blank" rel="noopener noreferrer" href="https://wp-tao.com/" title="Learn the Way of WordPress"><img width="125" height="125" src="'. $plugin_url .'images/250x250-tao-of-wordpress.jpg" alt="The Tao of WordPress"></a>',
		
		3  => '<a target="_blank" rel="noopener noreferrer" href="https://books.perishablepress.com/downloads/wizards-collection-sql-recipes-wordpress/" title="Wizard&rsquo;s SQL Recipes for WordPress"><img width="125" height="125" src="'. $plugin_url .'images/250x250-wizards-sql.jpg" alt="Wizard&rsquo;s SQL Recipes for WordPress"></a>',
		
		4  => '<a target="_blank" rel="noopener noreferrer" href="https://wp-tao.com/wordpress-themes-book/" title="Build and sell awesome themes"><img width="125" height="125" src="'. $plugin_url .'images/250x250-wp-themes-in-depth.jpg" alt="WordPress Themes In Depth"></a>',
		
		//
		
		5  => '<a target="_blank" rel="noopener noreferrer" href="https://plugin-planet.com/banhammer-pro/" title="Banhammer Pro: Drop the hammer."><img width="125" height="125" src="'. $plugin_url .'images/250x250-banhammer-pro.jpg" alt="Banhammer Pro"></a>',
		
		6  => '<a target="_blank" rel="noopener noreferrer" href="https://plugin-planet.com/bbq-pro/" title="Fastest WordPress Firewall"><img width="125" height="125" src="'. $plugin_url .'images/250x250-bbq-pro.jpg" alt="BBQ Pro Firewall"></a>',	
					
		7  => '<a target="_blank" rel="noopener noreferrer" href="https://plugin-planet.com/blackhole-pro/" title="Trap bad bots in a virtual black hole"><img width="125" height="125" src="'. $plugin_url .'images/250x250-blackhole-pro.jpg" alt="Blackhole Pro"></a>',
		
		8  => '<a target="_blank" rel="noopener noreferrer" href="https://plugin-planet.com/ga-google-analytics-pro/" title="Connect Google Analytics to WordPress"><img width="125" height="125" src="'. $plugin_url .'images/250x250-ga-pro.jpg" alt="GA Google Analytics Pro"></a>',
		
		9  => '<a target="_blank" rel="noopener noreferrer" href="https://plugin-planet.com/simple-ajax-chat-pro/" title="Unlimited chats for WordPress"><img width="125" height="125" src="'. $plugin_url .'images/250x250-sac-pro.jpg" alt="Simple Ajax Chat Pro"></a>',
				
		10  => '<a target="_blank" rel="noopener noreferrer" href="https://plugin-planet.com/usp-pro/" title="Unlimited front-end forms"><img width="125" height="125" src="'. $plugin_url .'images/250x250-usp-pro.jpg" alt="USP Pro"></a>',
		
	);
	
	$items = array_rand($array, 3);
	
	$item1 = isset($array[$items[0]]) ? $array[$items[0]] : 0;
	$item2 = isset($array[$items[1]]) ? $array[$items[1]] : 1;
	$item3 = isset($array[$items[2]]) ? $array[$items[2]] : 2;
	
	$url1 = esc_url('https://books.perishablepress.com/');
	$url2 = esc_url('https://plugin-planet.com/store/');
	$url3 = esc_url('https://monzillamedia.com/donate.html');
	
	$title1 = esc_html__('Perishable Press Books', 'show-support-ribbon');
	$title2 = esc_html__('Plugin Planet: Pro WordPress Plugins', 'show-support-ribbon');
	$title3 = esc_html__('Donate via PayPal, credit card, or cryptocurrency', 'show-support-ribbon');
	
	$link1 = ' <a target="_blank" rel="noopener noreferrer" href="'. $url1 .'" title="'. $title1 .'">'. esc_html__('books',    'show-support-ribbon') .'</a> ';
	$link2 = ' <a target="_blank" rel="noopener noreferrer" href="'. $url2 .'" title="'. $title2 .'">'. esc_html__('plugins',  'show-support-ribbon') .'</a>, ';
	$link3 = ' <a target="_blank" rel="noopener noreferrer" href="'. $url3 .'" title="'. $title3 .'">'. esc_html__('donation', 'show-support-ribbon') .'</a>. ';
	
	$message  = esc_html__('Thank you for using this plugin!', 'show-support-ribbon') .' ';
	$message .= esc_html__('Please show support by purchasing one of my', 'show-support-ribbon') . $link1;
	$message .= esc_html__('or', 'show-support-ribbon') . $link2 . esc_html__('or by making a', 'show-support-ribbon') . $link3;
	$message .= esc_html__('Your generous support helps to ensure future development of', 'show-support-ribbon') .' '. $plugin_project .' ';
	$message .= esc_html__('and is greatly appreciated.', 'show-support-ribbon');
	
	$donate = esc_html__('Any size donation helps me to continue developing this free plugin and other awesome WordPress resources.', 'show-support-ribbon');
	
	?>
	
	<style type="text/css">
		#project-wrap { width: 100%; overflow: hidden; }
		#project-wrap p { margin-top: 5px; font-size: 12px; }
		#project-wrap .project-support { float: left; max-width: 480px; }
		
		#project-wrap .project-links { width: 100%; overflow: hidden; margin: 15px 0; }
		#project-wrap .project-links img { display: block; width: 125px; height: 125px; margin: 0; padding: 0; border: 0; background-color: #fff; color: #fff; }
		#project-wrap .project-links a { float: left; width: 125px; height: 125px; margin: 0 0 0 15px; padding: 1px; border: 1px solid #ccc; opacity: 0.9; }
		#project-wrap .project-links a:hover { opacity: 1.0; }
		
		#project-wrap .project-blurb { 
			float: left; width: 220px; box-sizing: border-box; margin: 0 0 25px 20px; padding: 15px 20px; border-radius: 5px;
			background-color: #fefefe; border: 1px solid #ccc; box-shadow: 0 20px 25px -20px rgba(0,0,0,0.5);
			}
		#project-wrap .project-blurb a { text-decoration: none; }
		#project-wrap .project-blurb a:hover { text-decoration: underline; }
		#project-wrap .project-blurb p { margin-left: 0; margin-right: 0; }
		#project-wrap .project-blurb p:first-child { margin: 0 0 10px 0; font-size: 13px; }
		#project-wrap .project-blurb ul { margin: 0; padding: 0; font-size: 12px; }
		#project-wrap .project-blurb li { margin: 5px 0; list-style: none; }
		
		@media (max-width: 800px) {
			#mm-panel-current { display: none; }
		}
	</style>
	<div id="project-wrap">
		<div class="project-support">
			<div class="project-message">
				<p><?php echo $message; ?></p>
			</div>
			<div class="project-links">
				<?php echo $item1 . $item2 . $item3; ?>
			</div>
		</div>
		<div class="project-blurb">
			<p><strong><?php esc_html_e('Please Donate', 'show-support-ribbon'); ?></strong></p>
			<p><?php echo $donate; ?></p>
			<ul>
				<li><a target="_blank" rel="noopener noreferrer" href="<?php echo $url3; ?>" title="<?php echo $title3; ?>"><?php esc_html_e('Make a donation&nbsp;&raquo;', 'show-support-ribbon'); ?></a></li>
			</ul>
		</div>
	</div>
	
	<?php
	
}

show_support_ribbon_wp_resources();
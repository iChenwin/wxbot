<?php
    /**
     * ReduxFramework Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux_Framework_config' ) ) {

        class Redux_Framework_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                $this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => __( 'Section via hook', 'ta-magazine' ),
                    'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'ta-magazine' ),
                    'icon'   => 'el-icon-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            public function setSections() {

                /**
                 * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
                 * */

				// Array of social options
                $social_options = array(
                    'Twitter'       => 'Twitter',
                    'Facebook'      => 'Facebook',
                    'Google Plus'   => 'Google Plus',
                    'Pinterest'     => 'Pinterest',
                    'RSS'           => 'RSS',
                );

                // Background Patterns Reader
                $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
                $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
                $sample_patterns      = array();

                if ( is_dir( $sample_patterns_path ) ) :

                    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
                        $sample_patterns = array();

                        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                                $name              = explode( '.', $sample_patterns_file );
                                $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                                $sample_patterns[] = array(
                                    'alt' => $name,
                                    'img' => $sample_patterns_url . $sample_patterns_file
                                );
                            }
                        }
                    endif;
                endif;

                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'ta-magazine' ), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                                <img src="<?php echo esc_url( $screenshot ); ?>"
                                     alt="<?php esc_attr_e( 'Current theme preview', 'ta-magazine' ); ?>"/>
                            </a>
                        <?php endif; ?>
                        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                             alt="<?php esc_attr_e( 'Current theme preview', 'ta-magazine' ); ?>"/>
                    <?php endif; ?>

                    <h4><?php echo $this->theme->display( 'Name' ); ?></h4>

                    <div>
                        <ul class="theme-info">
                            <li><?php printf( __( 'By %s', 'ta-magazine' ), $this->theme->display( 'Author' ) ); ?></li>
                            <li><?php printf( __( 'Version %s', 'ta-magazine' ), $this->theme->display( 'Version' ) ); ?></li>
                            <li><?php echo '<strong>' . __( 'Tags', 'ta-magazine' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                        </ul>
                        <p class="theme-description"><?php echo $this->theme->display( 'Description' ); ?></p>
                        <?php
                            if ( $this->theme->parent() ) {
                                printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'ta-magazine' ) . '</p>', __( 'http://codex.wordpress.org/Child_Themes', 'ta-magazine' ), $this->theme->parent()->display( 'Name' ) );
                            }
                        ?>

                    </div>
                </div>

                <?php
                $item_info = ob_get_contents();

                ob_end_clean();

                $sampleHTML = '';
                if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
                    Redux_Functions::initWpFilesystem();

                    global $wp_filesystem;

                    $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
                }

                // ACTUAL DECLARATION OF SECTIONS
				//Header Settings
				$this->sections[] = array(
                    'title'         => __('Header Settings', 'ta-magazine'),
                    'heading'       => __('Header Settings', 'ta-magazine'),
                    'desc'          => __('Here you can uploading site logo and favicon, enable/disable header modules.', 'ta-magazine'),
                    'icon'          => 'el-icon-chevron-up',
                    'submenu'       => true,
                    'fields'        => array(
						array(
                            'title'     => __('Logo', 'ta-magazine'),
                            'subtitle'  => __('Use this field to upload your custom logo for use in the theme header. Max width: 242px', 'ta-magazine'),
                            'id'        => 'custom_logo',
                            'default'   => '',
                            'type'      => 'media',
                            'url'       => true,
                       ),

					   array( 
                            'title'     => __( 'Favicon', 'ta-magazine' ),
                            'subtitle'  => __( 'Use this field to upload your custom favicon.', 'ta-magazine' ),
                            'id'        => 'custom_favicon',
                            'default'   => '',
                            'type'      => 'media',
                            'url'       => true,
                        ),

						array(
                            'title'     => __('Header Announcements', 'ta-magazine'),
                            'subtitle'  => __('Select to enable/disable display Header Announcements.', 'ta-magazine'),
                            'id'        => 'disable_header_info',
                            'default'   => true,
                            'on'        => __('Enable', 'ta-magazine'),
                            'off'       => __('Disable', 'ta-magazine'),
                            'type'      => 'switch',
                       ),

						array(
                            'title'     => __('Header Ad Module', 'ta-magazine'),
                            'subtitle'  => __('Select to enable/disable display Header Ad Module.', 'ta-magazine'),
                            'id'        => 'disable_header_ad',
                            'default'   => true,
                            'on'        => __('Enable', 'ta-magazine'),
                            'off'       => __('Disable', 'ta-magazine'),
                            'type'      => 'switch',
                       ),

						array(
                            'title'     => __('Header Social Module', 'ta-magazine'),
                            'subtitle'  => __('Select to enable/disable display Header Social Module.', 'ta-magazine'),
                            'id'        => 'disable_header_social',
                            'default'   => true,
                            'on'        => __('Enable', 'ta-magazine'),
                            'off'       => __('Disable', 'ta-magazine'),
                            'type'      => 'switch',
                       ),

						array(
                            'title'     => __('Header Login Module', 'ta-magazine'),
                            'subtitle'  => __('Select to enable/disable display Header Login Module.', 'ta-magazine'),
                            'id'        => 'disable_login',
                            'default'   => true,
                            'on'        => __('Enable', 'ta-magazine'),
                            'off'       => __('Disable', 'ta-magazine'),
                            'type'      => 'switch',
                       ),

						array(
                            'id'        => 'header_info_title',
                            'type'      => 'text',
                            'title'     => __('Title for Announcements', 'ta-magazine'),
                            'default'   => 'Announcements',
							'subtitle'  => __('Set the title for Header Announcements.', 'ta-magazine'),
                       ),

                        array(
                            'id'        => 'header_info',
                            'type'      => 'editor',
                            'title'     => __('Announcement Content', 'ta-magazine'),
                            'default'   => '',
							'subtitle'  => __('Set the content for Header Announcements.', 'ta-magazine'),
                       ),
                   ),
               );

				//Homepage Settings
                $this->sections[] = array(
					'title'         => __('Homepage Settings', 'ta-magazine'),
                    'heading'       => __('Homepage Settings', 'ta-magazine'),
                    'desc'          => __('Here you can set homepage modules.', 'ta-magazine'),
                    'icon'          => 'el-icon-home',
                    'fields'    => array(
                         array(
                            'title'     => __('Slider Module', 'ta-magazine'),
                            'subtitle'  => __('Select to enable/disable display Slider Module. Sticky posts will be used in the slider.', 'ta-magazine'),
                            'id'        => 'disable_slider',
                            'default'   => true,
                            'on'        => __('Enable', 'ta-magazine'),
                            'off'       => __('Disable', 'ta-magazine'),
                            'type'      => 'switch',
                       ),

						array(
                            'title'     => __('Modern Listing Module', 'ta-magazine'),
                            'subtitle'  => __('Select to enable/disable display Modern Listing Module.', 'ta-magazine'),
                            'id'        => 'disable_modern',
                            'default'   => true,
                            'on'        => __('Enable', 'ta-magazine'),
                            'off'       => __('Disable', 'ta-magazine'),
                            'type'      => 'switch',
                       ),

						array(
                            'title'       => __('Modern Listing Categories', 'ta-magazine'),
                            'subtitle'    => __('Select categories for Modern Listing Module.', 'ta-magazine'),
                            'id'          => 'modern_cat',
                            'type'        => 'select',
							'multi'       => true,
							'sortable'    => true,
							'data'        => 'categories',
							'placeholder' => __('Select categories for posts.', 'ta-magazine'),
                       ),

						array(
                            'title'       => __('Number of Posts for Modern Listing', 'ta-magazine'),
                            'subtitle'    => __('Set number of posts for Modern Listing Module.', 'ta-magazine'),
                            'id'          => 'modern_posts',
                            'type'        => 'text',
							'default'     => '3',
							'validate'  => 'numeric',
							'msg'       => 'Not a valid number.',
                       ),

						array(
                            'title'     => __('Tab Listing Module', 'ta-magazine'),
                            'subtitle'  => __('Select to enable/disable display Tab Listing Module.', 'ta-magazine'),
                            'id'        => 'disable_tab',
                            'default'   => true,
                            'on'        => __('Enable', 'ta-magazine'),
                            'off'       => __('Disable', 'ta-magazine'),
                            'type'      => 'switch',
                       ),

						array(
                            'title'       => __('Tab Listing Categories', 'ta-magazine'),
                            'subtitle'    => __('Select categories for Tab Listing Module.', 'ta-magazine'),
                            'id'          => 'tab_cat',
                            'type'        => 'select',
							'multi'       => true,
							'sortable'    => true,
							'data'        => 'categories',
							'placeholder' => __('Select categories for posts.', 'ta-magazine'),
                       ),

						array(
                            'title'     => __('Blog Listing Module', 'ta-magazine'),
                            'subtitle'  => __('Select to enable/disable display Blog Listing Module.', 'ta-magazine'),
                            'id'        => 'disable_blog',
                            'default'   => true,
                            'on'        => __('Enable', 'ta-magazine'),
                            'off'       => __('Disable', 'ta-magazine'),
                            'type'      => 'switch',
                       ),

						array(
                            'title'       => __('Blog Listing Categories', 'ta-magazine'),
                            'subtitle'    => __('Select categories for Blog Listing Module.', 'ta-magazine'),
                            'id'          => 'blog_cat',
                            'type'        => 'select',
							'multi'       => true,
							'sortable'    => true,
							'data'        => 'categories',
							'placeholder' => __('Select categories for posts.', 'ta-magazine'),
                       ),

						array(
                            'title'       => __('Number of Posts for Blog Listing', 'ta-magazine'),
                            'subtitle'    => __('Set number of posts for Blog Listing Module.', 'ta-magazine'),
                            'id'          => 'blog_posts',
                            'type'        => 'text',
							'default'     => '5',
							'validate'  => 'numeric',
							'msg'       => 'Not a valid number.',
                       ),
                   )
               );

				//Blog Settings
                $this->sections[] = array(
					'title'         => __('Blog Settings', 'ta-magazine'),
                    'heading'       => __('Blog Settings', 'ta-magazine'),
                    'desc'          => __('Here you can set blog listing style and customize post style.', 'ta-magazine'),
                    'icon'          => 'el-icon-th-list',
                    'fields'    => array(
                         array(
                            'title'     => __('Blog Listing Style', 'ta-magazine'),
                            'subtitle'  => __('Select blog listing style for archive pages.', 'ta-magazine'),
                            'id'        => 'disable_listing_style',
                            'default'   => true,
                            'on'        => __('Modern Style', 'ta-magazine'),
                            'off'       => __('Blog Style', 'ta-magazine'),
                            'type'      => 'switch',
                       ),

						array( 
                            'title'     => __('Read More Button Text', 'ta-magazine'),
                            'subtitle'  => __('This is the text that will replace Load More.', 'ta-magazine'),
                            'id'        => 'read_more_text',
                            'default'   => 'Read More',
                            'type'      => 'text',
                       ),

						array( 
                            'title'     => __('Load More Button Text', 'ta-magazine'),
                            'subtitle'  => __('This is the text for Jetpack’s Infinite Scroll.', 'ta-magazine'),
                            'id'        => 'load_more_text',
                            'default'   => '+ Load More',
                            'type'      => 'text',
                       ),

					   array( 
                            'title'     => __('Related Posts Module Title', 'ta-magazine'),
                            'subtitle'  => __('This is the title for Related Posts Module.', 'ta-magazine'),
                            'id'        => 'related_title',
                            'default'   => 'Related Posts',
                            'type'      => 'text',
                       ),

						array(
                            'title'     => __('Post Featured Image', 'ta-magazine'),
                            'subtitle'  => __('Select to enable/disable display Post Featured Image on header.', 'ta-magazine'),
                            'id'        => 'disable_featured_img',
                            'default'   => true,
                            'on'        => __('Enable', 'ta-magazine'),
                            'off'       => __('Disable', 'ta-magazine'),
                            'type'      => 'switch',
                       ),

						array(
                            'title'     => __('Post Navigation Module', 'ta-magazine'),
                            'subtitle'  => __('Select to enable/disable display Post Navigation Module for next and previous posts.', 'ta-magazine'),
                            'id'        => 'disable_post_nav',
                            'default'   => true,
                            'on'        => __('Enable', 'ta-magazine'),
                            'off'       => __('Disable', 'ta-magazine'),
                            'type'      => 'switch',
                       ),
                   )
               );

				//Social Settings
                $this->sections[] = array(
					'title'         => __('Social Settings', 'ta-magazine'),
                    'heading'       => __('Social Settings', 'ta-magazine'),
                    'desc'          => __('Here you can set your social profiles.', 'ta-magazine'),
                    'icon'          => 'el-icon-group',
                    'fields'        => array(
                         array(
                            'title'     => __('Social Icons', 'ta-magazine'),
                            'subtitle'  => __('Arrange your social icons. Add complete URLs to your social profiles.', 'ta-magazine'),
                            'id'        => 'social_icons',
                            'type'      => 'sortable',
                            'options'   => $social_options,
                       ),
                   )
               );

				//Advertisement
				$this->sections[] = array(
                    'title'         => __('Ad Management', 'ta-magazine'),
                    'heading'       => __('Ad Management', 'ta-magazine'),
                    'desc'          => __('Here are all settings for advertisements.', 'ta-magazine'),
                    'icon'          => 'el-icon-eur',
                    'submenu'       => true,
                    'fields'        => array(
                        array(
                            'id'        => 'ad_header',
                            'type'      => 'ace_editor',
							'mode'      => 'html',
                            'title'     => __('Header Ad', 'ta-magazine'),
                            'default'   => '',
							'subtitle'  => __('Advertisement code for header area. Size: 468x60.', 'ta-magazine'),
                       ),

					   array(
                            'id'        => 'ad_left',
                            'type'      => 'ace_editor',
							'mode'      => 'html',
                            'title'     => __('Post Left Sidebar Ad', 'ta-magazine'),
                            'default'   => '',
							'subtitle'  => __('Advertisement code for post left sidebar area. Size: 160x600.', 'ta-magazine'),
                       ),

					   array(
                            'id'        => 'ad_post_top',
                            'type'      => 'ace_editor',
							'mode'      => 'html',
                            'title'     => __('Post Header Ad', 'ta-magazine'),
                            'default'   => '',
							'subtitle'  => __('Advertisement code for post header. Size: 468x60.', 'ta-magazine'),
                       ),

					   array(
                            'id'        => 'ad_post_bottom',
                            'type'      => 'ace_editor',
							'mode'      => 'html',
                            'title'     => __('Post Bottom Ad', 'ta-magazine'),
                            'default'   => '',
							'subtitle'  => __('Advertisement code for post bottom. Size: 468x600.', 'ta-magazine'),
                       ),
                   ),
               );

				//Footer Settings
                $this->sections[] = array(
					'title'     => __('Footer Settings', 'ta-magazine'),
					'heading'   => __('Footer Settings', 'ta-magazine'),
                    'desc'      => __('Here you can set site copyright information.', 'ta-magazine'),
                    'icon'      => 'el-icon-chevron-down',
                    'fields'    => array(
                        array(
                            'title'     => __('Custom Copyright', 'ta-magazine'),
                            'subtitle'  => __('Add your own custom text/html for copyright region.', 'ta-magazine'),
                            'id'        => 'custom_copyright',
                            'default'   => 'Copyright &copy; 2015 - <a href="http://themeart.co/free-theme/ta-magazine/" title="TA Magazine Free WordPress Theme" target="_blank">TA Magazine</a>. Powered by <a href="http://themeart.co/" title="Downlod Free Premium WordPress Themes &amp; Templates" target="_blank">ThemeArt</a> and <a href="http://wordpress.org/" title="Blog Tool, Publishing Platform, and CMS" target="_blank">WordPress</a>.',
                            'type'      => 'editor',
                       ),
                   )
               );

			   //Contact Page Settings
                $this->sections[] = array(
					'title'     => __('Contact Page Settings', 'ta-magazine'),
					'heading'   => __('Contact Page Settings', 'ta-magazine'),
                    'desc'      => __('Here you can set information for contact page.', 'ta-magazine'),
                    'icon'      => 'el-icon-envelope',
                    'fields'    => array(
                        array(
                            'title'     => __('Google Map Module', 'ta-magazine'),
                            'subtitle'  => __('Select to enable/disable display Google Map.', 'ta-magazine'),
                            'id'        => 'disable_map',
                            'default'   => true,
                            'on'        => __('Enable', 'ta-magazine'),
                            'off'       => __('Disable', 'ta-magazine'),
                            'type'      => 'switch',
                       ),

					   array(
                            'title'     => __('Google Map Embed Code', 'ta-magazine'),
                            'subtitle'  => __('Please refer to <a href="http://themeart.co/document/ta-magazine-theme-documentation/#google-map-settings" target="_blank">theme documentation</a> for how to Embed a Google Map with iFrame.', 'ta-magazine'),
                            'id'        => 'map_code',
                            'default'   => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1584.2679903399307!2d-122.09496935581758!3d37.42444119584552!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fba1a7f2db7e7%3A0x59c3e570fe8e0c73!2sGoogle+West+Campus+6%2C+2350+Bayshore+Pkwy%2C+Mountain+View%2C+CA+94043%2C+USA!5e0!3m2!1sen!2s!4v1422891258666" width="600" height="450" frameborder="0" style="border:0"></iframe>',
                            'type'      => 'ace_editor',
                            'mode'      => 'html',
                            'theme'     => 'monokai',
                       ),

					   array( 
                            'title'     => __('Contact Email', 'ta-magazine'),
                            'subtitle'  => __('Set your email address. This is where the contact form will send a message to.', 'ta-magazine' ),
                            'id'        => 'contact_email',
                            'default'   => 'yourname@yourdomain.com',
							'validate'  => 'email',
							'msg'       => 'Not a valid email address.',
                            'type'      => 'text',
                        ),

						array(
							'title'     => __('Contact Mail Subject', 'ta-magazine'),
							'subtitle'  => __('Add some topics for your mail subject.', 'ta-magazine'),
							'id'        => 'contact_subject',
							'type'      => 'multi_text',
							'default'   => array ('Aloha'),
							),
                   )
               );

				//404 Page Settings
                $this->sections[] = array(
					'title'     => __('404 Page Settings', 'ta-magazine'),
					'heading'   => __('404 Page Settings', 'ta-magazine'),
                    'desc'      => __('Here you can set information for 404 page.', 'ta-magazine'),
                    'icon'      => 'el-icon-error',
                    'fields'    => array(
						array(
                            'title'     => __('404 Image', 'ta-magazine'),
                            'subtitle'  => __('Use this field to upload your custom 404 image.', 'ta-magazine'),
                            'id'        => '404_image',
                            'default'   => '',
                            'type'      => 'media',
                            'url'       => true,
                       ),

                        array(
                            'title'     => __('Notice Information', 'ta-magazine'),
                            'subtitle'  => __('Add notice information for 404 page.', 'ta-magazine'),
                            'id'        => '404_info',
                            'default'   => "We're sorry, but we can't find the page you were looking for. It's probably some thing we've done wrong but now we know about it and we'll try to fix it. In the meantime, try one of these options:",
                            'type'      => 'editor',
                       ),
                   )
               );

			   //Custom CSS
                $this->sections[] = array(
                    'icon'      => 'el-icon-css',
                    'title'     => __('Custom CSS', 'ta-magazine'),
                    'fields'    => array(
                         array(
                            'title'     => __('Custom CSS', 'ta-magazine'),
                            'subtitle'  => __('Insert any custom CSS.', 'ta-magazine'),
                            'id'        => 'custom_css',
                            'type'      => 'ace_editor',
                            'mode'      => 'css',
                            'theme'     => 'monokai',
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __('Import / Export', 'ta-magazine'),
                    'desc'   => __('Import and Export your theme settings from file, text or URL.', 'ta-magazine'),
                    'icon'   => 'el-icon-refresh',
                    'fields' => array(
                        array(
                            'id'         => 'opt-import-export',
                            'type'       => 'import_export',
                            'title'      => 'Import Export',
                            'subtitle'   => 'Save and restore your theme options',
                            'full_width' => false,
                       ),
                   ),
               );

                $this->sections[] = array(
                    'type' => 'divide',
               );

                $this->sections[] = array(
                    'icon'   => 'el-icon-info-sign',
                    'title'  => __('Theme Information', 'ta-magazine'),
                    'desc'   => __('<p class="description">About TA Magazine</p>', 'ta-magazine'),
                    'fields' => array(
                        array(
                            'id'      => 'opt-raw-info',
                            'type'    => 'raw',
                            'content' => $item_info,
                       )
                   ),
               );

                if ( file_exists( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) ) {
                    $tabs['docs'] = array(
                        'icon'    => 'el-icon-book',
                        'title'   => __( 'Documentation', 'ta-magazine' ),
                        'content' => nl2br( file_get_contents( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) )
                    );
                }
            }

            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-1',
                    'title'   => __( 'Theme Information 1', 'ta-magazine' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'ta-magazine' )
                );

                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-2',
                    'title'   => __( 'Theme Information 2', 'ta-magazine' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'ta-magazine' )
                );

                // Set the help sidebar
                $this->args['help_sidebar'] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'ta-magazine' );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'ta_option',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => __( 'Theme Panel', 'ta-magazine' ),
                    'page_title'           => __( 'Theme Panel', 'ta-magazine' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-admin-settings',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => true,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => '',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => '_options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );

                // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
                $this->args['admin_bar_links'][] = array(
                    'id'    => 'redux-docs',
                    'href'   => 'http://themeart.co/document/ta-magazine-theme-documentation/',
                    'title' => __( 'Documentation', 'ta-magazine' ),
                );

                $this->args['admin_bar_links'][] = array(
                    //'id'    => 'redux-support',
                    'href'   => 'http://themeart.co/support/',
                    'title' => __( 'Support', 'ta-magazine' ),
                );

                // Panel Intro text -> before the form
                if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                    if ( ! empty( $this->args['global_variable'] ) ) {
                        $v = $this->args['global_variable'];
                    } else {
                        $v = str_replace( '-', '_', $this->args['opt_name'] );
                    }
                    $this->args['intro_text'] = sprintf( __( '<p>You can start customizing your theme with the powerful option panel.</p>', 'ta-magazine' ), $v );
                } else {
                    $this->args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'ta-magazine' );
                }

                // Add content after the form.
                $this->args['footer_text'] = __( '<p>Thanks for using <a href="http://themeart.co/free-theme/ta-magazine/" target="_blank">TA Magazine</a>. This free WordPress theme is designed by <a href=
				"http://themeart.co/" target="_blank">ThemeArt</a>. Please feel free to leave us some feedback about your experience, so we can improve our themes for you.</p>', 'ta-magazine' );
            }

            public function validate_callback_function( $field, $value, $existing_value ) {
                $error = true;
                $value = 'just testing';

                /*
              do your validation

              if(something) {
                $value = $value;
              } elseif(something else) {
                $error = true;
                $value = $existing_value;
                
              }
             */

                $return['value'] = $value;
                $field['msg']    = 'your custom error message';
                if ( $error == true ) {
                    $return['error'] = $field;
                }

                return $return;
            }

            public function class_field_callback( $field, $value ) {
                print_r( $field );
                echo '<br/>CLASS CALLBACK';
                print_r( $value );
            }

        }

        global $reduxConfig;
        $reduxConfig = new Redux_Framework_config();
    } else {
        echo "The class named Redux_Framework_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ):
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    endif;

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ):
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error = true;
            $value = 'just testing';

            /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            
          }
         */

            $return['value'] = $value;
            $field['msg']    = 'your custom error message';
            if ( $error == true ) {
                $return['error'] = $field;
            }

            return $return;
        }
    endif;

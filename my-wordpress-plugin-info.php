<?php
/*
Plugin Name: My WP Plugin Info
Plugin URI: http://simplelib.co.cc/?p=195
Description: Recieves info of any plugin from wordpress.org plugins repository. Visit <a href="http://simplelib.co.cc/">SimpleLib blog</a> for more details.
Version: 1.0.12
Author: minimus
Author URI: http://blogovod.co.cc
*/

/*  Copyright 2009, minimus  (email : minimus.blogovod@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( !class_exists( 'MyWpPluginInfo' ) ) {
	class MyWpPluginInfo {
		var $pluginSlug = null;
		var $pluginInfo = array();
		
		function MyWpPluginInfo() {
			$plugin_dir = basename( dirname( __FILE__ ) );
			if ( function_exists( 'load_plugin_textdomain' ) ) 
				load_plugin_textdomain( 'my-wordpress-plugin-info', PLUGINDIR . $plugin_dir, $plugin_dir );
			
			add_filter('tiny_mce_version', array(&$this, 'tinyMCEVersion') );
			add_action('init', array(&$this, 'addButtons'));
			add_shortcode('mwpi', array(&$this, 'doShortCode'));
			add_shortcode('mwpi_block', array(&$this, 'doShortCodeBlock'));
		}
		
		function getPluginInfo ( $slug = null ) {
			if ( !$slug ) return false;
			
			require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
			
			$info   = array(
			  'name'            => '',
			  'slug'            => '',
			  'version'         => '',
			  'author'          => '',
			  'author_profile'  => '',
			  'contributors'    => '',
			  'requires'        => '',
			  'tested'          => '',
			  'rating'          => '',
			  'num_ratings'     => '',
			  'rating_raw'      => '',
			  'downloaded'      => '',
			  'last_updated'    => '',
			  'homepage'        => '',
			  'download_link'   => '',
			  'tags'            => '',
			  'description'     => '',
			  'installation'    => '',
			  'faq'             => '',
			  'screenshots'     => '',
			  'changelog'       => '',
			  'other_notes'     => ''
			);
			
			$plugins_allowedtags = 
			  array('a' => array('href' => array(), 'title' => array(), 'target' => array()),
              'abbr' => array('title' => array()), 'acronym' => array('title' => array()),
              'code' => array(), 'pre' => array(), 'em' => array(), 'strong' => array(),
							'div' => array(), 'p' => array(), 'ul' => array(), 'ol' => array(), 'li' => array(),
							'h1' => array(), 'h2' => array(), 'h3' => array(), 'h4' => array(), 'h5' => array(), 'h6' => array(),
							'img' => array('src' => array(), 'class' => array(), 'alt' => array()));
								           
      $slug   = sanitize_title( $slug );
      
      if ( $slug !== $this->pluginSlug ) {
        $this->pluginSlug = $slug;
				$this->pluginInfo = plugins_api( 'plugin_information', array( 'slug' => $slug ) );
      }
      $plugin = $this->pluginInfo;
      
      if ( !$plugin or is_wp_error( $plugin ) ) return false;
      
      foreach ( array( 'name', 'slug', 'version', 'author', 'author_profile', 'requires', 'tested',	'rating', 'num_ratings', 'downloaded', 'last_updated', 'homepage', 'download_link' ) as $key ) {
      	$info[ $key ] = wp_kses($plugin->$key, $plugins_allowedtags);
      }
      
      foreach ( (array)$plugin->sections as $section_name => $content )
		    $info[ $section_name ] = wp_kses( $content, $plugins_allowedtags );
	    
	    //foreach ( (array)$plugin->contributors as $name => $link ) {
	    //  if ( $info[ 'contributors' ] !== '' ) $info[ 'contributors' ] .= ", <a href='".wp_kses( $link, $plugins_allowedtags )."'>".wp_kses( $name, $plugins_allowedtags )."</a>";
 		  //  else $info = "<a href='".wp_kses( $link, $plugins_allowedtags )."'>".wp_kses( $name, $plugins_allowedtags )."</a>";
	    //}
	    
	    foreach ( (array)$plugin->tags as $tag ) {
	    	if ( $info[ 'tags' ] === '' ) $info[ 'tags' ] = $tag;
	    	else $info[ 'tags' ] .= ', '.$tag;
	    }
	    
	    $info['rating_raw'] = $info['rating'];
      
      return $info;
		}  // getPluginInfo end
		
		function getFormatedPluginInfo( $slug = null ) {
			if ( empty( $slug ) ) return false;
			
			$plugin = $this->getPluginInfo( $slug );
			
			if ( empty( $plugin ) ) return false;
			
			$info = array(
			  'name'            => $plugin[ 'name' ],
			  'slug'            => $plugin[ 'slug' ],
			  'version'         => __('Current version', 'my-wordpress-plugin-info').': '.$plugin[ 'version' ],
			  'author'          => __('Author', 'my-wordpress-plugin-info').': '.$plugin[ 'author' ],
			  'author_profile'  => '', // later
			  'contributors'    => '', // not in this version
			  'requires'        => __('Requires Wordpress version', 'my-wordpress-plugin-info').': '.$plugin[ 'requires' ].' '.__( 'or higher', 'my-wordpress-plugin-info' ),
			  'tested'          => __('Compatible up to', 'my-wordpress-plugin-info').': '.$plugin[ 'tested' ],
			  'rating'          => __('Rating', 'my-wordpress-plugin-info').': '.$plugin[ 'rating' ],
			  'num_ratings'     => __('Number of ratings', 'my-wordpress-plugin-info').': '.sprintf( __ngettext( "%d vote", "%d votes", $plugin[ 'num_ratings' ], "my-wordpress-plugin-info" ), $plugin[ 'num_ratings' ] ),
			  'rating_raw'      => $this->buildRatingRaw( $plugin['rating'] ),
				'downloaded'      => sprintf( __ngettext( "%s hit", "%s hits", $plugin['downloaded'], "my-wordpress-plugin-info" ), number_format( $plugin['downloaded'], 0, ',', ' ' ) ),
			  'last_updated'    => __('Last updated', 'my-wordpress-plugin-info').': '.date( get_option('date_format'), strtotime( $plugin['last_updated'] ) ),
			  'homepage'        => '<a href="'.$plugin['homepage'].'">'.__('Plugin homepage', 'my-wordpress-plugin-info').'</a>',
			  'download_link'   => '<a href="'.$plugin['download_link'].'">'.__('Download', 'my-wordpress-plugin-info').'</a>',
			  'tags'            => __('Tags', 'my-wordpress-plugin-info').': '.$plugin['tags'],
			  'description'     => $plugin['description'],
			  'installation'    => $plugin['installation'],
			  'faq'             => $plugin['faq'],
			  'screenshots'     => $plugin['screenshots'],
			  'changelog'       => $plugin['changelog'],
			  'other_notes'     => $plugin['other_notes']				
			);
			
			$info['author_profile'] = __('Author', 'my-wordpress-plugin-info').': <a href="'.$plugin[ 'author_profile' ].'">'.strip_tags($info['author']).'</a>';
			
			return $info;
		}
		
		function buildRatingRaw( $rating = null, $votes = null ) {
			if ( is_null( $rating ) ) return '';
			
			$fullSrc = '<img src="'.plugins_url( 'my-wordpress-plugin-info/img/full.png' ).'"/>';
			$halfSrc = '<img src="'.plugins_url( 'my-wordpress-plugin-info/img/half.png' ).'"/>';
			$emptySrc = '<img src="'.plugins_url( 'my-wordpress-plugin-info/img/empty.png' ).'"/>';
			$sRating = 0.05 * $rating;
			$output = '';
			
			for ( $i = 1; $i <= 5; $i++ ) {
				if ( $sRating >= 1 ) $output .= $fullSrc;
				if ( $sRating <= 0 ) $output .= $emptySrc;
				if ( ( $sRating > 0 ) & ( $sRating < 1 ) ) $output .= $halfSrc;
				$sRating -= 1;
			}
			
			if ( !is_null( $votes ) ) $output .= ' ('.sprintf( __ngettext( "%d vote", "%d votes", $votes, "my-wordpress-plugin-info" ), $votes ).')';
			
			return $output;
		}
		
		function getBlockPluginInfo( $slug = null, $content = null ) {
			if ( empty( $slug ) ) return false;
			
			$plugin = $this->getFormatedPluginInfo( $slug );
			
			if ( empty( $plugin ) ) return false;
			
			$prefix = "<strong><a href='http://wordpress.org/extend/plugins/{$slug}/'>{$plugin['name']}</a></strong> ";
			$suffix = $plugin['author'].'. '.$plugin['version'].'. '.$plugin['last_updated'].'. '.$plugin['requires'].'. '.$plugin['tested'].'. '.$this->buildRatingRaw( $this->pluginInfo->rating, $this->pluginInfo->num_ratings ).' '.$plugin['download_link'];
			$content = '<p>'.$prefix.'<br/>'.$content.'<br/>'.$suffix.'</p>';
			return $content;
		}
		
		function getPluginInfoBlock( $slug = null, $content = null, $mode = null ) {
			if ( empty( $slug ) ) return false;
			
			$plugin = $this->getPluginInfo( $slug );
			
			if ( empty( $plugin ) ) return false;
			
			$prefix = "<strong><a href='http://wordpress.org/extend/plugins/{$slug}/'>{$plugin['name']}</a></strong> ";
			switch ( $mode ) {
				case 'info':
				  $suffix = __('Author', 'my-wordpress-plugin-info').': '.$plugin['author'].', '.__('version', 'my-wordpress-plugin-info').': '.$plugin['version'].', '.__('updated', 'my-wordpress-plugin-info').': '.date(get_option('date_format'), strtotime($plugin['last_updated'])).', <br/>'.__('Requires WP version', 'my-wordpress-plugin-info').': '.$plugin['requires'].' '.__('or higher', 'my-wordpress-plugin-info').', '.__('tested up to', 'my-wordpress-plugin-info').': '.$plugin['tested'].'. <br/>'.$this->buildRatingRaw($plugin['rating']).' ('.sprintf( __ngettext( "%d vote", "%d votes", $plugin[ 'num_ratings' ], "my-wordpress-plugin-info" ), $plugin[ 'num_ratings' ] ).')';
				  break;
		    case 'download':
		      $suffix = __('Author', 'my-wordpress-plugin-info').': '.$plugin['author'].', '.__('version', 'my-wordpress-plugin-info').': '.$plugin['version'].', '.__('updated', 'my-wordpress-plugin-info').': '.date(get_option('date_format'), strtotime($plugin['last_updated'])).', <br/>'.__('Requires WP version', 'my-wordpress-plugin-info').': '.$plugin['requires'].' '.__('or higher', 'my-wordpress-plugin-info').', '.__('tested up to', 'my-wordpress-plugin-info').': '.$plugin['tested'].'.<br/>'.'<a href="'.$plugin['download_link'].'">'.__('Download', 'my-wordpress-plugin-info').'</a> ('.sprintf( __ngettext( "%s hit", "%s hits", $plugin['downloaded'], "my-wordpress-plugin-info" ), number_format($plugin['downloaded'], 0, ',', ' ')).') '.$this->buildRatingRaw($plugin['rating']).' ('.sprintf( __ngettext( "%d vote", "%d votes", $plugin[ 'num_ratings' ], "my-wordpress-plugin-info" ), $plugin[ 'num_ratings' ] ).')';
		      break;
			}
			$content = '<p>'.$prefix.'<br/>'.$content.'</p><p>'.$suffix.'</p>';
			return $content;
		}
		
		function doShortCode( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'slug' => '',
				'data' => 'downloaded',
				'mode' => 'fmt',
				'body' => ''), 
				$atts ) );
			
			$validData = array( 'name', 'slug', 'version', 'author', 'author_profile', 'requires', 'tested',	'rating',			 'num_ratings', 'rating_raw', 'downloaded', 'last_updated', 'homepage', 'download_link', 'tags', 'description', 'installation', 'faq', 'screenshots', 'changelog', 'other_notes' );
			
			$info = array();
			if ( $slug !== '' ) {
				if ( $mode === 'api' & in_array( $data, $validData ) ) {
				  $info = $this->getPluginInfo( $slug );
				  if ( $info !== false ) return $info[$data];
				} elseif ( ( $mode === 'fmt' | $mode === 'formated' ) & in_array( $data, $validData ) ) {
					$info = $this->getFormatedPluginInfo( $slug );
				  if ( $info !== false ) return $info[$data];
				} elseif ( $mode === 'block' ) {
					return $this->getBlockPluginInfo( $slug, $body );
				}	else return 'Error!';
			} else return 'Error!';
			
		}
		
		function doShortCodeBlock( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'slug' => '',
				'mode' => 'info'), 
				$atts ) );
				
			$plugin = array();
			if ( $slug !== '' ) {
				return $this->getPluginInfoBlock( $slug, do_shortcode( $content ), $mode );
			}
			else return __('Plugin Slug not Defined!', 'my-wordpress-plugin-info');
		}
		
		function addButtons() {
			// Don't bother doing this stuff if the current user lacks permissions
      if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
        return;
      
      // Add only in Rich Editor mode
      if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", array(&$this, "addTinyMCEPlugin"));
        add_filter('mce_buttons', array(&$this, 'registerButton'));
      }
		}
		
		function registerButton( $buttons ) {
			array_push($buttons, "separator", "mwpi", "mwpi_block");
      return $buttons;
		}
		
		function addTinyMCEPlugin( $plugin_array ) {
			$plugin_array['mwpi'] = plugins_url('my-wordpress-plugin-info/tinymce/plugins/mwpi/editor_plugin.js');
      return $plugin_array;
		}
		
		function tinyMCEVersion( $version ) {
			return ++$version;
		}
	} // class end
} // if end

if ( class_exists( 'MyWpPluginInfo' ) ) $minimus_plugin_info = new MyWpPluginInfo;
?>
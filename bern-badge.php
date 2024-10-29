<?php

/**
* Plugin Name: Feel the Bern Badge for Bernie Sanders
* Plugin URI: https://www.spokanewp.com/portfolio
* Description: Show your support for Bernie Sanders by adding a badge to the top corner of your website.
* Author: Spokane WordPress Development
* Author URI: http://www.spokanewp.com
* Version: 1.1.5
* Text Domain: bern-badge
* Domain Path: /languages
*
* Copyright 2016 Spokane WordPress Development
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License, version 2, as
* published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*
*/

namespace BernBadge;

class Badge {

	const VERSION = '1.1.5';
	const VERSION_CSS = '1.1.5';
	const VERSION_JS = '1.1.3';
	const DEFAULT_BADGE = 'bern-badge-right-blue-en-6';

	private $color;
	private $position;
	private $language;
	private $style;

	/** @var Badge[] $bern_badges */
	private $bern_badges;

	/**
	 * @return mixed
	 */
	public function getName() {
		return 'bern-badge-' . $this->position . '-' . $this->color . '-' . $this->language . '-' . $this->style;
	}

	public function getFileName() {
		return plugin_dir_url( __FILE__ ) . 'images/' . $this->getName() . '.png';
	}

	/**
	 * @return bool
	 */
	public function isHiddenOnMobile()
	{
		$hidden = get_option( 'bern_badge_is_hidden_on_mobile', 'N' );
		return ( $hidden == 'Y' );
	}

	/**
	 * @return mixed
	 */
	public function getColor() {
		return $this->color;
	}

	/**
	 * @param mixed $color
	 *
	 * @return Badge
	 */
	public function setColor( $color ) {
		$this->color = $color;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * @param mixed $position
	 *
	 * @return Badge
	 */
	public function setPosition( $position ) {
		$this->position = $position;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getLanguage() {
		return $this->language;
	}

	/**
	 * @param mixed $language
	 *
	 * @return Badge
	 */
	public function setLanguage( $language ) {
		$this->language = $language;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getStyle() {
		return $this->style;
	}

	/**
	 * @param mixed $style
	 *
	 * @return Badge
	 */
	public function setStyle( $style ) {
		$this->style = $style;

		return $this;
	}

	public function activate()
	{

	}

	public function init()
	{
		$bern_badge = $this->get_bern_badge();

		wp_enqueue_script( 'bern-badge-js-cookie', plugin_dir_url( __FILE__ ) . 'js.cookie.js', array( 'jquery' ), (WP_DEBUG) ? time() : self::VERSION_JS, TRUE );
		wp_enqueue_script( 'bern-badge-js', plugin_dir_url( __FILE__ ) . 'bern-badge.js', array( 'jquery' ), (WP_DEBUG) ? time() : self::VERSION_JS, TRUE );
		wp_localize_script( 'bern-badge-js', 'bern_badge', array(
			'image' => $bern_badge->getFileName(),
			'color' => $bern_badge->getColor(),
			'position' => $bern_badge->getPosition(),
			'admin_bar' => ( is_admin_bar_showing() ) ? 1 : 0,
			'action1' => __( 'Visit BernieSanders.com', 'bern-badge' ),
			'action2' => __( 'Donate to Bernie Sanders', 'bern-badge' ),
			'action3' => __( 'Add this badge to your website', 'bern-badge' ),
			'action4' => __( 'Hide badge just for this page', 'bern-badge' ),
			'action5' => __( 'Hide badge for entire website', 'bern-badge' ),
			'action6' => __( 'Bern Badge admin settings', 'bern-badge' ),
			'link' => '/wp-admin/options-general.php?page=' . plugin_basename( __FILE__ ),
			'confirm' => __( 'Are you sure you want to remove this badge from the entire website for the duration of your visit?', 'bern-badge' )
		) );
		wp_enqueue_style( 'bern-badge-css', plugin_dir_url( __FILE__ ) . 'bern-badge.css', array(), (WP_DEBUG) ? time() : self::VERSION_CSS );
		if ( $this->isHiddenOnMobile() )
		{
			wp_enqueue_style( 'bern-badge-hidden-css', plugin_dir_url( __FILE__ ) . 'bern-badge-hidden-on-mobile.css', array(), (WP_DEBUG) ? time() : self::VERSION_CSS );
		}
		wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
	}

	public function admin_init()
	{
		wp_enqueue_script( 'bern-badge-admin-js', plugin_dir_url( __FILE__ ) . 'admin.js', array( 'jquery' ), (WP_DEBUG) ? time() : self::VERSION_JS, TRUE );
		wp_enqueue_style( 'bern-badge-admin-css', plugin_dir_url( __FILE__ ) . 'admin.css', array(), (WP_DEBUG) ? time() : self::VERSION_CSS );
	}

	public function register_settings()
	{
		register_setting( 'bern_badge_settings', 'bern_badge' );
		register_setting( 'bern_badge_settings', 'bern_badge_is_hidden_on_mobile' );
	}

	/**
	 * @param array $links
	 *
	 * @return array
	 */
	public function settings_link( $links )
	{
		$link = '<a href="options-general.php?page=' . plugin_basename( __FILE__ ) . '">' . __( 'Settings', 'bern-badge' ) . '</a>';
		$links[] = $link;
		return $links;
	}

	public function settings_page()
	{
		add_options_page(
			'Bern Badge ' . __( 'Settings', 'bern-badge' ),
			'Bern Badge',
			'manage_options',
			plugin_basename( __FILE__ ),
			array( $this, 'print_settings_page')
		);
	}

	public function print_settings_page()
	{
		include( 'settings.php' );
	}

	/**
	 * @return array
	 */
	public function get_colors()
	{
		return array(
			'blue' => __( 'Blue', 'bern-badge' ),
			'white' => __( 'White', 'bern-badge' ),
			'black' => __( 'Black', 'bern-badge' )
		);
	}

	/**
	 * @return array
	 */
	public function get_positions()
	{
		return array(
			'left' => __( 'Left', 'bern-badge'),
			'right' => __( 'Right', 'bern-badge' )
		);
	}

	/**
	 * @return array
	 */
	public function get_languages()
	{
		return array(
			'en' => __( 'English', 'bern-badge' )
		);
	}

	/**
	 * @return Badge[]
	 */
	public function get_bern_badges()
	{
		if ( $this->bern_badges === NULL )
		{
			$colors = $this->get_colors();
			$positions = $this->get_positions();
			$languages = $this->get_languages();

			$this->bern_badges = array();

			$dir = opendir( __DIR__ . '/images' );
			while( $file = readdir( $dir ) )
			{
				$parts = explode( '.', $file );
				if ( count( $parts ) == 2 && $parts[1] == 'png' )
				{
					$parts = explode( '-', $parts[0] );
					if ( count( $parts ) == 6 && $parts[0] == 'bern' && $parts[1] == 'badge' )
					{
						if ( array_key_exists( $parts[2], $positions ) && array_key_exists( $parts[3], $colors ) && array_key_exists( $parts[4], $languages ) )
						{
							$bern_badge = new Badge;
							$bern_badge
								->setPosition( $parts[2] )
								->setColor( $parts[3] )
								->setLanguage( $parts[4] )
								->setStyle( $parts[5] );
							$this->bern_badges[ $bern_badge->getName() ] = $bern_badge;
						}
					}
				}
			}
		}

		return $this->bern_badges;
	}

	/**
	 * @return Badge
	 */
	public function get_bern_badge()
	{
		$bern_badges = $this->get_bern_badges();
		$bern_badge = get_option( 'bern_badge', '' );

		if ( array_key_exists( $bern_badge, $bern_badges ) )
		{
			return $bern_badges[ $bern_badge ];
		}

		return $bern_badges[ self::DEFAULT_BADGE ];
	}
}

$controller = new Badge;

/* activate */
register_activation_hook( __FILE__, array( $controller, 'activate' ) );

if ( ! is_admin() )
{
	/* enqueue js and css */
	add_action( 'init', array( $controller, 'init' ) );
}
else
{
	/* enqueue js and css */
	add_action( 'init', array( $controller, 'admin_init' ) );

	/* register settings */
	add_action( 'admin_init', array( $controller, 'register_settings' ) );

	/* add the settings page link */
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $controller, 'settings_link' ) );

	/* add the settings page */
	add_action( 'admin_menu', array( $controller, 'settings_page' ) );
}
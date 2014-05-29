<?php
/**
 * Name: Admin Tools
 * Class: UsabilityDynamics\WPP\Admin_Tools
 * Minimum Core Version: 1.38.3
 * Version: 3.5.2
 * Description: Administrative Tools.
 * Capability: manage_wpp_admintools
 * Slug: wp-property-admin-tools
 *
 */
namespace UsabilityDynamics\WPP {

  if( !class_exists( 'UsabilityDynamics\WPP\Admin_Tools' ) ) {

    /**
     * Admin_Tools Class
     *
     * Contains administrative functions
     *
     * Copyright 2010 Andy Potanin, TwinCitiesTech.com, Inc.  <andy.potanin@twincitiestech.com>
     *
     * @version 1.0
     * @author Andy Potanin <andy.potanin@twincitiestech.com>
     * @package WP-Property
     * @subpackage Admin Functions
     */
    class Admin_Tools {

      /**
       * ( custom ) Capability to manage the current feature
       */
      static protected $capability = "manage_wpp_admintools";

      function __construct() {
        add_action( 'wpp_init', array( &$this, 'init' ) );
        add_action( 'wpp_pre_init', array( &$this, 'pre_init' ) );
      }

      function get( $key, $default ) {}
      function set( $key, $value ) {}

      /**
       * Special functions that must be called prior to init
       *
       */
      function pre_init() {
        /* Add capability */
        add_filter( 'wpp_capabilities', array( &$this, "add_capability" ) );
      }

      /*
       * Apply feature's Hooks and other functionality
       */
      function init() {

        if( current_user_can( self::$capability ) ) {
          //** Add Inquiry page to Property Settings page array */
          add_filter( 'wpp_settings_nav', array( &$this, 'settings_nav' ) );
          //** Add Settings Page */

          add_action( 'wpp_settings_content_admin_tools', array( &$this, 'settings_page' ) );
          //** Contextual Help */
          add_action( 'property_page_property_settings_help', array( &$this, 'wpp_contextual_help' ) );
        }

      }

      /*
       * Adds Custom capability to the current premium feature
       */
      function add_capability( $capabilities ) {

        $capabilities[ self::$capability ] = __( 'Manage Admin Tools', 'wpp' );

        return $capabilities;
      }

      /**
       * Add Contextual help item
       *
       * @param type $data
       *
       * @return string
       * @author korotkov@ud
       */
      function wpp_contextual_help( $data ) {

        $data[ 'Developer' ][ ] = '<h3>' . __( 'Developer', 'wpp' ) . '</h3>';
        $data[ 'Developer' ][ ] = '<p>' . __( 'The <b>slug</b> is automatically created from the title and is used in the back-end.  It is also used for template selection, example: floorplan will look for a template called property-floorplan.php in your theme folder, or default to property.php if nothing is found.' ) . '</p>';
        $data[ 'Developer' ][ ] = '<p>' . __( 'If <b>Searchable</b> is checked then the property will be loaded for search, and available on the property search widget.' ) . '</p>';
        $data[ 'Developer' ][ ] = '<p>' . __( 'If <b>Location Matters</b> is checked, then an address field will be displayed for the property, and validated against Google Maps API.  Additionally, the property will be displayed on the SuperMap, if the feature is installed.' ) . '</p>';
        $data[ 'Developer' ][ ] = '<p>' . __( '<b>Hidden Attributes</b> determine which attributes are not applicable to the given property type, and will be grayed out in the back-end.' ) . '</p>';
        $data[ 'Developer' ][ ] = '<p>' . __( '<b>Inheritance</b> determines which attributes should be automatically inherited from the parent property' ) . '</p>';
        $data[ 'Developer' ][ ] = '<p>' . __( 'Property attributes are meant to be short entries that can be searchable, on the back-end attributes will be displayed as single-line input boxes. On the front-end they are displayed using a definitions list.' ) . '</p>';
        $data[ 'Developer' ][ ] = '<p>' . __( 'Making an attribute as "searchable" will list it as one of the searchable options in the Property Search widget settings.' ) . '</p>';
        $data[ 'Developer' ][ ] = '<p>' . __( 'Be advised, attributes added via add_filter() function supercede the settings on this page.' ) . '</p>';
        $data[ 'Developer' ][ ] = '<p>' . __( '<b>Search Input:</b> Select and input type and enter comma-separated values that you would like to be used in property search, on the front-end.', 'wpp' ) . '</p>';
        $data[ 'Developer' ][ ] = '<p>' . __( '<b>Data Entry:</b> Enter comma-separated values that you would like to use on the back-end when editing properties.', 'wpp' ) . '</p>';

        return $data;

      }

      /**
       * Adds admin tools manu to settings page navigation
       *
       * @version 1.0
       * Copyright 2010 Andy Potanin, TwinCitiesTech.com, Inc.  <andy.potanin@twincitiestech.com>
       */
      function settings_nav( $tabs ) {

        $tabs[ 'admin_tools' ] = array(
          'slug'  => 'admin_tools',
          'title' => __( 'Developer', 'wpp' )
        );

        return $tabs;
      }

      /**
       * Displays advanced management page
       *
       *
       * @version 1.0
       * Copyright 2010 Andy Potanin, TwinCitiesTech.com, Inc.  <andy.potanin@twincitiestech.com>
       */
      function settings_page() {
        global $wpdb, $wp_properties;

        //$wpp_inheritable_attributes = $wp_properties[ 'property_stats' ];

        include_once( __DIR__ . '/ui/settings-section.php' );

      }

    }

  }

}
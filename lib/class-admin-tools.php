<?php
/**
 * Name: Admin Tools
 * Class: UsabilityDynamics\WPP\Admin_Tools
 * Internal Slug: admin_tools
 * Minimum Core Version: 1.38.3
 * Feature ID: 1
 * Version: 3.5.2
 * Description: Administrative Tools.
 *
 */namespace UsabilityDynamics\WPP {

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

      static protected $version = '3.5.2';

      /**
       * ( custom ) Capability to manage the current feature
       */
      static protected $capability = "manage_wpp_admintools";

      /**
       * Special functions that must be called prior to init
       *
       */
      function pre_init() {
        global $wp_properties;

        //**
        // As we want to get rid of property_meta - let's simply convert it to property stats.
        // We should do this only if property_meta exists which means that we did not do this yet.
        //*/
        if ( !empty( $wp_properties['property_meta'] ) && is_array( $wp_properties['property_meta'] ) ) {
          $wp_properties['property_stats'] = array_merge( (array)$wp_properties['property_stats'], (array)$wp_properties['property_meta'] );

          foreach( $wp_properties['property_meta'] as $meta_key => $meta_value ) {
            $wp_properties[ '_attribute_classification' ][ $meta_key ] = 'detail';
          }

          unset( $wp_properties['property_meta'] );
        }

        //** Legacy support for property_meta */
        if ( !is_admin() && ( empty($wp_properties[ 'configuration' ][ 'disable_legacy_detailed' ]) || $wp_properties[ 'configuration' ][ 'disable_legacy_detailed' ]=='false' ) ){
          foreach (array_keys((array)$wp_properties[ '_attribute_classification' ],'detail') as $slug){
            $wp_properties['property_meta'][$slug] = $wp_properties['property_stats'][$slug];
          }
        }

        /* Add capability */
        add_filter( 'wpp_capabilities', array( 'class_admin_tools', "add_capability" ) );
      }

      /**
       * Apply feature's Hooks and other functionality
       */
      static function init() {

        //**
        // Temp hack for removing admin_tools from available_features
        // It should be just removed from corporate DB later
        //*/
        global $wp_properties;
        unset($wp_properties['available_features']['class_admin_tools']);

        if( current_user_can( self::$capability ) ) {
          add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue_scripts' ) );
          //** Add Inquiry page to Property Settings page array */
          add_filter( 'wpp_settings_nav', array( __CLASS__, 'settings_nav' ) );
          //** Contextual Help */
          add_action( 'property_page_property_settings_help', array( __CLASS__, 'wpp_contextual_help' ) );
          //** JS Localization */
          add_filter( 'wpp::js::localization', array( __CLASS__, 'localize_scripts' ) );
        }

      }

      /**
       * Adds localization support to JS scripts.
       *
       * @param array $l10n
       * @return array
       */
      static function localize_scripts( $l10n ) {

        $l10n = (array) $l10n + array(
            'at_description'        => __( 'In this page you will be able to create and edit property attributes and organize them in groups, set data types and visibility and choose input fields for them', 'wpp' ),
            'at_search_input_colon' => __( 'Search Input:', 'wpp' ),
            'at_admin_input_colon'  => __( 'Admin Input:', 'wpp' ),
            'at_show_in_overview'   => __( 'Show in Overview', 'wpp' ),
            'at_searchable'         => __( 'Searchable', 'wpp' ),
            'at_sortable'           => __( 'Sortable', 'wpp' ),
            'at_slug_colon'         => __( 'Slug:', 'wpp' ),
            'at_disabled'           => __( 'Disable Attribute', 'wpp' ),
            'add_new_attribute'     => __( 'Add New Attribute', 'wpp' ),
            'add_new_group'         => __( 'Add New Group', 'wpp' ),
            'at_group_rename'       => __( 'Double click to edit Group', 'wpp' ),
            'at_admin_pre_values'   => __( 'Admin Values:', 'wpp' ),
            'at_search_pre_values'  => __( 'Search Values:', 'wpp' ),
            'at_main_attr_group'    => __( 'Main Attribute Group', 'wpp' ),
            'at_main_group_hint'    => __( 'Select which group is the main. Attributes from Main Group will be located at the top of attributes list on front-end.', 'wpp' ),
            'at_display_settings'    => __( 'Display Settings', 'wpp' ),
            'at_show_true_as_image_label' =>  sprintf( __( 'When displaying "%1$s / %2$s" attributes, show checkbox icons instead of "%1$s" and "%2$s" values.','wpp' ), __( 'Yes', 'wpp' ),__( 'No', 'wpp' ) )
          );

        return $l10n;
      }

      /**
       * Include admin scripts
       *
       * @global type $current_screen
       * @return type
       */
      function admin_enqueue_scripts() {
        global $current_screen;

        if( $current_screen->id == 'property_page_property_settings' ) {
          wp_enqueue_script( 'wpp-admin_tools', WPP_URL . 'js/models/admin_tools.model.js', array( 'wp-property-admin-global' ), WPP_ATools_Version, true );
        }

      }

      /**
       * Adds Custom capability to the current premium feature
       *
       * @param array $capabilities
       * @return type
       */
      function add_capability( $capabilities ) {

        $capabilities[self::$capability] = __( 'Manage Admin Tools','wpp' );

        return $capabilities;
      }

      /**
       * Add Contextual help item
       *
       * @param type $data
       * @return string
       * @author korotkov@ud
       */
      function wpp_contextual_help( $data ) {

        $data['Data Structure'][] = '<h3>' . __( 'Data Structure', 'wpp' ) .'</h3>';
        $data['Data Structure'][] = '<p>' . __( 'The <b>slug</b> is automatically created from the title and is used in the back-end.  It is also used for template selection, example: floorplan will look for a template called property-floorplan.php in your theme folder, or default to property.php if nothing is found.' ) .'</p>';
        $data['Data Structure'][] = '<p>' . sprintf(__( 'If <b>Searchable</b> is checked then the %1$s will be loaded for search, and available on the %1$s search widget.' ),WPP_F::property_label( 'singular' )) .'</p>';
        $data['Data Structure'][] = '<p>' . sprintf(__( 'If <b>Location Matters</b> is checked, then an address field will be displayed for the  %1$s, and validated against Google Maps API.  Additionally, the %1$s will be displayed on the SuperMap, if the feature is installed.' ),WPP_F::property_label( 'singular' )) .'</p>';
        $data['Data Structure'][] = '<p>' . sprintf(__( '<b>Hidden Attributes</b> determine which attributes are not applicable to the given %1$s type, and will be grayed out in the back-end.' ),WPP_F::property_label( 'singular' )) .'</p>';
        $data['Data Structure'][] = '<p>' . sprintf(__( '<b>Inheritance</b> determines which attributes should be automatically inherited from the parent %1$s.' ), WPP_F::property_label( 'singular' )) .'</p>';
        $data['Data Structure'][] = '<p>' . sprintf(__( '%1$s attributes are meant to be short entries that can be searchable, on the back-end attributes will be displayed as single-line input boxes. On the front-end they are displayed using a definitions list.' ), ucfirst(WPP_F::property_label( 'singular' ))) .'</p>';
        $data['Data Structure'][] = '<p>' . sprintf(__( 'Making an attribute as "searchable" will list it as one of the searchable options in the %1$s Search widget settings.' ), ucfirst(WPP_F::property_label( 'singular' ))) .'</p>';
        $data['Data Structure'][] = '<p>' . __( 'Be advised, attributes added via add_filter() function supercede the settings on this page.' ) .'</p>';
        $data['Data Structure'][] = '<p>' . sprintf(__( '<b>Search Input:</b> Select and input type and enter comma-separated values that you would like to be used in %1$s Search, on the front-end.', 'wpp' ), ucfirst(WPP_F::property_label( 'singular' ))) .'</p>';
        $data['Data Structure'][] = '<p>' . sprintf(__( '<b>Administrative:</b> Enter comma-separated values that you would like to use on the back-end when editing %1$s.', 'wpp' ), WPP_F::property_label( 'plural' )) .'</p>';

        return $data;

      }

      /**
       * Adds admin tools menu to settings page navigation
       *
       * @version 1.0
       * @copyright 2010-2012 Usability Dynamics, Inc. <info@usabilitydynamics.com>
       */
      function settings_nav( $tabs ) {

        $tabs['listing_types'] = array(
          'slug' => 'class_admin_tools',
          'interface' => 'listing_types',
          'title' => sprintf( __( '%1s Types','wpp' ), WPP_F::property_label() ),
          'feature' => false
        );

        $tabs['attribute_builder'] = array(
          'slug' => 'class_admin_tools',
          'interface' => 'attribute_builder',
          'title' => sprintf( __( '%1s Attributes','wpp' ), WPP_F::property_label() ),
          'feature' => false
        );

        return $tabs;
      }

      /**
       * Displays advanced management page
       *
       * @version 1.0
       * @copyright 2010-2012 Usability Dynamics, Inc. <info@usabilitydynamics.com>
       */
      function settings_page() {
        $interface =  WPP_UI::get_interface( 'attribute_builder' );
        echo is_wp_error( $interface ) ? $interface->get_error_message() : $interface;
      }

    }

  }

}
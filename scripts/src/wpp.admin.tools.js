/**
 * Admin Tools Handler
 *
 */
define( 'wpp.admin.tools', function Loader( require, exports, module ) {
  console.log( 'loaded', module.id, 'module' );

  return function Handler() {
    console.log( 'initialized', module.id, 'module' );

    jQuery( document ).ready( function() {

      jQuery( "#wpp_inquiry_attribute_fields tbody" ).sortable( {
        delay: 200
      } );

      jQuery( "#wpp_inquiry_meta_fields tbody" ).sortable( {
        delay: 200
      } );

      jQuery( "#wpp_inquiry_attribute_fields tbody tr, #wpp_inquiry_meta_fields tbody tr" ).live( "mouseover", function() {
        jQuery( this ).addClass( "wpp_draggable_handle_show" );
      } );
      ;

      jQuery( "#wpp_inquiry_attribute_fields tbody tr, #wpp_inquiry_meta_fields tbody tr" ).live( "mouseout", function() {
        jQuery( this ).removeClass( "wpp_draggable_handle_show" );
      } );
      ;

      /* Show advanced settings for an attribute when a certain value is changed */

      /*
       jQuery(".wpp_searchable_attr_fields").live("change", function() {
       var parent = jQuery(this).closest(".wpp_dynamic_table_row");
       jQuery(".wpp_development_advanced_option", parent).show();
       });
       */

      jQuery( ".wpp_all_advanced_settings" ).live( "click", function() {
        var action = jQuery( this ).attr( "action" );

        if( action == "expand" ) {
          jQuery( "#wpp_inquiry_attribute_fields .wpp_development_advanced_option" ).show();
        }

        if( action == "collapse" ) {
          jQuery( "#wpp_inquiry_attribute_fields .wpp_development_advanced_option" ).hide();
        }

      } )

      //* Stats to group functionality */
      jQuery( '.wpp_attribute_group' ).wppGroups();

      //* Fire Event after Row is added */
      jQuery( '#wpp_inquiry_attribute_fields tr' ).live( 'added', function() {
        //* Remove notice block if it exists */
        var notice = jQuery( this ).find( '.wpp_notice' );
        if( notice.length > 0 ) {
          notice.remove();
        }
        //* Unassign Group from just added Attribute */
        jQuery( 'input.wpp_group_slug', this ).val( '' );
        this.removeAttribute( 'wpp_attribute_group' );

        //* Remove background-color from the added row if it's set */
        if( typeof jQuery.browser.msie != 'undefined' && (parseInt( jQuery.browser.version ) == 9) ) {
          //* HACK FOR IE9 (it's just unset background color) peshkov@UD: */
          setTimeout( function() {
            var lr = jQuery( '#wpp_inquiry_attribute_fields tr.wpp_dynamic_table_row' ).last();
            var bc = lr.css( 'background-color' );
            lr.css( 'background-color', '' );
            jQuery( document ).bind( 'mousemove', function() {
              setTimeout( function() {
                lr.prev().css( 'background-color', bc );
              }, 50 );
              jQuery( document ).unbind( 'mousemove' );
            } );
          }, 50 );
        } else {
          jQuery( this ).css( 'background-color', '' );
        }

        //* Stat to group functionality */
        jQuery( this ).find( '.wpp_attribute_group' ).wppGroups();

      } );

      //* Determine if slug of property stat is the same as Geo Type has and show notice */
      jQuery( '#wpp_inquiry_attribute_fields tr .wpp_stats_slug_field' ).live( 'change', function() {
        var slug = jQuery( this ).val();
        var geo_type = false;
        if( typeof geo_type_attrs == 'object' ) {
          for( var i in geo_type_attrs ) {
            if( slug == geo_type_attrs[i] ) {
              geo_type = true;
              break;
            }
          }
        }
        var notice = jQuery( this ).parent().find( '.wpp_notice' );
        if( geo_type ) {
          if( !notice.length > 0 ) {
            //* Toggle Advanced option to show notice */
            var advanced_options = (jQuery( this ).parents( 'tr.wpp_dynamic_table_row' ).find( '.wpp_development_advanced_option' ));
            if( advanced_options.length > 0 ) {
              if( jQuery( advanced_options.get( 0 ) ).is( ':hidden' ) ) {
                jQuery( this ).parents( 'tr.wpp_dynamic_table_row' ).find( '.wpp_show_advanced' ).trigger( 'click' );
              }
            }
            jQuery( this ).parent().append( '<div class="wpp_notice"></div>' );
            notice = jQuery( this ).parent().find( '.wpp_notice' );
          }

          notice.html( '' );

        } else {
          if( notice.length > 0 ) {
            notice.remove();
          }
        }
      } );

      jQuery( ".wpp_pre_defined_value_setter" ).live( "change", function() {
        set_pre_defined_values_for_attribute( this );
      } );

      jQuery( ".wpp_pre_defined_value_setter" ).each( function() {
        set_pre_defined_values_for_attribute( this );
      } );

      function set_pre_defined_values_for_attribute( setter_element ) {

        var wrapper = jQuery( setter_element ).closest( "ul" );
        var setting = jQuery( setter_element ).val();
        var value_field = jQuery( "textarea.wpp_attribute_pre_defined_values", wrapper );

        switch( setting ) {

          case 'input':
            jQuery( value_field ).hide();
            break;

          case 'range_input':
            jQuery( value_field ).hide();
            break;

          case 'dropdown':
            jQuery( value_field ).show();
            break;

          case 'checkbox':
            jQuery( value_field ).hide();
            break;

          case 'multi_checkbox':
            jQuery( value_field ).show();
            break;

          default:
            jQuery( value_field ).hide();

        }

      }

    } );
  }

} );
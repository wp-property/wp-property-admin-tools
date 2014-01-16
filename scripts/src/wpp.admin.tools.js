/**
 * Admin Tools Handler
 *
 */
define( 'wpp.admin.tools', [ 'wpp.model', 'jquery', 'knockout', 'knockout.mapping' ], function() {
  // console.log( 'wpp.admin.tools:ko', ko );
  // console.log( 'wpp.admin.tools:jQuery', jQuery );

  return function domReady() {

    //var jQuery  = require( 'jquery' );
    var ko      = require( 'knockout' );
    var ko_mapping      = require( 'knockout.mapping' );
    var model   = require( 'wpp.model' );
    var _objectMap = function(o, handler){
      var res = {};
      for(var key in o) {
         res[key] = handler(o[key]);
      }
      return res;
    };

    var mapping = {
    
        _objectMap: function(o, handler) {
            var res = [];
            for(var key in o) {
             res.push(handler(o[key]));
            }
            return res;
        },

      //** Observable Attributes */
      attributes: {
        create : function( data ) {
          var that = mapping._objectMap( data.data, function( attr ){
            attr.new_item = false;
            return new mapping._attribute( attr );
          });
          return ko.observable( that );
        }
      },

      groups: {
        create : function( data ) {
          var that = mapping._objectMap( data.data, function( group ){
            group.new_item = false;
            return new mapping._group( group );
          });
          return ko.observable( that );
        }
      },

      _group: function( args ) {
        var self = this;
        args = jQuery.extend( true, {
            label      : 'New Group',
            slug       : 'new_group_tab_slug',
            edit_state  : false,
            reserved   : false,
            new_item   : true
        }, typeof args === 'object' ? args : {} );
        for( var i in args ) {
            if(typeof args[i] !== 'function') {
                self[i] = ko.observable( args[i] );
            }
        }
        
        self.delete_group = function( model ) {
            var c = typeof wpp.strings !== 'undefined' && typeof wpp.strings.remove_confirmation !== 'undefined' ?
            wpp.strings.remove_confirmation : 'Are you sure you want to remove group? All assigned attributes will be moved to Other.';
            if ( window.confirm( c ) ) {
              ko.utils.arrayForEach( model.attributes(), function(attr){
                if ( attr.group() === self.slug() ) {
                  attr.group('wpp_main');
                }
              });
              model.groups.remove( this );
            }
          };
          
        self.toggleEdit = function( item, event ) {
            jQuery('input[tab="tab_'+item.slug()+'"]').trigger('change');
            self.edit_state(!self.edit_state());
            if ( self.edit_state() ) {
              self.prevName = self.slug();
              jQuery('input[tab="tab_'+item.slug()+'"]').focus().select();
            } else {
              var model = false;
              if ( typeof wpp.settings_ui.view_model === 'object' ) {
                model = wpp.settings_ui.view_model.global;
                if ( self.slug() !== self.prevName ) {
                  ko.utils.arrayForEach( model.attributes(), function(attr){
                    if ( attr.group() === self.prevName ) {
                      attr.group(self.slug());
                    }
                  });
                }
              }
              if ( jQuery.trim(self.label()) === '' ) {
                self.label( self.prevName );
              }
            }
          };
      },
      
      _attribute: function ( args ) {
        var self = this;

          args = jQuery.extend( true, {
            label                : 'New Attribute',
            slug                 : 'new_attribute',
            group                : 'wpp_main',
            show_settings        : false,
            show_classifications : false,
            classification_label : 'Short Text',
            classification       : 'string',
            classification_settings : {},
            searchable           : false,
            sortable             : false,
            in_overview          : false,
            disabled             : false,
            search_predefined    : '',
            admin_predefined     : '',
            admin_input_type     : 'input',
            search_input_type    : 'input',
            show_admin_pre_values: false,
            show_search_pre_values: false,
            system               : false,
            reserved             : false,
            new_item             : true
          }, typeof args === 'object' ? args : {} );

          for( var i in args ) {
            if (typeof args[i] !== 'function'){
              self[i] = ko.observable( args[i] );
            }
          }
      
      }

    };

    var AttributeBuilder = ko_mapping.fromJS( model.settings._computed.data_structure, mapping );
    AttributeBuilder.add_data = function( item, vhanlder, view_model, event ) {
        if( typeof vhanlder == 'function' ) {
          item.push( new vhanlder );
        } else if ( typeof view_model[ vhanlder ] === 'function' ) {
          item.push( new view_model[ vhanlder ]() );
        }
        try{ self._args.actions.add_data( self, event, item, vhanlder ) } catch(e) { self._args.callback( e, view_model ); }
      };

    console.log( 'groups', AttributeBuilder.groups() );
    console.log( 'attributes', AttributeBuilder.attributes() );

    ko.applyBindings( AttributeBuilder, this );

    return;

    var geo_type_attrs = [];

    jQuery( "#wpp_inquiry_attribute_fields" ).find( 'tbody' ).sortable( {
      delay: 200
    } );

    jQuery( "#wpp_inquiry_meta_fields" ).find( 'tbody' ).sortable( {
      delay: 200
    } );

    jQuery( "#wpp_inquiry_attribute_fields tbody tr, #wpp_inquiry_meta_fields tbody tr" ).live( "mouseover", function() {
      jQuery( this ).addClass( "wpp_draggable_handle_show" );
    } );

    jQuery( "#wpp_inquiry_attribute_fields tbody tr, #wpp_inquiry_meta_fields tbody tr" ).live( "mouseout", function() {
      jQuery( this ).removeClass( "wpp_draggable_handle_show" );
    } );

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
    jQuery( '#wpp_inquiry_attribute_fields' ).find( 'tr' ).live( 'added', function() {
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

  }

});
<div data-requires="wpp.admin.tools" class="form-table wpp_option_table wpp_setting_interface">
  <div class="ud_tbody">
    <div class="wpp_primary_section">
      <div class="ud_td">
        <ul>
          <li>
            <div data-bind="visible: $root.attributes">
              <div class="wpp_side_load">
                <div class="wpp_side_load_content">
                  <div data-bind="tabbed: $root.groups(), droppable:{drop_cb:$root.drop_cb}">
                    <div class="wpp_vertical_tabs_wrapper">
                      <ul class="wpp_vertical_tabs" data-bind="sortable:{}, foreach: $root.groups()">
                        <li class="wpp_side_tab wpp_group_item" data-bind="attr: { wpp_group_name: ( $data.slug() ) }">
                          <input type="text" class="wpp_silent_edit" data-bind="unique_slug:{slug:$data.slug,text:$data.label,instance:'wpp_attribute_group_slug'}, enter_key: true, visible: $data.edit_state(), value: $data.label, attr: { 'tab':'tab_'+$data.slug(), 'name': 'wpp_settings[property_groups][' + ($data.slug()) + '][name]' }" />
                          <a data-bind="attr: {href:'#'+$data.slug()}">
                            <div>
                              <!-- ko if: !$data.reserved() -->
                              <span title="Rename" data-bind="visible: !$data.edit_state(), text: $data.label"></span>
                              <!-- /ko -->
                              <!-- ko if: $data.reserved() -->
                              <span data-bind="text: $data.label"></span>
                              <!-- /ko -->
                            </div>
                            <!-- ko if: !$data.reserved() -->
                            <span class="wpp_ddm"><span class="wpp_icon wpp_icon_48" data-bind="click: $data.delete_group.bind( $data, $root )">x</span></span>
                            <!-- /ko -->
                            <!-- ko if: !$data.reserved() && !$data.edit_state() -->
                            <span class="wpp_ddm"><span class="wpp_icon wpp_icon_145" data-bind="click: $data.toggleEdit">edit</span></span>
                            <!-- /ko -->
                            <!-- ko if: !$data.reserved() && $data.edit_state() -->
                            <span class="wpp_ddm"><span class="wpp_icon wpp_icon_44" data-bind="click: $data.toggleEdit">save</span></span>
                            <!-- /ko -->
                          </a>
                          <div class="wpp_clear"></div>
                        </li>
                      </ul>
                      <input type="button" class="button-secondary" data-bind="click: $root.add_data.bind( $root, $root.groups, $root._group )" value="Add New" />
                    </div>
                    <div class="wpp_tab_panel_wrapper">
                        <!-- ko foreach: $root.groups -->
                        <div data-bind="attr: {id:$data.slug}">
                            <ul class="wpp_tab_panel connectedSortable" data-bind="sortable:{start:$parentContext.$root.sort_start_cb,tolerance:'pointer', handle:'.wpp_handle', delay: 500}, foreach: $root.attributes">
                                <!-- ko if: $data.group() === $parentContext.$data.slug() && !$data.system() -->
                                    <li class="wpp_list_item wpp_attribute" data-bind="click: $data.click_inside, attr: {wpp_attribute_slug:$data.slug()}">
                                        <input type="hidden" data-bind="value: $data.group, attr: { name: 'wpp_settings[property_stats_groups][' + $data.slug() + ']' }" />
                                        <input class="wpp_attribute_classification" type="hidden" data-bind="value: $data.classification,  attr: { name: 'wpp_settings[attribute_classification][' + $data.slug() + ']' }" />
                                        <span class="wpp_button wpp_left wpp_handle"><span class="wpp_icon wpp_icon_120">M</span></span>

                                        <div class="wpp_input_wrapper">
                                            <input type="text" class="wpp_label wpp_major" data-bind="unique_slug:{slug:$data.slug,text:$data.label,instance:'wpp_attribute_item_slug'}, value: $data.label, attr: { 'name': 'wpp_settings[property_stats][' + ( $data.slug() ) + ']' }" autocomplete="off" />
                                        </div>

                                        <div class="wpp_input_wrapper wpp_hide_on_drag wpp_classifications">
                                            <input type="text" class="wpp_label wpp_major" data-bind="value: $data.classification_label" autocomplete="off" readonly="readonly" />
                                            <!-- ko if: !$data.reserved() -->
                                            <ul class="wpp_attribute_classifications" data-bind="visible: $data.show_classifications, foreach: $root.attribute_classification">
                                                <li data-bind="visible: !$data.settings.system()" ><a data-bind="click: $parentContext.$data.select_classification" href="javascript:void(0);"><span class="wpp_label" data-bind="text: $data.label"></span><span class="wpp_description" data-bind="text: $data.description"></span></a></li>
                                            </ul>
                                            <span class="wpp_button" data-bind="click: $data.toggle_classifications"><span class="wpp_icon wpp_icon_148">classifications</span></span>
                                            <!-- /ko -->
                                        </div>

                                        <div class="wpp_row_actions wpp_hide_on_drag">
                                            <span class="wpp_button wpp_left" data-bind="click: $data.toggle_settings"><span class="wpp_icon wpp_icon_96">settings</span></span>
                                            <!-- ko if: !$data.reserved() -->
                                            <span class="wpp_button wpp_right"><span class="wpp_icon wpp_icon_56" data-bind="click: $root.remove_data.bind( $data, $root.attributes )">x</span></span>
                                            <!-- /ko -->
                                        </div>

                                        <div class="wpp_collapsed wpp_hide_on_drag" data-bind="visible: $data.show_settings">
                                            <div class="row">
                                                <textarea class="wpp_textarea" placeholder="Please enter a description" data-bind="value: $data.description, attr:{'name':'wpp_settings[property_stats_descriptions]['+$data.slug()+']'}" ></textarea>
                                            </div>
                                            <div class="row clearfix">
                                              <div class="wpp_left">
                                                <table class="wpp_clean">
                                                  <tbody>
                                                    <tr>
                                                      <td><label data-bind="attr:{'for':'wpp_attr_slug_'+$data.slug()}">Slug:</label></td>
                                                      <td><input type="text" class="wpp_slug" readonly="true" data-bind="attr:{id:'wpp_attr_slug_'+$data.slug()}, value: $data.slug"></input></td>
                                                    </tr>
                                                    <!-- ko if: $data.classification_settings().editable -->
                                                    <!-- Administrative Input -->
                                                    <tr>
                                                      <td><label data-bind="attr: {'for':'wpp_admin_inputs_'+$data.slug()}">Admin Input:</label></td>
                                                      <td><select class="wpp_predefined_input_type wpp_admin_inputs" data-bind="value:$data.admin_input_type, attr: {id:'wpp_admin_inputs_'+$data.slug(),_type:$data.admin_input_type, name: 'wpp_settings[admin_attr_fields][' + $data.slug() + ']'}, event: {change: $data.show_admin_values}"></select></td>
                                                    </tr>
                                                    <!-- ko if: $data.classification_settings().admin_predefined_values -->
                                                    <!-- Administrative predefined values -->
                                                    <tr class="wpp_admin_values" style="display:none;">
                                                      <td><label>Admin Predefined:</label></td>
                                                      <td><textarea data-bind="value: $data.admin_predefined, attr: {name: 'wpp_settings[predefined_values][' + $data.slug() + ']'}"></textarea></td>
                                                    </tr>
                                                    <!-- /ko -->
                                                    <!-- /ko -->
                                                    <!-- ko if: $data.classification_settings().searchable -->
                                                    <!-- Search Input -->
                                                    <tr>
                                                      <td><label data-bind="attr: {'for':'wpp_search_inputs_'+$data.slug()}">Search Input:</label></td>
                                                      <td><select class="wpp_predefined_input_type wpp_search_inputs" data-bind="value:$data.search_input_type, attr: {id:'wpp_search_inputs_'+$data.slug(), _type:$data.search_input_type, name: 'wpp_settings[searchable_attr_fields][' + $data.slug() + ']'}, event: {change: $data.show_search_values}"></select></td>
                                                    </tr>
                                                    <!-- ko if: $data.classification_settings().search_predefined_values -->
                                                    <!-- Search predefined values -->
                                                    <tr class="wpp_search_values" style="display:none;">
                                                      <td><label>Search Predefined Values:</label></td>
                                                      <td><textarea data-bind="value: $data.search_predefined, attr: {name: 'wpp_settings[predefined_search_values][' + $data.slug() + ']'}"></textarea></td>
                                                    </tr>
                                                    <!-- /ko -->
                                                    <!-- /ko -->
                                                  </tbody>
                                                </table>
                                              </div>
                                              <div class="wpp_right">
                                                <table class="wpp_clean">
                                                  <tbody>
                                                    <tr>
                                                      <td>
                                                        <input type="checkbox" data-bind="checked: $data.sortable, attr: {id:'wpp_attr_sortable_'+$data.slug(), name: 'wpp_settings[sortable_attributes][]' }, value: $data.slug"></input>
                                                        <label data-bind="attr: {'for':'wpp_attr_sortable_'+$data.slug()}">Sortable</label>
                                                      </td>
                                                    </tr>
                                                    <!-- ko if: $data.classification_settings().searchable -->
                                                    <tr>
                                                      <td>
                                                        <input type="checkbox" data-bind="checked: $data.searchable, attr: {id:'wpp_attr_searchable_'+$data.slug(), name: 'wpp_settings[searchable_attributes][]' }, value: $data.slug"></input>
                                                        <label data-bind="attr: {'for':'wpp_attr_searchable_'+$data.slug()}">Searchable</label>
                                                      </td>
                                                    </tr>
                                                    <!-- /ko -->
                                                    <tr>
                                                      <td>
                                                        <input type="checkbox" data-bind="checked: $data.in_overview, attr: {id:'wpp_attr_in_overview_'+$data.slug(), name: 'wpp_settings[column_attributes][]' }, value: $data.slug"></input>
                                                        <label data-bind="attr: {'for':'wpp_attr_in_overview_'+$data.slug()}">Show in Overview</label>
                                                      </td>
                                                    </tr>
                                                    <!-- ko if: $data.classification_settings().can_be_disabled -->
                                                    <tr>
                                                      <td>
                                                        <input type="checkbox" data-bind="checked: $data.disabled, attr: {id:'wpp_attr_disabled_'+$data.slug(), name: 'wpp_settings[disabled_attributes][]' }, value: $data.slug"></input>
                                                        <label data-bind="attr: {'for':'wpp_attr_disabled_'+$data.slug()}">Disabled</label>
                                                      </td>
                                                    </tr>
                                                    <!-- /ko -->
                                                  </tbody>
                                              </table>
                                            </div>
                                          </div>

                                        </div>
                                        <div class="wpp_clear"></div>
                                    </li>
                                <!-- /ko -->
                            </ul>
                            <input type="button" class="button-secondary" data-bind="click: $root.add_attribute.bind( $root, {group:$data.slug()} )" value="Add New Attribute"></input>
                        </div>
                        <!-- /ko -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <div class="wpp_clear"></div>
    </div>
    <div class="wpp_secondary_section">
      <div class="ud_th">
        <strong>Dysplay Settings</strong>
      </div>
      <div class="ud_td">
        <ul>
          <li>
            <label>Main Group</label>
            <select data-bind="attr:{name:'wpp_settings[configuration][main_stats_group]'}, options: $root.groups, optionsText: 'label', optionsValue: 'slug'"></select>
            <span class="wpp_help wpp_button" style="margin-left:5px; margin-bottom:5px;">
              <span class="wpp_icon wpp_icon_106"></span>
              <div class="wpp_description">Descriptions for this option</div>
            </span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>




<table class="form-table">

  <tr>
    <td>
      <h3><?php //printf( __( '%1s Types', 'wpp' ), UsabilityDynamics\WPP\Utility::property_label() ); ?></h3>
      <table id="wpp_inquiry_property_types" class="ud_ui_dynamic_table widefat" allow_random_slug="true">
      <thead>
        <tr>
          <th><?php _e( 'Type', 'wpp' ) ?></th>
          <th><?php _e( 'Slug', 'wpp' ) ?></th>
          <th><?php _e( 'Settings', 'wpp' ) ?></th>
          <th><?php _e( 'Hidden Attributes', 'wpp' ) ?></th>
          <th><?php _e( 'Inherit from Parent', 'wpp' ) ?></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach( $wp_properties[ 'property_types' ] as $property_slug => $label ): ?>

        <tr class="wpp_dynamic_table_row" slug="<?php echo $property_slug; ?>" new_row='false'>
        <td>
          <input class="slug_setter" type="text" name="wpp_settings[property_types][<?php echo $property_slug; ?>]" value="<?php echo $label; ?>"/><br/>
          <span class="wpp_delete_row wpp_link">Delete</span>
        </td>
        <td>
          <input type="text" class="slug" readonly='readonly' value="<?php echo $property_slug; ?>"/>
        </td>

        <td>
          <ul>
            <li>
              <label for="<?php echo $property_slug; ?>_searchable_property_types">
                <input class="slug" id="<?php echo $property_slug; ?>_searchable_property_types" <?php if( is_array( $wp_properties[ 'searchable_property_types' ] ) && in_array( $property_slug, $wp_properties[ 'searchable_property_types' ] ) ) echo " CHECKED "; ?> type="checkbox" name="wpp_settings[searchable_property_types][]" value="<?php echo $property_slug; ?>"/>
                <?php _e( 'Searchable', 'wpp' ) ?>
              </label>
            </li>

            <li>
              <label for="<?php echo $property_slug; ?>_location_matters">
                <input class="slug" id="<?php echo $property_slug; ?>_location_matters"  <?php if( in_array( $property_slug, $wp_properties[ 'location_matters' ] ) ) echo " CHECKED "; ?> type="checkbox" name="wpp_settings[location_matters][]" value="<?php echo $property_slug; ?>"/>
                <?php _e( 'Location Matters', 'wpp' ) ?>
              </label>
            </li>
            <?php $property_type_settings = apply_filters( 'wpp_property_type_settings', array(), $property_slug ); ?>
            <?php foreach( (array) $property_type_settings as $property_type_setting ) : ?>
              <li>
              <?php echo $property_type_setting; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </td>

        <td>
          <ul class="wp-tab-panel wpp_hidden_property_attributes wpp_something_advanced_wrapper">

          <li class="wpp_show_advanced" wrapper="wpp_something_advanced_wrapper"><?php _e( 'Toggle Attributes Selection', 'wpp' ); ?></li>

            <?php foreach( $wp_properties[ 'property_stats' ] as $property_stat_slug => $property_stat_label ) { ?>
              <li class="wpp_development_advanced_option">
            <input id="<?php echo $property_slug . "_" . $property_stat_slug; ?>_hidden_attributes" <?php if( isset( $wp_properties[ 'hidden_attributes' ][ $property_slug ] ) && in_array( $property_stat_slug, $wp_properties[ 'hidden_attributes' ][ $property_slug ] ) ) echo " CHECKED "; ?> type="checkbox" name="wpp_settings[hidden_attributes][<?php echo $property_slug; ?>][]" value="<?php echo $property_stat_slug; ?>"/>
            <label for="<?php echo $property_slug . "_" . $property_stat_slug; ?>_hidden_attributes">
              <?php echo $property_stat_label; ?>
            </label>
          </li>
            <?php } ?>

            <?php foreach( $wp_properties[ 'property_meta' ] as $property_meta_slug => $property_meta_label ) { ?>
              <li class="wpp_development_advanced_option">
            <input id="<?php echo $property_slug . "_" . $property_meta_slug; ?>_hidden_attributes" <?php if( isset( $wp_properties[ 'hidden_attributes' ][ $property_slug ] ) && in_array( $property_meta_slug, $wp_properties[ 'hidden_attributes' ][ $property_slug ] ) ) echo " CHECKED "; ?> type="checkbox" name="wpp_settings[hidden_attributes][<?php echo $property_slug; ?>][]" value="<?php echo $property_meta_slug; ?>"/>
            <label for="<?php echo $property_slug . "_" . $property_meta_slug; ?>_hidden_attributes">
              <?php echo $property_meta_label; ?>
            </label>
          </li>
            <?php } ?>

            <?php if( !$wp_properties[ 'property_stats' ][ 'parent' ] ) { ?>
              <li class="wpp_development_advanced_option">
            <input id="<?php echo $property_slug; ?>parent_hidden_attributes" <?php if( isset( $wp_properties[ 'hidden_attributes' ][ $property_slug ] ) && in_array( 'parent', $wp_properties[ 'hidden_attributes' ][ $property_slug ] ) ) echo " CHECKED "; ?> type="checkbox" name="wpp_settings[hidden_attributes][<?php echo $property_slug; ?>][]" value="parent"/>
            <label for="<?php echo $property_slug; ?>parent_hidden_attributes"><?php _e( 'Parent Selection', 'wpp' ); ?></label>
          </li>
            <?php } ?>

          </ul>
        </td>

         <td>
          <ul class="wp-tab-panel wpp_inherited_property_attributes wpp_something_advanced_wrapper">
            <li class="wpp_show_advanced" wrapper="wpp_something_advanced_wrapper"><?php _e( 'Toggle Attributes Selection', 'wpp' ); ?></li>
            <?php foreach( $wpp_inheritable_attributes as $property_stat_slug => $property_stat_label ): ?>
              <li class="wpp_development_advanced_option">
              <input id="<?php echo $property_slug . "_" . $property_stat_slug; ?>_inheritance" <?php if( isset( $wp_properties[ 'property_inheritance' ][ $property_slug ] ) && in_array( $property_stat_slug, $wp_properties[ 'property_inheritance' ][ $property_slug ] ) ) echo " CHECKED "; ?> type="checkbox" name="wpp_settings[property_inheritance][<?php echo $property_slug; ?>][]" value="<?php echo $property_stat_slug; ?>"/>
              <label for="<?php echo $property_slug . "_" . $property_stat_slug; ?>_inheritance">
                <?php echo $property_stat_label; ?>
              </label>
            </li>
            <?php endforeach; ?>
            <li>
          </ul>
        </td>

      </tr>

      <?php endforeach; ?>
      </tbody>

      <tfoot>
        <tr>
          <td colspan='5'>
          <input type="button" class="wpp_add_row button-secondary" value="<?php _e( 'Add Row', 'wpp' ) ?>"/>
          </td>
        </tr>
      </tfoot>

      </table>
  </td>
  </tr>

  <tr>
    <td>
      <h3><?php _e( 'Advanced Options', 'wpp' ); ?></h3>
      <ul>
        <li>
          <?php // echo UsabilityDynamics\WPP\Utility::checkbox( "name=wpp_settings[configuration][show_ud_log]&label=" . __( 'Show Log.', 'wpp' ), $wp_properties[ 'configuration' ][ 'show_ud_log' ] ); ?>
          <br/>
          <span class="description"><?php _e( 'The log is always active, but the UI is hidden.  If enabled, it will be visible in the admin sidebar.', 'wpp' ); ?></span>
        </li>
        <li>
          <?php //echo UsabilityDynamics\WPP\Utility::checkbox( "name=wpp_settings[configuration][allow_parent_deep_depth]&label=" . __( 'Enable \'Falls Under\' deep depth.', 'wpp' ), $wp_properties[ 'configuration' ][ 'allow_parent_deep_depth' ] ); ?>
          <br/>
          <span class="description"><?php _e( 'Allows to set child property as parent.', 'wpp' ); ?></span>
        </li>
        <li>
          <?php //echo UsabilityDynamics\WPP\Utility::checkbox( "name=wpp_settings[configuration][disable_automatic_feature_update]&label=" . __( 'Disable automatic feature updates.', 'wpp' ), $wp_properties[ 'configuration' ][ 'disable_automatic_feature_update' ] ); ?>
          <br/>
          <span class="description"><?php _e( 'If disabled, feature updates will not be downloaded automatically.', 'wpp' ); ?></span>
        </li>
        <li>
          <?php// echo UsabilityDynamics\WPP\Utility::checkbox( "name=wpp_settings[configuration][disable_wordpress_postmeta_cache]&label=" . __( 'Disable WordPress update_post_caches() function.', 'wpp' ), $wp_properties[ 'configuration' ][ 'disable_wordpress_postmeta_cache' ] ); ?>
          <br/>
          <span class="description"><?php _e( 'This may solve Out of Memory issues if you have a lot of properties.', 'wpp' ); ?></span>
        </li>
        <li>
          <?php //echo UsabilityDynamics\WPP\Utility::checkbox( "name=wpp_settings[configuration][developer_mode]&label=" . __( 'Enable developer mode - some extra information displayed via Firebug console.', 'wpp' ), $wp_properties[ 'configuration' ][ 'developer_mode' ] ); ?>
          <br/>
        </li>

      </ul>
    </td>
  </tr>

</table>

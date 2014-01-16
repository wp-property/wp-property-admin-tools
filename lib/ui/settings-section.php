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
                                        <span class="wpp_button wpp_left wpp_handle"><span class="wpp_icon wpp_icon_120"></span></span>

                                        <div class="wpp_input_wrapper">
                                            <input type="text" class="wpp_label wpp_major" data-bind="unique_slug:{slug:$data.slug,text:$data.label,instance:'wpp_attribute_item_slug'}, value: $data.label, attr: { 'name': 'wpp_settings[property_stats][' + ( $data.slug() ) + ']' }" autocomplete="off" />
                                        </div>

                                        <div class="wpp_input_wrapper wpp_hide_on_drag">
                                            <input type="text" class="wpp_label wpp_major" data-bind="value: $data.classification_label" autocomplete="off" readonly="readonly" />
                                            <!-- ko if: !$data.reserved() -->
                                            <ul class="wpp_attribute_classifications" data-bind="visible: $data.show_classifications, foreach: $root.attribute_classification">
                                                <li data-bind="visible: !$data.settings.system()" ><a data-bind="click: $parentContext.$data.select_classification" href="javascript:void(0);"><span class="wpp_label" data-bind="text: $data.label"></span><span class="wpp_description" data-bind="text: $data.description"></span></a></li>
                                            </ul>
                                            <span class="wpp_input_button" data-bind="click: $data.toggle_classifications"><span class="wpp_input_icon">classifications</span></span>
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
                                        </div>
                                    </li>
                                <!-- /ko -->
                            </ul>
                        </div>
                        <?php /*

                              <div class="wpp_collapsed wpp_hide_on_drag" data-bind="visible: $data.show_settings">

                                <div class="row">
                                  <textarea class="wpp_textarea" placeholder="Please enter a description" data-bind="value: $data.description, attr: { 'name': 'wpp_settings[property_stats_descriptions][' + $data.slug() + ']' }" />
                                </div>

                                <div class="row clearfix">
                                  <div class="wpp_left">
                                    <table class="wpp_clean">
                                      <tbody>
                                        <tr>
                                          <td><label data-bind="attr:{'for':'wpp_attr_slug_'+$data.slug()}">Slug:</label></td>
                                          <td><input type="text" class="wpp_slug" readonly="true" data-bind="attr:{id:'wpp_attr_slug_'+$data.slug()}, value: $data.slug" /></td>
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
                                          <td><textarea data-bind="value: $data.admin_predefined, attr: {name: 'wpp_settings[predefined_values][' + $data.slug() + ']'}"/></td>
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
                                          <td><textarea data-bind="value: $data.search_predefined, attr: {name: 'wpp_settings[predefined_search_values][' + $data.slug() + ']'}"/></td>
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
                                            <input type="checkbox" data-bind="checked: $data.sortable, attr: {id:'wpp_attr_sortable_'+$data.slug(), name: 'wpp_settings[sortable_attributes][]' }, value: $data.slug" />
                                            <label data-bind="attr: {'for':'wpp_attr_sortable_'+$data.slug()}">Sortable</label>
                                          </td>
                                        </tr>
                                        <!-- ko if: $data.classification_settings().searchable -->
                                        <tr>
                                          <td>
                                            <input type="checkbox" data-bind="checked: $data.searchable, attr: {id:'wpp_attr_searchable_'+$data.slug(), name: 'wpp_settings[searchable_attributes][]' }, value: $data.slug" />
                                            <label data-bind="attr: {'for':'wpp_attr_searchable_'+$data.slug()}">Searchable</label>
                                          </td>
                                        </tr>
                                        <!-- /ko -->
                                        <tr>
                                          <td>
                                            <input type="checkbox" data-bind="checked: $data.in_overview, attr: {id:'wpp_attr_in_overview_'+$data.slug(), name: 'wpp_settings[column_attributes][]' }, value: $data.slug" />
                                            <label data-bind="attr: {'for':'wpp_attr_in_overview_'+$data.slug()}">Show in Overview</label>
                                          </td>
                                        </tr>
                                        <!-- ko if: $data.classification_settings().can_be_disabled -->
                                        <tr>
                                          <td>
                                            <input type="checkbox" data-bind="checked: $data.disabled, attr: {id:'wpp_attr_disabled_'+$data.slug(), name: 'wpp_settings[disabled_attributes][]' }, value: $data.slug" />
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
                          <input type="button" class="button-secondary" data-bind="click: $root.add_attribute.bind( $root, {group:$data.slug()} )" value="Add New Attribute" />
                        </div> */ ?>
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
      <div>
        <h3 style="float:left;"><?php printf( __( '%1s Attributes', 'wpp' ), UsabilityDynamics\WPP\Utility::property_label() ); ?></h3>
        <span class="">
        <div class="wpp_property_stat_functions">
          <?php _e( 'Advanced Stats Settings:', 'wpp' ) ?>
          <span class="wpp_all_advanced_settings" action="expand"><?php _e( 'expand all', 'wpp' ) ?></span>,
          <span class="wpp_all_advanced_settings" action="collapse"><?php _e( 'collapse all', 'wpp' ) ?></span>.
          <input type="button" id="sort_stats_by_groups" class="button-secondary" value="<?php _e( 'Sort Stats by Groups', 'wpp' ) ?>"/>
        </div>
        <div class="clear"></div>
      </div>

      <div id="wpp_dialog_wrapper_for_groups"></div>
      <div id="wpp_attribute_groups">
          <table cellpadding="0" cellspacing="0" allow_random_slug="true" class="ud_ui_dynamic_table widefat wpp_sortable">
            <thead>
              <tr>
                <th class="wpp_group_assign_col">&nbsp;</th>
                <th class='wpp_draggable_handle'>&nbsp;</th>
                <th class="wpp_group_name_col"><?php _e( 'Group Name', 'wpp' ) ?></th>
                <th class="wpp_group_slug_col"><?php _e( 'Slug', 'wpp' ) ?></th>
                <th class='wpp_group_main_col'><?php _e( 'Main', 'wpp' ) ?></th>
                <th class="wpp_group_color_col"><?php _e( 'Group Color', 'wpp' ) ?></th>
                <th class="wpp_group_action_col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
            <?php if( empty( $wp_properties[ 'property_groups' ] ) ) {
              //* If there is no any group, we set default */
              $wp_properties[ 'property_groups' ] = array(
                'main' => array(
                  'name'  => 'Main',
                  'color' => '#bdd6ff'
                )
              );
            }
            ?>
            <?php foreach( $wp_properties[ 'property_groups' ] as $slug => $group ): ?>
              <tr class="wpp_dynamic_table_row" slug="<?php echo $slug; ?>" new_row='false'>
                <td class="wpp_group_assign_col">
                  <input type="button" class="wpp_assign_to_group button-secondary" value="<?php _e( 'Assign', 'wpp' ) ?>"/>
                </td>
                <td class="wpp_draggable_handle">&nbsp;</td>
                <td class="wpp_group_name_col">
                  <input class="slug_setter" type="text" name="wpp_settings[property_groups][<?php echo $slug; ?>][name]" value="<?php echo $group[ 'name' ]; ?>"/>
                </td>
                <td class="wpp_group_slug_col">
                  <input type="text" class="slug" readonly='readonly' value="<?php echo $slug; ?>"/>
                </td>
                <td class="wpp_group_main_col">
                  <input type="radio" class="wpp_no_change_name" name="wpp_settings[configuration][main_stats_group]" <?php echo( $wp_properties[ 'configuration' ][ 'main_stats_group' ] == $slug ? "checked=\"checked\"" : "" ); ?> value="<?php echo $slug; ?>"/>
                </td>
                <td class="wpp_group_color_col">
                  <input type="text" class="wpp_input_colorpicker" name="wpp_settings[property_groups][<?php echo $slug; ?>][color]" value="<?php echo $group[ 'color' ]; ?>"/>
                </td>
                <td class="wpp_group_action_col">
                  <span class="wpp_delete_row wpp_link"><?php _e( 'Delete', 'wpp' ) ?></span>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan='7'>
                  <div style="float:left;text-align:left;">
                    <input type="button" class="wpp_add_row button-secondary" value="<?php _e( 'Add Group', 'wpp' ) ?>"/>
                    <input type="button" class="wpp_unassign_from_group button-secondary" value="<?php _e( 'Unassign from Group', 'wpp' ) ?>"/>
                  </div>
                  <div style="float:right;">
                    <input type="button" class="wpp_close_dialog button-secondary" value="<?php _e( 'Apply', 'wpp' ) ?>"/>
                  </div>
                  <div class="clear"></div>
                </td>
              </tr>
            </tfoot>
          </table>
      </div>

      <table id="wpp_inquiry_attribute_fields" class="ud_ui_dynamic_table widefat" allow_random_slug="true">
      <thead>
        <tr>
          <th class='wpp_draggable_handle'>&nbsp;</th>
          <th class='wpp_attribute_name_col'><?php _e( 'Attribute Name', 'wpp' ) ?></th>
          <th class='wpp_attribute_group_col'><?php _e( 'Group', 'wpp' ) ?></th>
          <th class='wpp_settings_input_col'><?php _e( 'Settings', 'wpp' ) ?></th>
          <th class='wpp_search_input_col'><?php _e( 'Search Input', 'wpp' ) ?></th>
          <th class='wpp_admin_input_col'><?php _e( 'Data Entry', 'wpp' ) ?></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach( $wp_properties[ 'property_stats' ] as $slug => $label ): ?>
        <?php $gslug = false; ?>
        <?php $group = false; ?>
        <?php if( !empty( $wp_properties[ 'property_stats_groups' ][ $slug ] ) ) : ?>
          <?php $gslug = $wp_properties[ 'property_stats_groups' ][ $slug ]; ?>
          <?php $group = $wp_properties[ 'property_groups' ][ $gslug ]; ?>
        <?php endif; ?>
        <tr class="wpp_dynamic_table_row" <?php echo( !empty( $gslug ) ? "wpp_attribute_group=\"" . $gslug . "\"" : "" ); ?> style="<?php echo( !empty( $group[ 'color' ] ) ? "background-color:" . $group[ 'color' ] : "" ); ?>" slug="<?php echo $slug; ?>" new_row='false'>

        <td class="wpp_draggable_handle">&nbsp;</td>

        <td class="wpp_attribute_name_col">
          <ul class="wpp_attribute_name">
            <li>
              <input class="slug_setter" type="text" name="wpp_settings[property_stats][<?php echo $slug; ?>]" value="<?php echo $label; ?>"/>
            </li>
            <li class="wpp_development_advanced_option">
              <input type="text" class="slug wpp_stats_slug_field" readonly='readonly' value="<?php echo $slug; ?>"/>
              <?php if( in_array( $slug, $wp_properties[ 'geo_type_attributes' ] ) ): ?>
                <div class="wpp_notice">
                <span><?php _e( 'Attention! This attribute (slug) is used by Google Validator and Address Display functionality. It is set automaticaly and can not be edited on Property Adding/Updating page.', 'wpp' ); ?></span>
              </div>
              <?php endif; ?>
            </li>
            <?php do_action( 'wpp::property_attributes::attribute_name', $slug ); ?>
            <li>
              <span class="wpp_show_advanced"><?php _e( 'Toggle Advanced Settings', 'wpp' ); ?></span>
            </li>
          </ul>
        </td>

        <td class="wpp_attribute_group_col">
          <input type="text" class="wpp_attribute_group" value="<?php echo( !empty( $group[ 'name' ] ) ? $group[ 'name' ] : "" ); ?>"/>
          <input type="hidden" class="wpp_group_slug" name="wpp_settings[property_stats_groups][<?php echo $slug; ?>]" value="<?php echo( !empty( $gslug ) ? $gslug : "" ); ?>">
        </td>

        <td class="wpp_settings_input_col">
          <ul>
            <li>
              <label>
                <input <?php if( in_array( $slug, ( ( !empty( $wp_properties[ 'sortable_attributes' ] ) ? $wp_properties[ 'sortable_attributes' ] : array() ) ) ) ) echo " CHECKED "; ?> type="checkbox" class="slug" name="wpp_settings[sortable_attributes][]" value="<?php echo $slug; ?>"/>
                <?php _e( 'Sortable.', 'wpp' ); ?>
              </label>
            </li>
            <li>
              <label>
                <input <?php if( is_array( $wp_properties[ 'searchable_attributes' ] ) && in_array( $slug, $wp_properties[ 'searchable_attributes' ] ) ) echo " CHECKED "; ?> type="checkbox" class="slug" name="wpp_settings[searchable_attributes][]" value="<?php echo $slug; ?>"/>
                <?php _e( 'Searchable.', 'wpp' ); ?>
              </label>
            </li>
            <li class="wpp_development_advanced_option">
              <label>
                <input <?php if( is_array( $wp_properties[ 'hidden_frontend_attributes' ] ) && in_array( $slug, $wp_properties[ 'hidden_frontend_attributes' ] ) ) echo " CHECKED "; ?> type="checkbox" class="slug" name="wpp_settings[hidden_frontend_attributes][]" value="<?php echo $slug; ?>"/>
                <?php _e( 'Admin Only.', 'wpp' ); ?>
              </label>
            </li>
            <li class="wpp_development_advanced_option">
              <label>
                <input <?php if( is_array( $wp_properties[ 'numeric_attributes' ] ) && in_array( $slug, $wp_properties[ 'numeric_attributes' ] ) ) echo " CHECKED "; ?> type="checkbox" class="slug" name="wpp_settings[numeric_attributes][]" value="<?php echo $slug; ?>"/>
                <?php _e( 'Format: numeric.', 'wpp' ); ?>
              </label>
            </li>
            <li class="wpp_development_advanced_option">
              <label>
                <input <?php if( is_array( $wp_properties[ 'currency_attributes' ] ) && in_array( $slug, $wp_properties[ 'currency_attributes' ] ) ) echo " CHECKED "; ?> type="checkbox" class="slug" name="wpp_settings[currency_attributes][]" value="<?php echo $slug; ?>"/>
                <?php _e( 'Format: currency.', 'wpp' ); ?>
              </label>
            </li>
            <li class="wpp_development_advanced_option">
              <label>
                <input <?php if( is_array( $wp_properties[ 'column_attributes' ] ) && in_array( $slug, $wp_properties[ 'column_attributes' ] ) ) echo " CHECKED "; ?> type="checkbox" class="slug" name="wpp_settings[column_attributes][]" value="<?php echo $slug; ?>"/>
                <?php _e( 'Show in "All Properties" table.', 'wpp' ); ?>
              </label>
            </li>
            <?php do_action( 'wpp::property_attributes::settings', $slug ); ?>
            <li class="wpp_development_advanced_option">
              <span class="wpp_delete_row wpp_link"><?php _e( 'Delete Attribute', 'wpp' ) ?></span>
            </li>
          </ul>
        </td>

        <td class="wpp_search_input_col">
          <ul>
            <li>
              <select name="wpp_settings[searchable_attr_fields][<?php echo $slug; ?>]" class="wpp_pre_defined_value_setter wpp_searchable_attr_fields">
                <option value=""> - </option>
                <option value="input" <?php selected( $wp_properties[ 'searchable_attr_fields' ][ $slug ], 'input' ); ?>><?php _e( 'Free Text', 'wpp' ) ?></option>
                <option value="range_input" <?php selected( $wp_properties[ 'searchable_attr_fields' ][ $slug ], 'range_input' ); ?>><?php _e( 'Text Input Range', 'wpp' ) ?></option>
                <option value="range_dropdown" <?php selected( $wp_properties[ 'searchable_attr_fields' ][ $slug ], 'range_dropdown' ); ?>><?php _e( 'Range Dropdown', 'wpp' ) ?></option>
                <option value="dropdown" <?php selected( $wp_properties[ 'searchable_attr_fields' ][ $slug ], 'dropdown' ); ?>><?php _e( 'Dropdown Selection', 'wpp' ) ?></option>
                <option value="checkbox" <?php selected( $wp_properties[ 'searchable_attr_fields' ][ $slug ], 'checkbox' ); ?>><?php _e( 'Single Checkbox', 'wpp' ) ?></option>
                <option value="multi_checkbox" <?php selected( $wp_properties[ 'searchable_attr_fields' ][ $slug ], 'multi_checkbox' ); ?>><?php _e( 'Multi-Checkbox', 'wpp' ) ?></option>
              </select>
            </li>
            <li>
              <textarea class="wpp_attribute_pre_defined_values" name="wpp_settings[predefined_search_values][<?php echo $slug; ?>]"><?php echo $wp_properties[ 'predefined_search_values' ][ $slug ]; ?></textarea>
            </li>
          </ul>
        </td>

        <td class="wpp_admin_input_col">
          <ul>
            <li>
              <select name="wpp_settings[admin_attr_fields][<?php echo $slug; ?>]" class="wpp_pre_defined_value_setter wpp_searchable_attr_fields">
                <option value=""> - </option>
                <option value="input" <?php selected( $wp_properties[ 'admin_attr_fields' ][ $slug ], 'input' ); ?>><?php _e( 'Free Text', 'wpp' ) ?></option>
                <option value="dropdown" <?php selected( $wp_properties[ 'admin_attr_fields' ][ $slug ], 'dropdown' ); ?>><?php _e( 'Dropdown Selection', 'wpp' ) ?></option>
                <option value="checkbox" <?php selected( $wp_properties[ 'admin_attr_fields' ][ $slug ], 'checkbox' ); ?>><?php _e( 'Single Checkbox', 'wpp' ) ?></option>
              </select>
            </li>
            <li>
              <textarea class="wpp_attribute_pre_defined_values" name="wpp_settings[predefined_values][<?php echo $slug; ?>]"><?php echo $wp_properties[ 'predefined_values' ][ $slug ]; ?></textarea>
            </li>
          </ul>
        </td>
      </tr>
      <?php endforeach; ?>
      </tbody>

      <tfoot>
        <tr>
          <td colspan='6'>
          <input type="button" class="wpp_add_row button-secondary" value="<?php _e( 'Add Row', 'wpp' ) ?>"/>
          </td>
        </tr>
      </tfoot>

      </table>
      <br class="cb"/>
      <h3><?php printf( __( '%1s Meta', 'wpp' ), UsabilityDynamics\WPP\Utility::property_label() ); ?></h3>
      <p><?php _e( 'Meta is used for descriptions,  on the back-end  meta fields will be displayed as textareas.  On the front-end they will be displayed as individual sections.', 'wpp' ) ?></p>

      <table id="wpp_inquiry_meta_fields" class="ud_ui_dynamic_table widefat">
      <thead>
        <tr>
          <th class='wpp_draggable_handle'>&nbsp;</th>
          <th class='wpp_attribute_name_col'><?php _e( 'Attribute Name', 'wpp' ) ?></th>
          <th class='wpp_attribute_slug_col'><?php _e( 'Attribute Slug', 'wpp' ) ?></th>
          <th class='wpp_settings_col'><?php _e( 'Settings', 'wpp' ) ?></th>
          <th class='wpp_delete_col'>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach( $wp_properties[ 'property_meta' ] as $slug => $label ): ?>

        <tr class="wpp_dynamic_table_row" slug="<?php echo $slug; ?>" new_row='false'>
        <th class='wpp_draggable_handle'>&nbsp;</th>
        <td>
         <ul>
          <li>
             <input class="slug_setter" type="text" name="wpp_settings[property_meta][<?php echo $slug; ?>]" value="<?php echo $label; ?>"/>
          </li>
          </ul>
        <td>
          <ul>
          <li>
             <input type="text" class="slug" readonly='readonly' value="<?php echo $slug; ?>"/>
          </li>
          </ul>
        </td>
        <td>
          <ul>
            </li>
            <input <?php if( is_array( $wp_properties[ 'hidden_frontend_attributes' ] ) && in_array( $slug, $wp_properties[ 'hidden_frontend_attributes' ] ) ) echo " CHECKED "; ?> type="checkbox" class="slug" name="wpp_settings[hidden_frontend_attributes][]" value="<?php echo $slug; ?>"/>
            <label><?php _e( 'Show in Admin Only', 'wpp' ); ?></label>
            </li>
          </ul>
        </td>

          <td>
          <span class="wpp_delete_row wpp_link"><?php _e( 'Delete Meta Attribute', 'wpp' ) ?></span>
          </td>
      </tr>

      <?php endforeach; ?>
      </tbody>

      <tfoot>
        <tr>
          <td colspan='4'>
          <input type="button" class="wpp_add_row button-secondary" value="<?php _e( 'Add Row', 'wpp' ) ?>"/>
          </td>
        </tr>
      </tfoot>

      </table>
    </td>
  </tr>

  <tr>
    <td>
      <h3><?php printf( __( '%1s Types', 'wpp' ), UsabilityDynamics\WPP\Utility::property_label() ); ?></h3>
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
          <?php echo UsabilityDynamics\WPP\Utility::checkbox( "name=wpp_settings[configuration][show_ud_log]&label=" . __( 'Show Log.', 'wpp' ), $wp_properties[ 'configuration' ][ 'show_ud_log' ] ); ?>
          <br/>
          <span class="description"><?php _e( 'The log is always active, but the UI is hidden.  If enabled, it will be visible in the admin sidebar.', 'wpp' ); ?></span>
        </li>
        <li>
          <?php echo UsabilityDynamics\WPP\Utility::checkbox( "name=wpp_settings[configuration][allow_parent_deep_depth]&label=" . __( 'Enable \'Falls Under\' deep depth.', 'wpp' ), $wp_properties[ 'configuration' ][ 'allow_parent_deep_depth' ] ); ?>
          <br/>
          <span class="description"><?php _e( 'Allows to set child property as parent.', 'wpp' ); ?></span>
        </li>
        <li>
          <?php echo UsabilityDynamics\WPP\Utility::checkbox( "name=wpp_settings[configuration][disable_automatic_feature_update]&label=" . __( 'Disable automatic feature updates.', 'wpp' ), $wp_properties[ 'configuration' ][ 'disable_automatic_feature_update' ] ); ?>
          <br/>
          <span class="description"><?php _e( 'If disabled, feature updates will not be downloaded automatically.', 'wpp' ); ?></span>
        </li>
        <li>
          <?php echo UsabilityDynamics\WPP\Utility::checkbox( "name=wpp_settings[configuration][disable_wordpress_postmeta_cache]&label=" . __( 'Disable WordPress update_post_caches() function.', 'wpp' ), $wp_properties[ 'configuration' ][ 'disable_wordpress_postmeta_cache' ] ); ?>
          <br/>
          <span class="description"><?php _e( 'This may solve Out of Memory issues if you have a lot of properties.', 'wpp' ); ?></span>
        </li>
        <li>
          <?php echo UsabilityDynamics\WPP\Utility::checkbox( "name=wpp_settings[configuration][developer_mode]&label=" . __( 'Enable developer mode - some extra information displayed via Firebug console.', 'wpp' ), $wp_properties[ 'configuration' ][ 'developer_mode' ] ); ?>
          <br/>
        </li>

      </ul>
    </td>
  </tr>

</table>

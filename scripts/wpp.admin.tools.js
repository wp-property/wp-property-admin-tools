define("wpp.admin.tools",["wpp.model","jquery","knockout","knockout.mapping","jquery.ui"],function(){return jQuery(document).bind("wpp::attribute_builder::init",function(a,b,c){function d(){var a=jQuery(this),b=a.parents("li.wpp_attribute"),d=a.val(),e=jQuery("select.wpp_admin_inputs",b),f=jQuery("select.wpp_search_inputs",b);if(""!==d&&"undefined"!=typeof c._attribute_classifications[d]){e.empty();for(var g in c._attribute_classifications[d].admin)"function"!=typeof c._attribute_classifications[d].admin[g]&&e.append('<option value="'+g+'">'+c._attribute_classifications[d].admin[g]+"</option>");e.val(e.attr("_type")),f.empty();for(var h in c._attribute_classifications[d].search)"function"!=typeof c._attribute_classifications[d].search[h]&&f.append('<option value="'+h+'">'+c._attribute_classifications[d].search[h]+"</option>");f.val(f.attr("_type"))}}jQuery(document).bind("admin_tools_show wpp_groups_changed wpp_attributes_changed",function(a,b){setTimeout(function(){jQuery(".wpp_tab_panel",b).css({"min-height":jQuery(".wpp_vertical_tabs_wrapper",b).height()})},200)}),b.attributes.subscribe(function(){jQuery(document).trigger("wpp_attributes_changed",jQuery(".wpp_section_class_admin_tools_settings_page")),setTimeout(function(){jQuery(".wpp_attribute_classification").trigger("change")},100)}),b.groups.subscribe(function(){jQuery(document).trigger("wpp_groups_changed",jQuery(".wpp_section_class_admin_tools_settings_page"))}),b.attributes.valueHasMutated(),jQuery(document).on("change",".wpp_attribute_classification",d),jQuery(".wpp_attribute_classification").trigger("change"),jQuery(".wpp_predefined_input_type").trigger("change"),jQuery(document).on("change",".wpp_attribute_group_slug",function(){b.groups.valueHasMutated()})}),function(){var a=require("knockout"),b=require("knockout.mapping"),c=require("wpp.model");a.bindingHandlers.sortable={init:function(){},update:function(a,b){jQuery(a).sortable(b())}},a.bindingHandlers.enter_key={init:function(a){jQuery(a).keypress(function(a){var b=a.which?a.which:a.keyCode;return 13===b?!1:!0})}},a.bindingHandlers.tabbed={init:function(b){a.utils.domNodeDisposal.addDisposeCallback(b,function(){jQuery(b).tabs("destroy")})},update:function(a,b,d,e){jQuery(a).bind("tabsselect",function(a,b){c.attributes_tab_index=b.index-1}),setTimeout(function(){try{var b=jQuery(a);b.is(":ui-tabs")&&b.tabs("destroy");var f=b.tabs();if(f.tabs("option","selected","undefined"!==c.attributes_tab_index?c.attributes_tab_index:0),"undefined"!=typeof d().droppable){var g={list:".connectedSortable",accept:".connectedSortable li",hoverClass:"ui-state-hover"},h=jQuery.extend(g,d().droppable);h.drop=function(a,b){"function"==typeof h.drop_cb&&h.drop_cb(a,b,e)},jQuery("ul:first li",f).droppable(h)}}catch(i){console.log("ko.bindingHandlers.tabbed",i.message)}},200)}},a.bindingHandlers.unique_slug={init:function(a,b,c,d){var e=jQuery.extend({slug:!1,text:!1,instance:!1,storage:!1,value_to_slug:!1},b());if(!e.slug||!e.text||!e.instance)return!1;if("undefined"==typeof e.slug||"undefined"==typeof e.text)return!1;var f=function(a){return a=a.replace(/[^a-zA-Z0-9_\s]/g,""),a=a.toLowerCase(),a=a.replace(/\s/g,"_")};e.storage&&("undefined"==typeof window.__ud_slug_storage&&(window.__ud_slug_storage={}),"undefined"==typeof window.__ud_slug_storage[e.instance]&&(window.__ud_slug_storage[e.instance]=[]),-1==window.__ud_slug_storage[e.instance].indexOf(e.slug())&&window.__ud_slug_storage[e.instance].push(e.slug())),jQuery(a).addClass(e.instance).data("slug",e.slug()).change(function(){var a=this,b=jQuery(this).val(),c=f(b),g=!1;return""===c&&(c="random"),e.storage?"undefined"!=typeof window.__ud_slug_storage[e.instance]&&-1!=window.__ud_slug_storage[e.instance].indexOf(c)&&(g=!0):jQuery("."+e.instance).each(function(b,d){d!==a&&c===jQuery(d).data("slug")&&(g=!0)}),g&&(c+="_"+(Math.floor(99e6*Math.random())+1e6)),"function"!=typeof d.new_item||d.new_item()?("function"==typeof e.slug?e.slug(c):e.slug=c,"function"==typeof e.text?e.text(b):e.text=b,jQuery(a).data("slug",c),e.value_to_slug&&"random"!==c&&jQuery(a).val(c),void 0):!1}),setTimeout(function(){jQuery(a).trigger("change")},100)}};var d={_objectMap:function(a,b){var c=[];for(var d in a)c.push(b(a[d]));return c},attributes:{create:function(b){var c=d._objectMap(b.data,function(a){return a.new_item=!1,new d._attribute(a)});return a.observableArray(c)}},groups:{create:function(b){var c=d._objectMap(b.data,function(a){return a.new_item=!1,new d._group(a)});return a.observableArray(c)}},_group:function(b){var c=this;b=jQuery.extend(!0,{label:"New Group",slug:"new_group_tab_slug",edit_state:!1,reserved:!1,new_item:!0},"object"==typeof b?b:{});for(var d in b)"function"!=typeof b[d]&&(c[d]=a.observable(b[d]));c.delete_group=function(b){var d="Are you sure you want to remove group? All assigned attributes will be moved to Other.";window.confirm(d)&&(a.utils.arrayForEach(b.attributes(),function(a){a.group()===c.slug()&&a.group("wpp_main")}),b.groups.remove(this))},c.toggleEdit=function(b){if(jQuery('input[tab="tab_'+b.slug()+'"]').trigger("change"),c.edit_state(!c.edit_state()),c.edit_state())c.prevName=c.slug(),jQuery('input[tab="tab_'+b.slug()+'"]').focus().select();else{var d=!1;"object"==typeof wpp.settings_ui.view_model&&(d=wpp.settings_ui.view_model.global,c.slug()!==c.prevName&&a.utils.arrayForEach(d.attributes(),function(a){a.group()===c.prevName&&a.group(c.slug())})),""===jQuery.trim(c.label())&&c.label(c.prevName)}}},_attribute:function(c){var d=this;c=jQuery.extend(!0,{label:"New Attribute",slug:"new_attribute",group:"wpp_main",show_settings:!1,show_classifications:!1,classification_label:"Short Text",classification:"string",classification_settings:{},searchable:!1,sortable:!1,in_overview:!1,disabled:!1,search_predefined:"",admin_predefined:"",admin_input_type:"input",search_input_type:"input",show_admin_pre_values:!1,show_search_pre_values:!1,system:!1,reserved:!1,new_item:!0},"object"==typeof c?c:{});for(var e in c)"function"!=typeof c[e]&&(d[e]=a.observable(c[e]));d.show_admin_values=function(a,b){var c=["dropdown","multi_checkbox"],d=jQuery(b.target),e=d.parents(".wpp_collapsed").find(".wpp_admin_values");e.hide(),-1!==c.indexOf(d.val())&&e.show()},d.show_search_values=function(a,b){var c=["dropdown","multi_checkbox"],d=jQuery(b.target),e=d.parents(".wpp_collapsed").find(".wpp_search_values");e.hide(),-1!==c.indexOf(d.val())&&e.show()},d.toggle_settings=function(){d.show_settings(!d.show_settings())},d.toggle_classifications=function(a,b){b.stopPropagation(),d.show_classifications(!d.show_classifications())},d.click_inside=function(){return d.show_classifications(!1),!0},d.select_classification=function(a,c){c.stopPropagation(),d.classification(this.slug()),d.classification_label(this.label()),d.classification_settings(b.toJS(this.settings)),d.show_classifications(!1),jQuery(".wpp_predefined_input_type").trigger("change"),jQuery(".wpp_attribute_classification").trigger("change")}}},e=jQuery.extend(c.settings._computed.data_structure,{attribute_classification:d._objectMap(c.settings._attribute_classifications,function(a){return a})}),f=b.fromJS(e,d);return f._group=d._group,f._attribute=d._attribute,f.add_data=function(a,b,c){"function"==typeof b?a.push(new b):"function"==typeof c[b]&&a.push(new c[b])},f.remove_data=function(a,b){var c="Are you sure you want to remove it?";confirm(c)&&a.remove(b)},f.add_attribute=function(a){a.classification_settings={searchable:!0,indexable:!0,editable:!0,type:"string"},this.attributes.push(new this._attribute(a))},f.drop_cb=function(b,c,d){var e=jQuery(c.draggable).attr("wpp_attribute_slug"),f=jQuery(b.target).attr("wpp_group_name");a.utils.arrayForEach(d.attributes(),function(a){a.slug()===e&&a.group()!==f&&c.draggable.hide("fast",function(){a.group(f),jQuery(".wpp_attribute_classification").trigger("change")})})},f.sort_start_cb=function(a,b){b.helper.width(305).height(40)},a.applyBindings(f,this),jQuery(document).trigger("wpp::attribute_builder::init",[f,c.settings]),void 0}});
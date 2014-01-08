/**
 * Admin Tools Handler
 *
 */
define( 'wpp.admin.tools', function Loader( require, exports, module ) {
  console.log( 'loaded', module.id, 'module' );

  return function Handler() {
    console.log( 'initialized', module.id, 'module' );

  }

});
import './styles/config.scss';
import './bootstrap';
//import bsCustomFileInput from 'bs-custom-file-input';

console.log('Hello Webpack Encore! Edit me in assets/config.js');

const $ = require('jquery');

$("#config_env").change(function() {
  console.log('config.env changed, submitting');
  $("#config_app").val(0);
  $("#config_stack").val(0);
  $("#config_client").val(0);
  $("#form_config").submit();
});

$("#config_app").change(function() {
  console.log('config.app changed, submitting');
  $("#config_stack").val(0);
  $("#config_client").val(0);
  $("#form_config").submit();
});

$("#config_stack").change(function() {
  console.log('config.stack changed, submitting');
  $("#form_config").submit();
});

$("#config_client").change(function() {
  console.log('config.client changed, submitting');
  $("#config_client").val(0);
  $("#form_config").submit();
});

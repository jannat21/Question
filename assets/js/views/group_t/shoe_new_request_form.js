// JavaScript Document
var new_request_code_block=0;
var new_request_code_tool=0;
var new_request_code_person=0;
var new_request_tool_type=0;

$('.show_new_request_form')
.on('click',
function()
{
	var l = Ladda.create(this);
 	l.start();
	var $new_request_modal = $('#new_request_modal_form');
	$new_request_modal.load(site_url+'/request/show_new_request_form', '', function(){
      $new_request_modal.modal('show');
	  l.stop();
	  new_request_code_block=$('#block_code_hidden').text();
	  var block_title_r=$('#block_title').html();
	  $('#select_block_result').html('<i class="fa fa-2x fa-cube"></i>'+block_title_1);
	 });
	 new_request_code_person=0;
	 new_request_code_tool=0;
});



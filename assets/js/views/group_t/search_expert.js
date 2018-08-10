// JavaScript Document
/*
var $modal = $('#search_expert');
$('.search_expert').on('click', function(){
	$modal.load(site_url+'/group_t/search_expert', '', function(){
      $modal.modal('show');
	  });   
});

*/
$('.search_expert_form').on('click',
function()
{
	var l = Ladda.create(this);
 	l.start();
	var $search_expert_modal = $('#search_expert_modal_form');
	$search_expert_modal.load(site_url+'/group_t/search_expert', '', function(){
      $search_expert_modal.modal('show');
	  l.stop();
	 });
});

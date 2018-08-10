
var $modal = $('#change_password');
$('.change_password').on('click', function(){
	$modal.load(site_url+'/group_t/change_password2', '', function(){
      $modal.modal('show');
	  });   
});






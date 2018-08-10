//به نام خدا
var plgns={};
plgns[0]="ui";
plgns[1]="state";
plgns[2]="types";
plgns[3]="search";
$(function () {
	$('#joze_tree').jstree({
							'core' :{
									 "check_callback":true,
									'themes': {'name': 'default','responsive': true,dots: true}
									},
							"plugins":plgns,
							"types":{'default':{'icon':'glyphicon glyphicon-cog'}}
						});
	 var to = false;
	 $('#joze_search').keyup(function () {
		 if(to) { clearTimeout(to); }
		 to = setTimeout(function () {
			 var v = $('#joze_search').val();
			 $('#joze_tree').jstree(true).search(v);
		}, 250);
	  });
  
	$('#joze_tree').on("changed.jstree", function (e, data) {console.log(data.selected);});
	$('#joze_tree').bind('select_node.jstree',function(e,data){select_node(data.node);});
});
	 
//FUNCTIONS
//SELECT JOZE TREE NODE AND GET BLOCKS
function select_node(node)
{
  $('#joze_search').val('');
  var node_id=node.id;
  var node_title=node.text;
  var id=node_id.split("_");
  joze_code=id[2];
  datas={};
  datas['joze_code']=joze_code;
  
  $('#joze_blocks').html("<img src='"+base_url+"assetes/img/rada24.gif' />");
  $('#joze_title').html(node_title);
  //$('html,body').animate({scrollTop:$('#joze_blocks').position().top+100},1000);
  $.ajax(
	{
		url:'get_joze_blocks',
		type:'POST',dataType:"json",cache:true,data:datas,error: function(j,t,e){alert(e);},
		success:function(data,t,j){
			$('#joze_blocks').html(data['table']);
		}
	}
 );				
}
//AUTOCOMPLETE
// autocomplet : this function will be executed every time we change the text
function autocomplete2(){
	person_code=0;
	$('#person_title').text('?');
  var min_length = 0; // min caracters to display the autocomplete
  var search_value= $('#search_person').val();
  search_value=search_value.trim();
  if (search_value.length > min_length) 
  {
	  $.ajax({
		  url: site_url+'/group_t/get_autocompete_person_list',
		  type: 'POST',	data: {search_value:search_value},
		  success:function(data)
		  {
			  $('#person_list_id').slideDown(500);
			  $('#person_list_id').html(data);
		  }
	  });
  }
  else 
  {
	  $('#person_list_id').hide();
  }					
}

// set_item : this function will be executed when we select an item
function set_item(item,id)
{
	// change input value
	$('#search_person').val(item);
	// hide proposition list
	$('#person_list_id').slideUp(500);
	
	var id=id.split("_");
	person_code=id[1];
	var person_title=item;
	$('#person_title').text(person_title);
}
//////SELECT TOOLS
//var base_url='<?php echo base_url(); ?>';
var tool_code=0;
var block_code=0;
var tool_type=0;
//var person_code=0;
var date1='';
var date2='';

$(function(){
	//CLICK TOOLS
	$('.tool').on('click',function(){
		if($(this).hasClass('disabled')){return false;}
		tool_type=$(this).attr('tool_type');
		$('.tool').removeClass('list-group-item-success');
		var id=$(this).attr('id');
		var id=id.split("_");
		tool_code=id[1];
		var tool_title=$(this).text();
		$('#tool_title').text(tool_title);
		$(this).addClass('list-group-item-success');
		});
	});
///SELECT BLOCK
function select_block(id)
{
	$('.block_info').removeClass('list-group-item-success');
	var id2=id.split("_");
	block_code=id2[1];
	var block_title=$('#'+id).text();
	$('#block_title').text(block_title);
	$('#'+id).addClass('list-group-item-success');				
}
//SAVE REQUEST
function save_request()
{
	$('.table tr').removeClass('danger');
	var success_flag=1;
	date1=$('#date1').val();
	date2=$('#date2').val();
	desc=$('#desc').val();
	//check validatation
	if (block_code=="" || block_code==null || isNaN(block_code)==true || block_code==0)
	{$('.block_title').addClass('danger');		success_flag=0;	}
	
	if (tool_code=="" || tool_code==null || isNaN(tool_code)==true || tool_code==0)
	{$('.tool_title').addClass('danger');		success_flag=0;	}
	
	if (person_code=="" || person_code==null || isNaN(person_code)==true || person_code==0)
	{$('.person_title').addClass('danger');		success_flag=0;	}
	
	if(date1=='' || date1==null)
	{$('.calendar').addClass('danger');		success_flag=0;	}
	
	if(date2=="" || date2==null)
	{$('.calendar').addClass('danger');		success_flag=0;	}
	
	/*if (date2<date1)
	{$('.calendar').addClass('danger');			success_flag=0;	}*/
	//
	if(success_flag==0)
	{
		return false;
	}
	datas={};					datas['block_code']=block_code;			datas['tool_code']=tool_code;		datas['person_code']=person_code;
	datas['date1']=date1;		datas['date2']=date2;					datas['desc']=desc;					datas['tool_type']=tool_type;
	var save_btn_html=$('#save_btn').html();
	$('#save_btn').html('<img src="'+base_url+'assetes/img/rada24.gif" />');
	$('#save_btn').addClass('disabled');
	$.ajax(
	{
		url:'save_request',
		type:'POST',data:datas,dataType:"json",cache:true,
		error: function()
		{$('#save_btn').removeClass('disabled');	$('#save_btn').html(save_btn_html);		$('.save_req').addClass('danger');},
		success: function(data)
		{
			if(data['data']=='success')
			{
				$('.save_req').addClass('success');
				setTimeout
				(
					function()
					{
						location.href='group_t_page';					
					}
					,50
				);				
				
			}
			else
			{
				$('.save_req').addClass('danger');	
			}
			$('#save_btn').removeClass('disabled');
			$('#save_btn').html(save_btn_html);
		}
	});
}
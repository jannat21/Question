// JavaScript Document
//search people
function search_people(){
	$('div').removeClass('mark_search');
	//$('div.person').removeClass('mark_search');
	var search_value=$('#search_people').val();
	search_value=search_value.trim();
	if(search_value==null | search_value=='')
	{
		$('#search_result').text('');
		return false; 
	}				
	$("div.person:contains("+search_value+")").addClass('mark_search');
	$('#search_result').text($('.mark_search').length+' نفر');
	$('.mark_search').each(function(){
		$('#persons').prepend($(this));					
	});	
	$('#persons').scrollTop(0);			
}//end of search people

//search people_2
function search_people_2(){
	$('div').removeClass('mark_search');
	//$('div.person').removeClass('mark_search');
	var search_value=$('#search_people_2').val();
	search_value=search_value.trim();
	if(search_value==null | search_value=='')
	{
		$('#search_result').text('');
		return false; 
	}				
	$("div.person_selection_2:contains("+search_value+")").addClass('mark_search');
	$('#search_result_2').text($('.mark_search').length+' نفر');
	$('.mark_search').each(function(){
		$('#person_selection').prepend($(this));					
	});	
	$('#person_selection').scrollTop(0);			
}//end of search people_2

//start search block
function search_block(){
	$('div').removeClass('mark_search');
	//$('div.block_item').removeClass('mark_search');
	var search_value=$('#search_block').val();
	search_value=search_value.trim();
	if(search_value==null | search_value=='')
	{
		$('#search_result_block').text('');
		return false; 
	}				
	$("div.block_item:contains("+search_value+")").addClass('mark_search');
	$('#search_result_block').text($('.mark_search').length+' بلوک دانشی');
	$('.mark_search').each(function(){
		$('#blokcs_info').prepend($(this));					
	});
	$('#blokcs_info').scrollTop(0);							
}//end of search block
//start search tool
function search_tool(){
	$('div').removeClass('mark_search');
	//$('div.tool').removeClass('mark_search');
	var search_value=$('#search_tool').val();
	search_value=search_value.trim();
	if(search_value==null | search_value=='')
	{
		$('#search_result_tool').text('');
		return false; 
	}				
	$("div.tool:contains("+search_value+")").addClass('mark_search');
	$('#search_result_tool').text($('.mark_search').length+' ابزار دانشی');
	$('.mark_search').each(function(){
		$('#tools').prepend($(this));					
	});	
	$('#tools').scrollTop(0);						
}//end of search tool

//start search request
function search_request(){
	$('div').removeClass('mark_search');
	//$('div.block_item').removeClass('mark_search');
	var search_value=$('#search_request').val();
	search_value=search_value.trim();
	if(search_value==null | search_value=='')
	{
		$('#search_result_request').text('');
		return false; 
	}				
	$("div.group_t_request_item:contains("+search_value+")").addClass('mark_search');
	
	$('#search_result_request').text($('.mark_search').length+' درخواست');
	$('.mark_search').each(function(){
		$('#requests_group_t').prepend($(this));					
	});
	$('#requests_group_t').scrollTop(0);							

	$('.mark_search>div').addClass('mark_search');
}//end of search request


//Start-right click menu
$(function(){
	$.contextMenu({
		selector: '.right_click', 
		callback: function(key, options) {
			if(key=='amar')
			{
				var id=this.attr('id');
				var res=id.split("_");
				id=res[1];
				if(isNaN(id)==true){return false;}
				$('#block_id_selected').val(id);
				$('#hidden_form').submit();				
			}
			if(key=='entekhab')
			{
				var block_id=this.attr('id');
				select_block(block_id);							
			}
		},
		items: {
			"entekhab": {name: "انتخاب بلوک دانشی", icon: "entekhab"},
			"amar": {name: "آمار بلوک دانشی", icon: "amar"}
		}
	});
	
	$('.right_click').on('click', function(e){
		console.log('clicked', this);
	})
	//right click of tool
	$.contextMenu({
		selector: '.tool', 
		callback: function(key, options) {
			if(key=='amar_tool')
			{
				/*var id=this.attr('id');
				var res=id.split("_");
				id=res[1];
				if(isNaN(id)==true){return false;}
				$('#block_id_selected').val(id);
				$('#hidden_form').submit();*/
				
			}
			if(key=='entekhab_tool')
			{
				var tool_id=this.attr('id');
				//alert(tool_id);
				select_tool(tool_id);							
			}
		},
		items: {
			"entekhab_tool": {name: "انتخاب ابزار", icon: "entekhab"},
			"amar_tool": {name: "آمار ابزار", icon: "amar"}
		}
	});
	
	$('.tool').on('click', function(e){
		console.log('clicked', this);
	})//end of tool right click
	
	//right click of person
	$.contextMenu({
		selector: '.person', 
		callback: function(key, options) {
			if(key=='amar_person')
			{
				/*var id=this.attr('id');
				var res=id.split("_");
				id=res[1];
				if(isNaN(id)==true){return false;}
				$('#block_id_selected').val(id);
				$('#hidden_form').submit();*/
				
			}
			if(key=='entekhab_person')
			{
				var person_id=this.attr('id');
				//alert(tool_id);
				select_person(person_id);							
			}
		},
		items: {
			"entekhab_person": {name: "انتخاب فرد", icon: "entekhab"},
			"amar_person": {name: "آمار فرد", icon: "amar"}
		}
	});
	
	$('.tool').on('click', function(e){
		console.log('clicked', this);
	})//end of person right click
});		
//End-right click menu
var selected_block_true=0;
var selected_block_id=0;
var selected_tool_true=0;
var selected_tool_id=0;
var selected_person_true=0;
var selected_person_id=0;
var selected_bar_visible=0;
var filled_true=0;
var saving_true=0;

var selected_block_html='';
var selected_tool_html='';
var selected_person_html='';
function check_fill(){
	if(selected_block_true==1 & selected_tool_true==1 & selected_person_true==1)
	{
		filled_true=1;
		$('#inserted_save').show(1000);
		$('#inserted_save').css('background-color','#6F0');
		$('#inserted_item_bar').css('background-color','#FFD9FF');	
	}
	return true;
}			
function add_question_mark()
{
	$('#inserted_block').html('?');
	$('#inserted_person').html('?');
	$('#inserted_tool').html('?');
}
function select_block(block_id)
{	
	var id=block_id.split("_");
	selected_block_id=id[1];
	selected_block_true=1;
	if(selected_bar_visible==0){
		add_question_mark();
		selected_bar_visible=1;
		$('#inserted_save').hide();
		$('#inserted_item_bar').fadeIn(2000);
		$('#inserted_item_bar').css('display','block');
	}
	
	var selected_block=$('<div></div>');
	selected_block.attr('id','selected_'+block_id);
	selected_block.addClass('selected_block');
	selected_block.html($('#'+block_id).html());
	selected_block_html=selected_block.html();
	$('#inserted_block').html('');
	$('#inserted_block').append(selected_block);
	check_fill();					
}
//select tool
function select_tool(tool_id)
{	
	var id=tool_id.split("_");
	selected_tool_id=id[1];
	selected_tool_true=1;
	if(selected_bar_visible==0){
		add_question_mark();
		selected_bar_visible=1;
		$('#inserted_save').hide();
		$('#inserted_item_bar').fadeIn(2000);
	}
	var selected_tool=$('<div></div>');
	selected_tool.attr('id','selected_'+tool_id);
	selected_tool.addClass('selected_block');
	selected_tool.html($('#'+tool_id).html());
	selected_tool_html=selected_tool.html();
	$('#inserted_tool').html('');
	$('#inserted_tool').append(selected_tool);
	check_fill();					
}//end of select tool
//select person
function select_person(person_id)
{	
	var id=person_id.split("_");
	selected_person_id=id[1];
	selected_person_true=1;
	if(selected_bar_visible==0){
		add_question_mark();
		selected_bar_visible=1;
		$('#inserted_save').hide();
		$('#inserted_item_bar').fadeIn(2000);
	}
	var selected_person=$('<div></div>');
	selected_person.attr('id','selected_'+person_id);
	selected_person.addClass('selected_block');
	selected_person.html($('#'+person_id).html());
	selected_person_html=selected_person.html();
	$('#inserted_person').html('');
	$('#inserted_person').append(selected_person);
	check_fill();				
}//end of select person



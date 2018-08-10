// JavaScript Document
//Send to archive request
function archive_request(request_id)
{
	datas={};
	datas['request_id']=request_id;
	$.ajax
	(
		{
			url:"archive_request",data:datas,dataType:"json",cache:true,type:'POST',error: function(e,s){alert('Error! '+e+s);},
			success:function(data)
			{
				var html=$('#request_'+request_id).html();
				$('#archive_reqs').append('<tr class="text-center">'+html+'</tr>');
				$('#request_'+request_id).fadeOut(500);
			}
		}
	);
}

//see request
function see_request(request_id,status,group_t_manager,codep)
{
	$('#alert_operation').removeClass().hide();
	$('#date_erae_suggest_tr').hide();
	$('#accept_reject_but').hide();
	$('#set_erae_date').hide();
	var datas={};
	datas['request_id']=request_id;
	$.ajax
	({
		url:'see_request',dataType:"json",data:datas,type:'POST',cache:true,
		error: function(e,s){alert('Error! '+e+'  '+s);},
		success:function(data)
		{
			//alert(data['data']);
			if(data['data']=='success')
			{
				var block_title=data['info'][0]['faraiand_title']+'-'+data['info'][0]['takhasos_title']+'-'+data['info'][0]['joze_title'];
				$('#block_title').text(block_title);
				$('#tool_title').text(data['info'][0]['title_tool']);
				$('#requester_title').text(data['info'][0]['nam']);
				$('#date_req').text(data['info'][0]['date_request']);
				$('#person_title').text(data['info'][0]['eraedahande']);
				if(status=='accept' && data['info'][0]['date_erae_suggest']!==null && data['info'][0]['tool_type']==2)
				{
					$('#date_erae_suggest_tr').show();
					$('#date_erae_suggest_lbl').html(data['info'][0]['date_erae_suggest']);
				}
				if(status=='wait' && group_t_manager==1)
				{
					$('#accept_reject_but').show();
					$('#reject_button').attr('req_id',request_id);
					$('#accept_button').attr('req_id',request_id);
				}
				if(status=='accept' && codep==data['info'][0]['code_person'] && data['info'][0]['tool_type']==2)
				{
					$('#set_erae_date').show();
					$('#set_date_erae_but').attr('req_id',request_id);
					$('#date_erae').val(data['info'][0]['date_erae_suggest']);
				}
				$('#stack1').modal('show');
			}
		}				
	});
}

//accept request
function accept_request()
{
	$('#alert_operation').removeClass().hide();
	var request_id=$('#accept_button').attr('req_id');
	var datas={};
	datas['request_id']=request_id;
	$.ajax
	({
		url:'accept_request',dataType:"json",data:datas,type:'POST',cache:true,
		error: function(e,s)
		{
			alert('Error! '+e+'  '+s); 
			$('#alert_operation').removeClass().addClass('alert alert-danger text-center').html('خطا در انجام عملیات.').show();
		},
		success:function(data)
		{
			//alert(data['data']);
			if(data['data']=='success')
			{
				/*$('#request_'+request_id).removeClass().addClass('success text-success text-center');
				$('#request_'+request_id+' i.status').removeClass().addClass('glyphicon glyphicon-ok');
				$('#request_'+request_id+' i.status').attr('title','پذیرفته شده');*/
				$('#alert_operation').removeClass().addClass('alert alert-success text-center').html('عملیات با موفقیت انجام شد.').show();
				location.reload();
			}
			else
			{
				$('#alert_operation').removeClass().addClass('alert alert-danger text-center').html('خطا در انجام عملیات.').show();
			}
		}
	});
}

//REJECT REQUEST
function reject_request()
{
	$('#alert_operation').removeClass().hide();	
	var request_id=$('#reject_button').attr('req_id');
	var datas={};
	datas['request_id']=request_id;
	$.ajax
	({
		url:'reject_request',dataType:"json",data:datas,type:'POST',cache:true,
		error: function(e,s)
		{
			alert('Error! '+e+'  '+s);
			$('#alert_operation').removeClass().addClass('alert alert-danger text-center').html('خطا در انجام عملیات.').show();
		},
		success:function(data)
		{
			//alert(data['data']);
			if(data['data']=='success')
			{
				/*$('#request_'+request_id).removeClass().addClass('success text-success text-center');
				$('#request_'+request_id+' i.status').removeClass().addClass('glyphicon glyphicon-ok');
				$('#request_'+request_id+' i.status').attr('title','پذیرفته شده');*/
				$('#alert_operation').removeClass().addClass('alert alert-success text-center').html('عملیات با موفقیت انجام شد.').show();
				location.reload();
			}
			else
			{
				$('#alert_operation').removeClass().addClass('alert alert-danger text-center').html('خطا در انجام عملیات.').show();				
			}
		}
	});
}
//set suggested date erae
function set_erae_suggest_date()
{
	$('#alert_operation').removeClass().hide();	
	$('#date_erae').removeClass('text-danger');
	var request_id=$('#set_date_erae_but').attr('req_id');
	var datas={};
	var date_suggest=$('#date_erae').val();
	if(date_suggest=='' || date_suggest==null)
	{
		$('#date_erae_lbl').addClass('text-danger');
		return false;
	}
	datas['request_id']=request_id;				datas['date_suggest']=date_suggest;
	$.ajax
	({
		url:'set_suggest_erae_date',dataType:"json",data:datas,type:'POST',cache:true,
		error: function(e,s)
		{
			alert('Error! '+e+'  '+s);
			$('#alert_operation').removeClass().addClass('alert alert-danger text-center').html('خطا در انجام عملیات.').show();
		},
		success:function(data)
		{
			//alert(data['data']);
			if(data['data']=='success')
			{
				$('#alert_operation').removeClass().addClass('alert alert-success text-center').html('عملیات با موفقیت انجام شد.').show();
				//location.reload();
			}
			else
			{
				$('#alert_operation').removeClass().addClass('alert alert-danger text-center').html('خطا در انجام عملیات.').show();				
			}
		}
	});	
}
//madovin list
function mosharekat_k(request_id)
{
	$('#list_madovin').modal('show');
	$('#req_id_filter').val(request_id);
	$('#alert_operation_2').hide();
	
	//get madovin list
	var datas={};
	datas['request_id']=request_id;
	$.ajax
	(
		{
			url:'get_madovin_list',dataType:"json",data:datas,type:'POST',cache:true,
			error: function(e,s)
			{
				alert('Error! '+e+'  '+s);
				$('#alert_operation_2').removeClass().addClass('alert alert-danger text-center').html('خطا در انجام عملیات.').show();
			},
			success:function(data)
			{
				//alert(data['data']);
				if(data['data']=='success')
				{						
					$('#list_madovin_list').html(data['madovin']);
				}//end of if
			}//end of success
		}//end of ajax
	);//end of ajax
	
}
//filter persons
function filter_persons()
{
	if($('#in_bashgah').is(':checked'))	{in_bashgah=1;}else{in_bashgah=0;}
	var samane=$('#samane_code').val();
	var mahfel=$('#mahfel_code').val();
	var request_id=$('#req_id_filter').val();
	if(request_id==0){return false};
	var datas={};	datas['in_bashgah']=in_bashgah;		datas['samane']=samane;		datas['mahfel']=mahfel;	datas['request_id']=request_id;
	$.ajax
	(
		{
			url:'filter_people',dataType:"json",data:datas,type:'POST',cache:true,
			error: function(e,s)
			{
				alert('Error! '+e+'  '+s);
				$('#alert_operation_2').removeClass().addClass('alert alert-danger text-center').html('خطا در انجام عملیات.').show();
			},
			success:function(data)
			{
				//alert(data['data']);
				if(data['data']=='success')
				{
					//var search_input='<input type="text" id="search_people_list" onChange="search_people_list()" ';
					//search_input=search_input+'	class="form-control" placeholder="جستجوی افراد لیست" />';
					$('#person_list').html(data['people']);
					//$('#alert_operation_2').removeClass().addClass('alert alert-success text-center').html('عملیات با موفقیت انجام شد.').show();
				
				}
				else
				{
					$('#alert_operation_2').removeClass().addClass('alert alert-danger text-center').html('خطا در انجام عملیات.').show();				
				}			
			}
			
		}
	
	);
}

//person lable mouse enter event
function person_m_m(codep)
{
	if($('#person_'+codep).hasClass('madov_item'))
	{
		$('#person_'+codep).removeClass().addClass('madov_item btn btn-danger person_total');
	}
	else
	{
		$('#person_'+codep).removeClass().addClass('btn btn-success person_total');
	}
	$('#person_'+codep+' img').removeClass().addClass('img-rounded fullwidth');
}
////person lable mouse out event
function person_o(codep)
{
	if($('#person_'+codep).hasClass('madov_item'))
	{
		$('#person_'+codep).removeClass().addClass('madov_item btn btn-success person_total');
	}
	else
	{
		$('#person_'+codep).removeClass().addClass('btn btn-info person_total');	
	}
	$('#person_'+codep+' img').removeClass().addClass('img-circle halfwidth');
}
////person lable mouse click event
function person_click(codep)
{
	var request_id=$('#req_id_filter').val();
	if(request_id<=0 || codep<=0){return false;}
	var datas={};		datas['request_id']=request_id;			datas['codep_madov']=codep;
	if($('#person_'+codep).hasClass('madov_item'))
	{
		$.ajax
		(
			{
				url:'remove_madov',dataType:"json",data:datas,type:'POST',cache:true,
				error: function(e,s)
				{
					alert('Error! '+e+'  '+s);
					$('#alert_operation_2').removeClass().addClass('alert alert-danger text-center').html('خطا در انجام عملیات.').show();
				},
				success:function(data)
				{
					//alert(data['data']);
					if(data['data']=='success')
					{
						$('#person_'+codep).removeClass().addClass('btn btn-info person_total');
						$('#person_'+codep+' img').removeClass().addClass('img-circle halfwidth');
						$('#person_'+codep).prependTo('#person_list');
					}//end of if
				}//end of success
			}//end of ajax
		);//end of ajax
	}
	else
	{
		$.ajax
		(
			{
				url:'add_madov',dataType:"json",data:datas,type:'POST',cache:true,
				error: function(e,s)
				{
					alert('Error! '+e+'  '+s);
					$('#alert_operation_2').removeClass().addClass('alert alert-danger text-center').html('خطا در انجام عملیات.').show();
				},
				success:function(data)
				{
					//alert(data['data']);
					if(data['data']=='success')
					{
						if(data['duplicate']=='duplicate')
						{
							alert('داده تکراری!');
						}
						else
						{
							$('#person_'+codep).removeClass().addClass('madov_item btn btn-success person_total');
							$('#person_'+codep+' img').removeClass().addClass('img-circle halfwidth');
							$('#person_'+codep).prependTo('#list_madovin_list');
						}
					}//end of if
				}//end of success
			}//end of ajax
		);//end of ajax
	}//end of else
}

//search filterd people in madovin list
function search_people_list()
{
	$('div.person_total').removeClass('mark_search');
	var search_value=$('#search_people_list').val();
	search_value=search_value.trim();
	if(search_value==null || search_value=='')
	{
		return false;
	}
	$("div.person_total:contains("+search_value+")").addClass('mark_search');
	//$('#count_samnane').text($('.mark_search2').length+' عدد');
	$('.mark_search').each(function(){
		$('#person_list').prepend($(this));					
	});
	alert('ok');	
}
//ersal davatname
function send_davatname()
{
	var request_id=$('#req_id_filter').val();
	if(request_id<=0){return false;}
	var datas={};			datas['request_id']=request_id;
	
	
	$.ajax
	(
		{
			url:'send_madovin_message',dataType:"json",data:datas,type:'POST',cache:true,
			error: function(e,s)
			{
				alert('Error! '+e+'  '+s);
				$('#alert_operation_2').removeClass().addClass('alert alert-danger text-center').html('خطا در انجام عملیات.').show();
			},
			success:function(data)
			{
				//alert(data['data']);
				if(data['data']=='success')
				{
					$('#alert_operation_2').removeClass().addClass('alert alert-success text-center').html('دعوت نامه ارسال شد.').show();
				}//end of if
			}//end of success
		}//end of ajax
	);//end of ajax
}
//////get the message info
function get_message(code_request,message_id,readed,msgtyp)
{
	var datas={};
	datas['message_id']=message_id;			datas['code_request']=code_request;			datas['readed']=readed;
	$.ajax
	({
		url:'get_message_info',dataType:"json",data:datas,type:'POST',cache:true,
		error: function(e,s){alert('Error! '+e+'  '+s);},
		success:function(data)
		{
			//alert(data['data']);
			/*
			if(readed==0)
			{
				var msg_count=$('#message_count').text();
				$('#message_count').text(msg_count-1);
				$('#message_'+message_id).removeClass('text-success');
			}*/
			$('#modal_title').text(msgtyp);
			$('#block_title').text(data['block_title']);
			$('#tool_title').text(data['tool_title']);
			$('#requester_title').text(data['requester']);
			$('#date_req').text(data['date_request']);
			$('#person_title').text(data['eraedahande']);
			$('#date_erae_suggest_lbl').text(data['date_erae_suggest']);
			
			$('#alert_operation').removeClass().hide();
			//$('#date_erae_suggest_tr').hide();
			$('#accept_reject_but').hide();
			$('#set_erae_date').hide();
			
			$('#stack1').modal('show');
		}				
	});
}

///////////req_finalization
function finalize(code_request,tool_type)
{
	if(tool_type==2)
	{
		$('#alert_op').hide();
		$('#req_finalization').modal('show');
		$('#alert_operation_3').hide();
		
		var appElement=document.querySelector('[ng-app=bashgah_app]');
		var $scope=angular.element(appElement).scope();
		var cs=$scope.$$childHead;
		h2=cs.get_request_info(code_request);		
		
		
		
		//cs.$apply(function(){cs.request_info=h2;});		
	}
}

app=angular.module('bashgah_app',[]);
app.controller('finalCtrl',function($scope,$http)
{
	$scope.madovin_list=[{}];
	//$scope.madovin_absent_list={};
	$scope.request_info=[{}];
	//$scope.request_finalize_info=[{}];
	
	$scope.get_request_info=function(request_id)
	{
		var datas={};
		datas['request_id']=request_id;
		$http({method:'post',url:'see_request/1',data:datas})
				.then(
						function(results)
						{
							$scope.request_info=results.data;
							//console.log(results.data.info[0]);
							$('#datepicker1').val(results.data.info[0].dateerae);
							$('#mark_request_value').val(results.data.info[0].mark);
						});
		$http({method:'post',url:'get_madovin_list2',data:datas}).then(function(results2){$scope.madovin_list=results2.data;});
	};
	
	//define class
	$scope.madov_class=function(m_status)
	{
		if(m_status=='present')
		{
			return "madov_item btn btn-success person_total";
		}
		else
		{
			return "madov_item btn btn-danger person_total";
		}
	}
	
	//Show absent present button
	$scope.show_absent=function(m_status)
	{if(m_status=='present'){return true;}else{return false;}}
	//Show absent present button
	$scope.show_present=function(m_status)
	{if(m_status=='absent'){return true;}else{return false;}}
	
	//update absent present list
	$scope.change_status=function(mp,code_request,status)
	{
		$('#checkbox_pr_'+mp.codep).hide(500);
		$('#checkbox_abs_'+mp.codep).hide(500);
		var datas={};		datas['request_id']=code_request;			datas['codep']=mp.codep;		datas['status']=status;
		$http({method:'post',url:'update_madovin_list_status',data:datas}).then(function(result)
		{
			$scope.madovin_list=result.data;			
			//$http({method:'post',url:'get_madovin_list2',data:datas}).then(function(results2){$scope.madovin_list=results2.data;});
		});
	}
	
	// save mark
	$scope.save_mark=function(data)
	{
		var mark_val=$('#mark_request_value').val();
		if(mark_val=='' || mark_val==null || isNaN(mark_val)==true)
		{
			$('#mark_request_value').addClass('has-error');
			return false;
		}
		var date_erae=$('#datepicker1').val();
		if(date_erae=='' || date_erae==null)
		{
			return false;
		}
		var datas={};	datas['mark']=mark_val;		datas['dateerae']=date_erae;		datas['suratjalase']=data[0].surat_jalase;
		datas['code_request']=data[0].code_request;
		//console.log(datas);
		$.ajax({url:site_url+'/group_t/save_request_mark',cache:true,data:datas,dataType:"json",type:'POST',
				success: function(data)
						 {$('#alert_op').text('اطلاعات با موفقیت ثبت شد.'); $('#alert_op').show();
						 $('#alert_op').removeClass().addClass('alert alert-success');
						 setInterval($('#req_finalization').modal('hide'),5000);},
				error: function()
						{alert('خطا!'); $('#alert_op').text('خطا در ثبت اطلاعات!'); $('#alert_op').show();
						$('#alert_op').removeClass().addClass('alert alert-danger');}
				});
		
	}	
	//
	$scope.open=function(obj)
	{
		alert(obj.status);	
	}
	
});

$(function() {	
	$("#datepicker1btn").click(function(event) {
		event.preventDefault();
		$("#datepicker1").datepicker({isRTL: true,dateFormat: "dd/mm/yy",changeMonth: true,changeYear: true, showOtherMonths: true,
                    selectOtherMonths: true});
		$("#datepicker1").focus();
	});
});
$("#datepicker1").on('click',function()
{
	$("#datepicker1btn").click();
});


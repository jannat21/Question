// JavaScript Document
$(function load_chart()
{
	total_block();
	setTimeout(takhasos_block(),500);
	setTimeout(avg_gap(),1000);	
	setTimeout(ten_max_tot_gap(),1500);		
});
//total block
function total_block()
{
	$("#chart").html("<p style='direction:rtl;'>در حال نمایش ...</p>");
	
	var options = {chart: {	renderTo: 'chart',type:'column',style:{fontFamily:'Droid Arabic Naskh'}},
					credits: {enabled: false},title: {text: 'تعداد بلوک ها و بلوک ها به تفکیک سامانه / صنعت',x: -20	},
					xAxis: {categories: [{}]},
					tooltip: {useHTML:true,
							formatter: function() {
						var s = '<div style="direction:rtl; font-family:"Droid Arabic Naskh"" ><b class="text-primary">'+ this.x +'</b>';
								$.each(this.points, function(i, point) {s += '<br/>'+point.series.name+': '+point.y;});
								s=s+'</div>';
								return s;
							},shared: true
					},
					series: [{},{}]
				};
	
	$.ajax({
		url: site_url+'/group_t/get_nataiej_arzyabi/total_block/0',
		data: 'show=impression',
		type:'post',
		dataType: "json",
		success: function(data){
			options.xAxis.categories = data.x_axis;
			options.series[0].name = 'بلوک ها';
			options.series[0].data = data.block_series;
			options.series[1].name = 'بلوک های ارزیابی شده';
			options.series[1].data = data.arzyabi_series;
			var chart = new Highcharts.Chart(options);			
		}
	});
}

//takhasos block
function takhasos_block()
{
	$("#chart_takhasos").html("<p style='direction:rtl;'>در حال نمایش ...</p>");
	
	var options = {chart: {	renderTo: 'chart_takhasos',type:'column',style:{fontFamily:'Droid Arabic Naskh'}},
					credits: {enabled: false},title: {text: 'بلوک های ارزیابی شده بر اساس تخصص',x: -20	},
					xAxis: {categories: [{}]},
					tooltip: {useHTML:true,
							formatter: function() {
						var s = '<div style="direction:rtl; font-family:"Droid Arabic Naskh"" ><b class="text-primary">'+ this.x +'</b>';
								$.each(this.points, function(i, point) {s += '<br/>'+point.series.name+': '+point.y;});
								s=s+'</div>';
								return s;
							},shared: true
					},
					series: [{},{}]
				};
	
	$.ajax({
		url: site_url+'/group_t/get_nataiej_arzyabi/takhasos_block/'+group_code,
		data: 'show=impression',
		type:'post',
		dataType: "json",
		success: function(data){
			options.xAxis.categories = data.x_axis;
			options.series[0].name = 'تعداد بلوک تخصص';
			options.series[0].data = data.takhasos_series;
			options.series[1].name = 'بلوک های ارزیابی شده';
			options.series[1].data = data.arzyabi_series;
			var chart = new Highcharts.Chart(options);			
		}
	});
}

//avg_gap
function avg_gap()
{
	$("#chart_avg_gap").html("<p style='direction:rtl;'>در حال نمایش ...</p>");
		
	var options = {chart: {	renderTo: 'chart_avg_gap',type:'column',style:{fontFamily:'Droid Arabic Naskh'}},
					credits: {enabled: false},title: {text: 'میانگین شکاف ها',x: -20	},
					xAxis: {categories: [{}]},
					tooltip: {useHTML:true,
							formatter: function() {
						var s = '<div style="direction:rtl; font-family:"Droid Arabic Naskh"" ><b class="text-primary">'+ this.x +'</b>';
								$.each(this.points, function(i, point) {s += '<br/>'+point.series.name+': '+point.y;});
								s=s+'</div>';
								return s;
							},shared: true
					},
					series: [{}]
				};
	
	$.ajax({
		url: site_url+'/group_t/get_nataiej_arzyabi/avg_gap/'+group_code,
		data: 'show=impression',
		type:'post',
		dataType: "json",
		success: function(data){
			options.xAxis.categories = data.x_axis;
			options.series[0].name = 'میانگین شکاف';
			options.series[0].data = data.gap_series;
			var chart = new Highcharts.Chart(options);			
		}
	});	
}
//ten max gap
function ten_max_tot_gap()
{
	$("#chart_ten_total_gap").html("<p style='direction:rtl;'>در حال نمایش ...</p>");
		
	var options = {chart: {	renderTo: 'chart_ten_total_gap',type:'column',style:{fontFamily:'Droid Arabic Naskh'}},
					credits: {enabled: false},title: {text: 'ده عدد از بلوک ها با بیشترین شکاف',x: -20	},
					xAxis: {categories: [{}]},
					tooltip: {useHTML:true,
							formatter: function() {
						var s = '<div style="direction:rtl; font-family:"Droid Arabic Naskh"" ><b class="text-primary">'+ this.x +'</b>';
								$.each(this.points, function(i, point) {s += '<br/>'+point.series.name+': '+point.y;});
								s=s+'</div>';
								return s;
							},shared: true
					},
					series: [{},{},{},{},{}]
				};
	
	$.ajax({
		url: site_url+'/group_t/get_nataiej_arzyabi/ten_max_tot_gap/'+group_code,
		data: 'show=impression',
		type:'post',
		dataType: "json",
		success: function(data){
			options.xAxis.categories = data.x_axis;
			options.series[0].name = 'شکاف کل';
			options.series[0].data = data.tot_gap_series;
			options.series[1].name = 'شکاف توزیع';
			options.series[1].data = data.gap_tu_series;
			options.series[2].name = 'شکاف تخصص';
			options.series[2].data = data.gap_t_series;
			options.series[3].name = 'شکاف کدسازی';
			options.series[3].data = data.gap_k_series;
			options.series[4].name = 'شکاف اعتبار';
			options.series[4].data = data.gap_e_series;
			var chart = new Highcharts.Chart(options);			
		}
	});	
}
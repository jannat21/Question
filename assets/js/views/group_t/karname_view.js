// JavaScript Document

$(function load_chart()
{
	//get_karname();	
});

//get person karname
/*function get_karname()
{
	$("#karname").html("<p style='direction:rtl;'>در حال نمایش ...</p>");
	
	var options = {chart: {	renderTo: 'karname',type:'column',style:{fontFamily:'Droid Arabic Naskh'}},
					credits: {enabled: false},title: {text: 'عملکرد در پروژه',x: -20	},
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
		url: site_url+'/group_t/get_karname/1/0/0/0/0/false',
		data: 'show=impression',
		type:'post',
		dataType: "json",
		success: function(data){
			options.xAxis.categories = data.x_axis;
			options.series[0].name = 'امتیازات';
			options.series[0].data = data.y_axis;
			
			var chart = new Highcharts.Chart(options);			
		},error: function(){alert('Error!');}
	});	
}
*/







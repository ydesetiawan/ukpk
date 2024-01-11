$('#dataTables-example').dataTable();

$('.datepicker').datepicker({
	format : 'yyyy-mm-dd'
});

//employee
// $("#employee_date_of_birth").on("changeDate", function(event) {
// 	$("#employee_password").val($("#employee_date_of_birth").datepicker('getFormattedDate'));
// });

//start-test
$("#answerA").on("change", function(event) {
	$("#choice_answer").val('A');
});
$("#answerB").on("change", function(event) {
	$("#choice_answer").val('B');
});
$("#answerC").on("change", function(event) {
	$("#choice_answer").val('C');
});
$("#answerD").on("change", function(event) {
	$("#choice_answer").val('D');
});



$("div.print-page").hide();
$("#onPrint").on("click", function(event) {
	Popup($("div.print-page").html());
});
function Popup(data) {
	var mywindow = window.open('', 'Uji Kompetensi Penerimaan Karyawan', '');
	mywindow.document.write('<html><head>');
	mywindow.document.write('<link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css" />');
	mywindow.document.write('</head><body >');
	mywindow.document.write(data);
	mywindow.document.write('</body></html>');
	mywindow.document.close();
	// necessary for IE >= 10
	mywindow.focus();
	// necessary for IE >= 10
	mywindow.print();
	mywindow.close();
	return true;
}

//TIMER
// var ukpkYear=2015;
// var ukpkMonth=6;
// var ukpkDay=15;
// var ukpkHour=7;
// var ukpkMinute=44;
// var ukpkSecound=10;
var startTime = new Date();
startTime = new Date(ukpkYear, ukpkMonth - 1, ukpkDay, ukpkHour, ukpkMinute, ukpkSecound);

$('#beforeTimeTest').countdown($.extend({
	until : startTime,
	onExpiry : startTest,
	compact : true,
	layout : '<center>Waktu uji kompetensi kurang <br><b>{dn} hari {hnn}{sep}{mnn}{sep}{snn}</b> {desc}</center>',
}, $.countdown.regionalOptions['id']));

function startTest() {
	allowedTest = 1;
	jQuery('#changeSession').load('session.php?allowedTest=' + allowedTest);
	setTimeout(function() {
		window.location.reload();
	}, 2000);
}

endTime = new Date(ukpkYear, ukpkMonth - 1, ukpkDay, ukpkHour + ukpkLongHour, ukpkMinute + ukpkLongMinute, ukpkSecound + ukpkLongSecound);
$('#startTimeTest').countdown($.extend({
	until : endTime,
	format : 'HMS',
	onExpiry : endTest,
	layout : '<center>Durasi Waktu uji kompetensi <br><b>{hnn}{sep}{mnn}{sep}{snn}</b> {desc}</center>',
	description : ' '
}, $.countdown.regionalOptions['id']));

function endTest() {
	allowedTest = 2;
	jQuery('#changeSession').load('session.php?allowedTest=' + allowedTest);
	setTimeout(function() {
		window.location.replace("home.php?menu=test");
	}, 2000);
}


$('#beforeTimeTest').hide();
$('#startTimeTest').hide();
$('#finishTest').hide();
$('.ukpkBeforeTest').hide();
$('.ukpkStartTest').hide();
$('.ukpkAfterTest').hide();
$('.status-hidden').hide();

if (allowedTest == 1) {
	$('#startTimeTest').show();
	$('.ukpkStartTest').show();
} else if (allowedTest == 2) {
	$('#finishTest').show();
	$('.ukpkAfterTest').show();
} else if (allowedTest == 0) {
	$('#beforeTimeTest').show();
	$('.ukpkBeforeTest').show();
}


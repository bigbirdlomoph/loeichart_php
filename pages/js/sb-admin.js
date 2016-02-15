$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
$(function() {
    $(window).bind("load resize", function() {
        console.log($(this).width())
        if ($(this).width() < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    })
})

<!-------code ajax load page ตอน link page------->
var HttPRequest = false;

	   function doCallAjax(url) {
		  HttPRequest = false;
		  if (window.XMLHttpRequest) { // Mozilla, Safari,...
			 HttPRequest = new XMLHttpRequest();
			 if (HttPRequest.overrideMimeType) {
				HttPRequest.overrideMimeType('text/html');
			 }
		  } else if (window.ActiveXObject) { // IE
			 try {
				HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
			 } catch (e) {
				try {
				   HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {}
			 }
		  } 
		  
		  if (!HttPRequest) {
			 alert('Cannot create XMLHTTP instance');
			 return false;
		  }
	
		    var pmeters = "";

			HttPRequest.open('POST',url,true);

			HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			HttPRequest.setRequestHeader("Content-length", pmeters.length);
			HttPRequest.setRequestHeader("Connection", "close");
			HttPRequest.send(pmeters);
			
			
			HttPRequest.onreadystatechange = function()
			{

				 if(HttPRequest.readyState == 3)  // Loading Request
				  {
				   document.getElementById("mySpan").innerHTML = "Now is Loading...";
				  }

				 if(HttPRequest.readyState == 4) // Return Request
				  {			  
					  document.getElementById('mySpan').innerHTML = HttPRequest.responseText;
				  }				
			}

	   }
<!-------code ajax load page sub index------->
var HttPRequest = false;

	   function doCallAjaxSub(url) {
		  HttPRequest = false;
		  if (window.XMLHttpRequest) { // Mozilla, Safari,...
			 HttPRequest = new XMLHttpRequest();
			 if (HttPRequest.overrideMimeType) {
				HttPRequest.overrideMimeType('text/html');
			 }
		  } else if (window.ActiveXObject) { // IE
			 try {
				HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
			 } catch (e) {
				try {
				   HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {}
			 }
		  } 
		  
		  if (!HttPRequest) {
			 alert('Cannot create XMLHTTP instance');
			 return false;
		  }
	
		    var pmeters = "";

			HttPRequest.open('POST',url,true);

			HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			HttPRequest.setRequestHeader("Content-length", pmeters.length);
			HttPRequest.setRequestHeader("Connection", "close");
			HttPRequest.send(pmeters);
			
			
			HttPRequest.onreadystatechange = function()
			{

				 if(HttPRequest.readyState == 3)  // Loading Request
				  {
				   document.getElementById("mySpan2").innerHTML = "Now is Loading...";
				  }

				 if(HttPRequest.readyState == 4) // Return Request
				  {			  
					  document.getElementById('mySpan2').innerHTML = HttPRequest.responseText;
				  }				
			}

	   }
<!--pop-->
function popup(url, title, w, h) {  
    // Fixes dual-screen position                         Most browsers      Firefox  
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;  
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;  
              
    width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;  
    height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;  
              
    var left = ((width / 2) - (w / 2)) + dualScreenLeft;  
    var top = ((height / 2) - (h / 2)) + dualScreenTop;  
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);  
  
    // Puts focus on the newWindow  
    if (window.focus) {  
        newWindow.focus();  
    }  
}  
<!--Alert -->
function alert_y(){
alert("กรุณาเลือกช่วงวันที่ที่ต้องการค้นหา");
}
<!--Year Select Report-->
function Year_select()
{
 var str_date=document.getElementById('frmyear').str_date.value;
 var end_date=document.getElementById('frmyear').end_date.value;
// alert(str_date);
    var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+="report_list.php";
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("str_date="+str_date+"&end_date="+end_date);
}
<!--Year Select Report-->
function Year_anc()
{
 var str_date=document.getElementById('frmyear').str_date.value;
 var end_date=document.getElementById('frmyear').end_date.value;
  var fdisp=document.getElementById('frmyear').fdisp.value;
   var idrep=document.getElementById('frmyear').idrep.value;
    var table=document.getElementById('frmyear').table.value;
	var age=document.getElementById('frmyear').age.value;
	//alert(idrep);
if (str_date=='' && end_date=='')
    {alert("กรุณาเลือกช่วงวันที่")}else{
    var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+=fdisp;
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("str_date="+str_date+"&end_date="+end_date+"&id="+idrep+"&table="+table+"&age="+age);
			
}
}
<!--Year Select Report-->
function Year_search()
{

 var fy=document.getElementById('fyear').fy.value;
  var fdisp=document.getElementById('fyear').fdisp.value;
   var idrep=document.getElementById('fyear').idrep.value;
    var table=document.getElementById('fyear').table.value;
	var age=document.getElementById('fyear').age.value;

    var str_date=(Number(fy)-1)+"-10-01";
	var end_date= (Number(fy))+"-09-30";
	//alert(str_date+" "+ end_date);
if (fy =='')
    {alert("กรุณาเลือกปี")}else{
    var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+=fdisp;
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("str_date="+str_date+"&end_date="+end_date+"&id="+idrep+"&table="+table+"&age="+age+"&fy="+fy);
			
}
}
<!--AMPURE Session-->
function ampure_serch()
{ 
 var ampcode=document.getElementById('form1').ampcode.value;
  //alert(ampcode);
	  var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+="monitor-session-show.php";
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("ampcode="+ampcode);
	         

 } 
<!--AMPURE data send-->
function ampure_serch()
{ 
 var ampcode=document.getElementById('form1').ampcode.value;
  //alert(ampcode);
	  var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+="monitor-data-send-show.php";
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("ampcode="+ampcode);
	         

 } 

<!--CHECKUSER--->
function chkuser(){
          var user=document.getElementById('frm1').user.value;
		  var pass=document.getElementById('frm1').pass.value;	
		  //alert(user);
	  var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+="checkuser.php";
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("user="+user+"&pass="+pass);
}
<!--Session Destroy-->
function sesdestroy(){
	
	    
	
	}
<!--chbox-->
function CheckAll() {
for (var i = 0; i < document.frm.elements.length; i++) {
if(document.frm.elements[i].type == 'checkbox'){
document.frm.elements[i].checked = !(document.frm.elements[i].checked);
}
}
}
<!--CHECK-BOX SELECT ALL-->
function checkAll(id)
{
	elm=document.getElementsByTagName('input');
	for(i=0; i<elm.length ;i++){
		 if(elm[i].id==id){
				elm[i].checked = true ;
		  }
	   }
	 
}
<!--CHECK-BOX UNSELECT ALL-->
function uncheckAll(id)
{
	elm=document.getElementsByTagName('input');
	for(i=0; i<elm.length ;i++){
		 if(elm[i].id==id){
				elm[i].checked = false ;
		  }
	   }
}
	
<!--confirmData-->
function sendingdata()
{
          var gdrive=document.getElementById('frm2').gdrive.value;
		  var userfile=document.getElementById('frm2').userfile.value;
		  var sdate=document.getElementById('frm2').sdate.value;
		  var title=document.getElementById('frm2').title.value;
		  var detail=document.getElementById('frm2').detail.value;
		  var user=document.getElementById('frm2').user.value;
		  var ssj=document.getElementById('frm2').ssj.value;
		  var sso=document.getElementById('frm2').sso.value;
		  var hosp=document.getElementById('frm2').hosp.value;
		  var pcuamp1=document.getElementById('frm2').pcuamp1.value;
		  var pcuamp2=document.getElementById('frm2').pcuamp2.value;
		  var pcuamp3=document.getElementById('frm2').pcuamp3.value;
		  var pcuamp4=document.getElementById('frm2').pcuamp4.value;
		  var pcuamp5=document.getElementById('frm2').pcuamp5.value;
		  var pcuamp6=document.getElementById('frm2').pcuamp6.value;
		  var pcuamp7=document.getElementById('frm2').pcuamp7.value;
		  var pcuamp8=document.getElementById('frm2').pcuamp8.value;
		  var pcuamp9=document.getElementById('frm2').pcuamp9.value;
		  var pcuamp10=document.getElementById('frm2').pcuamp10.value;
		  var pcuamp11=document.getElementById('frm2').pcuamp11.value;
		  var pcuamp12=document.getElementById('frm2').pcuamp12.value;
		  var pcuamp13=document.getElementById('frm2').pcuamp13.value;
		  var pcuamp14=document.getElementById('frm2').pcuamp14.value;	
		  alert(gdrive);
	  var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+="sms-send_data_query.php";
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("gdrive="+gdrive+"&userfile="+userfile+"&sdate="+sdate+"&user="+user+"&title="+title+"&detail="+detail+"&ssj="+ssj+"&sso="+sso+"&hosp="+hosp+"&pcuamp1="+pcuamp1+"&pcuamp2="+pcuamp2+"&pcuamp3="+pcuamp3+"&pcuamp4="+pcuamp4+"&pcuamp5="+pcuamp5+"&pcuamp6="+pcuamp6+"&pcuamp7="+pcuamp7+"&pcuamp8="+pcuamp8+"&pcuamp9="+pcuamp9+"&pcuamp10="+pcuamp10+"&pcuamp11="+pcuamp11+"&pcuamp12="+pcuamp12+"&pcuamp13="+pcuamp13+"&pcuamp14="+pcuamp14);
   	
}


<!--Download Book-->
function getbook()
{
   var userid=document.getElementById('frmgetb').userid.value;
   var code_input=document.getElementById('frmgetb').code_input.value;
   var code_hidden=document.getElementById('frmgetb').code_hidden.value;
   var bookid=document.getElementById('frmgetb').bookid.value;
   var box_file=document.getElementById('frmgetb').box_file.value;
   var box_title=document.getElementById('frmgetb').box_title.value;
   var box_gdrive=document.getElementById('frmgetb').box_gdrive.value;
   var box_date=document.getElementById('frmgetb').box_date.value;
   var box_id=document.getElementById('frmgetb').box_id.value;
  //alert(userid);
	  var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+="sms-user_get_book_query.php";
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("userid="+userid+"&code_hidden="+code_hidden+"&bookid="+bookid+"&box_file="+box_file+"&box_title="+box_title+"&box_gdrive="+box_gdrive+"&box_date="+box_date+"&box_id="+box_id+"&code_input="+code_input);
	
}
<!--reload-->
<!--User regist-->
function Ureg(){
	var username=document.getElementById('frmu').username.value;
	var password=document.getElementById('frmu').password.value;
	var fname=document.getElementById('frmu').fname.value;
	var lname=document.getElementById('frmu').lname.value;
	var box_id=document.getElementById('frmu').box_id.value;
    var box_group=document.getElementById('frmu').box_group.value;
   var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+="sms-adduser_query.php";
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("username="+username+"&password="+password+"&fname="+fname+"&lname="+lname+"&box_id="+box_id+"&box_group="+box_group);
			 
		frmu.reset();//reset From 
	
}

<!--User EDIT-->
function Uedit(){
	var user_id=document.getElementById('frmuedit').user_id.value;
	var username=document.getElementById('frmuedit').username.value;
	var password=document.getElementById('frmuedit').password.value;
	var fname=document.getElementById('frmuedit').fname.value;
	var lname=document.getElementById('frmuedit').lname.value;
	var box_id=document.getElementById('frmuedit').box_id.value;
    var box_group=document.getElementById('frmuedit').box_group.value;
   var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+="sms-edituser_query.php";
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("username="+username+"&password="+password+"&fname="+fname+"&lname="+lname+"&box_id="+box_id+"&box_group="+box_group+"&user_id="+user_id);
			 
		frmuedit.reset();//reset From 
	
}

//box add New
function boxNew(){
	  var box_code=document.getElementById('frmb').box_code.value;
	  var box_name=document.getElementById('frmb').box_name.value;
	  var box_type=document.getElementById('frmb').box_type.value;
	  var box_group=document.getElementById('frmb').box_group.value;
	  //alert(box_group);
	  var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+="sms-addbox_query.php";
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("box_code="+box_code+"&box_name="+box_name+"&box_type="+box_type+"&box_group="+box_group);
			 
		frmb.reset();//reset From 
	}
//box dell
function boxDell(){
	var box_year =document.getElementById('frmd').box_year.value;
	//alert(box_year);
	if(confirm('คุณต้องการทำลายหนังสือใช่หรือไม่ !!!')){
		
	var code_del=prompt("รหัสยืนยันการลบหนังสือ","");
	if(code_del=='ลบหนังสือ')
	{	
	var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+="sms-delete_query.php";
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("box_year="+box_year);
			 
		frmb.reset();//reset From
	 alert('หนังสือถูกทำลายเรียบร้อย')
   	}else{
		 alert('WRONG CODE DELETE !!!');
	}

  frmb.reset();//reset From
	}
}
//Search_report_modal
function Search_fmodal()
{
 var catId=document.getElementById('frm_report').catId.value;
 var catName=document.getElementById('frm_report').catName.value;
// alert(str_date);
    var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+="report_list_fmodal.php";
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("catId="+catId+"&catName="+catName);
}
//chang user
function changuser()
{
 var m=document.getElementById('frm_chang').m.value;	
 var nuser=document.getElementById('frm_chang').nuser.value;
 var ouser=document.getElementById('frm_chang').ouser.value;
 var uid=document.getElementById('frm_chang').uid.value;
 
 if(nuser==""||ouser==""){
	alert("กรุณาตรวจสอบข้อมูลด้วย"); 
 }else{
    var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+="pass_chang_q.php";
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("nuser="+nuser+"&ouser="+ouser+"&uid="+uid+"&m="+m);
  }
}

//chang password
function changpass()
{
 	
 var user=document.getElementById('frm_chang').user.value;
  var opass=document.getElementById('frm_chang').opass.value;
 var pass=document.getElementById('frm_chang').pass.value;
 var apass=document.getElementById('frm_chang').apass.value;
 var uid=document.getElementById('frm_chang').uid.value;
 
 if(user==""||opass==""||pass==""||apass==""){
	alert("กรุณาตรวจสอบข้อมูลด้วย"); 
	 }
  else if(pass!=apass){
   alert("รหัสผ่านของคุณไม่ตรงกัน");
 }else{
    var req;
	  if(window.XMLHttpRequest) req=new XMLHttpRequest();
	      else if(window.ActiveXObject)req=new ActiveXObject("Microsoft.XMLHTTP");
		else
		{
		 alert("Browser not support");return false;
		}
		req.onreadystatechange=function()
		  {
		    if (req.readyState==4)
			   {
				 document.getElementById("myShow").innerHTML = req.responseText;
			   }
		   }
		     var querystr="";
             querystr+="pass_chang_q.php";
			  //alert(querystr);
			 req.open("POST",querystr,true);
			 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
			 req.send("user="+user+"&pass="+pass+"&opass="+opass+"&apass="+apass+"&uid="+uid);
  }
}
//secure
function ark_user()
{
	
	var qu=prompt("เราไม่สามารถให้คุณผ่านเข้าไปได้ ถ้าคุณยืนยันไม่ถูกต้อง","");

	  if(qu=='administrator')
		{
	  		alert("ยินดีด้วยคุณสามารถเข้าใช้งานได้");
			window.location="index-admin.php";
		}
	   else
		{
	 		alert("คุณไม่สามารถเข้าใช้งานส่วนนี้ได้เนื่องจากการยืนยันไม่ถูกต้อง เราต้องขออภัยด้วย ลองเข้าใช้งานในส่วนของฝ่ายงานคุณดู");
			window.location="log_out.php";
		}
}
//contex menu
(function ($, window) {

    $.fn.contextMenu = function (settings) {

        return this.each(function () {

            // Open context menu
            $(this).on("contextmenu", function (e) {
                // return native menu if pressing control
                if (e.ctrlKey) return;
                
                //open menu
                $(settings.menuSelector)
                    .data("invokedOn", $(e.target))
                    .show()
                    .css({
                        position: "absolute",
                        left: getMenuPosition(e.clientX, 'width', 'scrollLeft'),
                        top: getMenuPosition(e.clientY, 'height', 'scrollTop')
                    })
                    .off('click')
                    .on('click', function (e) {
                        $(this).hide();
                
                        var $invokedOn = $(this).data("invokedOn");
                        var $selectedMenu = $(e.target);
                        
                        settings.menuSelected.call(this, $invokedOn, $selectedMenu);
                });
                
                return false;
            });

            //make sure menu closes on any click
            $(document).click(function () {
                $(settings.menuSelector).hide();
            });
        });
        
        function getMenuPosition(mouse, direction, scrollDir) {
            var win = $(window)[direction](),
                scroll = $(window)[scrollDir](),
                menu = $(settings.menuSelector)[direction](),
                position = mouse + scroll;
                        
            // opening menu would pass the side of the page
            if (mouse + menu > win && menu < mouse) 
                position -= menu;
            
            return position;
        }    

    };
})(jQuery, window);

$("#myTable td").contextMenu({
    menuSelector: "#contextMenu",
    menuSelected: function (invokedOn, selectedMenu) {
        var msg = "You selected the menu item '" + selectedMenu.text() +
            "' on the value '" + invokedOn.text() + "'";
        alert(msg);
    }
});
//logout
function logOut() {
  window.location = "logout.php";
  return false;
}
       
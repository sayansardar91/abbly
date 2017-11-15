<?php 
	$allow = array(1,2);
	if(!in_array($_SESSION['type'], $allow)){
		echo "<script>alert('You are not allowed to access this page.');</script>";
		echo "<script>window.location = '/index.php?pg=home'</script>";
	}
?>
<script type="text/javascript">
function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'my div', 'scrollbars=1,height=400,width=600');
        mywindow.document.write('<html><head><style>');
        mywindow.document.write('table {border-collapse: collapse !important; font-family:Verdana, Geneva, sans-serif;font-size: 14px;}table, th, td {border: 1px solid black !important;}table, tr, td{color:#000000;}');
        mywindow.document.write('</style></head><body><pre>');
        mywindow.document.write(data);
        mywindow.document.write('<pre></body></html>');
        mywindow.document.close();
        mywindow.print();
        return true;
    }
</script>
<link href="css/jquery-ui.css" rel="stylesheet"/>
<div class="row">
    <div class="col-md-12 col-sm-6 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <form class="form-horizontal row-border">
            <div class="form-group">
            	<div class="row">
                	<label class="col-md-2 control-label">Dr. Name :</label>
                    <div class="col-md-3">
                    <select class="form-control" name="atd_doctor" id="atd_doctor" required="true">
                        <option value="">Select Doctor</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                  	<label class="radio-inline"><input type="radio" name="rptOpt" id="rptOpt" value="1">Only Amount</label>
                    <label class="radio-inline"><input type="radio" name="rptOpt" id="rptOpt" value="2">By Date Range</label>
                  </div>
                  <div class="row">
                  <div class="col-md-12" align="center">
                  	<div class="row">&nbsp;</div>
                    <button type="button" class="btn btn-primary" name="submit" id="idBtnSubmit">Submit</button>
                    <button type="reset" id="reset" class="btn btn-default">Reset</button>
                  </div>
                  </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row" id="amnt">
    <div class="col-md-12 col-sm-6 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
              <div class="col-md-3">
                <label class="label-inline">Doctor Fees : Rs. <span id="amtodoc"></span> /-</label>
              </div>
              <div class="col-md-3">
                <label class="label-inline">SKNH Charges : Rs. <span id="amtonhm"></span> /-</label>
              </div>
              <div class="col-md-3">
                <label class="label-inline">Adv. By Doctor : Rs. <span id="amtadv"></span> /-</label> 
              </div>
              <div class="col-md-3">
                <label class="label-inline">Adv. By SKNH : Rs. <span id="amtadvn"></span> /-</label> 
              </div>
          </div>
          <div class="row">
              <div class="col-md-12 text-center">
                <label class="label-inline"><span id="amtbal"></span></label> 
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="row" id="ntd">
    <div class="col-md-12 col-sm-6 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
          	<div class="col-md-2">
                    <input class="form-control" placeholder="From Date" name="from_date" id="from_date" type="text" required="true">
                  </div>
              <div class="col-md-2">
                    <input class="form-control" placeholder="To Date" name="to_date" id="to_date" type="text" required="true">
                  </div>
          </div>
          <div class="row">
            <div class="col-md-12 text-right">
              <input TYPE="button" onClick="PrintElem('#drPrintTable')" value="Print">
            </div>
          </div>
          <div class="row">&nbsp;</div>
          <div id="drPrintTable">
          <table width="100%" border="1" style="text-align:center !important" id="drTable">
            <tr>
              <th scope="col" colspan="6" style="text-align:center !important"><strong>Nursing Home To Doctor</strong></th>
            </tr>
            <tr>
              <td width="10%"><strong>S/No</strong></td>
              <td width="18%"><strong>Reg. No.</strong></td>
              <td width="18%"><strong>Patient Name</strong></td>
              <td width="18%"><strong>Admition Date</strong></td>
              <td width="18%"><strong>Discharge Date</strong></td>
              <td width="18%"><strong>Payment Amount</strong></td>
            </tr>
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row" id="dtn">
    
    <div class="col-md-12 col-sm-6 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12 text-right">
              <input TYPE="button" onClick="PrintElem('#crPrintTable')" value="Print">
            </div>
          </div>
          <div class="row">&nbsp;</div>
          <div id="crPrintTable">
              <table width="100%" border="1" style="text-align:center !important" id="crTable">
            <tr>
              <th scope="col" colspan="6" style="text-align:center !important"><strong>Doctor To Nursing Home</strong></th>
            </tr>
            <tr>
              <td width="10%"><strong>S/No</strong></td>
              <td width="18%"><strong>Reg. No.</strong></td>
              <td width="18%"><strong>Patient Name</strong></td>
              <td width="18%"><strong>Admition Date</strong></td>
              <td width="18%"><strong>Discharge Date</strong></td>
              <td width="18%"><strong>Payment Amount</strong></td>
            </tr>
          </table>
          </div>
        </div>
      </div>
    </div>
  </div>
    <div class="row" id="advn">
    <div class="col-md-12 col-sm-6 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12 text-right">
              <input TYPE="button" onClick="PrintElem('#advPrintTable')" value="Print">
            </div>
          </div>
          <div class="row">&nbsp;</div>
          <div id="advPrintTable">
          <table width="100%" border="1" style="text-align:center !important" id="advnTable">
            <tr>
              <th scope="col" colspan="4" style="text-align:center !important"><strong>Adv. by Nursing Home</strong></th>
            </tr>
            <tr>
              <td width="10%"><strong>S/No</strong></td>
              <td width="30%"><strong>Payment Date</strong></td>
              <td width="30%"><strong>Payment Amount</strong></td>
            </tr>
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row" id="adv">
    <div class="col-md-12 col-sm-6 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12 text-right">
              <input TYPE="button" onClick="PrintElem('#adv1PrintTable')" value="Print">
            </div>
          </div>
          <div class="row">&nbsp;</div>
          <div id="adv1PrintTable">
          <table width="100%" border="1" style="text-align:center !important" id="advTable">
            <tr>
              <th scope="col" colspan="4" style="text-align:center !important"><strong>Adv. by Doctor</strong></th>
            </tr>
            <tr>
              <td width="10%"><strong>S/No</strong></td>
              <td width="30%"><strong>Payment Date</strong></td>
              <td width="30%"><strong>Remarks</strong></td>
              <td width="30%"><strong>Payment Amount</strong></td>
            </tr>
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>

  <script src="js/jquery-ui.js"></script>
  <script>
  	$(function (event) {
		$.getJSON("action.php?action=get_doctall", function (data) {
			$('#atd_doctor').empty();
            $('#atd_doctor').append(
                    $('<option></option>').val("").html("Select Doctor Name"));
            $.each(data, function (index) {
                $('#atd_doctor').append(
                        $('<option></option>').val(data[index].id).html("Dr. "+data[index].doc_name)
                        );
            });
        });
	});
  	$(document).ready(function(e) {
        $('#ntd,#dtn,#amnt,#adv,#advn').hide();
    });
	$("#idBtnSubmit").click(function(e) {
        var opt = $('#rptOpt:checked').val();
		var amtodoc = "";
		var amtonhm = "";
    var amtadv = "";
		var amtbal = "";
		switch(opt){
			case '1':
				if ($('#atd_doctor').val()) {
					$.getJSON("action.php?action=docamount", {id: $('#atd_doctor').val()}, function (data) {
						 if(data['success']){
							 $('#amnt').show();
							 $.each(data, function (index,val) {
							 	$('#'+index).html(val);
  								if(index == "amtodoc")x = Number(val);
  								if(index == "amtonhm")y = Number(val);
                  if(index == "amtadv")a = Number(val);
                  if(index == "amtadvn")b = Number(val);
							 });
							 p = x - b;
               q = y - a;
               str = "Balance Due For ";
               if(p > q){
                  amtbal = p - q;
                  str = str + " Doctor : Rs "+amtbal+" /-"
               }else{
                  amtbal = p - q;
                  str = str + " SKNH : Rs "+amtbal+" /-"
               }
               $('#amtbal').html(str);
						 }else{
							 $('#amnt').hide();
						 }
					});
				} else {
					alert('Please select Docotor Name.');
				}
				break;
			 case '2':
			 		if ($('#atd_doctor').val()) {
					$.getJSON("action.php?action=docamntrng", {id: $('#atd_doctor').val()}, function (data) {
						 if(data['success']){
							 $('#ntd,#dtn,#amnt,#adv,#advn').show();
							 $.each(data, function (index,val) {
							 	$('#'+index).html(val);
								$('#'+index).val(val);
								if(index == "amtodoc"){
									x = Number(val);
								}
								if(index == "amtonhm"){
									y = Number(val);
								}
                if(index == "amtadv"){
                  a = Number(val);
                }
                if(index == "amtadvn"){
                  b = Number(val);
                }
                if(index == "dr_list"){
                  createTable(val,'drTable');
                }
                if(index == "cr_list"){
                  createTable(val,'crTable');
                }
                if(index == "adv_list"){
                  createAdvTable(val,'advTable');
                }
                if(index == "advn_list"){
                  createAdvTable(val,'advnTable');
                }
							 });
							 
               p = x - b;
               q = y - a;
               str = "Balance Due For ";
               if(p > q){
                  amtbal = p - q;
                  str = str + " Doctor : Rs "+amtbal+" /-"
               }else{
                  amtbal = p - q;
                  str = str + " SKNH : Rs "+amtbal+" /-"
               }

							 $('#amtbal').html(str);
               
						 }else{
							 $('#amnt').hide();
						 }
					});
				} else {
					alert('Please select Docotor Name.');
				}
			 		
			 		break;
			default:
				alert("Please Select any one of the option from the above.");
		}
    });
  </script>
  <script>
    $('#from_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        /*minDate: -1,*/
         maxDate: new Date()
    }).datepicker("setDate", new Date());
	$('#to_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        /*minDate: -1,*/
         maxDate: new Date()
    }).datepicker("setDate", new Date());
</script>
<script type="text/javascript">
  $('#from_date,#to_date').on('change',function(e){
    var startDate = new Date($('#from_date').val());
    var endDate = new Date($('#to_date').val());

    if (startDate < endDate){
        if ($('#atd_doctor').val()) {
          $.getJSON("action.php?action=datechange", {
                        id: $('#atd_doctor').val(),
                        from:$('#from_date').val(),
                        to:$('#to_date').val()
              }, function (data) {
             if(data['success']){
               $('#ntd,#dtn,#amnt,#adv,#advn').show();
               $.each(data, function (index,val) {
                $('#'+index).html(val);
                $('#'+index).val(val);
                if(index == "amtodoc"){
                  x = Number(val);
                }
                if(index == "amtonhm"){
                  y = Number(val);
                }
                if(index == "amtadv"){
                  a = Number(val);
                }
                if(index == "amtadvn"){
                  b = Number(val);
                }
                if(index == "dr_list"){
                  createTable(val,'drTable');
                }
                if(index == "cr_list"){
                  createTable(val,'crTable');
                }
                if(index == "adv_list"){
                  createAdvTable(val,'advTable');
                }
                if(index == "advn_list"){
                  createAdvTable(val,'advnTable');
                }
               });
               p = x - b;
               q = y - a;
               str = "Balance Due For ";
               if(p > q){
                  amtbal = p - q;
                  str = str + " Doctor : Rs "+amtbal+" /-"
               }else{
                  amtbal = p - q;
                  str = str + " SKNH : Rs "+amtbal+" /-"
               }

               $('#amtbal').html(str);
               
             }else{
               $('#amnt').hide();
             }
          });
        } else {
          alert('Please select Docotor Name.');
        }
    }else{
      alert('From date should be smaller than the To Date.');
      $('#to_date').val($.datepicker.formatDate('yy-mm-dd', new Date()));
    }
  });
</script>
<script type="text/javascript">
  function createTable(data,tId){
    var table = $("#"+tId);
    var total = "";
    table.find("tr.tdItem").remove();
    table.find("tr.itemTot").remove();
    $.each(data, function (i, item) {
        var tr = $("<tr class='tdItem'></tr>");
        table.append(tr);

        var td = $("<td>" + item.sno + "</td>");
        tr.append(td);

        var td = $("<td>" + item.reg_no + "</td>");
        tr.append(td);

        var td = $("<td>" + item.pt_name + "</td>");
        tr.append(td);
      
        var td = $("<td>" + item.admit_date + "</td>");
        tr.append(td);

        var td = $("<td>" + item.payment_date + "</td>");
        tr.append(td);
        total = Number(total) + Number(item.amount_paid);
        var td = $("<td>" + item.amount_paid + "</td>");
        tr.append(td);
    });
    var trtotal = $("<tr class='itemTot'></tr>");
    table.append(trtotal);
    var td = $("<td colspan='3' align='right'><strong>Total Amount&nbsp;&nbsp;</strong></td>");
    trtotal.append(td);
    var td = $("<td><strong>Rs. " + total + " /-</strong></td>");
    trtotal.append(td);
  }
</script>
<script type="text/javascript">
  function createAdvTable(data,tId){
    var table = $("#"+tId);
    var total = "";
    table.find("tr.tdItem").remove();
    table.find("tr.itemTot").remove();
    $.each(data, function (i, item) {
        var tr = $("<tr class='tdItem'></tr>");
        table.append(tr);

        var td = $("<td>" + item.sno + "</td>");
        tr.append(td);

        var td = $("<td>" + item.payment_date + "</td>");
        tr.append(td);
        
        var td = $("<td>" + item.remarks + "</td>");
        tr.append(td);
        
        total = Number(total) + Number(item.amount_paid);
        var td = $("<td>" + item.amount_paid + "</td>");
        tr.append(td);
        
        
    });
    var trtotal = $("<tr class='itemTot'></tr>");
    table.append(trtotal);
    var td = $("<td colspan='3' align='right'><strong>Total Amount&nbsp;&nbsp;</strong></td>");
    trtotal.append(td);
    var td = $("<td><strong>Rs. " + total + " /-</strong></td>");
    trtotal.append(td);
  }
</script>

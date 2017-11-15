<?php 
    $allow = array(1,2,3);
    if(!in_array($_SESSION['type'], $allow)){
        echo "<script>alert('You are not allowed to access this page.');</script>";
        echo "<script>window.location = '/index.php?pg=home'</script>";
    }
?>
<link href="css/jquery-ui.css" rel="stylesheet"/>
<style>
.numeric {
    text-align: right;
}
</style>
<style>
table {
/*border-collapse: collapse;*/
}
table, th, td {
    /*border: 1px solid black;*/
    border-collapse: separate;
    border-spacing: 5px;
    margin-top: 10px;
}
</style>
<div class="row" >
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading" >Patient Account Details</div>
      <div class="panel-body">
        <div class="col-md-12">
          <div class="row">
            <?php
                        if (isset($_SESSION['success'])) {
                            if ($_SESSION['success']) {
                                ?>
            <div class="alert bg-success" role="alert" > <span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $_SESSION['msg']; ?> <a href="javascript:void(0)" class="close pull-right"><span class="glyphicon glyphicon-remove"></span></a> </div>
            <?php } else { ?>
            <div class="alert bg-danger" role="alert" > <span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $_SESSION['msg']; ?> <a href="javascript:void(0)" class="close pull-right"><span class="glyphicon glyphicon-remove"></span></a> </div>
            <?php
                }
            }
            ?>
          </div>
          <form class="form-horizontal" id="doct_form" action="action.php?action=pt_acc" method="post" onsubmit="return chkEmpty();">
            <div class="row">
              <div class="col-md-2 text-right">
                <label class="control-label">Patient ID : </label>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <input type="text" class="form-control" id="reg_no" name="reg_no" required/>
                </div>
              </div>
              <div class="col-md-2 text-right">
                <label class="control-label">Account Date : </label>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <input type="text" class="form-control" id="entry_date" name="entry_date" required/>
                </div>
              </div>
            </div>
            <div class="row text-center">
              <div class="col-md-9">
                <label class="control-label" id="pt_admtdt">&nbsp;</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <table id="tbCharge" width="90%" cellspacing="10">
                    <thead>
                      <tr align="center">
                        <td><h4>&nbsp;</h4></td>
                        <td><h4>Org. Charge</h4></td>
                        <td><h4>From Dr.</h4></td>
                        <td><h4>2nd Charge</h4></td>
                        <td><h4>Remarks / Details</h4></td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr id="summaryRow">
                        <td align="right">Total Charge : </td>
                        <td align="center"><span id="total_chrg">Rs. 00/-</span></td>
                        <td>&nbsp;</td>
                        <td align="center"><span id="total_ptnr">Rs. 00/-</span></td>
                      </tr>
                    </tbody>
                  </table>
                  </div>
              </div>
            </div>
            <div class="row">&nbsp;</div>
            <div class="row">
              <div class="col-md-6 text-right">
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
              </div>
              <div class="col-md-6">
                <button type="reset" id="reset" class="btn btn-default">Reset</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.col--> 
  </div>
</div>
<script src="js/jquery-ui.js"></script> 
<script>
    $('#entry_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
    }).datepicker("setDate", new Date());

    $(document).ready(function () {
        $(".bg-success,.bg-danger").delay(5000).fadeOut();
            $.ajax({url: "action.php?action=del_session", success: function (result) {
        }});
    });
    $(function (event) {
        $("#reg_no").autocomplete(
        {
            source: 'action.php?action=reg_no',
        });
    });

    //When DOM loaded we attach click event to button
    $(document).ready(function () {

        //attach keypress to input
        $('.numeric').keydown(function (event) {
            // Allow special chars + arrows 
            if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9
                    || event.keyCode == 27 || event.keyCode == 13
                    || (event.keyCode == 65 && event.ctrlKey === true)
                    || (event.keyCode >= 35 && event.keyCode <= 39)) {
                return;
            } else {
                // If it's not a number stop the keypress
                if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                    event.preventDefault();
                }
            }
        });

    });


  $(document).ready(function(e){
    var chrgArr = ["Doctor Charge","OT Mejor", "OT Minor","OT Ortho","OT C-ARM","Medicine (OT + Ward + Other)","Baby Doctor Charge", "Baby Medicine","Baby Other Charge","Bed Charge","Extra Bed Charge","Private Attendent","Labour Room Charge","Nursing Home Charge","Others Charge"];
    var table = $("#tbCharge");
    var chrgCnt = 1;
    for(var i = 0;i<chrgArr.length;i++){
      var tr = $("<tr></tr>");
      var td=$('<td><input type="checkbox" id="chkCharge_'+chrgCnt+'" onclick="handleClick(this);" value="'+chrgCnt+'">'+
                '<strong>&nbsp;'+chrgArr[i]+'</strong><input type="hidden" id="hdChrgType_'+chrgCnt+'" name="chrg['+chrgCnt+'][chrg_type]" value="'+chrgCnt+'"  disabled></td>');
      tr.append(td);
      var td = $('<td><input type="hidden" id="hdChrgID_'+chrgCnt+'" name="chrg['+chrgCnt+'][id]" value="" disabled><input type="text" id="txtOrg_'+chrgCnt+'" name="chrg['+chrgCnt+'][org_chrg]" placeholder="Enter Charge" size="10" onkeyup="addVal(this)" class="form-control numeric chrgOrg" disabled/></td>');
      tr.append(td);
      var td = $('<td align="center"><input id="chkDr_'+chrgCnt+'" type="checkbox" value="1" name="chrg['+chrgCnt+'][doc]"  disabled ></td>');
      tr.append(td);
      var td = $('<td><input type="text" id="txtPtnr_'+chrgCnt+'" size="10" name="chrg['+chrgCnt+'][chrg_prt]" class="form-control chrg numeric" placeholder="Enter Charge" onkeyup="addValPart()" disabled /></td>');
      tr.append(td);

      if(chrgCnt == 10){
        var td= $('<td><div class="row"><div class="col-md-6"><input type="text" id="txtBedDays" name="chrg['+chrgCnt+'][bedDays]" placeholder="No. Of Days" class="form-control numeric" size="5" onkeyup="calcBed(this)" disabled></div><div class="col-md-6"><input type="text" id="txtBedCheg" name="chrg['+chrgCnt+'][bedChrg]" placeholder="Bed Charge" class="form-control numeric" size="5" disabled></div></div></td>');
        tr.append(td);
      }else if(chrgCnt == 11){
        var td= $('<td><div class="row"><div class="col-md-6"><input type="text" id="txtExtBedDays" name="chrg['+chrgCnt+'][bedExtDays]" placeholder="No. Of Days" class="form-control numeric" size="5" onkeyup="calcBedExt(this)" disabled></div><div class="col-md-6"><input type="text" id="txtBedChegExt" name="chrg['+chrgCnt+'][bedExtChrg]" placeholder="Bed Charge"  class="form-control numeric" size="5" disabled></div></div></td>');
        tr.append(td);
      }else if(chrgCnt == 12){
        var td= $('<td><div class="row"><div class="col-md-4"><input type="text" onkeyup="calcPvtAtd()" id="txtAtdNo" name="chrg['+chrgCnt+'][atdNo]" class="form-control numeric" size="5" placeholder="No." disabled></div><div class="col-md-4"><input type="text" id="txtAtdDays" onkeyup="calcPvtAtd()" name="chrg['+chrgCnt+'][atdDays]" placeholder="Days" class="form-control numeric" size="5" disabled></div><div class="col-md-4"><input type="text" id="txtAtdChrg" name="chrg['+chrgCnt+'][atdChrg]" placeholder="Amount" onkeyup="calcPvtAtd()" class="form-control numeric" size="5" disabled></div></div></td>');
        tr.append(td);
      }else{
        var td = $('<td><input type="text" id="txtRmk_'+chrgCnt+'" class="form-control" name="chrg['+chrgCnt+'][remarks]" placeholder="Enter Remarks / Details"  disabled /></td>');
        tr.append(td);
      }
      table.find("tr:last").before(tr);
      chrgCnt++;
    }
  });

function handleClick(cb) {
    var cleanVar = null;
    $("input[id$='_"+cb.value+"']").each(function (i, el) {
         //It'll be an array of elements
         if ($(this).is('input:text')){
          var id = $(this).attr('id');
          if(id == "txtOrg_"+cb.value){
            cleanVar = !$(this).prop("disabled");
            if(cleanVar){
              modVal($(this));
              modValPrt($("#txtPtnr_"+cb.value));
            }
          }
         }
         if(cleanVar){
            if ($(this).is('input:text')){
              $(this).val('');
            }
            if ($(this).is('input:checkbox')){
              $(this).prop('checked',false);
            }
         }
     });
    $("#hdChrgType_"+cb.value).prop("disabled", !cb.checked);
    $("#hdChrgID_"+cb.value).prop("disabled", !cb.checked);
    $("#txtOrg_"+cb.value).prop("disabled", !cb.checked);
    $("#chkDr_"+cb.value).prop("disabled", !cb.checked);
    $("#txtPtnr_"+cb.value).prop("disabled", !cb.checked);
    if(cb.value == 10){
      $("#txtBedDays").prop("disabled", !cb.checked);
      $("#txtBedCheg").prop("disabled", !cb.checked);
      var isDisabled = !$('#txtBedCheg').prop('disabled');
      if(isDisabled){
        $.getJSON("action.php?action=get_bdcrg", {id: $("#reg_no").val()}, function (dt) {
          $("#txtBedCheg").val(dt['txtBedCheg']);
          $("#txtBedCheg").prop("readonly", true);
        });
      }else{
        $("#txtBedCheg,#txtBedDays").val("");
      }

    }if(cb.value == 11){
      $("#txtExtBedDays").prop("disabled", !cb.checked);
      $("#txtBedChegExt").prop("disabled", !cb.checked);
      var isDisabled = !$('#txtBedChegExt').prop('disabled');
      if(isDisabled){
        $.getJSON("action.php?action=get_bdcrg", {id: $("#reg_no").val()}, function (dt) {
          $("#txtBedChegExt").val(dt['txtBedCheg']);
          $("#txtBedChegExt").prop("readonly", true);
        });
      }else{
        $("#txtExtBedDays,#txtBedChegExt").val("");
      }
    }if(cb.value == 12){
      $("#txtAtdNo").prop("disabled", !cb.checked);
      $("#txtAtdDays").prop("disabled", !cb.checked);
      $("#txtAtdChrg").prop("disabled", !cb.checked);
      var isDisabled = $('#txtOrg_12').prop('disabled');
      if(isDisabled){
         $("#txtAtdNo,#txtAtdDays,#txtAtdChrg").val("");
      }
    }else{
      $("#txtRmk_"+cb.value).prop("disabled", !cb.checked);
    }
}
  
$("#reg_no").blur(function(e){
        var regno = $(e.target).val();
        var chrgVal = null;
        $.getJSON("action.php?action=get_tot", {id: regno}, function (dt) {
            $("#pt_admtdt").empty();
            $("#pt_admtdt").append(dt['pt_admtdt']);
            $("#entry_date").val(dt['entry_date']);
            if(dt.hasOwnProperty('pt_acount')){
              //console.log(dt['pt_acount']);
              $.each(dt['pt_acount'], function(key,value){
                  
                  $.each(value, function(k,val){
                    if(k == 'chrgTp'){
                      chrgVal = val;
                      $('#chkCharge_'+val).prop('disabled',false);
                      $('#chkCharge_'+val).prop('checked',true);
                      $('#hdChrgType_'+val).prop('disabled',false);
                    }else if((k == 'chkDr_'+chrgVal) && (value[k] == 1)){
                      //console.log(k+"=>"+'chkDr_'+chrgVal);
                      $("#"+k).prop('disabled',false);
                      $("#"+k).prop('checked',true);
                    }else{
                        $("#"+k).prop('disabled',false);
                        if(k == 'txtBedCheg'){
                            $("#"+k).prop('readonly',true);
                        }
                        if(k == 'txtBedChegExt'){
                            $("#"+k).prop('readonly',true);
                        }
                        $("#"+k).val(val);
                      /*}*/
                    }
                  });
              });
              addValOrg();
            }
        });
  });
  function calcBed(e){
    var t = Number($(e).val())*Number($('#txtBedCheg').val());
    $("#txtOrg_10").val(t);
    addVal($("#txtOrg_10"));
  }
  function calcBedExt(e){
    var t = Number($(e).val())*Number($('#txtBedChegExt').val());
    $("#txtOrg_11").val(t);
    addVal($("#txtOrg_11"));
  }
  function calcPvtAtd(){
    var t = Number($('#txtAtdChrg').val())*Number($('#txtAtdDays').val())*Number($('#txtAtdNo').val());
    $("#txtOrg_12").val(t);
    addVal($("#txtOrg_12"));
  }
  function addVal(e){
    var totOrg = null;
    var totBaby = null;
    var txtId = null;
    $("input[id*='txtOrg_']").each(function (i, el) {
         if(!$(this).prop('disabled')){
          txtId = $(this).attr('id')
           if((txtId != 'txtOrg_7') && (txtId != 'txtOrg_8') && (txtId != 'txtOrg_9')){
              totOrg = Number(totOrg)+Number($(this).val());
           }else{
              totBaby = Number(totBaby)+Number($(this).val());
           }
         }
     });
    //alert("Total Charg : "+totOrg+" Total Baby Charge : "+totBaby);
    var sd = Number($('#pt_admtdt').text().replace(/[^0-9]/gi, '')); // Replace everything that is not a number with nothing
    if(sd){
      if(totOrg <= sd){
        $('#total_chrg').text('Rs. ' + (Number(totOrg)+Number(totBaby)) + ' /-');
      }else{
        alert("You can't add charges more than the contact amount.\n Contact Amount: Rs."+sd+" /- \n Current Total : Rs. "+totOrg+"/-\n Total Baby Charges : Rs. "+totBaby+" /-");   
        $('#total_chrg').text('Rs. ' + (Number(totOrg)+Number(totBaby) - Number($(e).val())) + ' /-');
        $(e).val("");
      }
    }else{
      $('#total_chrg').text('Rs. ' + (Number(totOrg)+Number(totBaby)) + ' /-');
    }
    
  }
  function modVal(e){
    var sd = Number($('#total_chrg').text().replace(/[^0-9]/gi, ''));
    $('#total_chrg').text('Rs. ' + (Number(sd)-Number($(e).val())) + ' /-');
  }

  function addValOrg(){
    var totOrg = null;
        $("input[id*='txtOrg_']").each(function (i, el) {
         if(!$(this).prop('disabled')){
              totOrg = Number(totOrg)+Number($(this).val());
         }
         $('#total_chrg').text('Rs. ' +totOrg+ ' /-');
     });
    addValPart();
  }
  function addValPart(){
    var totPart = null;
        $("input[id*='txtPtnr_']").each(function (i, el) {
         if(!$(this).prop('disabled')){
              totPart = Number(totPart)+Number($(this).val());
         }
         $('#total_ptnr').text('Rs. ' +totPart+ ' /-');
     });
  }
  function modValPrt(e){
    var sd = Number($('#total_ptnr').text().replace(/[^0-9]/gi, ''));
    $('#total_ptnr').text('Rs. ' + (Number(sd)-Number($(e).val())) + ' /-');
  }
</script>


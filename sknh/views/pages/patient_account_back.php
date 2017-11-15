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
              <div class="col-md-8">
                <label class="control-label" id="pt_admtdt">&nbsp;</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <table id="sampTable" width="80%" cellspacing="10">
                    <thead>
                      <tr align="center">
                        <td><h4>Charge Type</h4></td>
                        <td><h4>Remarks / Details</h4></td>
                        <td><h4>Charge</h4></td>
                        <td><h4>Action</h4></td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr align="center">
                        <td><label>Child Medicine</label><input type="hidden" name="chrg_type[]" value="9"></td>
                        <td><input type="text" id="rem9" name="chrg_remarks[]" class="form-control" onkeyup="addBed(this)"/></td>
                        <td><input type="text" id="chrg9" name="chrg_amount[]" class="form-control chrg numeric" onkeyup="addValue()" /></td>
                      </tr>
                      <tr align="center">
                        <td><label>Baby Doc. Charge</label><input type="hidden" name="chrg_type[]" value="13"></td>
                        <td><input type="text" id="rem13" name="chrg_remarks[]" class="form-control" onkeyup="addBed(this)"/></td>
                        <td><input type="text" id="chrg13" name="chrg_amount[]" class="form-control chrg numeric" onkeyup="addValue()" /></td>
                      </tr>
                      <tr align="center">
                        <td><label>Baby Other Charge</label><input type="hidden" name="chrg_type[]" value="14"></td>
                        <td><input type="text" id="rem14" name="chrg_remarks[]" class="form-control" onkeyup="addBed(this)"/></td>
                        <td><input type="text" id="chrg14" name="chrg_amount[]" class="form-control chrg numeric" onkeyup="addValue()" /></td>
                      </tr>
                      <tr align="center">
                        <td><select onchange="chkVal(this);" name="chrg_type[]" class="form-control">
                            <option value="">Select A Charge</option>
                            <option value="4">Private Attendent</option>
                            <option value="5">OT Mejor</option>
                            <option value="6">OT Minor</option>
                            <option value="7">OT Ortho.</option>
                            <option value="8">OT C-ARM</option>
                            <option value="10">OT Medicine</option>
                            <option value="11">Word Medicine</option>
                            <option value="12">Other Medicine</option>
                            <option value="15">Labour Room Charge</option>
                            <option value="16">Nursing Home Charge</option>
                            <option value="17">Bed Charge</option>
                          </select></td>
                        <td><input type="text" name="chrg_remarks[]" class="form-control" onkeyup="addBed(this)"/></td>
                        <td><input type="text" name="chrg_amount[]" class="form-control chrg numeric" onkeyup="addVal()" /></td>
                        <td></td>
                      </tr>
                      <tr id="summaryRow">
                        <td colspan="2" align="right">Total Charge : </td>
                        <td colspan="1" align="center"><span id="total_chrg">Rs. 00/-</span></td>
                      </tr>
                    </tbody>
                  </table>
                  <br>
                  <input type="button" id="AddBtn" onclick="addTableRow($('#sampTable'));" value="Add More"/>
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
                                        $('#acc_date').datepicker({
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
</script> 
<script>

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

</script> 
<script>
    var rowC = 1;
    function addTableRow(jQtable) {

        jQtable.each(function () {
            var $table = $(this);
            //var $tds = $('<tr id="rowNo'+rowC+'" align="center">');
            var $tds;
            $tds = '<tr id="rowNo' + rowC + '" align="center"><td>\
                <select onchange="chkVal(this);" name="chrg_type[]" class="form-control">\\n\
                    <option value="">Select A Charge</option>\
                    <option value="4">Private Attendent</option>\
                    <option value="5">OT Mejor</option>\
                    <option value="6">OT Minor</option>\
                    <option value="7">OT Ortho.</option>\
                    <option value="8">OT C-ARM</option>\
                    <option value="10">OT Medicine</option>\
                    <option value="11">Word Medicine</option>\
                    <option value="12">Other Medicine</option>\
                    <option value="15">Labour Room Charge</option>\
                    <option value="16">Nursing Home Charge</option>\
                    <option value="17">Bed Charge</option>\
                </select>\
              </td>\
              <td><input type="text" name="chrg_remarks[]" class="form-control" onkeyup="addBed(this)"/></td>\
             <td><input type="text" name="chrg_amount[]" class="form-control numeric chrg" onkeyup="addVal()"/></td>\
             <td> <a href="javascript:void(0);" onclick="removeRow(' + rowC + ');">Delete</a></td></tr>';
            if ($('tbody', this).length > 0) {
                // $('tbody', this).append(tds);
                if (rowC <= 10) {
                    $('tr:last', this).before($tds);
                    rowC++;
                }

            } else {
                $(this).append($tds);
            }
        });
    }
    window.addTableRow = addTableRow;
    function removeRow(removeNum) {
        jQuery('#rowNo' + removeNum).remove();
        addVal();
        rowC--;
    }
    var htmlPrev, htmlNext,bedChrg;
    function chkVal(theID) {
        var opt = $(theID).val();

        var html4 = '<input type="hidden" name="chrg_remarks[]" value="4" />\
                <input type="text" id="atd_no" name="atd_no" placeholder="Atd. No" style="margin-bottom:10px; margin-top:10px;"/><br/>\
                <input type="text" id="atd_days" name="atd_days" placeholder="Atd. Days" style="margin-bottom:10px"/><br/>\
                <input type="text" id="atd_chrg" name="atd_chrg" onkeyup="calcAtd(this)" placeholder="Atd. Charges" style="margin-bottom:10px"/><br/>';
        if (opt == 4) {
            //$(theID).closest("td").siblings().find("input").val('10');
            htmlPrev = $(theID).closest('td').next().html();
            htmlNext = $(theID).closest('td').next().closest('td').next().html();
            $(theID).closest('td').next().html(html4);
        } else if (opt == 17) {
            $.getJSON("action.php?action=get_days", {id: $('#reg_no').val()}, function (data) {
                for (member in data) {
                    if (data[member] !== null){
                        bedChrg = data['bed_chrg'];
                        $(theID).closest('td').next().find("input").closest('td').next().find("input").val(data['bed_chrg']);
                        console.log(bedChrg);
                    }
                }
            });
        } else {
            $(theID).closest('td').next().html(htmlPrev);
            $(theID).closest('td').next().closest('td').next().html(htmlNext)
            htmlPrev = $(theID).closest('td').next().html();
            htmlNext = $(theID).closest('td').next().closest('td').next().html();
        }
    }
    function addBed(theID){
        var opt = $(theID).closest('td').prev().find("select").val();
        if(opt === '17'){
            var cheg = Number(bedChrg) * Number($(theID).val());
            $(theID).closest('td').next().find("input").val(cheg);
        }
    }
    function addVal() {
        var tot = 0;
        var sd = $('#pt_admtdt').text().replace(/[^0-9]/gi, ''); // Replace everything that is not a number with nothing
        var amount = parseInt(sd, 10);
        var crntChrg = null;
        $(".chrg").each(function () {
            crntChrg = Number($(this).val());
            tot = tot + Number($(this).val());
        });
		var chkTOT = tot - (Number($('#chrg9').val())+Number($('#chrg13').val())+Number($('#chrg14').val()));
        if(isNaN(amount)){
            $('#total_chrg').text('Rs. ' + tot + ' /-');
        }else{
            if(chkTOT <= amount){
                $('#total_chrg').text('Rs. ' + tot + ' /-');
            }else{
                alert("You can't add charges more than the contact amount.\n Contact Amount: Rs."+amount+" /- \n Current Total : Rs. "+tot+"/-");   
                tot = Number(tot) - Number(crntChrg);
                $(".chrg:last").val('');
                $('#total_chrg').text('Rs. ' + tot + ' /-');
            }
        }
    }
    function addValue() {
        var tot = 0;
        var sd = $('#pt_admtdt').text().replace(/[^0-9]/gi, ''); // Replace everything that is not a number with nothing
        var amount = parseInt(sd, 10);
        var crntChrg = null;
        $(".chrg").each(function () {
            crntChrg = Number($(this).val());
            tot = tot + Number($(this).val());
        });
        $('#total_chrg').text('Rs. ' + tot + ' /-');
    }
    function calcAtd(thisVal) {
        $(thisVal).closest('td').siblings().find("input").val(Number($('#atd_no').val()) * Number($('#atd_days').val()) * Number($('#atd_chrg').val()));
        addVal();
    }
    $('#reg_no').on('blur', function (e) {
        var jQtable = $('#sampTable');
        var html;
        var i, regno;
        regno = $('#reg_no').val();
        var atd = ["Attending Doctor", "Attending Nurse", "Attending Anaesthetists"];
        $.getJSON("action.php?action=get_tot", {id: regno}, function (dt) {
            $("#pt_admtdt").empty();
            $("#pt_admtdt").append(dt['pt_admtdt']);
        });
        $.getJSON("action.php?action=get_ptd", {id: regno}, function (data) {
            if (data['pt_details'][0]['chrg_type'] == "") {
                for (var i = 0; i < 1; i++) {
                    html += '<tr align="center">\n\
                    <td>' + atd[i] + '<input type="hidden" name="chrg_type[]" value="' + (i + 1) + '"/></td>\n\
                    <td><input type="text" name="chrg_remarks[]" onkeyup="addBed(this)" class="form-control" value="' + data['pt_details'][i]['chrg_remarks'] + '" required/></td>\n\
                    <td><input type="text" name="chrg_amount[]" class="form-control numeric chrg" onkeyup="addVal()"/></td>\
                    <td>&nbsp;</td></tr>';
                }
            } else {
                for (i = 0; i < 1; i++) {
                    html += '<tr align="center"><input type="hidden" name="id[]" value="' + data['pt_details'][i]['id'] + '"/>\n\
                    <td>' + atd[i] + '<input type="hidden" name="chrg_type[]" value="' + (i + 1) + '"/></td>\n\
                    <td><input type="text" name="chrg_remarks[]" onkeyup="addBed(this)" class="form-control" value="' + data['pt_details'][i]['chrg_remarks'] + '" required/></td>\n\
                    <td><input type="text" name="chrg_amount[]" class="form-control numeric chrg" onkeyup="addVal()" value="' + data['pt_details'][i]['chrg_amount'] + '"/></td>\
                    <td>&nbsp;</td></tr>';
                }
                for (n = i; n < data['pt_details'].length; n++) {
                    if (data['pt_details'][n]['chrg_type'] === '4') {
                        html += '<tr align="center"><input type="hidden" name="id[]" value="' + data['pt_details'][n]['id'] + '"/>';

                        html += '<td><select onchange="chkVal(this);" name="chrg_type[]" class="form-control">\\n\
                                        <option value="">Select A Charge</option>\
                                        <option value="4" selected>Private Attendent</option>\
                                        <option value="5">OT Mejor</option>\
                                        <option value="6">OT Minor</option>\
                                        <option value="7">OT Ortho.</option>\
                                        <option value="8">OT C-ARM</option>\
                                        <option value="10">OT Medicine</option>\
                                        <option value="11">Word Medicine</option>\
                                        <option value="12">Other Medicine</option>\
                                        <option value="15">Labour Room Charge</option>\
                                        <option value="16">Nursing Home Charge</option>\
                                        <option value="17">Bed Charge</option>\
                                    </select></td>';
                        html += '<td><input type="hidden" name="chrg_remarks[]" onkeyup="addBed(this)" value="4" />\n\
                                    <input type="text" id="atd_no" name="atd_no" placeholder="Atd. No" value="' + data['pt_details'][n]['atd_no'] + '" style="margin-bottom:10px; margin-top:10px;"/><br/>\
                                    <input type="text" id="atd_days" name="atd_days" placeholder="Atd. Days" value="' + data['pt_details'][n]['atd_days'] + '" style="margin-bottom:10px"/><br/>\
                                    <input type="text" id="atd_chrg" name="atd_chrg" onkeyup="calcAtd(this)" value="' + data['pt_details'][n]['atd_chrg'] + '" placeholder="Atd. Charges" style="margin-bottom:10px"/><br/></td>\n\
                                <td><input type="text" name="chrg_amount[]" class="form-control numeric chrg" onkeyup="addVal()" value="' + data['pt_details'][n]['chrg_amount'] + '"/></td>\
                                <td>&nbsp;</td></tr>';
                    } else if(data['pt_details'][n]['chrg_type'] != "9" 
                            && data['pt_details'][n]['chrg_type'] != "13"
                            && data['pt_details'][n]['chrg_type'] != "14"){
                        html += '<tr align="center"><input type="hidden" name="id[]" value="' + data['pt_details'][n]['id'] + '"/>';

                        html += '<td><select onchange="chkVal(this);" name="chrg_type[]" class="form-control">\n\
                                        <option value="">Select A Charge</option>\
                                        <option value="4">Private Attendent</option>\
                                        <option value="5" ' + ((data['pt_details'][n]['chrg_type'] === '5') ? 'selected' : '') + '>OT Mejor</option>\
                                        <option value="6" ' + ((data['pt_details'][n]['chrg_type'] === '6') ? 'selected' : '') + '>OT Minor</option>\
                                        <option value="7" ' + ((data['pt_details'][n]['chrg_type'] === '7') ? 'selected' : '') + '>OT Ortho.</option>\
                                        <option value="8" ' + ((data['pt_details'][n]['chrg_type'] === '8') ? 'selected' : '') + '>OT C-ARM</option>\
                                        <option value="10" ' + ((data['pt_details'][n]['chrg_type'] === '10') ? 'selected' : '') + '>OT Medicine</option>\
                                        <option value="11" ' + ((data['pt_details'][n]['chrg_type'] === '11') ? 'selected' : '') + '>Word Medicine</option>\
                                        <option value="12" ' + ((data['pt_details'][n]['chrg_type'] === '12') ? 'selected' : '') + '>Other Medicine</option>\
                                        <option value="15" ' + ((data['pt_details'][n]['chrg_type'] === '15') ? 'selected' : '') + '>Labour Room Charge</option>\
                                        <option value="16" ' + ((data['pt_details'][n]['chrg_type'] === '16') ? 'selected' : '') + '>Nursing Home Charge</option>\
                                        <option value="17" ' + ((data['pt_details'][n]['chrg_type'] === '17') ? 'selected' : '') + '>Bed Charge</option>\
                                    </select></td>';

                        html += '<td><input type="text" name="chrg_remarks[]" onkeyup="addBed(this)" class="form-control" value="' + data['pt_details'][n]['chrg_remarks'] + '" required/></td>\n\
                                <td><input type="text" name="chrg_amount[]" class="form-control numeric chrg" onkeyup="addVal()" value="' + data['pt_details'][n]['chrg_amount'] + '"/></td>\
                                <td>&nbsp;</td></tr>';
                    }else{
                        if(data['pt_details'][n]['chrg_type'] == "9"){
                            $('#rem9').val(data['pt_details'][n]['chrg_remarks']);
                            $('#chrg9').val(data['pt_details'][n]['chrg_amount']);
                        }
                        if(data['pt_details'][n]['chrg_type'] == "13"){
                            $('#rem13').val(data['pt_details'][n]['chrg_remarks']);
                            $('#chrg13').val(data['pt_details'][n]['chrg_amount']);
                        }
                        if(data['pt_details'][n]['chrg_type'] == "14"){
                            $('#rem14').val(data['pt_details'][n]['chrg_remarks']);
                            $('#chrg14').val(data['pt_details'][n]['chrg_amount']);
                        }
                        addValue();
                    }

                }
            }
            jQtable.each(function () {

                $('tr:first', this).after(html);
            });
            addVal();
        });

    });
</script>
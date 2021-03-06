<?php 
	$allow = array(1,2);
	if(!in_array($_SESSION['type'], $allow)){
		echo "<script>alert('You are not allowed to access this page.');</script>";
		echo "<script>window.location = '/index.php?pg=home'</script>";
	}
?>
<link href="css/jquery-ui.css" rel="stylesheet"/>
<div class="row" >
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" >Birth Certificate Details</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="row">
                        <?php
                        if (isset($_SESSION['success'])) {
                            if ($_SESSION['success']) {
                                if (isset($_SESSION['reg_no'])) {
                                    echo "<script type=\"text/javascript\">
        window.open('reports/birth_certificate.php?reg_no=" . $_SESSION['reg_no'] . "', '_blank')
                                </script>";
                                }
                                ?>
                                <div class="alert bg-success" role="alert" >
                                    <span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $_SESSION['msg']; ?>
                                    <a href="javascript:void(0)" class="close pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                                </div>
                            <?php } else { ?>
                                <div class="alert bg-danger" role="alert" >
                                    <span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $_SESSION['msg']; ?> 
                                    <a href="javascript:void(0)" class="close pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <form class="form-horizontal" id="baby_doct_form" action="action.php?action=add_baby" method="post">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <input type="hidden" id="bb_id" name="bb_id" value=""/>
                                    <label for="doc_reg" class="col-xs-4 control-label">Baby S/No : </label>
                                    <div class="col-xs-5">
                                        <input type="text" class="form-control" id="baby_id" name="baby_id"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="doc_reg" class="col-xs-4 control-label">Patient ID</label>
                                    <div class="col-xs-5">
                                        <input type="text" class="form-control" id="patient_reg_no" name="patient_reg_no"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row"><hr></div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="doc_name" class="col-xs-4 control-label">1. Date Of Birth : </label>
                                    <div class="col-xs-7">
                                        <input type="text" class="form-control" id="baby_dob" name="baby_dob" placeholder="(Day,Month &AMP; Year to be written.)" />
                                        <div class="row">
                                            <div class="col-md-3">
                                                <select name="hr" id="hr" class="time">
                                                    <?php for ($i = 0; $i <= 12; $i++) { ?>
                                                        <option value="<?php echo sprintf("%'.02d\n", $i); ?>"><?php echo sprintf("%'.02d\n", $i); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="min" id="min" class="time">
                                                    <?php for ($i = 0; $i < 60; $i++) { ?>
                                                        <option value="<?php echo sprintf("%'.02d\n", $i); ?>"><?php echo sprintf("%'.02d\n", $i); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="sec" id="sec" class="time">
                                                    <?php for ($i = 0; $i < 60; $i++) { ?>
                                                        <option value="<?php echo sprintf("%'.02d\n", $i); ?>"><?php echo sprintf("%'.02d\n", $i); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="merd" id="merd" class="time">
                                                    <option value="AM">AM</option>
                                                    <option value="PM">PM</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="doj" class="col-xs-5 control-label">2. Sex</label>
                                    <div class="col-xs-6">
                                        <div class="col-xs-5">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="baby_sex" id="baby_sexM" value="M" >Male
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xs-5">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="baby_sex" id="baby_sexF" value="F" >Female
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">3. Name of The Child</label>
                                    <div class="col-xs-7">
                                        <input type="text" class="form-control" name="baby_name" id="baby_name" placeholder="(If not named, keep the column blank.)"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="doc_name" class="col-xs-4 control-label">4. Father's Full Name</label>
                                    <div class="col-xs-7">
                                        <input type="text" class="form-control" id="baby_father_name" name="baby_father_name" />
                                    </div>
                                    <div class="col-xs-1 text-center">
                                        <a href="javascript:void(null)" class="aadhar_link" data-aadhar-type="father">
                                        <img 
                                            src="images/Aadhaar_Logo.svg" 
                                            alt="Link aadhaar"
                                            height="30px"
                                            width="30px" 
                                            title="Add aadhaar number of father"
                                            data-toggle="modal" data-target="#myModal"
                                        />
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="doj" class="col-xs-4 control-label">5. Mother's Full Name</label>
                                    <div class="col-xs-7">
                                        <input type="text" class="form-control" id="baby_mother_name" name="baby_mother_name" />
                                    </div>
                                    <div class="col-xs-1 text-center">
                                        <a href="javascript:void(null)" class="aadhar_link" data-aadhar-type="mother">
                                        <img 
                                            src="images/Aadhaar_Logo.svg" 
                                            alt="Link aadhaar"
                                            height="30px"
                                            width="30px" 
                                            title="Add aadhaar number of mother"
                                            data-toggle="modal" data-target="#myModal"
                                        />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="display:none;" id="div_adhar">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">AADHAAR No</label>
                                    <div class="col-xs-7">
                                        <label class="control-label" id="father_adhar"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">AADHAAR No</label>
                                    <div class="col-xs-7">
                                        <label class="control-label" id="mother_adhar"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="dor" class="col-xs-5 control-label">
                                        6. Address of The Parents at The Time of birth</label>
                                    <div class="col-xs-6">
                                        <textarea class="form-control" rows="3" style="resize: none" id="baby_pr_address" name="baby_pr_address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">7. Permanent Address of The Parents</label>
                                    <div class="col-xs-7">
                                        <textarea class="form-control" rows="3" style="resize: none" id="baby_pm_address" name="baby_pm_address"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">8. Place Of Birth : </label>
                                    <div class="col-xs-7">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="baby_pob" id="baby_pob1" value="1" >Hospital&nbsp;&nbsp;
                                            </label>
                                            <label>
                                                <input type="radio" name="baby_pob" id="baby_pob2" value="2" >Institution&nbsp;&nbsp;
                                            </label>
                                            <label>
                                                <input type="radio" name="baby_pob" id="baby_pob3" value="3" >House&nbsp;&nbsp;
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="col-xs-12 form-group">
                                    <label for="dor" class="col-xs-4 control-label">
                                        Address of Place of Birth</label>
                                    <div class="col-xs-8">
                                        <textarea class="form-control" rows="3" style="resize: none" id="baby_pob_address" name="baby_pob_address" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="col-xs-12 form-group">
                                    <label for="dor" class="control-label">
                                        10. Town or Village of Residence of the Mother</label>
                                        (Place where the mother usually lives. This can be different from the place where the delivery occurred.The House address is not to be entered.)
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="doj" class="col-xs-5 control-label">a) Name of Town/Village:</label>
                                    <div class="col-xs-7">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="baby_place_name" name="baby_place_name"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="doj" class="col-xs-5 control-label">b) Is it a Town or Village?</label>
                                    <div class="col-xs-6">
                                        <div class="col-xs-5">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="baby_res_place" id="baby_res_place1" value="T" >Town
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xs-5">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="baby_res_place" id="baby_res_place2" value="V" >Village
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="doj" class="col-xs-5 control-label">c) Name of District</label>
                                    <div class="col-xs-7">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="baby_dist_name" name="baby_dist_name"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="doj" class="col-xs-5 control-label">d) Name of the State</label>
                                    <div class="col-xs-7">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="baby_state_name" name="baby_state_name"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">11. Religion of The Family : </label>
                            </div>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="baby_religion" id="baby_religion1" value="1" >Hindu
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="baby_religion" id="baby_religion2" value="2" >Muslim
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="baby_religion" id="baby_religion3" value="3" >Christian
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="baby_other_rel" name="baby_onter_rel" class="form-control" placeholder="Other Religion"/>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="control-label">12. Father's Level Of Education : </label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id='baby_gurd_quali' name="baby_gurd_quali" />
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">13. Mother's Level Of Education : </label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id='baby_patient_quali' name="baby_patient_quali" />
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="control-label">14. Father's occupation : </label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id='baby_gurd_ocu' name="baby_gurd_ocu" />
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">15. Mother's occupation : </label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id='baby_patient_ocu' name="baby_patient_ocu" />
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="control-label">16. Age of the mother (in completed years) at the time of marriage : </label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id='baby_m_age' name="baby_m_age" />
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">17. Age of the mother (in completed years) at the time of this birth : </label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id='baby_age' name="baby_age" />
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-md-5" >
                        <label>18. Number of children born alive to the mother so far including this child :</label>
                    </div>
                    <div class="col-md-5">
                        <input type="text" id='baby_child_no' name="baby_child_no" />
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-md-5" >
                        <label>19. Type of attention at delivery :</label>
                    </div>
                    <div class="col-md-5">
                        <div class="radio">
                            <label>
                                <input type="radio" name="baby_atn_delivery" id="baby_atn_delivery1" value="1" >1. Institutional - Government
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="baby_atn_delivery" id="baby_atn_delivery2" value="2" >2. Institutional - Private or Non-Government
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="baby_atn_delivery" id="baby_atn_delivery3" value="3" >3. Doctor, Nurse or Trained Midwife
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="baby_atn_delivery" id="baby_atn_delivery4" value="4" >4. Traditional Birth Attendant
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="baby_atn_delivery" id="baby_atn_delivery5" value="5" >5. Relatives or Other
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-md-5" >
                        <label>20. Method of delivery :</label>
                    </div>
                    <div class="col-md-5">
                        <div class="radio">
                            <label>
                                <input type="radio" name="baby_method_delivery" id="baby_method_delivery1" value="1" >1. Normal
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="baby_method_delivery" id="baby_method_delivery2" value="2" >2. Caesarean
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="baby_method_delivery" id="baby_method_delivery3" value="3" >3. Forceps / Vacuum
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-md-3" >
                        <label class="control-label">21. Birth Weight(in kgs) (if available): </label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id='baby_weight' name="baby_weight" class="form-control"/>
                    </div>
                    <div class="col-md-3" >
                        <label class="control-label">22. Duration of Pregnancy(in weeks): </label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id='baby_preg_dur' name="baby_preg_dur" class="form-control"/>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row" style="display: none;" id="rm_row">
                    <div class="form-group">
                        <div class="col-md-3" >

                            <label class="control-label  text-right">Remarks : </label>

                        </div>
                        <div class="col-md-9">
                            <input type="text" id='baby_remarks' name="baby_remarks" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row"><hr></div>
                <div class="row">
                    <div class="col-md-6 text-right">
                        <button type="submit" class="btn btn-primary" name="baby_submit">Submit</button>
                    </div>
                    <div class="col-md-6">
                        <button type="reset" id="baby_reset" class="btn btn-default">Reset</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.col-->
</div></div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="col-xs-12 text-center">
            <img 
                    src="images/Aadhaar_Logo.svg" 
                    alt="Link aadhar"
                    height="80px"
                    width="100px" 
                    title="AADHAAR Details"
                />
          </div>
          <div class="col-xs-12 text-center">
            <h4 class="modal-title text-center">Put <span id="adhar-span"></span> AADHAAR Number</h4>    
          </div>
        </div>
        <div class="modal-body">
          <div class="row">
                <div style="display: table;margin: 0 auto;">
                 <input type="text" id="aadhaar_no" class='form-control text-center'>
                </div>
                <div style="display: table;margin: 0 auto; padding:5px;">
                 <input type="button" id="btn-add-adhar" value="ADD" class="btn btn-primary">
                </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<style>
    * {
        .border-radius: 0 !important;
    }

    #field {
        margin-bottom:20px;
    }
</style>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.maskedinput.min.js"></script>
<script>
    $('#reset').on('click', function () {
        $(this).closest('form').find('input[type=text], textarea').val('');
    });
    $(document).ready(function () {
        //$('.bg-success,.bg-danger').hide();
        $('#aadhaar_no').mask('9999-9999-9999');
        $.getJSON("action.php?action=get_dpt", function (data) {
            $('#dept_id').append(
                    $('<option></option>').val("").html("Select Department"));
            $.each(data, function (index) {
                $('#dept_id').append(
                        $('<option></option>').val(data[index].id).html(data[index].dept_name));
            });
        });
        $(".bg-success,.bg-danger").delay(5000).fadeOut();
        $.ajax({url: "action.php?action=del_session", success: function (result) {
            }});
    });
    $('.close').on("click", function () {
        $(this).closest("div").fadeOut();
    });
    $('#doj').datepicker({});
    $('#dor').datepicker({});
</script>
<script>
    $(document).ready(function () {
        getReg();
    });

    function getReg() {
        $.ajax({url: "action.php?action=baby_id_no", success: function (result) {
                $("#baby_id").val($.trim(result));
            }});
    }
    $(function (event) {
        $("#patient_reg_no").autocomplete({
            source: 'action.php?action=reg_no'
        });
    });
    $('#baby_dob').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
    }).datepicker("setDate", new Date());
    $(function (event) {
        $("#baby_id").autocomplete({
            source: 'action.php?action=baby_id'
        });
    });
    $('#baby_id').on('blur', function () {
        $('#div_adhar').show();
        $.getJSON("action.php?action=get_baby&baby_id=" + $('#baby_id').val(), function (data) {
            $.each(data, function (i, value) {
                if (i === 'baby_sex') {
                    $('#' + i + value).val(value).attr('checked', 'checked');
                } else if (i === 'baby_pob') {
                    $('#' + i + value).val(value).attr('checked', 'checked');
                    if(value == 3){
                        $("#baby_pob_address").prop("disabled",false);
                    }
                } else if (i === 'hr') {
                    document.getElementById("hr").selectedIndex = value;
                } else if (i === 'min') {
                    document.getElementById("min").selectedIndex = value;
                } else if (i === 'sec') {
                    document.getElementById("sec").selectedIndex = value;
                } else if (i === 'merd') {
                    $('#merd').val(value);
                    //document.getElementById("merd").selectedIndex = $.trim(value);
                } else if (i === 'baby_religion') {
                    $('#' + i + value).val(value).attr('checked', 'checked');
                } else if (i === 'baby_res_place') {
                    if(value == 1){
                        $('#' + i + "2").val("V").attr('checked', 'checked');
                    }else if(value == 2){
                        $('#' + i + "1").val("T").attr('checked', 'checked');
                    }else{
                        if(value == "T"){
                            $('#' + i + "1").val(value).attr('checked', 'checked');
                        }else if(value == "V"){
                            $('#' + i + "2").val(value).attr('checked', 'checked');
                        }
                    }
                } else if (i === 'baby_atn_delivery') {
                    $('#' + i + value).val(value).attr('checked', 'checked');
                } else if (i === 'baby_method_delivery') {
                    $('#' + i + value).val(value).attr('checked', 'checked');
                } else if(i == 'baby_father_aadhar'){
                    $("#father_adhar").html(value);
                    $('<input>').attr({
                        type: 'hidden',
                        name: i,
                        value: value
                    }).insertAfter("#father_adhar");
                }else if(i == 'baby_mother_aadhar'){
                    $("#mother_adhar").html(value);
                    $('<input>').attr({
                        type: 'hidden',
                        name: i,
                        value: value
                    }).insertAfter("#mother_adhar");
                }
                else {
                    $('#' + i).val(value);
                }
                $('#rm_row').show();
            });
            //$("#emp_form").attr('action', 'action.php?action=emp_update');
        });
    });
    $('#patient_reg_no').on('blur', function () {
        $.getJSON("action.php?action=get_parent&patient_reg_no=" + $('#patient_reg_no').val(), function (data) {
            $.each(data, function (i, value) {
                if (i === 'baby_religion') {
                    switch (value) {
                        case 'Hindu':
                            $('#baby_religion1').attr('checked', 'checked');
                            break;
                        case 'Muslim':
                            $('#baby_religion2').attr('checked', 'checked');
                            break;
                        case 'Christian':
                            $('#baby_religion3').attr('checked', 'checked');
                            break;
                        default:
                            $('#baby_other_rel').val(value);
                            break;
                    }

                } else {
                    $('#' + i).val(value);
                }

            });
        });
    });

    $("input[name=baby_pob]").on('change',function(){
        if($(this).val()==3){
            $("#baby_pob_address").prop("disabled",false).focus();
        }else{
            $("#baby_pob_address").prop("disabled",true).val('');
        }
    });

    $('.aadhar_link').on('click',function(){
        $('#aadhaar_no').val('');
        $('#adhar-span').html(ucword($(this).data('aadhar-type')+"'s"));
        if($('#ahar_type').length == 0){
            $('<input>').attr({
                type: 'hidden',
                id: 'ahar_type',
                name: 'ahar_type',
                value: $(this).data('aadhar-type')
            }).insertAfter('#aadhaar_no');
        }else{
            $('#ahar_type').val($(this).data('aadhar-type'));
        }
    });

    $('#btn-add-adhar').on('click',function(){
        var intRegex = /^\d{4}-\d{4}-\d{4}$/g;
        if($('#aadhaar_no').val().trim().match(intRegex)){
            $('#div_adhar').show();
            if($('input[name=baby_'+$('#ahar_type').val().trim()+'_aadhar]').length == 0){
                $('<input>').attr({
                    type: 'hidden',
                    name: 'baby_'+$('#ahar_type').val().trim()+'_aadhar',
                    value: $('#aadhaar_no').val().trim()
                }).appendTo('#baby_doct_form');
            }else{
                $('input[name=baby_'+$('#ahar_type').val().trim()+'_aadhar]').val($('#aadhaar_no').val().trim());
            }
            $('#'+$('#ahar_type').val().trim()+'_adhar').html($('#aadhaar_no').val().trim());
            $('#myModal').modal('hide');
        }else{
            console.log("In-Valid");
        }
    });
    function ucword(str){
        str = str.toLowerCase().replace(/(^([a-zA-Z\p{M}]))|([ -][a-zA-Z\p{M}])/g, function(replace_latter) { 
            return replace_latter.toUpperCase();
        });  //Can use also /\b[a-z]/g
        return str;  //First letter capital in each word
    }

</script>
<style>
    .time{margin-top: 10px;width: 50px;height: 34px;}
</style>

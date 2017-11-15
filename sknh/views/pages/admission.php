<?php 
	$allow = array(1,2,3);
	if(!in_array($_SESSION['type'], $allow)){
		echo "<script>alert('You are not allowed to access this page.');</script>";
		echo "<script>window.location = '/index.php?pg=home'</script>";
	}
?>
<link href="css/jquery-ui.css" rel="stylesheet"/>
<div class="row" >
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" >Admit New Patient</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="row">
                        <?php
                        if (isset($_SESSION['success'])) {
                            if ($_SESSION['success']) {
                                if (isset($_SESSION['reg_no'])) {
                                    echo "<script type=\"text/javascript\">
        window.open('reports/admission_form.php?reg_no=" . $_SESSION['reg_no'] . "', '_blank')
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
                    <form action="action.php?action=adm_reg" method="post" id="admin_form">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group">
                                    <label>Registration Number</label>
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" id="regno" name="regno">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="reg_no" name="reg_no" readonly="readonly"/>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" id="srch_reg">Search</button>
                                        </span>
                                    </div>
                                </div></div>
                            <div class="col-md-3"><div class="form-group" id="admission-date">
                                    <label>Admission Date</label>
                                    <input class="form-control" type="text" id="admit_date" name="admit_date" required="required">
                                </div></div>
                            <div class="col-md-4"><div class="form-group">
                                    <label>Admission Time</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control" name="hr" id="hr">
                                                <?php
                                                for ($i = 1; $i <= 12; $i++) {
                                                    if ($i < 10) {
                                                        $i = "0$i";
                                                    }
                                                    ?>
                                                    <option value="<?php echo $i; ?>" <?php echo ($i == date("h")) ? "selected='selected'" : ""; ?> ><?php echo $i; ?></option>
<?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control" name="min" id="min">
                                                <?php
                                                $min = "";
                                                $cmin = date("i");
                                                for ($i = 0; $i <= 59; $i++) {
                                                    if ($i < 10) {
                                                        $i = "0$i";
                                                    }
                                                    ?>
                                                    <option value="<?php echo $i; ?>" <?php echo ($i == $cmin) ? "selected='selected'" : ""; ?> ><?php echo $i; ?></option>
<?php } ?>
                                            </select></div>
                                        <div class="col-md-4">
                                            <select class="form-control" name="meridian" id="meridian">
                                                <option value="AM" <?php echo (date("A") == "AM") ? "selected='selected'" : ""; ?>>AM</option>
                                                <option value="PM" <?php echo (date("A") == "PM") ? "selected='selected'" : ""; ?>>PM</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Contact No 1</label>
                                    <input type="text" class="form-control contacts" name="contact_no_1" id="contact_no_1"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Contact No 2</label>
                                    <input type="text" class="form-control contacts" name="contact_no_2" id="contact_no_2"/>
                                </div>
                            </div>
                            <div class="col-md-5"><div class="form-group">
                                    <div class="col-sm-6">
                                        <label>Bed Type</label>
                                        <select class="form-control" name="bed_type" id="bed_type" required>
                                        </select>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <span id="tbed">Total Beds :&nbsp;<span id="tot"></span></span>&nbsp;
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <label>Bed Number</label>
                                    <select class="form-control" name="bed_no" id="bed_no" required>
                                    </select>
                                    <div class="row">
                                        <div class="col-md-12 text-center" >
                                            <span id="avlbed">Available Beds :&nbsp;<span id="avl"></span></span>&nbsp;
                                        </div>
                                    </div>
                                    </div></div></div>
                            <div class="col-md-3"><div class="form-group">

                                    <label>Bed Charge</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="bed_chrg" id="bed_chrg" readonly="readonly"/>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="doc_ref" id="doc_ref">
                                                <option value="1">NH</option>
                                                <option value="2">By Dr.</option>
                                            </select>
                                        </div>
                                    </div>
                                </div></div>
                            <div class="col-md-2"><div class="form-group">
                                    <label>Total Contact Charge</label>
                                    <input class="form-control" type="text" name="tot_charge" id="tot_charge"/>
                                </div></div>

                        </div>
                        <div class="row"><hr /></div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Patient : First Name</label>
                                    <input class="form-control" type="text" name="first_name" id="first_name"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input class="form-control" type="text" name="middle_name" id="middle_name"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" type="text" name="last_name" id="last_name"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Sex</label>
                                    <div class="row">
                                        <div class="col-md-4"><div class="radio">
                                                <label>
                                                    <input type="radio" name="sex" id="sexM" value="M" >Male
                                                </label>
                                            </div></div>
                                        <div class="col-md-4"><div class="radio">
                                                <label>
                                                    <input type="radio" name="sex" id="sexF" value="F" >Female
                                                </label>
                                            </div></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Age (Years)</label>
                                    <div class="row">
                                        <div class="col-md-6"><input class="form-control" type="text" id="age" name="age"/></div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Marrige Age (Years)</label>
                                    <div class="row">
                                        <div class="col-md-6"><input class="form-control" type="text" id="m_age" name="m_age"/></div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Blood Group</label>
                                    <select class="form-control" name="blood_group"id="blood_group">
                                        <option value="">Blood Group</option>
                                        <option value="A+(pos)">A+(pos)</option>
                                        <option value="A-(ne)">A-(ne)</option>
                                        <option value="B+(pos)">B+(pos)</option>
                                        <option value="B-(ne)">B-(ne)</option>
                                        <option value="AB+(pos)">AB+(pos)</option>
                                        <option value="AB-(ne)">AB-(ne)</option>
                                        <option value="O+(pos)">O+(pos)</option>
                                        <option value="O-(ne)">O-(ne)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Religion</label>
                                    <input class="form-control" type="text" id="religion" name="religion"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Patient Qualification</label>
                                    <input class="form-control" type="text" id="patient_quali" name="patient_quali"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Patient Ocupation</label>
                                    <input class="form-control" type="text" id="patient_ocu" name="patient_ocu"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Relationship</label>
                                    <select class="form-control" name="relation" id="relation">
                                        <option value="">Relationship</option>
                                        <option value="C/o">C/o</option>
                                        <option value="S/o">S/o</option>
                                        <option value="D/o">D/o</option>
                                        <option value="W/o">W/o</option>
                                    </select>
                                </div>
                            </div>
                           


                        </div>
                        <div class="row">
                         <div class="col-md-4">
                                <div class="form-group">
                                    <label>Parent/Guardian</label>
                                    <input class="form-control" type="text" name="gurd_name" id="gurd_name"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Guardian/Parent Qualification</label>
                                <input class="form-control" type="text" id="gurd_quali" name="gurd_quali"/>
                            </div>
                            <div class="col-md-4">
                                <label>Guardian/Parent Ocupation</label>
                                <input class="form-control" type="text" id="gurd_ocu" name="gurd_ocu"/>
                            </div>
                            <!--<div class="col-md-4">
                                <label>Guardian/Parent Contact No</label>
                                <input class="form-control contacts" type="text" name="gud_contact_no" id="gud_contact_no"/>
                            </div>-->
                        </div>
                        <div class="row"><hr /></div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Village / Address</label>
                                <input class="form-control" type="text" name="address" id="address"/>
                            </div>
                            <div class="col-md-4">
                                <label>PO</label>
                                <input class="form-control po" type="text" id="po" name="po"/>
                                <div id="po_result"></div>
                            </div>

                            <div class="col-md-4">
                                <label>P.S</label>
                                <input type="text" class="form-control ps" id="ps" name="ps"/>
                                <div id="ps_result"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label>District</label>
                                <input class="form-control dist" type="text" id="dist" name="dist"/>
                                <div id="dist_result"></div>
                            </div>
                            <div class="col-md-4">
                                <label>State</label>
                                <input class="form-control" type="text" id="state" name="state"/>
                            </div>
                        </div>
                        <div class="row"><hr /></div>
                        <div class="row">
                            <div class="col-md-6">
                                <label >Attending Doctor</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="form-control" name="dept_name" id="dept_name" required="true">
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" name="atd_doctor" id="atd_doctor" required="true">
                                            <option value="">Select Doctor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Attending Nurse</label>
                                <select class="form-control" name="atd_nurse" id="atd_nurse" required="true">
                                    <option value="">Select Atd. Nurse</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Provessional Diagnosis</label>
                                <select class="form-control" name="prov_diog" id="prov_diog" required="true">

                                </select>
                            </div>
                        </div>
                        <div class="row"><hr /></div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Anesthetist</label>
                                <select class="form-control" name="atd_anasth" id="atd_anasth">
                                    <option value="">Select Anesthetist</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Assistant</label>
                                <input class="form-control" type="text" id="atd_assist" name="atd_assist"/>
                            </div>
                            <div class="col-md-4">
                                <label>Treatment / Operation</label>
                                <input class="form-control" type="text" id="treatment" name="treatment"/>
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        <button type="reset" id="reset" class="btn btn-default">Reset</button>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.col-->
</div>
<script src="js/jquery-ui.js"></script>
<script>
    $('#reset').on('click', function () {
        $(this).closest('form').find('input[type=text], textarea').val('');
        getReg();
        $("#tbed,#avlbed").hide();
    });
    $(document).ready(function () {
        $("#tbed,#avlbed").hide();
    });
    $(function (event) {

        $("#ps").autocomplete(
                {
                    source: 'action.php?action=ps',
                });
        $("#dist").autocomplete(
                {
                    source: 'action.php?action=dist',
                });
        $("#po").autocomplete(
                {
                    source: 'action.php?action=po',
                });
        $("#state").autocomplete(
                {
                    source: 'action.php?action=state',
                });
        $("#religion").autocomplete(
                {
                    source: 'action.php?action=religion',
                });
        $("#patient_quali").autocomplete(
                {
                    source: 'action.php?action=patient_quali',
                });
        $("#patient_ocu").autocomplete(
                {
                    source: 'action.php?action=patient_ocu',
                });
        $("#gurd_quali").autocomplete(
                {
                    source: 'action.php?action=gurd_quali',
                });
        $("#gurd_ocu").autocomplete(
                {
                    source: 'action.php?action=gurd_ocu',
                });
        $("#pin").autocomplete(
                {
                    source: 'action.php?action=pin',
                });
        $("#reg_no").autocomplete({
            source: 'action.php?action=reg_no'
        });
        $("#atd_assist").autocomplete({
            source: 'action.php?action=atd_assist'
        });
    });
</script>
<script>
    $('#admit_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        /*minDate: -1,
         maxDate: new Date()*/
    }).datepicker("setDate", new Date());
</script>
<script>
    $(document).ready(function () {
        $(".contacts").attr("maxlength", 12)
    });
    function getReg() {
        $.ajax({url: "action.php?action=reg", success: function (result) {
                $("#reg_no").val($.trim(result));
            }});
    }
    $(document).ready(function () {
        getReg();
        $(".bg-success,.bg-danger").delay(5000).fadeOut();
        $.ajax({url: "action.php?action=del_session", success: function (result) {
            }});
    });
    $(document).ready(function () {
        $.getJSON("action.php?action=get_bdcat", function (data) {
            $('#bed_type').append(
                    $('<option></option>').val("").html("Select Type"));
            $.each(data, function (index) {
                $('#bed_type').append(
                        $('<option></option>').val(data[index].id).html(data[index].bed_type)
                        );
            });
        });

        $.getJSON("action.php?action=prov_list", function (data) {
            $('#prov_diog').append(
                    $('<option></option>').val("").html("Select Prov. Diagnosis"));
            $.each(data, function (index) {
                $('#prov_diog').append(
                        $('<option></option>').val(data[index].id).html(data[index].diog_name)
                        );
            });
        });
    });
    $(document).ready(function () {
        $.getJSON("action.php?action=get_dpt", function (data) {
            $('#dept_name').append(
                    $('<option></option>').val("").html("Select Department"));
            $.each(data, function (index) {
                $('#dept_name').append(
                        $('<option></option>').val(data[index].id).html(data[index].dept_name)
                        );
            });
        });
        $.getJSON("action.php?action=atd_nurse", function (data) {
            $.each(data["doc_details"], function (index) {
                $('#atd_nurse').append(
                    $('<option></option>').val(data["doc_details"][index].id).html(data["doc_details"][index].doc_name)
                );
            });
        });
        $.getJSON("action.php?action=atd_ansth", function (data) {
            $.each(data["doc_details"], function (index) {
                $('#atd_anasth').append(
                    $('<option></option>').val(data["doc_details"][index].id).html(data["doc_details"][index].doc_name)
                );
            });
        });
    });
    var bd_no = "";
    var bd_type = "";
    var dept_name = "";
    var atd_doctor = "";
    var atd_nurse = "";
    $("#srch_reg").click(function () {

        if ($("#srch_reg").text() == "Search") {
            $("#reg_no").val("").prop("readonly", false).focus();
            $("#srch_reg").text("Go");
        } else if ($("#srch_reg").text() == "Go") {
            $.getJSON("action.php?action=get_pt", {id: $('#reg_no').val()}, function (data) {
                $.each(data, function (index) {
                    //console.log(data[index]);
                    $("#id").val(data['id']);
                    $("#reg_no").attr('disabled', true);
                    $("#regno").val(data['reg_no']);
                    $("#srch_reg").text("Search");
                    $("#admit_date").val(data['admit_date'])/*.attr('disabled', true)*/;
                    $("#hr").val(data['hr']).attr('disabled', true);
                    $("#min").val(data['min']).attr('disabled', true);
                    $("#meridian").val(data['meridian']).attr('disabled', true);
                    $("#bed_type").val(data['bed_type']);
                    $("#bed_chrg").val(data['bed_chrg']);
                    $("#first_name").val(data['first_name']);
                    $("#middle_name").val(data['middle_name']);
                    $("#last_name").val(data['last_name']);
                    $("#age").val(data['age']);
                    $("#m_age").val(data['m_age']);
                    $("#blood_group").val(data['blood_group']);
                    $("#religion").val(data['religion']);
                    $("#patient_quali").val(data['patient_quali']);
                    $("#patient_ocu").val(data['patient_ocu']);
                    $("#relation").val(data['relation']);
                    $("#gurd_name").val(data['gurd_name']);
                    $("#gurd_quali").val(data['gurd_quali']);
                    $("#gurd_ocu").val(data['gurd_ocu']);
                    $("#address").val(data['address']);
                    $("#pin").val(data['pin']);
                    $("#po").val(data['po']);
                    $("#ps").val(data['ps']);
                    $("#dist").val(data['dist']);
                    $("#state").val(data['state']);
                    $("#atd_assist").val(data['atd_assist']);
                    $("#contact_no_1").val(data['contact_no_1']);
                    $("#contact_no_2").val(data['contact_no_2']);
                    $("#gud_contact_no").val(data['gud_contact_no']);
                    $("#prov_diog").val(data['prov_diog']).attr('selected', true);
                    $("#doc_ref").val(data['doc_ref'])/*.attr('disabled', true)*/;
                    $("#tot_charge").val(data['tot_charge'])/*.attr('disabled', true)*/;
                    $("#sex"+data['sex']).val(data['sex']).prop('checked', true);
                    $("#admin_form").attr('action', 'action.php?action=adm_update');
                    $('#atd_nurse').val(data['atd_nurse']).attr('selected', true);
					$('#atd_anasth').val(data['atd_anasth']).attr('selected',true);
					$('#treatment').val(data['treatment']);
                    bd_type = data['bed_type'];
                    bd_no = data['bed_no'];
                    $("#dept_name").val(data['dept_name']);
                    dept_name = data['dept_name'];
                    atd_doctor = data['atd_doctor'];
                    //atd_nurse = data['atd_nurse'];

                });
                getBed();
                getDoc();
                //$("#bed_no").attr('disabled', true);
            });
        }
    });
    $('#bed_type').change(function () {
        if ($('#bed_type').val()) {
            $.getJSON("action.php?action=get_bdt", {id: $('#bed_type').val()}, function (data) {
                $("#tbed,#avlbed").show();
                $("#tot").html(data["tot_beds"].bed_no);
                $("#avl").html(data["beds_avail"].avail);
                $('#bed_no').empty();
                $('#bed_no').append(
                        $('<option></option>').val("").html("Select Bed No"));
                $.each(data["bd_details"], function (index) {
                    //console.log(data["bd_details"][index].id+"=>"+data["bd_details"][index].bed_name);
                    $('#bed_no').append(
                            $('<option></option>').val(data["bd_details"][index].id).html(data["bd_details"][index].bed_name)
                            );
                });
            });
        } else {
            $("#tbed,#avlbed").hide();
            $('#bed_no').empty();
            $('#bed_chrg').val("");
        }
    });

    function getBed() {
        
        $.getJSON("action.php?action=get_bdta", {id: bd_type}, function (data) {
            $('#bed_no').empty();
            $('#bed_no').append(
                    $('<option></option>').val("").html("Select Bed No"));
            $.each(data["bd_details"], function (index) {
                console.log(data["bd_details"][index].id+" => "+bd_no);
                if (bd_no === data["bd_details"][index].id ) {
                    console.log(bd_no);
                    $('#bed_no').append(
                            $('<option></option>').val(data["bd_details"][index].id)
                            .html(data["bd_details"][index].bed_name)
                            .attr('selected', true)
                            );
                } else {
                    $('#bed_no').append(
                            $('<option></option>').val(data["bd_details"][index].id).html(data["bd_details"][index].bed_name)
                            );
                }
            });
        });
    }

    $('#dept_name').change(function () {
        if ($('#dept_name').val()) {
            $.getJSON("action.php?action=doc_lst", {id: $('#dept_name').val()}, function (data) {
                $('#atd_doctor').empty();
                $('#atd_doctor').append(
                        $('<option></option>').val("").html("Select Doctors"));
                $.each(data["doc_details"], function (index) {
                    //console.log(data["bd_details"][index].id+"=>"+data["bd_details"][index].bed_name);
                    $('#atd_doctor').append(
                            $('<option></option>').val(data["doc_details"][index].id).html("Dr." + data["doc_details"][index].doc_name)
                            );
                });
            });
        } else {
            $('#atd_doctor').empty();
            $('#atd_doctor').append($('<option></option>').val("").html("Select Doctors"));
        }
    });
    function getDoc() {
        $.getJSON("action.php?action=doc_lst", {id: dept_name}, function (data) {
            $('#atd_doctor').empty();
            $('#atd_doctor').append(
                    $('<option></option>').val("").html("Select Doctors"));
            $.each(data["doc_details"], function (index) {
                //console.log(data["bd_details"][index].id+"=>"+data["bd_details"][index].bed_name);
                if (atd_doctor === data["doc_details"][index].id) {
                    $('#atd_doctor').append(
                            $('<option></option>').val(data["doc_details"][index].id)
                            .html("Dr." + data["doc_details"][index].doc_name)
                            .attr('selected', true)
                            );
                }
            });
        });
    }
    $('#bed_no').change(function () {
        $.getJSON("action.php?action=get_bdchrg", {id: $('#bed_type').val()}, function (data) {
            $("#bed_chrg").val(data["bed_chrg"].bed_chrg);
        });
    });
    /*$('#admit_date').change(function () {
     $.post("action.php?action=reg_blg",
     {
     date: $('#admit_date').val()
     },
     function (data, status) {
     $('#reg_no').val(data)
     });
     });*/
</script>
<script>
    $(document).ready(function () {
        $(".contacts").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
    });
</script>

<?php
include("db_connect.php");
include("config.php");
include("layouts/header.php");

$id = (isset($_GET['id']) ? $_GET['id'] : 0);
$msg = (isset($_GET['message']) ? $_GET['message'] : "");

$insData = '';
$priorData = [];
if ($id > 0) {
    $selectSql = "SELECT * FROM insurance WHERE id = $id LIMIT 1";
    $result = $conn->query($selectSql);
    if (isset($result->num_rows) && $result->num_rows > 0) {
        $insData = $result->fetch_assoc();
    } else {
        header("Location:edit.php");
    }

    $selectSql = "SELECT * FROM prior_reports WHERE ins_id = $id ORDER BY start_date DESC";
    $result = $conn->query($selectSql);
    if (isset($result->num_rows) && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $temp = [];
            $temp['id'] = $row['id'];
            $temp['ins_id'] = $row['ins_id'];
            $temp['report_type'] = $row['report_type'];
            $temp['year'] = $row['year'];
            $temp['quarter'] = $row['quarter'];
            $temp['start_date'] = date('m/d/Y', strtotime($row['start_date']));
            $temp['end_date'] = date('m/d/Y', strtotime($row['end_date']));
            $temp['total_miles'] = number_format($row['total_miles'], 2);
            $temp['state_miles'] = $row['state_miles'];
            $priorData[] = $temp;
        }
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?= $msg ?>
            <h2>&nbsp;</h2>
            <form id='addEditPromoForm' method='POST'  action='javascript:void(0);' class="form-horizontal"  enctype="multipart/form-data">
                <input id="id" type="hidden" class="form-control" name="id" value="<?= $id ?>" >
                <input id="submitted" type="hidden" class="form-control" name="submitted" value="1" >
                <div class="form-group m-form__group row">
                    <div class="col-lg-4">
                        <label>Insured Number : </label>
                        <input type="number" id="ins_number" name="ins_number" class="form-control m-input" value="<?= $insData['ins_number'] ?>" <?= ($id > 0 ? "readonly='readonly' " : "") ?>>
                    </div>
                    <div class="col-lg-1" style='text-align: center;' >
                        <label style='padding-top: 32px;'>OR</label>
                    </div>
                    <div class="col-lg-6">
                        <label>Policy Number : </label>
                        <input style="max-width: 375px;" type="text" id="policy_number" name="policy_number" class="form-control m-input" value="<?= $insData['policy_number'] ?>" <?= ($id > 0 ? "readonly='readonly' " : "") ?>>
                    </div>
                    
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-lg-4" <?= ($id > 0 ? "style='display: none; '" : "") ?>>
                        <!--<label>&nbsp;</label>-->
                        <button id="search" type="buton" class="btn btn-primary">Search</button>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-lg-4">
                        <label>Insured Name: </label>
                        <input type="text" id="ins_name" name="ins_name" class="form-control m-input" value="<?= $insData['ins_name'] ?>" readonly='readonly' />
                    </div>
                    <div class="col-lg-4">
                        <label>Business Start Year: </label>
                        <select id="start_year" name='start_year' class="form-control" disabled>
                            <option value=''></option>
                            <?php foreach ($yearArr as $year) { ?>
                                <option value='<?= $year ?>' <?= ($year == $insData['start_year'] ? "selected='selected'" : "") ?>><?= $year ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-lg-4">
                        <label>Insured State: </label>
                        <select id="ins_state" name='ins_state' class="form-control" disabled>
                            <option value=''></option>
                            <?php foreach ($stateArr as $key => $val) { ?>
                                <option value='<?= $val ?>' <?= ($val == $insData['ins_state'] ? "selected='selected'" : "") ?>><?= $val ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Insured City: </label>
                        <input type="text" id="ins_city" name="ins_city" class="form-control m-input" value="<?= $insData['ins_city'] ?>" readonly='readonly'>
                    </div>
                    <div class="col-lg-4">
                        <label>Dot Number: </label>
                        <input type="number" id="dot_number" name="dot_number" class="form-control m-input" value="<?= $insData['dot_number'] ?>" readonly='readonly'>
                    </div>
                </div>
                
                <div class="form-group m-form__group row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Prior Entries</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Quarter</th>
                                            <th>Year</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Total Mileage</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count($priorData) > 0) {
                                            foreach ($priorData as $record) {
                                                ?>
                                                <tr>
                                                    <td><?= $record['report_type'] ?></td>
                                                    <td><?= $record['quarter'] ?></td>
                                                    <td><?= $record['year'] ?></td>
                                                    <td><?= $record['start_date'] ?></td>
                                                    <td><?= $record['end_date'] ?></td>
                                                    <td><?= $record['total_miles'] ?></td>
                                                    <td>
                                                        <a onclick="populateEditData('<?= $record['id'] ?>', '<?= $record['report_type'] ?>', '<?= $record['quarter'] ?>', '<?= $record['year'] ?>', '<?= $record['start_date'] ?>', '<?= $record['end_date'] ?>', '<?= $record['total_miles'] ?>');" href="javascript:void(0);"><i class="fa fa-edit" style="cursor: pointer;"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="7" style="text-align: center;"><b>No Prior Entries Found!!!</b></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box group_item box-solid box-default" >
                    <div class="box-header">
                        <h3 class="box-title pull-left">Add New Entry</h3>
                        <button onclick="resetPriorEntry();" type="button" class="btn btn-info" style="width:100px">Reset</button>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                                                    <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label>Report Type<span class="text-warning">*</span>: </label>
                                <input id="prior_record_id" name="prior_record_id" type='hidden' value="0" />
                                <select id="report_type" name='report_type' class="form-control add_new_prior-select" required>
                                    <option value='' >Please Select</option>
                                    <option value='Specified' >Specified</option>
                                    <option value='Quarterly' >Quarterly</option>
                                </select>
                            </div>
                            <div class="col-lg-4 hideOnQuarterly" style="display: none;">
                                <label>Year: </label>
                                <select id="year" name='year' class="form-control add_new_prior-select" >
                                    <option value='' >Please Select</option>
                                    <?php foreach ($yearArr as $year) { ?>
                                        <option value='<?= $year ?>' ><?= $year ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-4 hideOnQuarterly" style="display: none;">
                                <label>Quarter : </label>
                                <select id="quarter" name='quarter' class="form-control add_new_prior-select" >
                                    <option value='' >Please Select</option>
                                    <option value='Q1' >Q1</option>
                                    <option value='Q2' >Q2</option>
                                    <option value='Q3' >Q3</option>
                                    <option value='Q4' >Q4</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-3">
                                <label>Start Date<span class="text-warning">*</span>: </label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type="text" class="form-control add_new_prior-text" id="start_date" name="start_date"  value="" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label>End Date<span class="text-warning">*</span>: </label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type="text" class="form-control add_new_prior-text" id="end_date" name="end_date"  value=""/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>

                            </div>
                            <div class="col-lg-2">
                                <label>Power Units: </label>
                                <input type="number" min="1" max="9999" id="units" name="units" class="form-control m-input add_new_prior-text" value="">
                            </div>
                            <div class="col-lg-2">
                                <label>Miles Per Gallon: </label>
                                <input type="number" min="1" id="miles_per_gallon" name="miles_per_gallon" class="add_new_prior-text form-control m-input" value="">
                            </div>
                            <div class="col-lg-2">
                                <label>Total Miles<span class="text-warning">*</span>: </label>
                                <input  type="text" id="total_miles" name="total_miles"  class="form-control m-input add_new_prior-text" value="" required>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-12">
                                <label>US</label>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Jurisdiction</th>
                                            <th>Miles</th>
                                            <th>Jurisdiction</th>
                                            <th>Miles</th>
                                            <th>Jurisdiction</th>
                                            <th>Miles</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($us_miles as $state) {
                                            ?>
                                            <tr>
                                                <td><?= $state[0] ?></td>
                                                <td>
                                                    <input type="text" id="miles_<?= $state[0] ?>" name="miles[]"  class="add_new_prior-text form-control m-input milesCls" value="" >
                                                    <input type="hidden" name="miles_state[]" value="<?= $state[0] ?>" >
                                                </td>
                                                <td><?= $state[1] ?></td>
                                                <td>
                                                    <input type="text" id="miles_<?= $state[1] ?>" name="miles[]"  class="add_new_prior-text form-control m-input milesCls" value="" >
                                                    <input type="hidden" name="miles_state[]" value="<?= $state[1] ?>" >
                                                </td>
                                                <?php if (isset($state[2])) { ?>
                                                    <td><?= $state[2] ?></td>
                                                    <td>
                                                        <input type="text" id="miles_<?= $state[2] ?>" name="miles[]"  class="add_new_prior-text form-control m-input milesCls" value="" >
                                                        <input type="hidden" name="miles_state[]" value="<?= $state[2] ?>" >
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <div class="col-lg-12">
                                <label>Other Territories</label>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Jurisdiction</th>
                                            <th>Miles</th>
                                            <th>Jurisdiction</th>
                                            <th>Miles</th>
                                            <th>Jurisdiction</th>
                                            <th>Miles</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($otherTerrMiles as $state) {
                                            ?>
                                            <tr>
                                                <td><?= $state[0] ?></td>
                                                <td>
                                                    <input type="text" id="miles_<?= $state[0] ?>" name="miles[]"  class="add_new_prior-text form-control m-input milesCls" value="" >
                                                    <input type="hidden" name="miles_state[]" value="<?= $state[0] ?>" >
                                                </td>
                                                <td><?= $state[1] ?></td>
                                                <td>
                                                    <input type="text" id="miles_<?= $state[1] ?>" name="miles[]"  class="add_new_prior-text form-control m-input milesCls" value="" >
                                                    <input type="hidden" name="miles_state[]" value="<?= $state[1] ?>" >
                                                </td>
                                                <?php if (isset($state[2])) { ?>
                                                    <td><?= $state[2] ?></td>
                                                    <td>
                                                        <input type="text" id="miles_<?= $state[2] ?>" name="miles[]"  class="add_new_prior-text form-control m-input milesCls" value="" >
                                                        <input type="hidden" name="miles_state[]" value="<?= $state[2] ?>" >
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-4">
                        <button id="submit" type="submit" class="btn btn-primary" >Submit</button>
                        <button id="cancel" type="button" class="btn btn-primary" >Cancel</button>
                        <button id="delete" type="button" class="btn btn-primary" >Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("layouts/footer.php"); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script type="text/javascript">

    if ("<?= $msg ?>" != '') {
        toastr.success("<?= $msg ?>");
    }
    $(document).ready(function () {
        $("#start_date").datepicker({
            format: "mm/dd/yyyy",
            todayBtn: 1,
            autoclose: true,
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#end_date').datepicker('setStartDate', minDate);
        });

        $("#end_date").datepicker({
            format: "mm/dd/yyyy"
        }).on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#start_date').datepicker('setEndDate', maxDate);
        });


        $('#report_type').on('change', function () {
            if ($('#report_type').val() == 'Quarterly') {
                $('.hideOnQuarterly').show();
                syncDatesOnQuarterly();    
            } else {
                $('.hideOnQuarterly').hide();
            }
        });

        $('#year , #quarter').on('change', function () {
            syncDatesOnQuarterly();
        });

        $('#submit').click(function () {
            editInsData();
        });

        $('#search').click(function () {
            searchIns();
        });

        $('#cancel').click(function () {
            window.location.href = baseUrl + "/edit.php";
        });

        $('#delete').click(function () {
            deletePriorEntry();
        });

        if("<?= $id ?>" == '0') {
            $('.add_new_prior-select').attr('disabled', 'disabled');
            $('.add_new_prior-text').attr('readonly', 'readonly');
        }

    });

    function syncDatesOnQuarterly() {
        var yr = $('#year').val();
        var q = $('#quarter').val();
        var stdt = '';
        var endt = '';
        if (q == 'Q1') {
            stdt = "01/01/"+yr;
            endt = "03/31/"+yr;
        }
        if (q == 'Q2') {
            stdt = "04/01/"+yr;
            endt = "06/30/"+yr;
        }
        if (q == 'Q3') {
            stdt = "07/01/"+yr;
            endt = "09/30/"+yr;
        }
        if (q == 'Q4') {
            stdt = "10/01/"+yr;
            endt = "12/31/"+yr;
        }
        $('#start_date').val(stdt);
        $('#end_date').val(endt);
    }

    function editInsData() {
        if($('#addEditPromoForm').valid()) {
            $('.spinner').show();
            var data = $('#addEditPromoForm').serialize();
            $.ajax({
                url: baseUrl + "/save.php?id=<?= $id ?>",
                method: "POST",
                data: data,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    $('.spinner').hide();
                    if (typeof (response.status) != 'undefined' && response.status == 1) {
                        toastr.success(response.message);
                        window.location.href = baseUrl + '/edit.php?id=' + response.data.id;
                        //+'&message=New record added successfully '
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (response) {
                    $('.spinner').hide();
                    toastr.error('Something went wrong!!!');
                }
            });
        }
    }

    function searchIns() {
        $('.spinner').show();

        var data = {
            ins_number: $('#ins_number').val(),
            policy_number: $('#policy_number').val()
        };
        $.ajax({
            url: baseUrl + "/search.php",
            method: "POST",
            data: data,
            dataType: 'json',
            success: function (response) {
                $('.spinner').hide();
                if (typeof (response.status) != 'undefined' && response.status == 1) {
                    toastr.success(response.message);
                    if (typeof (response.data.id) != 'undefined') {
                        window.location.href = baseUrl + '/edit.php?id=' + response.data.id;
                    } else {
                        toastr.error('Something went wrong!!');
                    }
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (response) {
                $('.spinner').hide();
                toastr.error('Something went wrong!!!');
            }
        });
    }

    function populateEditData(id, report_type, quarter, year, start_date, end_date, total_miles) {

        $('.spinner').show();
        resetPriorEntry();
        $.ajax({
            url: baseUrl + "/get_prior_record.php?id=" + id,
            method: "GET",
            dataType: 'json',
            success: function (response) {
                $('.spinner').hide();
                if (typeof (response.status) != 'undefined' && response.status == 1) {
//                    toastr.success(response.message);
                    if (typeof (response.data) != 'undefined') {
                        $('#prior_record_id').val(response.data.id);
                        $('#report_type').val(response.data.report_type);
                        $('#quarter').val(response.data.quarter);
                        $('#year').val(response.data.year);
                        $('#start_date').val(response.data.start_date);
                        $('#end_date').val(response.data.end_date);
                        $('#miles_per_gallon').val(response.data.miles_per_gallon);
                        $('#units').val(response.data.units);
//                        $('#total_miles').val(response.data.total_miles);
                        $('#total_miles').val(new Intl.NumberFormat('en-US', { maximumSignificantDigits: 3 }).format(response.data.total_miles));

                        if ($('#report_type').val() == 'Specified') {
                            $('.hideOnQuarterly').hide();
                        } else {
                            $('.hideOnQuarterly').show();
                            syncDatesOnQuarterly();
                        }

                        var state_miles = response.data.state_miles;
                        Object.keys(state_miles).forEach(function (key) {
                            $('#miles_' + key).val(new Intl.NumberFormat('en-US', { maximumSignificantDigits: 3 }).format(state_miles[key]));
                            //$('#miles_' + key).val(state_miles[key]);
                        });
                    } else {
                        toastr.error('No prior entry found!!');
                    }
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (response) {
                $('.spinner').hide();
                toastr.error('Something went wrong!!!');
            }
        });

    }

    function resetPriorEntry() {
        $('#prior_record_id').val(0);
        $('#report_type').val("");
        $('#quarter').val("");
        $('#year').val("");
        $('#start_date').val("");
        $('#end_date').val("");
        $('#miles_per_gallon').val("");
        $('#units').val("");
        $('#total_miles').val("");

        $('.milesCls').each(function (ind, ele) {
            $(ele).val(0);
        });
    }

    function deletePriorEntry() {
        if (!($('#prior_record_id').val() > 0)) {
            toastr.error("No prior entry selected for deletion!!!");
            return;
        }

        if (confirm("Are you sure want to delete this prior entry?")) {
            $('.spinner').show();
            $.ajax({
                url: baseUrl + "/delete_prior_record.php?id=" + $('#prior_record_id').val(),
                method: "GET",
                dataType: 'json',
                success: function (response) {
                    $('.spinner').hide();
                    if (typeof (response.status) != 'undefined' && response.status == 1) {
                        toastr.success(response.message);
                        window.location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (response) {
                    $('.spinner').hide();
                    toastr.error('Something went wrong!!!');
                }
            });
        }
    }

</script>
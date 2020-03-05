<?php
include("db_connect.php");
include("config.php");
include("layouts/header1.php");

$id = (isset($_GET['id']) ? $_GET['id'] : 0);
?>

<div class="container" style="margin-top:30px">
    <div class="row">
        <div class="col-sm-12">
            <h2>Edit Insured Mileage Report</h2>
            <form id='addEditPromoForm' method='POST'  action='' class="form-horizontal"  enctype="multipart/form-data">
                <input id="id" type="hidden" class="form-control" name="id" value="" autofocus>
                <div class="form-group m-form__group row">
                    <div class="col-lg-4">
                        <label>Insured Number <span class="text-warning">*</span> : </label>
                        <input type="number" name="ins_number" class="form-control m-input" value="" <?= ($id > 0 ? "readonly='readonly' required" : "") ?>>
                    </div>
                    
                    <div class="col-lg-4">
                        <label>Policy Number <span class="text-warning">*</span> : </label>
                        <input type="number" name="ins_number" class="form-control m-input" value="" <?= ($id > 0 ? "readonly='readonly' required" : "") ?>>
                    </div>
                    <div class="col-lg-4">
                        <!--<label>&nbsp;</label>-->
                        <button type="submit" class="btn btn-primary" name="signup" value="Sign up">Search</button>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-lg-4">
                        <label>Insured Name: </label>
                        <input type="text" name="ins_name" class="form-control m-input" value="" <?= ($id > 0 ? "readonly='readonly' required" : "") ?>>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-lg-4">
                        <label>Insured State: </label>
                        <input type="text" name="ins_state" class="form-control m-input" value="" <?= ($id > 0 ? "readonly='readonly' required" : "") ?>>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-lg-4">
                        <label>Dot Number: </label>
                        <input type="number" name="dot_number" class="form-control m-input" value="" <?= ($id > 0 ? "readonly='readonly' required" : "") ?>>
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
                                        <tr>
                                            <td>Quarterly</td>
                                            <td>Q4</td>
                                            <td>2020</td>
                                            <td>21/2/2020</td>
                                            <td>21/2/2020</td>
                                            <td>50000</td>
                                            <td>
                                                <i class="fa fa-edit"></i>&nbsp;
                                                <i class="fa fa-remove"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Specified</td>
                                            <td></td>
                                            <td>2020</td>
                                            <td>21/2/2020</td>
                                            <td>21/2/2020</td>
                                            <td>50000</td>
                                            <td>
                                                <i class="fa fa-edit"></i>&nbsp;
                                                <i class="fa fa-remove"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Quarterly</td>
                                            <td>Q4</td>
                                            <td>2020</td>
                                            <td>21/2/2020</td>
                                            <td>21/2/2020</td>
                                            <td>50000</td>
                                            <td>
                                                <i class="fa fa-edit"></i>&nbsp;
                                                <i class="fa fa-remove"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box group_item box-solid box-default" >
                    <div class="box-header">
                        <h3 class="box-title">Add New Report</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                                                    <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label>Report Type: </label>
                                <select id="report_type" name='report_type' class="form-control" >
                                    <option value='Specified' >Specified</option>
                                    <option value='Quarterly' >Quarterly</option>
                                </select>
                            </div>
                            <div class="col-lg-4 hideOnQuarterly" style="display: none;">
                                <label>Year: </label>
                                <select id="year" name='year' class="form-control" >
                                    <?php foreach ($yearArr as $year) { ?>
                                        <option value='<?= $year ?>' ><?= $year ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-4 hideOnQuarterly" style="display: none;">
                                <label>Quarter : </label>
                                <select id="quarter" name='quarter' class="form-control" >
                                    <option value='Q1' >Q1</option>
                                    <option value='Q2' >Q2</option>
                                    <option value='Q3' >Q3</option>
                                    <option value='Q4' >Q4</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label>Start Date<span class="text-warning">*</span>: </label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type="text" class="form-control" id="start_date" name="start_date"  value=""/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>End Date<span class="text-warning">*</span>: </label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type="text" class="form-control" id="end_date" name="end_date"  value=""/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>

                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label>Number of power units: </label>
                                <input type="number" min="0" max="9999" name="units" class="form-control m-input" value="0">
                            </div>
                            <div class="col-lg-4">
                                <label>Miles per gallon: </label>
                                <input type="number" maxlength="5" name="miles_per_gallon" class="form-control m-input" value="00.00">
                            </div>
                            <div class="col-lg-4">
                                <label>Total Miles<span class="text-warning">*</span>: </label>
                                <input type="number" name="total_miles" maxlength="10" class="form-control m-input" value="0" required>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-12">
                                <label>US Miles </label>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Jurisdiction</th>
                                            <th>Miles</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>AL</td>
                                            <td>50000</td>
                                        </tr>
                                        <tr>
                                            <td>AK</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>AZ</td>
                                            <td>50000</td>
                                        </tr>
                                        <tr>
                                            <td>AR</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>CA</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>CO</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>DE</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>FL</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <div class="col-lg-12">
                                <label>Canada Miles </label>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Jurisdiction</th>
                                            <th>Miles</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>AB</td>
                                            <td>50000</td>
                                        </tr>
                                        <tr>
                                            <td>BC</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>NB</td>
                                            <td>50000</td>
                                        </tr>
                                        <tr>
                                            <td>NA</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>NL</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>NT</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>NS</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>OTHER</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-4">
                        <button type="submit" class="btn btn-primary" name="signup" value="Sign up">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("layouts/footer1.php"); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#start_date").datepicker({
            format: "dd/mm/yyyy",
            todayBtn: 1,
            autoclose: true,
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#end_date').datepicker('setStartDate', minDate);
        });

        $("#end_date").datepicker({
            format: "dd/mm/yyyy",
        }).on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#start_date').datepicker('setEndDate', maxDate);
        });


        $('#report_type').on('change', function () {
            if ($('#report_type').val() == 'Specified') {
                $('.hideOnQuarterly').hide();
            } else {
                $('.hideOnQuarterly').show();
                syncDatesOnQuarterly();
            }
        });

        $('#year , #quarter').on('change', function () {
            syncDatesOnQuarterly();
        });

    });

    function syncDatesOnQuarterly() {
        var yr = $('#year').val();
        var q = $('#quarter').val();
        var stdt = '';
        var endt = '';
        if (q == 'Q1') {
            stdt = "01/01/" + yr;
            endt = "31/03/" + yr;
        }
        if (q == 'Q2') {
            stdt = "01/04/" + yr;
            endt = "30/06/" + yr;
        }
        if (q == 'Q3') {
            stdt = "01/07/" + yr;
            endt = "30/09/" + yr;
        }
        if (q == 'Q4') {
            stdt = "01/10/" + yr;
            endt = "31/12/" + yr;
        }
        $('#start_date').val(stdt);
        $('#end_date').val(endt);
    }
</script>
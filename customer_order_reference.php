<!DOCTYPE html>
<html>
<head>
    <title>Bootstrap Datetimepicker Disable Past Dates Example - ItSolutionStuff.com</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
</head>
<body>
  
<div class="container">
    <h2>Bootstrap Datetimepicker Disable Past Dates Example - ItSolutionStuff.com</h2>
    <strong>Today Date is 5/7/2020</strong>
    <div class="row">
    <p>checkin</p>
        <div class='col-sm-3'>
            <div class="form-group">
                <div class='input-group date datetimepickerDemo'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <p>checkout</p>
    <div class="row">
        <div class='col-sm-3'>
            <div class="form-group">
                <div class='input-group date datetimepickerDemo'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
  
<script type="text/javascript">
    $(function () {
        $('.datetimepickerDemo').datetimepicker({
            minDate:new Date()
        });
    });
</script>
  
</body>
</html>
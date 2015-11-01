<!DOCTYPE html>
<html>
<title>Personio Assignment</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Keywords" content="">
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../Resources/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="../../Resources/css/bootstrap-theme.min.css">
    <!-- Jquery datepicker -->
    <link rel="stylesheet" href="../../Resources/css/jquery-ui.min.css">
    <!-- Custom -->
    <link rel="stylesheet" href="../../Resources/css/styles.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Remaining vacation calculation</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form method="post" name="calc_form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group input-group ">
                            <input type="text" id="hire_date" name="hire_date" class="form-control date" data-validation="required" placeholder="Hire date">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group input-group">
                            <input type="text" id="calculation_date" name="calculation_date" class="form-control date" data-validation="required" placeholder="Calculation date">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="vacation-period">
                        <div class="vacation-block">
                            <div class="col-md-5">
                                <div class="form-group input-group">
                                    <input type="text" name="start_vacation[]" class="form-control date" placeholder="Start vacation (Ex: 2009-05-19)">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group input-group">
                                    <input type="text" name="end_vacation[]" class="form-control date" placeholder="End vacation (Ex: 2015-05-19)">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <a id="add-more" href="#">+ add more</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="bs-example">
                            <p class="text-info">Please enter Hire date and Calculation date above.</p>
                        </div>
                        <div class="highlight">
                            <pre>
                                <code></code>
                            </pre>
                        </div>
                    </div>
                </div>
                <button type="submit" name="calc" class="btn btn-primary">Calculation</button>
            </form>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>
<!-- Latest jquery script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="../../Resources/js/bootstrap.min.js"></script>

<!-- Jquery date picker -->
<script src="../../Resources/js/jquery-ui.min.js"></script>

<!-- Jquery application -->
<script src="../../Resources/js/custom.js"></script>
</body>
</html>
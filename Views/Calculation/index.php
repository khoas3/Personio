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
                            <input type="text" id="hire_date" name="hire_date" class="form-control date"  placeholder="Hire date">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group input-group">
                            <input type="text" id="calculation_date" name="calculation_date" class="form-control date" placeholder="Calculation date">
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
                            <p class="text-info">Hello world</p>
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
<script type="text/javascript">
    $('.date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd"
    });
    // Submit form by Ajax.
    $('form').submit(function(e){
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: '/calculation',
            data: $( this ).serializeArray()
        }).done(function(msg){
            console.log(msg);
        })
        ;
        return false;
    });
    // Add more vacation period.
    $('#add-more').on('click', function(e){
        e.preventDefault();
        var rm_btn_html = '<div class="col-md-2">';
            rm_btn_html+='<a href="#" class="btn bg-danger remove-btn">Remove</a>';
            rm_btn_html+='</div>';
        var rm_btn = $(rm_btn_html);
        var $clone = $('.vacation-block').first().clone(true).append(rm_btn);
        var datepicker = $clone.find("input[type='text']");
        $.each(datepicker, function(){
            var $this = $(this);
            $this.datepicker("destroy");
            $this.removeAttr("id");
            $this.datepicker();
            $this.val("");
        });
        $('.vacation-period').append($clone);
        rm_btn.click(function(e){
            e.preventDefault()
            $(this).closest('div .vacation-block').remove();
        });
    });

</script>
</body>
</html>
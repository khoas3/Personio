
$( document ).ready(function() {
    $('#hire_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        onClose: function( selectedDate ) {
            $( "#calculation_date" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    $('#calculation_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        onClose: function( selectedDate ) {
            $( "#hire_date" ).datepicker( "option", "maxDate", selectedDate );
        }
    });

    $('.date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd"
    });
    var form_validate = function(){
        var ret = true;
        $('body').find('input').each(function(){
            var $this = $(this);
            var data_validation = $this.attr('data-validation');

            if(typeof data_validation !== typeof undefined && data_validation !== false){
                if(data_validation == "required"){
                    if($this.val() == ''){
                        $this.addClass('error').css({'border-color': 'rgb(185, 74, 72)'});
                        ret = false;
                    }
                }
            }
        });
        return ret;
    };
    // Submit form by Ajax.
    $('form').submit(function(e){
        $('.bs-example').empty();
        e.preventDefault();
        if(form_validate()){
            $.ajax({
                method: "POST",
                url: '/calculation',
                data: $( this ).serializeArray()
            }).done(function(msg){
                decorator(msg);
            });
        }
        return false;
    });
    var decorator = function(msg){
        var start_working = $('#hire_date').val();
        var calculation_date = $('#calculation_date').val();
        var decoration = $('.bs-example');
        var $msg = $.parseJSON(msg);
        decoration.html('<p class="text-info">You work from: <strong>'+start_working+'</strong> to: <strong>'+calculation_date+'</strong></p>');
        $.each($msg.vacation, function (i,v) {
            decoration.append('<p class="text-success">Year '+i+', you have <strong>'+ v +'</strong> remaining vacation.</p>');
        });
        $.each($msg.vacation_taken, function (i,v) {
            decoration.append('<p class="text-danger">'+ v +'</p>');
        });
    };
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
            $this.datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd"
            });
            $this.val("");
        });
        $('.vacation-period').append($clone);
        rm_btn.click(function(e){
            e.preventDefault();
            $(this).closest('div .vacation-block').remove();
        });
    });
});


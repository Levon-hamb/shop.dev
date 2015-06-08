$(document).ready(function(){

    var $container = $('.container');
// initialize
//    $container.masonry({
//        columnWidth: 150,
//        itemSelector: '.item'
//    });
//    var msnry = $container.data('masonry');


    //$('#search').click(function(e){
    //    e.preventDefault();
    //
    //    var search = $('#srch').val();
    //    var category =$( "#category option:selected" ).val();
    //
    //    if(category == 0 && search){
    //        //alert('asdasdasd');
    //        window.location.href = "/search/"+search;
    //    }else if(category != 0 && search){
    //        window.location.href = "/search/"+category+'/'+search;
    //    }
    //    else if(category != 0 && search.length < 1){
    //        window.location.href = "/search/category/"+category;
    //    }
    //});

    $('#categories').click(function(){
        $(this).next('.hidee').slideToggle();
    });

    $('body').keydown(function(event){
        if(event.keyCode==13){
            $('#signIn').trigger('click');
        }
    });
    $('body').keydown(function(event){
        if(event.keyCode==13){
            $('#signUp').trigger('click');
        }
    });

    $('#signIn').click(function(e){
        e.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();
        var isValidEmail = true;
        var isValidPass = true;
        var remember = $('#checkbox').is(":checked");
//console.log(remember);
        if(validateEmail(email)){
            $('#email').parent().removeClass('has-error');
            $('#email').next('.help-block').hide();

            isValidEmail = true;
        }else{
            $('#email').parent().addClass('has-error');
            $('#email').next('.help-block').show();
            isValidEmail = false;
        }
        if(password && password.length >= 6){
            $('#password').parent().removeClass('has-error');
            $('#password').next('.help-block').hide();
            isValidPass = true;
        }else{
            $('#password').parent().addClass('has-error');
            $('#password').next('.help-block').show();
            isValidPass = false;
        }


        if(isValidPass == false || isValidEmail == false){
            return isValidPass;
        }
        else if(isValidPass == true && isValidEmail == true){
            var isUser = null;
            $.ajax({
                type: "POST",
                url: "signin",
                data: ({email: email, password: password, remember: remember}),
                success : function(data){
                    isUser = data;
                    //console.log(data);
                },
                async: false,
                dataType: "JSON"
            });
            var valid = true;
            if(isUser == true){
                $('#not_exist').parent().removeClass('has-error');
                $('#not_exist').hide();
                valid = true;
                window.location.href = "/";

            }else{
                $('#not_exist').parent().addClass('has-error');
                $('#not_exist').show();
                valid = false;
            }
            return valid;
        }
    });

    $('#signUp').click(function(e){
        e.preventDefault();
        var email = $('#email').val();
        var user_name = $('#user_name').val();
        var re_password = $('#re_password').val();
        var password = $('#password').val();
        var phone_number = $('#phone_number').val();
        var isValid_email = true;
        var isValid_user_name = true;
        var isValid_phone = true;

        var isValid_pass = true;
        var isValid_re = true;
        var isValidUnique = true;
        var isUnique = null;
        if(user_name && user_name.length >= 3){
            $('#user_name').parent().removeClass('has-error');
            $('#user_name').next('.help-block').hide();
            isValid_user_name = true;
        }else{
            $('#user_name').parent().addClass('has-error');
            $('#user_name').next('.help-block').show();
            isValid_user_name = false;
        }
        if(validPhone(phone_number)){
            $('#phone_number').parent().removeClass('has-error');
            $('#phone_number').next('.help-block').hide();
            isValid_phone = true;
        }else{
            $('#phone_number').parent().addClass('has-error');
            $('#phone_number').next('.help-block').show();
            isValid_phone = false;
        }
        if(validPass(re_password) && re_password.length >= 6){
            $('#re_password').parent().removeClass('has-error');
            $('#re_password').next('.help-block').hide();
            isValid_re = true;
        }else{
            $('#re_password').parent().addClass('has-error');
            $('#re_password').next('.help-block').show();
            isValid_re = false;
        }
        if(validateEmail(email)){
            $('#email').parent().removeClass('has-error');
            $('#email').next('.help-block').hide();
            isValid_email = true;
            isUnique = uniqeEmail(email);
            //console.log(isUnique);
            if(isUnique == 0){
                $('#email').parent().removeClass('has-error');
                $('#email').parent().children('#no_unique').hide();
                isValidUnique = true;
            }else{
                $('#email').parent().addClass('has-error');
                $('#email').parent().children('#no_unique').show();
                isValidUnique = false;
            }

        }else{
            $('#email').parent().addClass('has-error');
            $('#email').next('.help-block').show();
            isValid_email = false;
        }
        if(validPass(password) && password.length >= 6){
            $('#password').parent().removeClass('has-error');
            $('#password').next('.help-block').hide();
            isValid_pass = true;
            if(re_password == password && re_password.length >= 6 && password.length >= 6){
                $('#password').parent().removeClass('has-error');
                $('#password').next('.help-block').hide();
                $('#re_password').parent().removeClass('has-error');
                $('#re_password').next('.help-block').hide();
                isValid_pass = true;

            }else{
                $('#re_password').parent().addClass('has-error');
                $('#re_password').next('.help-block').show();
                isValid_pass = false;
            }

        }else{
            $('#password').parent().addClass('has-error');
            $('#password').next('.help-block').show();
            isValid_pass = false;
        }
        if(isValid_email == true && isValid_user_name == true && isValid_phone == true && isValid_pass == true
            && isValid_re == true && isValidUnique == true ){
            var isUser = true;
            $.ajax({
                type: "POST",
                url: "signup",
                data: ({email: email, password: password, re_password: re_password, user_name: user_name, phone_number: phone_number}),
                success : function(data){
                    console.log(data);
                    isUser = data;
                },
                async: false,
                dataType: "JSON"
            });
            if(isUser){
                window.location.href = "/";
            }else{

            }
        }
        else {
            return false;
        }
    });

    $('#forgot_pass_submit').click(function(e){
        e.preventDefault();

        var email = $('#forgot_pass_email').val();
        var isValid = true;
        if(validateEmail(email)){
            $('#forgot_pass_email').parent().removeClass('has-error');
            $('#forgot_pass_email').next('.help-block').hide();
            var noUnique = uniqeEmail(email);
            if(noUnique == 1){
                $('#forgot_pass_email').parent().removeClass('has-error');
                $('#forgot_pass_email').parent().children('#no_unique').hide();
                isValid = true;
                var pass = null;
                $.ajax({
                    type: "POST",
                    url: "forgot",
                    data: ({email: email}),
                    success : function(data){
                        pass = data;

                    },
                    async: false,
                    dataType: "JSON"
                });
                //console.log(pass);
                if(pass){
                    window.location.href = "/";
                }
            }else{
                $('#forgot_pass_email').parent().addClass('has-error');
                $('#forgot_pass_email').parent().children('#no_unique').show();
                isValid = false;
            }
        }else{
            $('#forgot_pass_email').parent().addClass('has-error');
            $('#forgot_pass_email').next('.help-block').show();
            isValid = false;
        }



    });

    function validateEmail(email){
        var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{3,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        var valid = emailReg.test(email);

        if(!valid) {
            return false;
        } else {
            return true;
        }
    }

    function uniqeEmail(email){
        var status = null;
        $.ajax({
            type: "POST",
            url: "uniqueEmail",
            data: ({email: email}),
            success : function(data){
                status = data;
            },
            async: false,
            dataType: "JSON"
        });
        return status;
    }

    $('#save_new_pass').click(function(e){
        e.preventDefault();
        var new_pass = $('#new_password').val();
        var new_confirm_pass = $('#new_confirm_pass').val();

        var isValid = true;
        if(new_pass == new_confirm_pass && new_pass.length >= 6 && new_confirm_pass.length >= 6 && validPass(new_pass) && validPass(new_confirm_pass) ){
            console.log("asdasdasdasdasd");
            $('#new_password').parent().removeClass('has-error');
            $('#new_password').next('.help-block').hide();
            $('#new_confirm_pass').parent().removeClass('has-error');
            $('#new_confirm_pass').next('.help-block').hide();
            isValid = true;

        }else{
            $('#new_password').parent().addClass('has-error');
            $('#new_password').next('.help-block').show();
            $('#new_confirm_pass').parent().addClass('has-error');
            $('#new_confirm_pass').next('.help-block').show();

            isValid = false;
        }

        if(isValid){
            var pass = null;
            $.ajax({
                type: "POST",
                url: "/save_pass",
                data: ({new_password: new_pass, new_confirm_pass: new_confirm_pass}),
                success : function(data){
                    pass = data;
                    //console.log(data);
                },
                async: false,
                dataType: "JSON"
            });
            if(pass){
                window.location.href = "profile";
            }
        }
        return isValid;

    });

    function validPass(pass){
        var pattern = new RegExp(/^([a-z0-9_-]{6,18}$)/i);
        return pattern.test(pass);
    }

    $('#saveProfile').click(function(e){
        e.preventDefault();
        var user_name = $('#user_name').val();
        var phone_number = $('#phone_number').val();
        var isValid = true;
        var valid_user_name = true;
        var isUnique = false;
        var old_phone_number = $('#old_phone_number').text();
        var old_user_name = $('#old_user_name').text();
        if(old_phone_number == phone_number && old_user_name == user_name){
            window.location.href = '/profile';
        }else{
            if(validPhone(phone_number)){
                $('#phone_number').parent().removeClass('has-error');
                $('#phone_number').next('.help-block').hide();
                isValid = true;
            }else{
                $('#phone_number').parent().addClass('has-error');
                $('#phone_number').next('.help-block').show();
                isValid = false;
            }
            if(validUserName(user_name)){
                $('#user_name').parent().removeClass('has-error');
                $('#user_name').next('.help-block').hide();
                valid_user_name = true;
            }else{
                $('#user_name').parent().addClass('has-error');
                $('#user_name').next('.help-block').show();
                valid_user_name = false;
            }

            if(isValid == true && valid_user_name == true){
                var profile = null;
                $.ajax({
                    type: "POST",
                    url: "saveProfile",
                    data: ({phone_number: phone_number, user_name: user_name}),
                    success : function(data){
                        profile = data;
                    },
                    async: false,
                    dataType: "JSON"
                });
                if(profile){
                    window.location.href = "/profile";
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

    });

    function validQty(qty){
        var pattern = new RegExp(/^(([1-9]{1})+([0-9]{0,10}$))/i);
        return pattern.test(qty);
    }

    function validPhone(phone){
        var pattern = new RegExp(/^([0-9-]{8,18}$)/i);
        return pattern.test(phone);
    }

    function validUserName(user_name){
        var pattern = new RegExp(/^([a-z0-9_-]{2,18}$)/i);
        return pattern.test(user_name);
    }

    $('#add_prod').click(function(e){
        e.preventDefault();

        var name = $('#prod_name').val();
        var desc = $('#prod_desc').val();
        var price = $('#prod_price').val();
        var qty = $('#qty').val();
        var currency = $("#currency option:selected").text();

        var image = $('input[name=photo]')[0].files[0];
        var isValid_name = true;
        var isValid_desc = true;
        var isValid_price = true;
        var isValid_curr = true;
        var isValid = true;
        var isValid_qty = true;

        var allVals = [];



        $('input[name="category"]:checked').each(function() {
            allVals.push(this.value);
        });


        if(validQty(qty)){
            $('#qty').parent().removeClass('has-error');
            $('#qty').next('.help-block').hide();
            isValid_qty = true;

        }else{
            $('#qty').parent().addClass('has-error');
            $('#qty').next('.help-block').show();
            isValid_qty = false;

        }
        if(name && name.length > 2){
            $('#prod_name').parent().removeClass('has-error');
            $('#prod_name').next('.help-block').hide();
            isValid_name = true;
        }else{
            $('#prod_name').parent().addClass('has-error');
            $('#prod_name').next('.help-block').show();
            isValid_name = false;
        }
        if(desc && desc.length > 2){
            $('#prod_desc').parent().removeClass('has-error');
            $('#prod_desc').next('.help-block').hide();
            isValid_desc = true;
        }else{
            $('#prod_desc').parent().addClass('has-error');
            $('#prod_desc').next('.help-block').show();
            isValid_desc = false;
        }
        if(validPrice(price)){
            $('#prod_price').parent().removeClass('has-error');
            $('#prod_price').next('.help-block').hide();
            isValid_price = true;
        }else{
            $('#prod_price').parent().addClass('has-error');
            $('#prod_price').next('.help-block').show();
            isValid_price = false;
        }
        if(currency == 'EUR' || currency == 'USD' || currency == 'RUB'){
            $('#currency').parent().removeClass('has-error');
            $('#currency').next('.help-block').hide();
            isValid_curr = true;
        }else{
            $('#currency').parent().addClass('has-error');
            $('#currency').next('.help-block').show();
            isValid_curr = false;
        }
        if(image){
            $('#photo').parent().removeClass('has-error');
            $('#photo').next('.help-block').hide();
            isValid = true;
        }else{
            $('#photo').parent().addClass('has-error');
            $('#photo').next('.help-block').show();
            isValid = false;
        }


        if(isValid && isValid_curr && isValid_desc && isValid_name && isValid_price && isValid_qty){
            var product = null;
            var data = new FormData();

            data.append('photo', image);
            data.append('name', name);
            data.append('description', desc);
            data.append('price', price);
            data.append('qty', qty);
            data.append('currency', currency);
            allVals = JSON.stringify(allVals);
            data.append('category', allVals);

            $.ajax({
                type: "POST",
                url: "/add",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                success : function(data){
                    product = data;
                },
                async: false
                //dataType: "JSON"
            });
            if(product == 1){
                window.location.href = "/myproducts";
            }else{
                return false;
            }
        }else{
            console.log("false")
        }
    });

    function validPrice(price){
        var pattern = new RegExp(/^([0-9]{1,18}$)/i);
        return pattern.test(price);
    }

    $('#edit_prod').click(function(e){
        e.preventDefault();

        var name = $('#prod_name').val();
        var desc = $('#prod_desc').val();
        var price = $('#prod_price').val();
        var currency = $("#currency option:selected").text();
        var image = $('input[name=photo]')[0].files[0];
        var src = $('img')[0].src;
        var prod_id = $('#prod_id').val();
        var qty = $('#qty').val();
        var isValid_qty = true;
        var isValid_name = true;
        var isValid_desc = true;
        var isValid_price = true;
        var isValid_curr = true;
        var isValid = true;
        var allVals = [];

        $('input[name="category"]:checked').each(function() {
            allVals.push(this.value);
            //console.log(allVals);

        });

        if(validQty(qty)){
            $('#qty').parent().removeClass('has-error');
            $('#qty').next('.help-block').hide();
            isValid_qty = true;

        }else{
            $('#qty').parent().addClass('has-error');
            $('#qty').next('.help-block').show();
            isValid_qty = false;

        }
        if(name && name.length > 2){
            $('#prod_name').parent().removeClass('has-error');
            $('#prod_name').next('.help-block').hide();
            isValid_name = true;

        }else{
            $('#prod_name').parent().addClass('has-error');
            $('#prod_name').next('.help-block').show();
            isValid_name = false;

        }
        if(desc && desc.length > 2){
            $('#prod_desc').parent().removeClass('has-error');
            $('#prod_desc').next('.help-block').hide();
            isValid_desc = true;

        }else{
            $('#prod_desc').parent().addClass('has-error');
            $('#prod_desc').next('.help-block').show();
            isValid_desc = false;

        }
        if(validPrice(price)){
            $('#prod_price').parent().removeClass('has-error');
            $('#prod_price').next('.help-block').hide();
            isValid_price = true;

        }else{
            $('#prod_price').parent().addClass('has-error');
            $('#prod_price').next('.help-block').show();
            isValid_price = false;

        }


        if(currency == 'EUR' || currency == 'USD' || currency == 'RUB'){
            $('#currency').parent().removeClass('has-error');
            $('#currency').next('.help-block').hide();
            isValid_curr = true;
        }else{
            $('#currency').parent().addClass('has-error');
            $('#currency').next('.help-block').show();
            isValid_curr = false;
        }
        if(image){
            $('#photo').parent().removeClass('has-error');
            $('#photo').next('.help-block').hide();
            isValid = true;

        }else{
            if(src){
                $('#photo').parent().removeClass('has-error');
                $('#photo').next('.help-block').hide();
                isValid = true;
                image = src;
            }else{
                $('#photo').parent().addClass('has-error');
                $('#photo').next('.help-block').show();
                isValid = false;
            }

        }


        if(isValid && isValid_curr && isValid_desc && isValid_name && isValid_price && isValid_qty){
            var product = null;
            var data = new FormData();

            data.append('photo', image);
            data.append('name', name);
            data.append('description', desc);
            data.append('price', price);
            data.append('currency', currency);
            data.append('qty', qty);
            data.append('prod_id', prod_id);
            allVals = JSON.stringify(allVals);
            data.append('category', allVals);

            $.ajax({
                type: "POST",
                url: "/edit",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                success : function(data){
                    product = data;
                },
                async: false
                //dataType: "JSON"
            });
            if(product == 1){
                window.location.href = "/myproducts";
            }else{
                return false;
            }

        }else{
            console.log("false")
        }
    });

    $('.prod').on('change', function(e){
        e.preventDefault();
        var qty = $( this ).val();
        var validqty = true;
        var maxValue = $(this).map(function(){
            return this.max;
        }).get();
        var max = parseInt(maxValue[0]);
        //console.log(test);

        if(validQty(qty)){
            $(this).parent().removeClass('has-error');
            $(this).next('.help-block').hide();
            $(this).parent().nextAll().attr("disabled", false);
            $('#buy').attr("disabled", false);
            validqty = true;

            if(qty > max){
                $('#buy').attr("disabled", true);
                $(this).parent().addClass('has-error');
                $(this).siblings('.low').show();
                $(this).parent().nextAll().attr("disabled", true);
                validqty = false;
            }else{
                $('#buy').attr("disabled", false);
                $(this).parent().removeClass('has-error');
                $(this).siblings('.low').hide();
                $(this).parent().nextAll().attr("disabled", false);
                validqty = true;
            }
        }else{
            $('#buy').attr("disabled", true);
            $(this).parent().removeClass('has-error');
            $(this).siblings('.low').hide();
            $(this).parent().addClass('has-error');
            $(this).next('.help-block').show();
            $(this).parent().nextAll().attr("disabled", true);
            //$(this).parent().next('.buy_now').attr("disabled", true);
            validqty = false;
        }
        return validqty;
    })


});



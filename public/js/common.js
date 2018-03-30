
    // SideNav init
    $(".button-collapse").sideNav();

    // Custom scrollbar init
    var el = document.querySelector('.custom-scrollbar');
    Ps.initialize(el);

    new WOW().init();

    $('.mdb-select').material_select();


    
    $('[data-toggle="popover"]').popover({
      trigger: 'focus',
      html: true
    });
    $('.popover-dismiss').popover({
      trigger: 'focus'
    });


    $('.link2delete').click(function(){
        if ( !confirm('Удалить запись?') )
            return false;
    });

    $('.user-login-ldap-loader').blur(function(){
        var login = $(this).val();
        if (!login)
            return;

        $.ajaxSetup({timeout:5000}); //in milliseconds

        $('#loader').show();
        var form = $(this).parent().parent();
        $(form).find('*').attr('disabled',true);
        $.get('/admin/user-from-ldap/'+login,function(data){
            //alert(data);
            var user = JSON.parse(data);

            if (user.found == 0)
            {
                $('#Modal').find('.modal-title').text('Пользователь не найден');
                $('#Modal').find('.modal-body').text("Мы не смогли найти пользователя в Active Direcotry компании. :(  "+
                    "Если Вы так и задумывали, то это нестрашно, заполняйте поля формы вручную."+
                    "Иначе проверьте ввод логина. Удачи!");
                $('#Modal').modal();

            }
            else
            {
                toastr.success('Загружены данные из AD.');

                $('form #name').val(user.name);
                $('form label[for=name]').addClass('active');

                $('form #rusname').val(user.rusname);
                $('form label[for=rusname]').addClass('active');

                $('form #title').val(user.title);
                $('form label[for=title]').addClass('active');

                $('form #department').val(user.department);
                $('form label[for=department]').addClass('active');

                $('form #employeenumber').val(user.employeenumber);
                $('form label[for=employeenumber]').addClass('active');

                $('form #phone').val(user.phone);
                $('form label[for=phone]').addClass('active');

                $('form #avatar').val(user.avatar);
                $('form #imgavatar').attr('src',user.avatar);

            }
        })
        .done(function() {
            toastr.success('Успешно соединились с AD.');
            $('#loader').hide();
            $(form).find('*').attr('disabled',false);
        })
        .fail(function() {
            toastr.error('Ошибка соединения с AD. Попробуйте еще раз. Бывает..');
            $('#loader').hide();
            $(form).find('*').attr('disabled',false);
        });
    });

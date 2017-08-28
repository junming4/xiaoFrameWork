/**
 * 注册页
 */

$(function () {
    var $userNameObj = $("input[name='user_name']"); //用户名对象
    var $userEmObj = $userNameObj.parent('td').next('td').find('em');
    var $passwordObj = $("input[name='password']"); //密码对象
    var $passwordEmObj = $passwordObj.parent('td').next('td').find('em');
    var $rePasswordObj = $("input[name='rePassword']");//确认密码对象
    var $rePasswordEmObj = $rePasswordObj.parent('td').next('td').find('em');
    var $emailObj = $("input[name='email']"); //邮箱对象
    var $emailEmObj = $emailObj.parent('td').next('td').find('em');

    //输入绑定
    $userNameObj.bind('input propertychange',function(){
        checkUserName();
    });
    //绑定失去焦点时
    $userNameObj.blur(function () {
        checkAjaxName();

    });
    //密码输入校验
    $passwordObj.bind('input propertychange',function () {
        checkPassword();
    });

    //确认密码校验
    $rePasswordObj.bind('input propertychange',function () {
        checkRePassword();
    });

    //邮箱验证
    $emailObj.bind('input propertychange',function (){
        checkMail();
    });


    //用户名
    function checkUserName() {
        var userName = $userNameObj.val();
        var userNameLength = userName.length;
        $userEmObj.addClass('hide');
        if(userNameLength < 4){
            $userEmObj.removeClass('hide');
            $userEmObj.text("用户名不能少于4个字！");
            return false;
        }
        if(userNameLength >25){
            $userEmObj.removeClass('hide');
            $userEmObj.text("用户名不能大于25个字！");
            return false;
        }
    }

    function checkAjaxName(){
        var $url = 'index.php?m=user&a=checkUserName';
        $.ajax({
            type: "POST",
            url: $url,
            dataType: 'json',
            async : false,
            data: {'user_name': $userNameObj.val()},
            success: function(data){
                if(data.code != 1){
                    $userEmObj.removeClass('hide');
                    $userEmObj.text(data.msg);
                    return false;
                }
            },
            error:function (msg) {
                alert("网络异常！");
                console.log(msg);
            }
        });
    }

    function checkPassword() {
        var password = $passwordObj.val();
        var passwordLength = password.length;

        $passwordEmObj.addClass('hide');
        if(passwordLength < 6){
            $passwordEmObj.removeClass('hide');
            $passwordEmObj.text("密码长度不能少于6个字！");
            return false;
        }
        if(passwordLength >20){
            $passwordEmObj.removeClass('hide');
            $passwordEmObj.text("密码长度不能大于20个字！");
            return false;
        }
    }

    function checkRePassword() {
        var rePassword = $rePasswordObj.val();
        $rePasswordEmObj.addClass('hide');
        if(rePassword !== $passwordObj.val()){
            $rePasswordEmObj.removeClass('hide');
            $rePasswordEmObj.text("两次密码不相同！");
            return false;
        }
    }


    function checkMail() {
        var mail = $emailObj.val();
        $emailEmObj.addClass('hide');
        var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(mail)){
            //非法邮箱mail
            $emailEmObj.removeClass('hide');
            $emailEmObj.text("邮箱格式不正确！");
            return false;
        }
        $emailEmObj.removeClass('hide');
        $emailEmObj.text('');
        //ajax 进行测试
        var $url = 'index.php?m=user&a=checkEmail';
        $.ajax({
            type: "POST",
            url: $url,
            dataType: 'json',
            async : false,
            data: {'email': $emailObj.val()},
            success: function(data){
                if(data.code != 1){
                    $emailEmObj.removeClass('hide');
                    $emailEmObj.text(data.msg);
                    return false;
                }else{
                    $emailEmObj.addClass('hide');
                }
            },
            error: function (msg) {
                alert("网络异常！");
                console.log(msg);
            }
        });

    }


    //提交表单
    $("#submitReg").click(function () {
        checkUserName();
        checkAjaxName();
        checkPassword();
        checkRePassword();
        checkMail();


        var hideCount = $(".main td .hide").length;

        console.log(hideCount);
        //return false;



        if(hideCount !== 4) {
            alert("请把资料填写完整再提交！");
            return false;
        }

        $(".is_accept").attr("checked", true);

        $("#regForm").submit();

    });

});

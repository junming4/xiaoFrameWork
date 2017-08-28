/**
 * 用户修改js
 */
$(function () {
    laydate({
        elem: '#birth'
    })
});

var config = {
    province: '#province',
    city: "#city"
};
city_selector(config);
$(function(){
    city_selector();
});

$(function () {
    $("#submitReg").click(function () {

        var $id = parseInt($("#user_id").val());
        var $url = "index.php?m=user&a=update&user_id="+$id;

        var $nickNameObj = $("input[name='nick_name']");
        var $realnameObj = $("input[name='real_name']");
        var $sex = $("input[name='sex']:checked").val();

        //地区获取
        var $provinceObj = $("#province").val();
        var $cityObj = $('#city').val();
        var $birth = $("#birth").val();
        var $hobbyLength = $('input[name="hobby"]:checked').length;

        if($nickNameObj.val().length <1){
            alert("昵称不能为空！");
            return false;
        }
        if($realnameObj.val().length <1){
            alert("真实姓名不能为空！");
            return false;
        }

        if($hobbyLength <1) {
            alert("请选中爱好！");
            return false;
        }
        if($provinceObj.length <1){
            alert("请选中省！");
            return false;
        }
        if($cityObj.length <1){
            alert("请选中市！");
            return false;
        }
        if($birth.length <1){
            alert("生日不能为空！");
            return false;
        }

        var $hobby = [];
        $('input[name="hobby"]:checked').each(function(){
            $hobby.push($(this).val());
        });

        var $data = {'nick_name': $nickNameObj.val(),'real_name': $realnameObj.val(), 'sex': $sex,
                'province': $provinceObj,'city': $cityObj, 'birthday': $birth, 'hobby': $hobby};


        $.ajax({
            type: "POST",
            url: $url,
            dataType: 'json',
            data: $data,
            success: function(data){
                if(data.code == 1){
                    alert(data.msg);
                    return false;
                }else{
                    alert(data.msg);
                    window.onload();
                }
            },
            error:function (msg) {
                alert("网络异常！");
                console.log(msg);
            }
        })

    });
});





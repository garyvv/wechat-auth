<script language="javascript" type="text/javascript">
    if(window.localStorage){
//    	alert('This browser supports localStorage');
        localStorage.setItem("token", "{!! $token !!}");
        localStorage.setItem("is_boss", "{!! $is_boss !!}");
        localStorage.setItem("userId", "{!! $userId !!}");
        localStorage.setItem("wechatInfo", '{!! $jsonUser !!}');
        window.location.href="{!! $url !!}";
    }else{
    	alert('This browser does NOT support localStorage');
    }
</script>

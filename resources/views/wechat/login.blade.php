<script language="javascript" type="text/javascript">
    if(window.localStorage){
//    	alert('This browser supports localStorage');
        localStorage.setItem("token", "{!! $token !!}");
        localStorage.setItem("userId", "{!! $userId !!}");
        window.location.href="{!! $url !!}";
    }else{
    	alert('This browser does NOT support localStorage');
    }
</script>

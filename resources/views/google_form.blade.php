{{--<div class="box">--}}
{{--    <iframe id="IframeId" src="https://docs.google.com/forms/d/e/1FAIpQLScMkP6aX_2l03_6dcOr83ykBJjk0LlAFQ9SZmu-zUSLsKGvLA/viewform?embedded=true" width="640" height="959" frameborder="0" marginheight="0" marginwidth="0">Đang tải…</iframe>--}}
{{--</div>--}}

{{--<div class="form">--}}
{{--    form thanh toán--}}
{{--</div>--}}


<!DOCTYPE html>
<html>
<head>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
</head>
<body>

<iframe src="https://docs.google.com/forms/d/e/1FAIpQLScMkP6aX_2l03_6dcOr83ykBJjk0LlAFQ9SZmu-zUSLsKGvLA/viewform?embedded=true" width="640" height="827" frameborder="0" marginheight="0" marginwidth="0">Đang tải…</iframe>

<iframe src="https://docs.google.com/forms/d/e/1FAIpQLScMkP6aX_2l03_6dcOr83ykBJjk0LlAFQ9SZmu-zUSLsKGvLA/viewform?embedded=true" width="640" height="827" frameborder="0" marginheight="0" marginwidth="0">Đang tải…</iframe>

<script>
    var iframe = document.getElementById('googleFormIframe');
    const st = console.log(iframe.contentWindow.location);

    setInterval(function() {
        var iframe = document.getElementById('googleFormIframe');

        // Kiểm tra xem iframe đã điều hướng đến trang cảm ơn (hoặc URL khác)
        if (iframe.contentWindow.location.href.includes('your_redirect_url')) {
            console.log('Form đã được submit!');
        }
    }, 1000); // Kiểm tra mỗi giây một lần
</script>

</body>
</html>

<script src="/webcam.js"></script>

    <div id="my_camera" style="width:100px; height:100px;"></div>
    <div id="my_result"></div>
    <div id="my_resulturl"></div>

    <script language="JavaScript">
        Webcam.attach( '#my_camera' );

        function take_snapshot() {
            Webcam.snap( function(data_uri) {
                document.getElementById('my_result').innerHTML = '<img src="'+data_uri+'"/>';
                document.getElementById('my_resulturl').innerHTML = data_uri;
            } );
        }
</script>

<a href="javascript:void(take_snapshot())">Take Snapshot</a>
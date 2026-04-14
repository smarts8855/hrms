<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* simple sizing */
    .capture-box {
        border: 1px solid #ddd;
        padding: 8px;
        display: inline-block;
        margin-right: 10px;
    }

    .preview-img {
        width: 140px;
        height: 170px;
        object-fit: cover;
        border: 1px solid #ccc;
        display: block;
        margin-bottom: 6px;
    }

    .sig-canvas {
        border: 1px solid #ccc;
        width: 320px;
        height: 120px;
        touch-action: none;
    }

    .small-btn {
        margin-right: 6px;
    }
</style>
<form action="{{ url('/documentation-passport-signature') }}" enctype="multipart/form-data" method="POST">
    {{ csrf_field() }}
    <div class="tab-pane" role="tabpanel" id="step2">
        <div class="col-md-offset-0">
            <h3 class="text-success text-center">
                <i class="glyphicon glyphicon-camera"></i> <b>Passport And Signature</b>
            </h3>
            <div class="text-danger" align="right" style="margin-top: -35px;">
                Field with <span class="text-danger"><big>*</big></span> is required
            </div>
        </div>
        <br />

    </div>
    <div class="row col-md-offset-1">

        <!-- Passport: first row; capture (left) and preview/upload (right) -->
        <div class="row" style="margin-bottom:15px;">
            <div class="col-md-12">
                <h4>Passport</h4>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Capture area -->
                        <div class="capture-box" style="width:100%;">
                            <video id="passportVideo" width="100%" height="240" autoplay
                                style="display:none;border:1px solid #ccc;"></video>
                            <div style="margin-top:8px;">
                                <button type="button" id="startCam" class="btn btn-default small-btn">Open
                                    Camera</button>
                                <button type="button" id="snap" class="btn btn-primary small-btn"
                                    disabled>Capture</button>
                                <button type="button" id="stopCam" class="btn btn-warning small-btn"
                                    disabled>Close</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="capture-box" 
                        {{-- style="width:100%;" --}}
                        >
                            <div class="text-center mb-2">
                                @if (isset($passportPreviewUrl) && !empty($passportPreviewUrl))
                                    <small class="text-success">Current passport photo</small>
                                @else
                                    <small class="text-muted">No passport photo uploaded yet</small>
                                @endif
                            </div>
                            <img id="passportPreview" class="preview-img"
                                src="{{ !empty($passportPreviewUrl) ? asset($passportPreviewUrl) : '' }}"
                                alt="Passport preview"
                                style="width:100%;height:auto;max-height:240px;object-fit:cover;">
                            <div style="margin-top:8px;">
                                <input type="file" id="passportFile" name="passport_file" accept="image/*">
                                <input type="hidden" id="passport_data" name="passport_data" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Signature: second row; canvas (left) and preview/upload (right) -->
        <div class="row" style="margin-top:10px;">
            <div class="col-md-12">
                <h4>Signature</h4>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Canvas & controls -->
                        <div class="capture-box" style="width:100%;">
                            <canvas id="sigCanvas" class="sig-canvas" style="width:100%;height:160px;"></canvas>
                            <div style="margin-top:8px;">
                                <button type="button" id="sigClear" class="btn btn-default small-btn">Clear</button>
                                <button type="button" id="sigSave" class="btn btn-success small-btn">Save</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="capture-box" style="width:100%;">
                            <div class="text-center mb-2">
                                @if (isset($signaturePreviewUrl) && !empty($signaturePreviewUrl))
                                    <small class="text-success">Current signature</small>
                                @else
                                    <small class="text-muted">No signature uploaded yet</small>
                                @endif
                            </div>
                            <img id="signaturePreview" class="preview-img"
                                src="{{ !empty($signaturePreviewUrl) ? asset($signaturePreviewUrl) : '' }}"
                                alt="Signature preview"
                                style="width:100%;height:auto;max-height:160px;object-fit:contain;">
                            <div style="margin-top:8px;">
                                <label>Or upload signature image</label>
                                <input type="file" id="signatureFile" name="signature_file" accept="image/*">
                                <input type="hidden" id="signature_data" name="signature_data" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    </p>
    </p>
    <hr />
    <div align="center">
        <ul class="list-inline">

            <li>
            <li><a href="{{ url('/documentation-account') }}" class="btn btn-default">Previous</a></li>
            <button type="submit" class="btn btn-primary">Save and continue</button><!--next-step-->
            </li>
        </ul>
    </div>
    </div>
</form>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>

<script>
    $(document).ready(function() {

        $("#department").change(function(e) {

            //console.log(e);
            var dept_id = e.target.value;
            // var state_id = $(this).val();

            //alert(dept_id);
            //$token = $("input[name='_token']").val();
            //ajax
            $.get('get-designation?dept_id=' + dept_id, function(data) {
                $('#designation').empty();
                //console.log(data);
                //$('#lga').append( '<option value="">Select</option>' );
                $.each(data, function(index, obj) {
                    $('#designation').append('<option value="' + obj.id + '">' + obj
                        .designation + '</option>');
                });


            })
        });


    });
</script>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(
            "input[type='date'], #dob, #dob2, #presentAppointment1, #presentAppointment2, #firstAppointment1, #firstAppointment2", {
                dateFormat: "Y-m-d",
                allowInput: true,
                altInput: true,
                altFormat: "F j, Y",
                maxDate: "today",
                yearSelectorType: "scroll",
            });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    (function() {
        // ===== Passport camera =====
        let video = document.getElementById('passportVideo');
        let startCam = document.getElementById('startCam');
        let snapBtn = document.getElementById('snap');
        let stopCam = document.getElementById('stopCam');
        let passportPreview = document.getElementById('passportPreview');
        let passportFile = document.getElementById('passportFile');
        let passportHidden = document.getElementById('passport_data');
        let streamRef = null;

        startCam.addEventListener('click', async function() {
            try {
                streamRef = await navigator.mediaDevices.getUserMedia({
                    video: {
                        width: 640,
                        height: 480
                    }
                });
                video.srcObject = streamRef;
                video.style.display = 'block';
                snapBtn.disabled = false;
                stopCam.disabled = false;
                startCam.disabled = true;
            } catch (err) {
                alert('Could not access camera: ' + err.message);
            }
        });

        snapBtn.addEventListener('click', function() {
            let canvas = document.createElement('canvas');
            canvas.width = video.videoWidth || 640;
            canvas.height = video.videoHeight || 480;
            let ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            let dataUrl = canvas.toDataURL('image/jpeg', 0.9);
            passportPreview.src = dataUrl;
            passportHidden.value = dataUrl; // base64 for server if you prefer
            // clear file input if image taken by camera
            passportFile.value = '';
        });

        stopCam.addEventListener('click', function() {
            if (streamRef) {
                streamRef.getTracks().forEach(t => t.stop());
                streamRef = null;
            }
            video.style.display = 'none';
            snapBtn.disabled = true;
            stopCam.disabled = true;
            startCam.disabled = false;
        });

        passportFile.addEventListener('change', function(e) {
            let f = e.target.files[0];
            if (!f) return;
            let reader = new FileReader();
            reader.onload = function(ev) {
                passportPreview.src = ev.target.result;
                passportHidden.value = ''; // prefer uploaded file; clear base64
                // if you want to also store base64, set passportHidden.value = ev.target.result;
            };
            reader.readAsDataURL(f);
            // stop camera if running
            if (streamRef) stopCam.click();
        });

        // ===== Signature pad =====
        const canvas = document.getElementById('sigCanvas');
        // resize for device pixel ratio
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext('2d').scale(ratio, ratio);
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255,255,255,0)',
            penColor: 'black'
        });

        document.getElementById('sigClear').addEventListener('click', function() {
            signaturePad.clear();
            document.getElementById('signature_data').value = '';
            document.getElementById('signaturePreview').src = '';
            document.getElementById('signatureFile').value = '';
        });

        document.getElementById('sigSave').addEventListener('click', function() {
            if (signaturePad.isEmpty()) {
                alert('Please provide a signature first.');
                return;
            }
            const dataUrl = signaturePad.toDataURL('image/png');
            document.getElementById('signature_data').value = dataUrl;
            document.getElementById('signaturePreview').src = dataUrl;
            // clear uploaded file selection, uploaded file will be preferred by server if present
            document.getElementById('signatureFile').value = '';
        });

        document.getElementById('signatureFile').addEventListener('change', function(e) {
            const f = e.target.files[0];
            if (!f) return;
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('signaturePreview').src = ev.target.result;
                document.getElementById('signature_data').value = ''; // prefer file upload
                signaturePad.clear();
            };
            reader.readAsDataURL(f);
        });

        // On form submit: if passport_data or signature_data are base64 and files empty, they will be sent as hidden inputs.
        // Server-side: prefer uploaded file if present; else if hidden base64 provided, decode and save.
        document.querySelector("form[action='{{ url('/documentation-basic-infox') }}']").addEventListener('submit',
            function() {
                // nothing extra required here; hidden inputs already set when user captures/saves.
                // Optional: trim whitespace
            });

    })();
</script>

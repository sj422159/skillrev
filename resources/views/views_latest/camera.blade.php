@extends('views_latest.new_index')

@section('camera')

<img id="video_feed" style="width:100%;height:auto;">
    <script>
        const video = document.getElementById('video_feed');

        // Use the getUserMedia API to access the camera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                video.srcObject = stream;
            })
            .catch((error) => {
                console.error('Error accessing the camera:', error);
            });
    </script>
@endsection

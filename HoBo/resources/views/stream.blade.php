<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$serie->SerieTitel}}</title>
    <link rel="icon" type="image/x-icon" href="../img/HOBO_beeldmerk.png">
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body id="stream-body">
    @if ($serie->trailerVideo == null)
        <iframe width="100%" height="auto" src="https://www.youtube.com/embed/2VzzsLyWWLo?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <a href="/filminfo/{{ $serie->SerieID }}">
            <button>
                <img src="../img/left-chevron.png" alt="">
            </button>
        </a>
    @else
    <iframe width="100%" height="auto" src="{{$serie->trailerVideo}}?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    <a href="/filminfo/{{ $serie->SerieID }}">
        <button>
            <img src="../img/left-chevron.png" alt="">
        </button>
    </a>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var startTime = new Date().getTime();

            window.addEventListener('beforeunload', function () {
                var endTime = new Date().getTime();
                var watchtime = Math.floor((endTime - startTime) / 1000);
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('/update-watchtime', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ watchtime: watchtime })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error sending watchtime: ' + response.status);
                    }
                    console.log('Watchtime sent successfully');
                })
                .catch(error => {
                    console.error('Error sending watchtime:', error);
                });
            });
        });
    </script>
</body>
</html>
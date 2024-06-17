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
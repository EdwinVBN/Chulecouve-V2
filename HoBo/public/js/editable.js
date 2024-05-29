// Extract the KlantNr from the URL path
const urlParts = window.location.pathname.split('/');
const klantNr = urlParts.pop();
console.log('KlantNr:', klantNr);

document.querySelectorAll('.editable').forEach(function(element) {
    element.addEventListener('dblclick', function() {
        var text = this.innerText;
        this.innerHTML = '<input type="text" class="nice-input" value="' + text + '">';
        this.querySelector('input').focus();
    });

    element.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            var input = this.querySelector('input');
            var text = input.value;
            this.innerHTML = text;

            // Make a POST request to update the data on the server
            fetch('/update-user-data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    'klantNr': klantNr,
                    'field': this.id,
                    'value': text
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // If the update was successful, refresh the page
                    location.reload();
                } else {
                    // If the update failed, display an error message
                    if (data.errors) {
                        // Handle validation errors
                        let errorMessage = '';
                        for (const field in data.errors) {
                            errorMessage += `${field}: ${data.errors[field].join(', ')}\n`;
                        }
                        alert(errorMessage);
                    } else {
                        // Handle other errors
                        alert('An error occurred: ' + data.error);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred. Please try again later.');
            });
        }
    });
});
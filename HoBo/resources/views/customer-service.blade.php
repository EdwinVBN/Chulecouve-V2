<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Service</title>
    <link rel="stylesheet" href="{{ asset('SCSS/styles.css') }}">
</head>
<body id="home-body">
    @include('header')

    <div class="container">
        <h1><i class="fas fa-headset"></i> Customer Service</h1>
        <div id="chat-container" class="chat-container">
        </div>
        <div class="input-group">
            <input type="text" id="question" class="form-control" placeholder="Ask a question...">
            <button id="send-btn" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send</button>
        </div>
        <div id="typing-indicator" class="typing-indicator" style="display: none;">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <script>
        document.getElementById('send-btn').addEventListener('click', function() {
            var question = document.getElementById('question').value;
            if (question.trim() !== '') {
                displayUserMessage(question);
                document.getElementById('question').value = '';
                showTypingIndicator();
                sendQuestion(question);
            }
        });

        function sendQuestion(question) {
            showTypingIndicator();

            // Send the question to the server via AJAX
            fetch('/customer-service/request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ question: question })
            })
            .then(response => response.json())
            .then(data => {
                hideTypingIndicator();
                displayAssistantMessage(data.response);
            })
            .catch(error => {
                hideTypingIndicator();
                console.error('Error:', error);
            });
        }

        function displayUserMessage(message) {
            var chatContainer = document.getElementById('chat-container');
            var messageElement = document.createElement('div');
            messageElement.classList.add('chat-message', 'user-message');
            messageElement.textContent = message;
            chatContainer.appendChild(messageElement);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function displayAssistantMessage(response) {
            var chatContainer = document.getElementById('chat-container');
            var messageElement = document.createElement('div');
            messageElement.classList.add('chat-message', 'assistant-message');

            var avatarElement = document.createElement('img');
            avatarElement.src = '{{ asset("img/robot-avatar.jpg") }}';
            avatarElement.alt = 'AI Avatar';
            avatarElement.classList.add('avatar');

            var textElement = document.createElement('div');
            textElement.textContent = response;

            messageElement.appendChild(avatarElement);
            messageElement.appendChild(textElement);

            chatContainer.appendChild(messageElement);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function showTypingIndicator() {
            var typingIndicator = document.getElementById('typing-indicator');
            typingIndicator.style.display = 'flex';
        }

        function hideTypingIndicator() {
            var typingIndicator = document.getElementById('typing-indicator');
            typingIndicator.style.display = 'none';
        }
    </script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>
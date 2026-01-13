<!-- Chatbot Widget CSS and HTML -->
<style>
    /* Chatbot Widget Styles */
    .chatbot-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .chatbot-toggle-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #5ed154 100%);
        color: white;
        border: none;
        cursor: pointer;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .chatbot-toggle-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .chatbot-toggle-btn.active {
        background: linear-gradient(135deg, #5ed154 0%, #667eea 100%);
    }

    .chatbot-window {
        position: absolute;
        bottom: 80px;
        right: 0;
        width: 380px;
        height: 460px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 40px rgba(0, 0, 0, 0.16);
        display: none;
        flex-direction: column;
        overflow: hidden;
        animation: slideUp 0.3s ease-out;
    }

    .chatbot-window.active {
        display: flex;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chatbot-header {
        background: linear-gradient(135deg, #667eea 0%, #5ed154 100%);
        color: white;
        padding: 20px;
        text-align: center;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chatbot-header h3 {
        margin: 0;
        font-size: 18px;
        flex: 1;
    }

    .chatbot-header-buttons {
        display: flex;
        gap: 10px;
    }

    .chatbot-header-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .chatbot-header-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .chatbot-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: #f7f7f7;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .chat-message {
        display: flex;
        margin-bottom: 12px;
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chat-message.user {
        justify-content: flex-end;
    }

    .message-content {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 12px;
        word-wrap: break-word;
        line-height: 1.4;
        font-size: 14px;
    }

    .message-content.bot {
        background: white;
        border: 1px solid #e0e0e0;
        color: #333;
    }

    .message-content.user {
        background: linear-gradient(135deg, #667eea 0%, #5ed154 100%);
        color: white;
    }

    .message-time {
        font-size: 12px;
        color: #999;
        margin-top: 4px;
        padding: 0 8px;
        display: none;
    }

    .chatbot-input-area {
        padding: 15px;
        background: white;
        border-top: 1px solid #e0e0e0;
        display: flex;
        gap: 10px;
    }

    .chatbot-input {
        flex: 1;
        border: 1px solid #ddd;
        border-radius: 24px;
        padding: 10px 16px;
        font-size: 14px;
        font-family: inherit;
        outline: none;
        transition: border-color 0.3s;
    }

    .chatbot-input:focus {
        border-color: #667eea;
    }

    .chatbot-send-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #5ed154 100%);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .chatbot-send-btn:hover {
        transform: scale(1.05);
    }

    .chatbot-send-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .chatbot-empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #999;
        text-align: center;
    }

    .chatbot-empty-state-icon {
        font-size: 48px;
        margin-bottom: 12px;
    }

    .chatbot-empty-state-text {
        font-size: 14px;
    }

    .loading-dots {
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .loading-dots span {
        width: 8px;
        height: 8px;
        background: #667eea;
        border-radius: 50%;
        animation: bounce 1.4s infinite;
    }

    .loading-dots span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .loading-dots span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes bounce {
        0%, 80%, 100% {
            opacity: 0.5;
        }
        40% {
            opacity: 1;
        }
    }

    /* Responsive */
    @media (max-width: 480px) {
        .chatbot-window {
            width: calc(100vw - 40px);
            height: 70vh;
            max-height: 600px;
        }
    }
</style>

<!-- Chatbot HTML -->
<div class="chatbot-container">
    <!-- Toggle Button -->
    <button class="chatbot-toggle-btn" id="chatbot-toggle" title="Open Chat">
        <i class="fas fa-comments"></i>
    </button>

    <!-- Chat Window -->
    <div class="chatbot-window" id="chatbot-window">
        <!-- Header -->
        <div class="chatbot-header">
            <h3>JobVerseBD Assistant</h3>
            <div class="chatbot-header-buttons">
                <button class="chatbot-header-btn" id="chatbot-clear" title="Clear Chat">
                    <i class="fas fa-redo"></i>
                </button>
                <button class="chatbot-header-btn" id="chatbot-close" title="Close Chat">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="chatbot-messages" id="chatbot-messages">
            <div class="chatbot-empty-state">
                <div class="chatbot-empty-state-icon">💬</div>
                <div class="chatbot-empty-state-text">
                    <p><strong>Hi there! 👋</strong></p>
                    <p>How can I assist you today?</p>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="chatbot-input-area">
            <input 
                type="text" 
                class="chatbot-input" 
                id="chatbot-input" 
                placeholder="Type your message..." 
                autocomplete="off"
            >
            <button class="chatbot-send-btn" id="chatbot-send">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<!-- Chatbot JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatbotToggle = document.getElementById('chatbot-toggle');
    const chatbotWindow = document.getElementById('chatbot-window');
    const chatbotClose = document.getElementById('chatbot-close');
    const chatbotClear = document.getElementById('chatbot-clear');
    const chatbotInput = document.getElementById('chatbot-input');
    const chatbotSend = document.getElementById('chatbot-send');
    const chatbotMessages = document.getElementById('chatbot-messages');
    let isMessageEmpty = true;

    // Toggle chatbot window
    chatbotToggle.addEventListener('click', function() {
        chatbotWindow.classList.toggle('active');
        chatbotToggle.classList.toggle('active');
        if (chatbotWindow.classList.contains('active')) {
            chatbotInput.focus();
        }
    });

    // Close chatbot window
    chatbotClose.addEventListener('click', function() {
        chatbotWindow.classList.remove('active');
        chatbotToggle.classList.remove('active');
    });

    // Clear chat history
    chatbotClear.addEventListener('click', function() {
        if (confirm('Are you sure you want to clear the chat history?')) {
            fetch('chatbot_api.php?action=clear_history', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    chatbotMessages.innerHTML = `
                        <div class="chatbot-empty-state">
                            <div class="chatbot-empty-state-icon">💬</div>
                            <div class="chatbot-empty-state-text">
                                <p><strong>Hi there! 👋</strong></p>
                                <p>How can I assist you today?</p>
                            </div>
                        </div>
                    `;
                }
            });
        }
    });

    // Send message
    function sendMessage() {
        const message = chatbotInput.value.trim();
        if (!message) return;

        // Clear empty state if needed
        if (isMessageEmpty) {
            chatbotMessages.innerHTML = '';
            isMessageEmpty = false;
        }

        // Add user message to chat
        addMessageToChat(message, 'user');
        chatbotInput.value = '';
        chatbotInput.focus();

        // Show loading indicator
        showLoadingIndicator();

        // Send message to API
        fetch('chatbot_api.php?action=send_message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            removeLoadingIndicator();
            if (data.success) {
                addMessageToChat(data.response, 'bot', data.timestamp);
            }
        })
        .catch(error => {
            removeLoadingIndicator();
            addMessageToChat('Sorry, I encountered an error. Please try again.', 'bot');
        });
    }

    // Send button click
    chatbotSend.addEventListener('click', sendMessage);

    // Send on Enter key
    chatbotInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Add message to chat
    function addMessageToChat(message, sender, time = '') {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${sender}`;
        
        const contentDiv = document.createElement('div');
        contentDiv.className = `message-content ${sender}`;
        
        // Process message for line breaks
        message = message.replace(/\n/g, '<br>');
        contentDiv.innerHTML = message;
        
        messageDiv.appendChild(contentDiv);
        
        if (time) {
            const timeDiv = document.createElement('div');
            timeDiv.className = 'message-time';
            timeDiv.textContent = time;
            messageDiv.appendChild(timeDiv);
        }
        
        chatbotMessages.appendChild(messageDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    // Show loading indicator
    function showLoadingIndicator() {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'chat-message';
        messageDiv.id = 'loading-indicator';
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content bot';
        contentDiv.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div>';
        
        messageDiv.appendChild(contentDiv);
        chatbotMessages.appendChild(messageDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    // Remove loading indicator
    function removeLoadingIndicator() {
        const loader = document.getElementById('loading-indicator');
        if (loader) {
            loader.remove();
        }
    }
});
</script>

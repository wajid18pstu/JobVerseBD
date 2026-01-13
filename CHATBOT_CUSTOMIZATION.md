# 🎨 Chatbot Customization Examples

This file contains ready-to-use code snippets for common chatbot customizations.

## 1. Change Chatbot Colors to Match Your Brand

Edit `chatbot_widget.php` and find the CSS section. Replace the gradient colors:

**Current (Purple):**
```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

**Option A: Blue Theme**
```css
background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
```

**Option B: Green Theme**
```css
background: linear-gradient(135deg, #00c853 0%, #1de9b6 100%);
```

**Option C: Orange Theme**
```css
background: linear-gradient(135deg, #ff9800 0%, #ff6f00 100%);
```

**Option D: Red Theme**
```css
background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
```

## 2. Change Chatbot Position

Edit `chatbot_widget.php` CSS section:

**Bottom-Right (Default):**
```css
.chatbot-container {
    bottom: 20px;
    right: 20px;
}
```

**Bottom-Left:**
```css
.chatbot-container {
    bottom: 20px;
    left: 20px;
}
```

**Top-Right:**
```css
.chatbot-container {
    top: 20px;
    right: 20px;
}
```

**Top-Left:**
```css
.chatbot-container {
    top: 20px;
    left: 20px;
}
```

## 3. Customize Welcome Message

Edit `chatbot_widget.php`, find this section:

**Current:**
```html
<div class="chatbot-empty-state-text">
    <p><strong>Hi there! 👋</strong></p>
    <p>How can I assist you today?</p>
</div>
```

**Customize to:**
```html
<div class="chatbot-empty-state-text">
    <p><strong>Welcome to JobVerseBD! 🎉</strong></p>
    <p>I'm here to help with any questions about jobs, applications, or our platform.</p>
    <p>What can I help you with?</p>
</div>
```

## 4. Add Custom Keyword Responses

Edit `chatbot_api.php`, find the `getKeywordBasedResponse()` function and add new patterns:

```php
// Add this after existing keyword blocks

// Pricing/Cost keywords
if (preg_match('/\b(price|cost|fee|charge|premium)\b/i', $message)) {
    return "📊 Our pricing information:\n\n• Free Account: Full access to all jobs\n• Premium Seeker: $9.99/month - Priority support\n• Employer Basic: $49.99/month - Post 5 jobs\n• Employer Plus: $99.99/month - Unlimited posts\n\nWould you like more details?";
}

// Verification keywords
if (preg_match('/\b(verify|verification|email verification)\b/i', $message)) {
    return "✅ Email Verification Steps:\n\n1. Check your email inbox\n2. Look for verification email\n3. Click the verification link\n4. Your account is verified!\n\nNot receiving the email? Check spam folder or request a new link.";
}

// Interview keywords
if (preg_match('/\b(interview|schedule|meeting)\b/i', $message)) {
    return "📅 Interview Process:\n\n• Employer reviews application\n• You receive interview invitation\n• Schedule convenient time\n• Video/Phone interview conducted\n• Receive feedback\n\nCheck 'My Applications' for updates!";
}
```

## 5. Add Custom Category-Based FAQ

Insert into database:

```sql
INSERT INTO chatbot_faqs (question, answer, category, keywords, is_active) VALUES
('What are your company values?', 
'JobVerseBD is committed to connecting quality talent with excellent opportunities. We value integrity, innovation, and inclusivity in the job market.', 
'Company Info', 
'values, company, mission, culture', 
TRUE);

INSERT INTO chatbot_faqs (question, answer, category, keywords, is_active) VALUES
('How do I report inappropriate content?', 
'If you encounter inappropriate content or behavior, please report it immediately by:\n1. Clicking the report button\n2. Contacting our support team\n3. Emailing admin@jobversebd.com\n\nWe take safety seriously.', 
'Safety', 
'report, inappropriate, abuse, harassment, safety', 
TRUE);

INSERT INTO chatbot_faqs (question, answer, category, keywords, is_active) VALUES
('What are the system requirements?', 
'JobVerseBD works on:\n• Any modern web browser (Chrome, Firefox, Safari, Edge)\n• Desktop, tablet, or mobile devices\n• No software installation needed\n• Internet connection required\n\nBrowser must have JavaScript enabled.', 
'Technical', 
'system, requirements, browser, device, support', 
TRUE);
```

## 6. Change Chatbot Title

Edit `chatbot_widget.php`, find:

**Current:**
```html
<h3>JobVerse Assistant</h3>
```

**Change to any of these:**
```html
<h3>JobVerse Help Center</h3>
<!-- or -->
<h3>Support Bot</h3>
<!-- or -->
<h3>Your AI Assistant</h3>
<!-- or -->
<h3>Help & Support</h3>
```

## 7. Customize Input Placeholder

Edit `chatbot_widget.php`, find:

**Current:**
```html
<input 
    ...
    placeholder="Type your message..." 
    ...
>
```

**Change to:**
```html
<input 
    ...
    placeholder="Ask me anything about JobVerseBD..." 
    ...
>
```

## 8. Change Chatbot Size

Edit CSS in `chatbot_widget.php`:

**Current Size:**
```css
.chatbot-window {
    width: 380px;
    height: 550px;
}
```

**Make Smaller (Compact):**
```css
.chatbot-window {
    width: 300px;
    height: 400px;
}
```

**Make Larger (Expanded):**
```css
.chatbot-window {
    width: 450px;
    height: 650px;
}
```

## 9. Add Custom Loading Message

Edit `chatbot_api.php`, modify the `showLoadingIndicator()` function to include custom text:

```javascript
function showLoadingIndicator() {
    const messageDiv = document.createElement('div');
    messageDiv.className = 'chat-message';
    messageDiv.id = 'loading-indicator';
    
    const contentDiv = document.createElement('div');
    contentDiv.className = 'message-content bot';
    contentDiv.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div><small>Thinking...</small>';
    
    messageDiv.appendChild(contentDiv);
    chatbotMessages.appendChild(messageDiv);
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
}
```

## 10. Enable Debug Mode (For Development)

Add to `chatbot_api.php` at the top:

```php
// Debug mode - logs all messages to a file
define('CHATBOT_DEBUG', true);
define('DEBUG_LOG_FILE', __DIR__ . '/chatbot_debug.log');

if (CHATBOT_DEBUG) {
    $debug_msg = date('Y-m-d H:i:s') . " - Action: $action - Message: $user_message\n";
    file_put_contents(DEBUG_LOG_FILE, $debug_msg, FILE_APPEND);
}
```

## 11. Disable Chatbot on Specific Pages

Instead of including the chatbot on a page, wrap it in a condition:

```php
<?php 
// Hide chatbot on checkout or payment pages
if (strpos($_SERVER['REQUEST_URI'], 'payment') === false) {
    include 'chatbot_widget.php'; 
}
?>
```

## 12. Add Custom Response Delay

Edit `chatbot_widget.php`, find `showLoadingIndicator()` and add delay:

```javascript
// Send message to API with delay for natural feel
setTimeout(() => {
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
    });
}, 500); // 500ms delay
```

## 13. Custom Styling - Dark Mode

Add to chatbot CSS section in `chatbot_widget.php`:

```css
/* Dark Mode Theme */
.chatbot-window {
    background: #1e1e1e;
}

.chatbot-messages {
    background: #2d2d2d;
}

.message-content.bot {
    background: #3d3d3d;
    border-color: #4d4d4d;
    color: #e0e0e0;
}

.chatbot-input {
    background: #3d3d3d;
    color: #e0e0e0;
    border-color: #4d4d4d;
}

.chatbot-input::placeholder {
    color: #999;
}
```

## 14. Add Emoji Support in Responses

Edit `chatbot_api.php` responses to include emojis:

```php
if (preg_match('/\b(hello|hi|hey)\b/i', $message)) {
    return "👋 Hello! Welcome to JobVerseBD. How can I help you today?";
}

if (preg_match('/\b(thanks|thank you)\b/i', $message)) {
    return "😊 You're welcome! If you need anything else, feel free to ask. Good luck! 🚀";
}
```

## 15. Add Rate Limiting (Prevent Spam)

Edit `chatbot_api.php`, add this at the beginning:

```php
// Rate limiting - 5 messages per 10 seconds
session_start();
if (!isset($_SESSION['chatbot_last_messages'])) {
    $_SESSION['chatbot_last_messages'] = [];
}

$current_time = time();
$_SESSION['chatbot_last_messages'] = array_filter(
    $_SESSION['chatbot_last_messages'], 
    function($time) use ($current_time) {
        return ($current_time - $time) < 10;
    }
);

if (count($_SESSION['chatbot_last_messages']) > 5) {
    echo json_encode([
        'success' => false,
        'error' => 'Too many messages. Please wait a moment.'
    ]);
    exit;
}

$_SESSION['chatbot_last_messages'][] = $current_time;
```

---

## Need More Help?

- See `CHATBOT_README.md` for overview
- See `CHATBOT_SETUP_GUIDE.md` for detailed setup
- Check code comments in `chatbot_api.php` and `chatbot_widget.php`
- Review the JavaScript console for errors (F12 in browser)

Happy customizing! 🎨

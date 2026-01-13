# JobVerseBD Chatbot Implementation Guide

## Overview
A fully functional AI-powered chatbot has been added to your JobVerseBD website. The chatbot assists users with common queries about registration, jobs, applications, payments, and more.

## Files Created

### 1. **create_chatbot_table.sql**
   - SQL script to create database tables
   - Contains: `chatbot_conversations` table for storing chat history
   - Contains: `chatbot_faqs` table with pre-populated common questions and answers

### 2. **chatbot_api.php**
   - Backend API endpoint for chatbot functionality
   - Handles user messages and generates responses
   - Stores conversation history in database
   - Features:
     - FAQ-based knowledge base search
     - Keyword-based intelligent responses
     - Conversation tracking by session
     - Support for multiple users

### 3. **chatbot_widget.php**
   - Frontend chatbot UI component
   - Responsive design (works on desktop and mobile)
   - Features:
     - Floating chat window
     - Real-time message sending
     - Message history
     - Clear chat option
     - Professional styling with gradient colors

## Installation Steps

### Step 1: Create Database Tables
Execute the SQL file in your database:

```sql
-- Using phpMyAdmin:
1. Open phpMyAdmin
2. Select your 'jobportal' database
3. Click on "SQL" tab
4. Copy all content from create_chatbot_table.sql
5. Click "Go" to execute
```

Or via command line:
```bash
mysql -u root jobportal < create_chatbot_table.sql
```

### Step 2: Integrate Chatbot Widget into Pages

Add the chatbot widget to all pages where you want it to appear. Include this line at the end of your page (before closing body tag):

```php
<?php include 'chatbot_widget.php'; ?>
```

**Pages to update:**
- `index.php` (Homepage)
- `jobs.php` (Job listings)
- `contact.php` (Contact page)
- `seekerAccount.php` (Job seeker account)
- `employerAccount.php` (Employer account)
- `adminAccount.php` (Admin account)
- Any other public pages

### Step 3: Verify Font Awesome Icons
Make sure Font Awesome is loaded on your pages (already present in your bootstrap setup):
```html
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
```

## Features

### 🤖 Core Functionality
- **Intelligent Response System**: Combines FAQ database with keyword-based responses
- **Conversation History**: Stores all conversations for future reference
- **Session Tracking**: Maintains separate conversations for each user session
- **Multi-language Support**: Easy to add translations

### 📱 User Interface
- Floating chat widget (bottom-right corner)
- Responsive design (works on all devices)
- Smooth animations
- User-friendly interface
- Toggle, clear, and close buttons

### 📚 Knowledge Base
Pre-loaded FAQs covering:
- Registration & Account Management
- Job Posting & Application Process
- Coding Exam Features
- Payment Systems
- Profile Management
- General Support

## Customization

### Adding New FAQ Responses
Add new questions to the database:

```php
INSERT INTO chatbot_faqs (question, answer, category, keywords) VALUES
('Your question?', 'Your detailed answer here', 'Category Name', 'keyword1, keyword2');
```

### Modifying Colors
Edit `chatbot_widget.php` - Update the gradient colors in CSS:
```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
/* Change the hex codes to your preferred colors */
```

### Adding Keywords
Edit the `getKeywordBasedResponse()` function in `chatbot_api.php` to add new keyword patterns and responses.

### Custom Position
By default, chatbot appears at bottom-right. To change position, modify the CSS:
```css
.chatbot-container {
    bottom: 20px;  /* Change to 'top' if needed */
    right: 20px;   /* Change to 'left' if needed */
}
```

## API Endpoints

### Send Message
```
POST /chatbot_api.php?action=send_message
Content-Type: application/json

{
    "message": "User's question"
}

Response:
{
    "success": true,
    "message": "User's question",
    "response": "Bot's response",
    "timestamp": "HH:mm"
}
```

### Get Chat History
```
GET /chatbot_api.php?action=get_history

Response:
{
    "success": true,
    "history": [
        {
            "user_message": "...",
            "bot_response": "...",
            "timestamp": "..."
        }
    ]
}
```

### Clear Chat History
```
POST /chatbot_api.php?action=clear_history

Response:
{
    "success": true,
    "message": "Chat history cleared"
}
```

## Database Schema

### chatbot_conversations table
```
- id: INT (Primary Key)
- user_id: INT (NULL for anonymous users)
- session_id: VARCHAR(255)
- user_message: VARCHAR(1000)
- bot_response: VARCHAR(2000)
- timestamp: DATETIME
- user_ip: VARCHAR(50)
```

### chatbot_faqs table
```
- id: INT (Primary Key)
- question: VARCHAR(500)
- answer: VARCHAR(2000)
- category: VARCHAR(100)
- keywords: VARCHAR(500)
- created_at: DATETIME
- updated_at: DATETIME
- is_active: BOOLEAN
```

## Troubleshooting

### Chatbot not appearing?
1. Ensure `chatbot_widget.php` is included in your page
2. Check browser console for JavaScript errors
3. Verify Font Awesome CSS is loaded

### Messages not being stored?
1. Verify database tables were created successfully
2. Check that `connect.php` has correct database credentials
3. Review PHP error logs

### Styling issues?
1. Clear browser cache
2. Check for CSS conflicts with existing styles
3. Verify Bootstrap classes don't conflict

### FAQs not matching?
1. Check keywords are properly set in FAQ table
2. Ensure questions are relevant to search
3. Add more keywords to improve matching

## Performance Optimization

### For High Traffic:
1. Add database indexes on `session_id` and `timestamp`
2. Archive old conversations regularly
3. Cache FAQ responses

### Caching Old Chats:
```sql
-- Archive conversations older than 30 days
INSERT INTO chatbot_conversations_archive 
SELECT * FROM chatbot_conversations 
WHERE timestamp < DATE_SUB(NOW(), INTERVAL 30 DAY);

DELETE FROM chatbot_conversations 
WHERE timestamp < DATE_SUB(NOW(), INTERVAL 30 DAY);
```

## Security Considerations

✅ **Implemented:**
- SQL injection prevention (prepared statements)
- XSS protection (proper escaping)
- Session-based tracking
- User IP logging

## Support & Future Enhancements

Potential upgrades:
- Integration with AI services (OpenAI API, Google Dialogflow)
- Multi-language support
- Admin dashboard for FAQ management
- User feedback ratings
- Analytics and reporting
- Escalation to human support
- Integration with ticketing system

## Testing Checklist

- [ ] Database tables created successfully
- [ ] Chatbot appears on homepage
- [ ] Send/receive messages working
- [ ] Chat history displays correctly
- [ ] Clear chat button works
- [ ] Close button works
- [ ] Toggle button responsive
- [ ] Mobile display looks good
- [ ] No JavaScript errors in console
- [ ] FAQ questions return correct answers
- [ ] Keyword-based responses work
- [ ] Messages stored in database

---

**Chatbot Implementation Complete! 🎉**

For issues or customization needs, refer to the code comments in the respective files.

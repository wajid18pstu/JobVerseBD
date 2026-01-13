<?php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);

require_once 'connect.php';

// Check database connection
if (!$conn) {
    echo json_encode([
        'success' => false,
        'error' => 'Database connection failed'
    ]);
    exit;
}

// Start session for tracking conversations
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get or create session ID for tracking conversation
if (!isset($_SESSION['chatbot_session_id'])) {
    $_SESSION['chatbot_session_id'] = bin2hex(random_bytes(16));
}

$session_id = $_SESSION['chatbot_session_id'];
$user_ip = $_SERVER['REMOTE_ADDR'];
$user_id = isset($_SESSION['login_user']) ? $_SESSION['login_user'] : NULL;

// Get request method and action
$action = isset($_GET['action']) ? $_GET['action'] : '';
$method = $_SERVER['REQUEST_METHOD'];

// Get the user's input
$user_message = '';
if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $user_message = isset($input['message']) ? trim($input['message']) : '';
}

// Handle different actions
if ($action === 'send_message' && !empty($user_message)) {
    try {
        $bot_response = generateBotResponse($user_message, $conn);
        
        // Store conversation history - safely
        if ($conn) {
            $stmt = $conn->prepare("INSERT INTO chatbot_conversations (user_id, session_id, user_message, bot_response, user_ip) VALUES (?, ?, ?, ?, ?)");
            
            if ($stmt) {
                $stmt->bind_param("issss", $user_id, $session_id, $user_message, $bot_response, $user_ip);
                $stmt->execute();
                $stmt->close();
            }
        }
        
        echo json_encode([
            'success' => true,
            'message' => $user_message,
            'response' => $bot_response,
            'timestamp' => date('H:i')
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => true,
            'message' => $user_message,
            'response' => generateBotResponse($user_message, $conn),
            'timestamp' => date('H:i')
        ]);
    }
} elseif ($action === 'get_history') {
    // Get conversation history
    $stmt = $conn->prepare("SELECT user_message, bot_response, timestamp FROM chatbot_conversations WHERE session_id = ? ORDER BY timestamp DESC LIMIT 10");
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $history = [];
    while ($row = $result->fetch_assoc()) {
        $history[] = $row;
    }
    $stmt->close();
    
    echo json_encode([
        'success' => true,
        'history' => array_reverse($history)
    ]);
} elseif ($action === 'clear_history') {
    // Clear conversation history
    $stmt = $conn->prepare("DELETE FROM chatbot_conversations WHERE session_id = ?");
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $stmt->close();
    
    echo json_encode([
        'success' => true,
        'message' => 'Chat history cleared'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid request'
    ]);
}

/**
 * Generate bot response based on user message
 */
function generateBotResponse($user_message, $conn) {
    $user_message_lower = strtolower($user_message);
    
    // First, search in FAQ database
    $faq_response = searchFAQ($user_message_lower, $conn);
    if ($faq_response) {
        return $faq_response;
    }
    
    // If no FAQ match, use keyword-based responses
    return getKeywordBasedResponse($user_message_lower);
}

/**
 * Search FAQ database for relevant answers
 */
function searchFAQ($user_message, $conn) {
    try {
        // Simple LIKE search (more compatible than MATCH)
        $search_term = '%' . $conn->real_escape_string($user_message) . '%';
        
        $query = "SELECT answer FROM chatbot_faqs 
                  WHERE is_active = TRUE 
                  AND (question LIKE ? OR keywords LIKE ?)
                  LIMIT 1";
        
        $stmt = $conn->prepare($query);
        
        if (!$stmt) {
            return null;
        }
        
        $stmt->bind_param("ss", $search_term, $search_term);
        
        if (!$stmt->execute()) {
            $stmt->close();
            return null;
        }
        
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row['answer'];
        }
        
        $stmt->close();
        return null;
    } catch (Exception $e) {
        return null;
    }
}

/**
 * Provide keyword-based responses
 */
function getKeywordBasedResponse($message) {
    // Greeting keywords
    if (preg_match('/\b(hello|hi|hey|greetings|good morning|good afternoon|good evening)\b/i', $message)) {
        $greetings = [
            "Hello! 👋 Welcome to JobVerseBD. How can I help you today?",
            "Hi there! 😊 I'm here to assist you. What would you like to know?",
            "Hey! Welcome to JobVerseBD. Feel free to ask me anything about our platform!"
        ];
        return $greetings[array_rand($greetings)];
    }
    
    // Help keywords
    if (preg_match('/\b(help|support|assist|need help)\b/i', $message)) {
        return "I'm here to help! 🤝 I can assist you with:\n\n• Registration & Account Issues\n• Job Posting & Applications\n• Coding Exams\n• Payment & Billing\n• Profile Management\n• General Questions\n\nWhat would you like help with?";
    }
    
    // Register keywords
    if (preg_match('/\b(register|signup|sign up|create account|new account)\b/i', $message)) {
        return "To register on JobVerseBD:\n1. Click the 'Sign Up' button on the homepage\n2. Choose 'Job Seeker' or 'Employer'\n3. Fill in your details (name, email, password)\n4. Verify your email address\n5. Complete your profile\n\nDo you need help with any specific step?";
    }
    
    // Job posting keywords
    if (preg_match('/\b(post job|create job|publish job|job posting)\b/i', $message)) {
        return "To post a job:\n1. Log in to your employer account\n2. Go to 'Post a Job'\n3. Fill in job details (title, description, requirements)\n4. Set salary and location\n5. Add skills and qualifications\n6. Review and publish\n\nNeed assistance with anything specific?";
    }
    
    // Job application keywords
    if (preg_match('/\b(apply|application|apply for job)\b/i', $message)) {
        return "To apply for a job:\n1. Log in as a Job Seeker\n2. Browse jobs or use search\n3. Click on a job you like\n4. Click the 'Apply' button\n5. Submit your application with resume\n6. Track your application status\n\nHave any questions about the process?";
    }
    
    // Contact keywords
    if (preg_match('/\b(contact|contact us|reach out|get in touch)\b/i', $message)) {
        return "You can reach us through:\n📧 Email: support@jobversebd.com\n📞 Phone: +880 XXXX XXXXX\n💬 Contact Form: Visit our Contact page\n⏰ Support Hours: 9 AM - 6 PM (Weekdays)\n\nWould you like to file a support ticket?";
    }
    
    // Thank you keywords
    if (preg_match('/\b(thank|thanks|thankyou|appreciate)\b/i', $message)) {
        return "You're welcome! 😊 If you need anything else, feel free to ask. Happy job hunting or recruiting!";
    }
    
    // Goodbye keywords
    if (preg_match('/\b(bye|goodbye|exit|quit|close|see you)\b/i', $message)) {
        return "Goodbye! 👋 Thank you for using JobVerseBD. Have a great day!";
    }
    
    // If no match, provide general help message
    return "I'm here to help! 😊 I can assist you with questions about:\n\n✓ Registration & Accounts\n✓ Job Posting & Applications\n✓ Coding Exams\n✓ Payments\n✓ Profile Management\n✓ General Platform Questions\n\nWhat would you like to know more about?";
}

// Add debug endpoint (temporary - for troubleshooting)
if ($action === 'debug') {
    $debug_info = [
        'connection' => $conn ? 'Connected' : 'Failed',
        'tables_exist' => [],
        'session_id' => $session_id
    ];
    
    // Check if tables exist
    if ($conn) {
        $tables_result = $conn->query("SHOW TABLES LIKE 'chatbot_%'");
        if ($tables_result) {
            while ($row = $tables_result->fetch_row()) {
                $debug_info['tables_exist'][] = $row[0];
            }
        }
    }
    
    echo json_encode($debug_info);
    exit;
}

if ($conn) {
    $conn->close();
}
?>

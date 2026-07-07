<?php
/**
 * Fix Jobs with Missing Categories
 * This script allows admins to view and fix jobs with missing or empty categories
 */

include 'authorizeAdmin.php';
include 'connect.php';

header('Content-Type: text/html; charset=utf-8');

// Handle form submission to update category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_category'])) {
    $post_id = intval($_POST['post_id']);
    $new_category = $conn->real_escape_string($_POST['new_category']);
    
    if (!empty($new_category)) {
        $update_sql = "UPDATE post SET category = '$new_category' WHERE id = $post_id";
        if ($conn->query($update_sql)) {
            $success_message = "Category updated successfully for Post ID: $post_id";
        } else {
            $error_message = "Error updating category: " . $conn->error;
        }
    } else {
        $error_message = "Category cannot be empty.";
    }
}

// Handle form submission to update industry
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_industry'])) {
    $post_id = intval($_POST['post_id']);
    $new_industry = $conn->real_escape_string($_POST['new_industry']);
    
    if (!empty($new_industry)) {
        $update_sql = "UPDATE post SET industry = '$new_industry' WHERE id = $post_id";
        if ($conn->query($update_sql)) {
            $success_message = "Industry updated successfully for Post ID: $post_id";
        } else {
            $error_message = "Error updating industry: " . $conn->error;
        }
    } else {
        $error_message = "Industry cannot be empty.";
    }
}

// Fetch all jobs with empty or NULL categories
$sql = "SELECT p.id, p.name, p.eid, (SELECT name FROM employer WHERE id=p.eid) as employer_name, 
        p.category, p.industry, p.date, p.status 
        FROM post p 
        WHERE p.category IS NULL OR p.category = '' 
        ORDER BY p.date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fix Job Categories & Industries | Admin</title>
    <link rel="icon" href="img/jobsConnect.svg" type="image/x-icon">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .page-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .job-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background: #f9f9f9;
        }
        .job-card h5 {
            color: #667eea;
            margin-top: 0;
        }
        .job-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        .info-item {
            font-size: 0.95rem;
        }
        .info-label {
            font-weight: 600;
            color: #555;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        .form-group select,
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.95rem;
        }
        .btn-update {
            background-color: #667eea;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        .btn-update:hover {
            background-color: #764ba2;
        }
        .no-jobs {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        .no-jobs i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="page-title">
            <i class="fas fa-tools"></i> Fix Missing Job Categories & Industries
        </h1>
        
        <?php if (isset($success_message)): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
        </div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($result->num_rows > 0): ?>
        <p style="color: #666; margin-bottom: 20px;">
            Found <strong><?php echo $result->num_rows; ?></strong> job(s) with missing or empty categories.
        </p>
        
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="job-card">
            <h5><?php echo htmlspecialchars($row['name']); ?></h5>
            
            <div class="job-info">
                <div class="info-item">
                    <span class="info-label">Post ID:</span> <?php echo $row['id']; ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span> 
                    <span style="background-color: <?php echo $row['status'] == 'open' ? '#28a745' : '#dc3545'; ?>; 
                           color: white; padding: 3px 8px; border-radius: 3px;">
                        <?php echo ucfirst($row['status']); ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Employer:</span> <?php echo htmlspecialchars($row['employer_name'] ?? 'Unknown'); ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Posted:</span> <?php echo $row['date']; ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Current Category:</span> 
                    <span style="color: #dc3545; font-weight: 600;">
                        <?php echo empty($row['category']) ? '(empty)' : htmlspecialchars($row['category']); ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Current Industry:</span> 
                    <span style="color: #ff9800; font-weight: 600;">
                        <?php echo empty($row['industry']) ? '(empty)' : htmlspecialchars($row['industry']); ?>
                    </span>
                </div>
            </div>
            
            <div style="border-top: 1px solid #ddd; padding-top: 15px; margin-top: 15px;">
                <h6 style="margin-bottom: 15px; color: #333;">Update Category</h6>
            <form method="POST" style="display: inline;">
                <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                
                <div class="form-group">
                    <label>Select New Category:</label>
                    <select name="new_category" required>
                        <option value="">-- Choose Category --</option>
                        <optgroup label="White Collar Jobs">
                            <option value="Accounting Jobs">Accounting Jobs</option>
                            <option value="Interior Design Jobs">Interior Design Jobs</option>
                            <option value="Bank Jobs">Bank Jobs</option>
                            <option value="Content Writing Jobs">Content Writing Jobs</option>
                            <option value="Consultant Jobs">Consultant Jobs</option>
                            <option value="Engineering Jobs">Engineering Jobs</option>
                            <option value="Export Import Jobs">Export Import Jobs</option>
                            <option value="Merchandiser Jobs">Merchandiser Jobs</option>
                            <option value="Security Jobs">Security Jobs</option>
                            <option value="HR Jobs">HR Jobs</option>
                            <option value="Hotel Jobs">Hotel Jobs</option>
                            <option value="Application Programming Jobs">Application Programming Jobs</option>
                            <option value="Client Server Jobs">Client Server Jobs</option>
                            <option value="DBA Jobs">DBA Jobs</option>
                            <option value="Ecommerce Jobs">Ecommerce Jobs</option>
                            <option value="ERP Jobs">ERP Jobs</option>
                            <option value="VLSI Jobs">VLSI Jobs</option>
                            <option value="Mainframe Jobs">Mainframe Jobs</option>
                            <option value="Middleware Jobs">Middleware Jobs</option>
                            <option value="Mobile Jobs">Mobile Jobs</option>
                            <option value="Network administrator Jobs">Network administrator Jobs</option>
                            <option value="IT Jobs">IT Jobs</option>
                            <option value="Testing Jobs">Testing Jobs</option>
                            <option value="System Programming Jobs">System Programming Jobs</option>
                            <option value="EDP Jobs">EDP Jobs</option>
                            <option value="Telecom Software Jobs">Telecom Software Jobs</option>
                            <option value="Telecom Jobs">Telecom Jobs</option>
                            <option value="BPO Jobs">BPO Jobs</option>
                            <option value="Legal Jobs">Legal Jobs</option>
                            <option value="Marketing Jobs">Marketing Jobs</option>
                            <option value="Packaging Jobs">Packaging Jobs</option>
                            <option value="Pharma Jobs">Pharma Jobs</option>
                            <option value="Maintenance Jobs">Maintenance Jobs</option>
                            <option value="Logistics Jobs">Logistics Jobs</option>
                            <option value="Sales Jobs">Sales Jobs</option>
                            <option value="Secretary Jobs">Secretary Jobs</option>
                            <option value="Corporate Planning Jobs">Corporate Planning Jobs</option>
                            <option value="Site Engineering Jobs">Site Engineering Jobs</option>
                            <option value="Film Jobs">Film Jobs</option>
                            <option value="Teacher Jobs">Teacher Jobs</option>
                            <option value="Airline Jobs">Airline Jobs</option>
                            <option value="Graphic Designer Jobs">Graphic Designer Jobs</option>
                            <option value="Shipping Jobs">Shipping Jobs</option>
                            <option value="Analytics Jobs">Analytics Jobs</option>
                            <option value="Business Intelligence Jobs">Business Intelligence Jobs</option>
                            <option value="Other">Other</option>
                        </optgroup>
                        <optgroup label="Blue Collar Jobs">
                            <option value="Caregiver/Nanny">Caregiver/Nanny</option>
                            <option value="Beautician/Salon">Beautician/Salon</option>
                            <option value="Sewing machine operator">Sewing machine operator</option>
                            <option value="Carpenter">Carpenter</option>
                            <option value="Plumber/Pipe fitting">Plumber/Pipe fitting</option>
                            <option value="Welder">Welder</option>
                            <option value="Boiler Operator">Boiler Operator</option>
                            <option value="Gym/Fitness Trainer">Gym/Fitness Trainer</option>
                            <option value="Interpreter">Interpreter</option>
                            <option value="Imam/Khatib/Muezzin">Imam/Khatib/Muezzin</option>
                            <option value="Mason/Construction worker">Mason/Construction worker</option>
                            <option value="Nurse">Nurse</option>
                            <option value="Deliveryman">Deliveryman</option>
                            <option value="Pathologist">Pathologist</option>
                            <option value="Other">Other</option>
                        </optgroup>
                    </select>
                </div>
                
                <button type="submit" name="update_category" class="btn-update">
                    <i class="fas fa-save"></i> Update Category
                </button>
            </form>
            </div>

            <div style="border-top: 1px solid #ddd; padding-top: 15px; margin-top: 15px;">
                <h6 style="margin-bottom: 15px; color: #333;">Update Industry</h6>
            <form method="POST">
                <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                
                <div class="form-group">
                    <label>Select New Industry:</label>
                    <select name="new_industry" required>
                        <option value="">-- Choose Industry --</option>
                        <option value="Accounting , Finance">Accounting , Finance</option>
                        <option value="Advertising , PR , MR , Event Management">Advertising , PR , MR , Event Management</option>
                        <option value="Agriculture , Dairy">Agriculture , Dairy</option>
                        <option value="Animation , Gaming">Animation , Gaming</option>
                        <option value="Architecture , Interior Design">Architecture , Interior Design</option>
                        <option value="Automobile , Auto Anciliary , Auto Components">Automobile , Auto Anciliary , Auto Components</option>
                        <option value="Aviation , Aerospace Firms">Aviation , Aerospace Firms</option>
                        <option value="Banking , Financial Services , Broking">Banking , Financial Services , Broking</option>
                        <option value="BPO , Call Centre , ITES">BPO , Call Centre , ITES</option>
                        <option value="Brewery , Distillery">Brewery , Distillery</option>
                        <option value="Broadcasting">Broadcasting</option>
                        <option value="Ceramics , Sanitary ware">Ceramics , Sanitary ware</option>
                        <option value="Chemicals , PetroChemical , Plastic , Rubber">Chemicals , PetroChemical , Plastic , Rubber</option>
                        <option value="Construction , Engineering , Cement , Metals">Construction , Engineering , Cement , Metals</option>
                        <option value="Consumer Electronics , Appliances , Durables">Consumer Electronics , Appliances , Durables</option>
                        <option value="Courier , Transportation , Freight , Warehousing">Courier , Transportation , Freight , Warehousing</option>
                        <option value="Education , Teaching , Training">Education , Teaching , Training</option>
                        <option value="Electricals , Switchgears">Electricals , Switchgears</option>
                        <option value="Export , Import">Export , Import</option>
                        <option value="Facility Management">Facility Management</option>
                        <option value="Fertilizers , Pesticides">Fertilizers , Pesticides</option>
                        <option value="FMCG , Foods , Beverage">FMCG , Foods , Beverage</option>
                        <option value="Food Processing">Food Processing</option>
                        <option value="Fresher , Trainee , Entry Level">Fresher , Trainee , Entry Level</option>
                        <option value="Gems , Jewellery">Gems , Jewellery</option>
                        <option value="Glass , Glassware">Glass , Glassware</option>
                        <option value="Government , Defence">Government , Defence</option>
                        <option value="Heat Ventilation , Air Conditioning">Heat Ventilation , Air Conditioning</option>
                        <option value="Industrial Products , Heavy Machinery">Industrial Products , Heavy Machinery</option>
                        <option value="Insurance">Insurance</option>
                        <option value="Internet , Ecommerce">Internet , Ecommerce</option>
                        <option value="Iron and Steel">Iron and Steel</option>
                        <option value="IT-Hardware & Networking">IT-Hardware & Networking</option>
                        <option value="IT-Software , Software Services">IT-Software , Software Services</option>
                        <option value="KPO , Research , Analytics">KPO , Research , Analytics</option>
                        <option value="Leather">Leather</option>
                        <option value="Legal">Legal</option>
                        <option value="Media , Entertainment , Internet">Media , Entertainment , Internet</option>
                        <option value="Medical , Healthcare , Hospitals">Medical , Healthcare , Hospitals</option>
                        <option value="Medical Devices , Equipments">Medical Devices , Equipments</option>
                        <option value="Mining , Quarrying">Mining , Quarrying</option>
                        <option value="NGO , Social Services , Regulators , Industry Associations">NGO , Social Services , Regulators , Industry Associations</option>
                        <option value="Office Equipment , Automation">Office Equipment , Automation</option>
                        <option value="Oil and Gas , Energy , Power , Infrastructure">Oil and Gas , Energy , Power , Infrastructure</option>
                        <option value="Other">Other</option>
                        <option value="Pharma , Biotech , Clinical Research">Pharma , Biotech , Clinical Research</option>
                        <option value="Printing , Packaging">Printing , Packaging</option>
                        <option value="Publishing">Publishing</option>
                        <option value="Pulp and Paper">Pulp and Paper</option>
                        <option value="Real Estate , Property">Real Estate , Property</option>
                        <option value="Recruitment , Staffing">Recruitment , Staffing</option>
                        <option value="Retail , Wholesale">Retail , Wholesale</option>
                        <option value="Security , Law Enforcement">Security , Law Enforcement</option>
                        <option value="Semiconductors , Electronics">Semiconductors , Electronics</option>
                        <option value="Shipping , Marine">Shipping , Marine</option>
                        <option value="Strategy , Management Consulting Firms">Strategy , Management Consulting Firms</option>
                        <option value="Sugar">Sugar</option>
                        <option value="Telecom,ISP">Telecom,ISP</option>
                        <option value="Textiles , Garments , Accessories">Textiles , Garments , Accessories</option>
                        <option value="Travel , Hotels , Restaurants , Airlines , Railways">Travel , Hotels , Restaurants , Airlines , Railways</option>
                        <option value="Tyres">Tyres</option>
                        <option value="Water Treatment , Waste Management">Water Treatment , Waste Management</option>
                        <option value="Wellness , Fitness , Sports, Beauty">Wellness , Fitness , Sports, Beauty</option>
                    </select>
                </div>
                
                <button type="submit" name="update_industry" class="btn-update">
                    <i class="fas fa-save"></i> Update Industry
                </button>
            </form>
            </div>
        </div>
        <?php endwhile; ?>
        
        <?php else: ?>
        <div class="no-jobs">
            <i class="fas fa-check"></i>
            <p>All jobs have proper categories assigned! <strong>✓</strong></p>
        </div>
        <?php endif; ?>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
            <a href="adminAccount.php" class="btn-update" style="display: inline-block; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Back to Admin Dashboard
            </a>
        </div>
    </div>
</body>
</html>

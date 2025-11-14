<?php
// users.php - User Management Page
session_start();
require_once 'config/database.php';

// Get database connection
$db = getDB();

// Page variables
$page_title = "Users";
$current_page = "users";

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    header('Content-Type: application/json');
    
    // Delete user
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['user_id'])) {
        $user_id = (int)$_POST['user_id'];
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting user']);
        }
        $stmt->close();
        exit;
    }
    
    // Get user details
    if (isset($_POST['action']) && $_POST['action'] === 'get_user' && isset($_POST['user_id'])) {
        $user_id = (int)$_POST['user_id'];
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user) {
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
        $stmt->close();
        exit;
    }
    
    // Update user
    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $user_id = (int)$_POST['user_id'];
        $first_name = escapeString($_POST['first_name']);
        $last_name = escapeString($_POST['last_name']);
        $email = escapeString($_POST['email']);
        $phone = escapeString($_POST['phone']);
        $address = escapeString($_POST['address']);
        $city = escapeString($_POST['city']);
        $postal_code = escapeString($_POST['postal_code']);
        $status = escapeString($_POST['status']);
        
        $stmt = $db->prepare("UPDATE users SET first_name=?, last_name=?, email=?, phone=?, address=?, city=?, postal_code=?, status=? WHERE id=?");
        $stmt->bind_param("ssssssssi", $first_name, $last_name, $email, $phone, $address, $city, $postal_code, $status, $user_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'User updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating user']);
        }
        $stmt->close();
        exit;
    }
    
    // Add new user
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $first_name = escapeString($_POST['first_name']);
        $last_name = escapeString($_POST['last_name']);
        $email = escapeString($_POST['email']);
        $phone = escapeString($_POST['phone']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $address = escapeString($_POST['address']);
        $city = escapeString($_POST['city']);
        $postal_code = escapeString($_POST['postal_code']);
        $status = escapeString($_POST['status']);
        
        $stmt = $db->prepare("INSERT INTO users (first_name, last_name, email, phone, password, address, city, postal_code, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $first_name, $last_name, $email, $phone, $password, $address, $city, $postal_code, $status);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'User added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding user: ' . $db->error]);
        }
        $stmt->close();
        exit;
    }
}

// Fetch users with search and filters
$search = isset($_GET['search']) ? escapeString($_GET['search']) : '';
$role_filter = isset($_GET['role']) ? escapeString($_GET['role']) : '';
$status_filter = isset($_GET['status']) ? escapeString($_GET['status']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

// Build query
$where = [];
$params = [];
$types = '';

if (!empty($search)) {
    $where[] = "(first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= 'sss';
}

if (!empty($status_filter)) {
    $where[] = "status = ?";
    $params[] = $status_filter;
    $types .= 's';
}

$where_clause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Count total users
$count_query = "SELECT COUNT(*) as total FROM users $where_clause";
if (!empty($params)) {
    $count_stmt = $db->prepare($count_query);
    $count_stmt->bind_param($types, ...$params);
    $count_stmt->execute();
    $total_users = $count_stmt->get_result()->fetch_assoc()['total'];
    $count_stmt->close();
} else {
    $total_users = $db->query($count_query)->fetch_assoc()['total'];
}

// Fetch users
$query = "SELECT * FROM users $where_clause ORDER BY created_at DESC LIMIT ? OFFSET ?";
$params[] = $per_page;
$params[] = $offset;
$types .= 'ii';

if (!empty($where)) {
    $stmt = $db->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $stmt = $db->prepare("SELECT * FROM users ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
}

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
$stmt->close();

// Calculate stats
$stats_query = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
    SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive,
    SUM(CASE WHEN MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) THEN 1 ELSE 0 END) as new_this_month
    FROM users";
$stats_result = $db->query($stats_query);
$stats = $stats_result->fetch_assoc();

$total_pages = ceil($total_users / $per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | ADMIN PANEL</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/users.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s;
        }

        .modal-content {
            background-color: #fff;
            margin: 2% auto;
            padding: 0;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideIn 0.3s;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        .modal-header {
            padding: 20px 25px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            color: #1f2937;
        }

        .modal-body {
            padding: 25px;
        }

        .modal-footer {
            padding: 20px 25px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .close {
            color: #9ca3af;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close:hover {
            color: #374151;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .user-detail-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .user-detail-row:last-child {
            border-bottom: none;
        }

        .user-detail-label {
            font-weight: 600;
            color: #6b7280;
            width: 140px;
            flex-shrink: 0;
        }

        .user-detail-value {
            color: #1f2937;
            flex: 1;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-banned {
            background-color: #fef3c7;
            color: #92400e;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .modal-content {
                width: 95%;
                margin: 5% auto;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'includes/sidebar.php'; ?>

        <div class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <button class="toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1>User Management</h1>
                </div>
                <div class="header-right">
                    <button class="btn btn-primary" onclick="openAddModal()">
                        <i class="fas fa-plus"></i> Add New User
                    </button>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #3b82f6;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Total Users</p>
                        <h3 class="stat-value"><?php echo $stats['total']; ?></h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #10b981;">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Active Users</p>
                        <h3 class="stat-value"><?php echo $stats['active']; ?></h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #ef4444;">
                        <i class="fas fa-user-times"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Inactive Users</p>
                        <h3 class="stat-value"><?php echo $stats['inactive']; ?></h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #8b5cf6;">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">New This Month</p>
                        <h3 class="stat-value"><?php echo $stats['new_this_month']; ?></h3>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="content-section">
                <div class="filters-bar">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchUsers" placeholder="Search users by name or email..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="filters">
                        <select id="filterStatus">
                            <option value="">All Status</option>
                            <option value="active" <?php echo $status_filter == 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $status_filter == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                            <option value="banned" <?php echo $status_filter == 'banned' ? 'selected' : ''; ?>>Banned</option>
                        </select>
                        <button class="btn btn-secondary" onclick="resetFilters()">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Status</th>
                                <th>Joined Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($users) > 0): ?>
                                <?php foreach($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
                                            </div>
                                            <span class="user-name"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($user['city'] ?? '-'); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo strtolower($user['status']); ?>">
                                            <?php echo ucfirst($user['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action btn-view" title="View Details" onclick="viewUser(<?php echo $user['id']; ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-action btn-edit" title="Edit User" onclick="editUser(<?php echo $user['id']; ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-action btn-delete" title="Delete User" onclick="deleteUser(<?php echo $user['id']; ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 40px;">
                                        <i class="fas fa-users" style="font-size: 48px; color: #d1d5db; margin-bottom: 15px;"></i>
                                        <p style="color: #6b7280;">No users found</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($total_pages > 1): ?>
                <div class="pagination">
                    <button class="btn btn-secondary btn-sm" <?php echo $page <= 1 ? 'disabled' : ''; ?> onclick="changePage(<?php echo $page - 1; ?>)">
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <div class="pagination-info">
                        Page <?php echo $page; ?> of <?php echo $total_pages; ?> (<?php echo $total_users; ?> users)
                    </div>
                    <button class="btn btn-secondary btn-sm" <?php echo $page >= $total_pages ? 'disabled' : ''; ?> onclick="changePage(<?php echo $page + 1; ?>)">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <?php endif; ?>
            </div>

            <?php include 'includes/footer.php'; ?>
        </div>
    </div>

    <!-- View User Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-user"></i> User Details</h2>
                <span class="close" onclick="closeModal('viewModal')">&times;</span>
            </div>
            <div class="modal-body" id="viewModalBody">
                <!-- Content loaded via JavaScript -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('viewModal')">Close</button>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-edit"></i> Edit User</h2>
                <span class="close" onclick="closeModal('editModal')">&times;</span>
            </div>
            <div class="modal-body">
                <div id="editAlert" class="alert"></div>
                <form id="editUserForm">
                    <input type="hidden" id="edit_user_id" name="user_id">
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name *</label>
                            <input type="text" id="edit_first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name *</label>
                            <input type="text" id="edit_last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" id="edit_email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Phone *</label>
                            <input type="text" id="edit_phone" name="phone" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea id="edit_address" name="address"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" id="edit_city" name="city">
                        </div>
                        <div class="form-group">
                            <label>Postal Code</label>
                            <input type="text" id="edit_postal_code" name="postal_code">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status *</label>
                        <select id="edit_status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="banned">Banned</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('editModal')">Cancel</button>
                <button class="btn btn-primary" onclick="updateUser()">
                    <i class="fas fa-save"></i> Update User
                </button>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-user-plus"></i> Add New User</h2>
                <span class="close" onclick="closeModal('addModal')">&times;</span>
            </div>
            <div class="modal-body">
                <div id="addAlert" class="alert"></div>
                <form id="addUserForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name *</label>
                            <input type="text" id="add_first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name *</label>
                            <input type="text" id="add_last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" id="add_email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Phone *</label>
                            <input type="text" id="add_phone" name="phone" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" id="add_password" name="password" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea id="add_address" name="address"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" id="add_city" name="city">
                        </div>
                        <div class="form-group">
                            <label>Postal Code</label>
                            <input type="text" id="add_postal_code" name="postal_code">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status *</label>
                        <select id="add_status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="banned">Banned</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('addModal')">Cancel</button>
                <button class="btn btn-primary" onclick="addUser()">
                    <i class="fas fa-plus"></i> Add User
                </button>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        // Modal functions
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            const alert = document.querySelector(`#${modalId} .alert`);
            if (alert) {
                alert.style.display = 'none';
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }

        // View user details
        function viewUser(userId) {
            fetch('users.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `ajax=1&action=get_user&user_id=${userId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const user = data.user;
                    const statusClass = user.status.toLowerCase();
                    document.getElementById('viewModalBody').innerHTML = `
                        <div class="user-detail-row">
                            <div class="user-detail-label">Name:</div>
                            <div class="user-detail-value">${user.first_name} ${user.last_name}</div>
                        </div>
                        <div class="user-detail-row">
                            <div class="user-detail-label">Email:</div>
                            <div class="user-detail-value">${user.email}</div>
                        </div>
                        <div class="user-detail-row">
                            <div class="user-detail-label">Phone:</div>
                            <div class="user-detail-value">${user.phone}</div>
                        </div>
                        <div class="user-detail-row">
                            <div class="user-detail-label">Address:</div>
                            <div class="user-detail-value">${user.address || '-'}</div>
                        </div>
                        <div class="user-detail-row">
                            <div class="user-detail-label">City:</div>
                            <div class="user-detail-value">${user.city || '-'}</div>
                        </div>
                        <div class="user-detail-row">
                            <div class="user-detail-label">Postal Code:</div>
                            <div class="user-detail-value">${user.postal_code || '-'}</div>
                        </div>
                        <div class="user-detail-row">
                            <div class="user-detail-label">Status:</div>
                            <div class="user-detail-value">
                                <span class="status-badge status-${statusClass}">${user.status.charAt(0).toUpperCase() + user.status.slice(1)}</span>
                            </div>
                        </div>
                        <div class="user-detail-row">
                            <div class="user-detail-label">Joined Date:</div>
                            <div class="user-detail-value">${new Date(user.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</div>
                        </div>
                    `;
                    openModal('viewModal');
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while fetching user details');
            });
        }

        // Edit user
        function editUser(userId) {
            fetch('users.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `ajax=1&action=get_user&user_id=${userId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const user = data.user;
                    document.getElementById('edit_user_id').value = user.id;
                    document.getElementById('edit_first_name').value = user.first_name;
                    document.getElementById('edit_last_name').value = user.last_name;
                    document.getElementById('edit_email').value = user.email;
                    document.getElementById('edit_phone').value = user.phone;
                    document.getElementById('edit_address').value = user.address || '';
                    document.getElementById('edit_city').value = user.city || '';
                    document.getElementById('edit_postal_code').value = user.postal_code || '';
                    document.getElementById('edit_status').value = user.status;
                    openModal('editModal');
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while fetching user details');
            });
        }

        // Update user
        function updateUser() {
            const form = document.getElementById('editUserForm');
            const formData = new FormData(form);
            formData.append('ajax', '1');
            formData.append('action', 'update');

            fetch('users.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const alert = document.getElementById('editAlert');
                if (data.success) {
                    alert.className = 'alert alert-success';
                    alert.textContent = data.message;
                    alert.style.display = 'block';
                    setTimeout(() => {
                        closeModal('editModal');
                        location.reload();
                    }, 1500);
                } else {
                    alert.className = 'alert alert-error';
                    alert.textContent = data.message;
                    alert.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const alert = document.getElementById('editAlert');
                alert.className = 'alert alert-error';
                alert.textContent = 'An error occurred while updating user';
                alert.style.display = 'block';
            });
        }

        // Open add modal
        function openAddModal() {
            document.getElementById('addUserForm').reset();
            openModal('addModal');
        }

        // Add user
        function addUser() {
            const form = document.getElementById('addUserForm');
            const formData = new FormData(form);
            formData.append('ajax', '1');
            formData.append('action', 'add');

            fetch('users.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const alert = document.getElementById('addAlert');
                if (data.success) {
                    alert.className = 'alert alert-success';
                    alert.textContent = data.message;
                    alert.style.display = 'block';
                    setTimeout(() => {
                        closeModal('addModal');
                        location.reload();
                    }, 1500);
                } else {
                    alert.className = 'alert alert-error';
                    alert.textContent = data.message;
                    alert.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const alert = document.getElementById('addAlert');
                alert.className = 'alert alert-error';
                alert.textContent = 'An error occurred while adding user';
                alert.style.display = 'block';
            });
        }

        // Delete user
        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                fetch('users.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `ajax=1&action=delete&user_id=${userId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting user');
                });
            }
        }

        // Search functionality
        let searchTimeout;
        document.getElementById('searchUsers').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                applyFilters();
            }, 500);
        });

        // Status filter
        document.getElementById('filterStatus').addEventListener('change', function() {
            applyFilters();
        });

        // Apply filters
        function applyFilters() {
            const search = document.getElementById('searchUsers').value;
            const status = document.getElementById('filterStatus').value;
            
            let url = 'users.php?';
            if (search) url += `search=${encodeURIComponent(search)}&`;
            if (status) url += `status=${encodeURIComponent(status)}&`;
            
            window.location.href = url;
        }

        // Reset filters
        function resetFilters() {
            window.location.href = 'users.php';
        }

        // Change page
        function changePage(page) {
            const search = document.getElementById('searchUsers').value;
            const status = document.getElementById('filterStatus').value;
            
            let url = `users.php?page=${page}`;
            if (search) url += `&search=${encodeURIComponent(search)}`;
            if (status) url += `&status=${encodeURIComponent(status)}`;
            
            window.location.href = url;
        }
    </script>
</body>
</html>
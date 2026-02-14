<?php
error_reporting(0);
ini_set('display_errors', 0);

include 'connection.php';

$edit_mode = false;
$edit_id = 0;
$edit_title = '';
$edit_content = '';
$message = '';

if (isset($_POST['create'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    
    $sql = "INSERT INTO journal (title, content) VALUES ('$title', '$content')";
    
    if ($conn->query($sql)) {
        $message = "<div class='alert alert-success'>Journal entry created successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

if (isset($_POST['update'])) {
    $journal_id = intval($_POST['journal_id']);
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    
    $sql = "UPDATE journal SET title='$title', content='$content' WHERE journal_id=$journal_id";
    
    if ($conn->query($sql)) {
        $message = "<div class='alert alert-success'>Journal entry updated successfully!</div>";
        header("Location: index.php");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

if (isset($_GET['delete'])) {
    $journal_id = intval($_GET['delete']);
    $sql = "DELETE FROM journal WHERE journal_id=$journal_id";
    
    if ($conn->query($sql)) {
        $message = "<div class='alert alert-success'>Journal entry deleted successfully!</div>";
        header("Location: index.php");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_id = intval($_GET['edit']);
    
    $result = $conn->query("SELECT * FROM journal WHERE journal_id=$edit_id");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $edit_title = $row['title'];
        $edit_content = $row['content'];
    }
}

$entries = $conn->query("SELECT * FROM journal ORDER BY entry_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Journal - CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        * {
            font-family: Georgia, serif;
        }
        
        body {
            background: linear-gradient(180deg, #E8F3E8 0%, #C8E6C9 25%, #A5D6A7 50%, #90CAF9 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .container {
            max-width: 1000px;
        }
        
        .card {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 15px;
            margin-bottom: 30px;
            background: rgba(255, 255, 255, 0.95);
        }
        
        .card-header {
            background: linear-gradient(135deg, #A5D6A7 0%, #81C784 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        
        .journal-entry {
            transition: transform 0.3s;
            background: rgba(232, 243, 232, 0.3);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        
        .journal-entry:hover {
            transform: translateY(-5px);
            background: rgba(200, 230, 201, 0.4);
        }
        
        .btn-custom {
            border-radius: 25px;
            padding: 10px 25px;
            font-family: Georgia, serif;
        }
        
        .btn-primary {
            background: #81C784;
            border: none;
        }
        
        .btn-primary:hover {
            background: #66BB6A;
        }
        
        .btn-warning {
            background: #FFD54F;
            border: none;
            color: #333;
        }
        
        .btn-warning:hover {
            background: #FFCA28;
        }
        
        .btn-secondary {
            background: #9E9E9E;
            border: none;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #757575;
        }
        
        .entry-date {
            color: #5F8D60;
            font-size: 0.9rem;
            font-style: italic;
        }
        
        h1 {
            color: #2E7D32;
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
            font-family: Georgia, serif;
            font-weight: bold;
        }
        
        h3 {
            font-family: Georgia, serif;
        }
        
        h4 {
            color: #388E3C;
            font-family: Georgia, serif;
        }
        
        .form-label {
            color: #2E7D32;
            font-weight: 600;
        }
        
        .form-control {
            border: 2px solid #C8E6C9;
            border-radius: 10px;
            font-family: Georgia, serif;
        }
        
        .form-control:focus {
            border-color: #81C784;
            box-shadow: 0 0 0 0.2rem rgba(129, 199, 132, 0.25);
        }
        
        textarea.form-control {
            font-family: Georgia, serif;
        }
        
        .alert-success {
            background: #C8E6C9;
            border: none;
            color: #2E7D32;
            border-radius: 10px;
        }
        
        .badge {
            background: rgba(255, 255, 255, 0.9) !important;
            color: #2E7D32 !important;
            font-family: Georgia, serif;
        }
        
        .btn-outline-warning {
            border-color: #FFD54F;
            color: #F57F17;
        }
        
        .btn-outline-warning:hover {
            background: #FFD54F;
            color: #333;
        }
        
        .btn-outline-danger {
            border-color: #EF9A9A;
            color: #C62828;
        }
        
        .btn-outline-danger:hover {
            background: #EF9A9A;
            color: white;
        }
        
        .edit-mode-highlight {
            border: 3px solid #FFD54F;
            box-shadow: 0 0 20px rgba(255, 213, 79, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="bi bi-journal-text"></i> My Personal Journal</h1>
        
        <?php echo $message; ?>
        
        <div class="card <?php echo $edit_mode ? 'edit-mode-highlight' : ''; ?>">
            <div class="card-header">
                <h3 class="mb-0">
                    <?php if ($edit_mode): ?>
                        <i class="bi bi-pencil-square"></i> Edit Journal Entry
                    <?php else: ?>
                        <i class="bi bi-plus-circle"></i> New Journal Entry
                    <?php endif; ?>
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <?php if ($edit_mode): ?>
                        <input type="hidden" name="journal_id" value="<?php echo $edit_id; ?>">
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo htmlspecialchars($edit_title); ?>" 
                               placeholder="Enter your journal title..." required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="6" 
                                  placeholder="Write your thoughts here..." required><?php echo htmlspecialchars($edit_content); ?></textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <?php if ($edit_mode): ?>
                            <button type="submit" name="update" class="btn btn-warning btn-custom">
                                <i class="bi bi-check-circle"></i> Update Entry
                            </button>
                            <a href="index.php" class="btn btn-secondary btn-custom">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        <?php else: ?>
                            <button type="submit" name="create" class="btn btn-primary btn-custom">
                                <i class="bi bi-plus-circle"></i> Add Entry
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">
                    <i class="bi bi-book"></i> Journal Entries 
                    <span class="badge bg-light text-dark"><?php echo $entries ? $entries->num_rows : 0; ?></span>
                </h3>
            </div>
            <div class="card-body">
                <?php if ($entries && $entries->num_rows > 0): ?>
                    <?php while($row = $entries->fetch_assoc()): ?>
                        <div class="journal-entry">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                                    <p class="entry-date">
                                        <i class="bi bi-calendar"></i> 
                                        <?php echo date('F d, Y - h:i A', strtotime($row['entry_date'])); ?>
                                    </p>
                                    <p class="mb-0"><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                                </div>
                                <div class="ms-3">
                                    <a href="?edit=<?php echo $row['journal_id']; ?>" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="?delete=<?php echo $row['journal_id']; ?>" class="btn btn-sm btn-outline-danger" 
                                       onclick="return confirm('Are you sure you want to delete this entry?')" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-journal-x" style="font-size: 3rem; color: #81C784;"></i>
                        <p class="mt-3">No journal entries yet. Start writing your first entry!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
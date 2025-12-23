<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام أرشفة الوثائق الإلكترونية</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }
        .nav {
            background: #f8f9fa;
            padding: 15px 30px;
            border-bottom: 2px solid #e9ecef;
        }
        .nav a {
            display: inline-block;
            padding: 10px 20px;
            margin-left: 10px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .nav a:hover {
            background: #764ba2;
            transform: translateY(-2px);
        }
        .content {
            padding: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        .form-group input[type="text"],
        .form-group input[type="file"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            padding: 12px 30px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #764ba2;
            transform: translateY(-2px);
        }
        .documents-list {
            margin-top: 30px;
        }
        .document-card {
            background: #f8f9fa;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            border-right: 4px solid #667eea;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s;
        }
        .document-card:hover {
            transform: translateX(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .document-info h3 {
            color: #667eea;
            margin-bottom: 5px;
        }
        .document-info p {
            color: #666;
            font-size: 14px;
        }
        .document-actions {
            display: flex;
            gap: 10px;
        }
        .document-actions a {
            padding: 8px 15px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .document-actions a.delete {
            background: #dc3545;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
        }
        .stat-card h2 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .stat-card p {
            font-size: 1.1em;
            opacity: 0.9;
        }
        .search-box {
            margin-bottom: 20px;
        }
        .search-box input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 نظام أرشفة الوثائق الإلكترونية</h1>
            <p>نظام متكامل لإدارة وأرشفة الوثائق الإلكترونية</p>
        </div>
        
        <div class="nav">
            <a href="index.php">الصفحة الرئيسية</a>
            <a href="index.php?page=upload">رفع وثيقة</a>
            <a href="index.php?page=categories">التصنيفات</a>
            <a href="index.php?page=search">البحث</a>
        </div>
        
        <div class="content">
            <?php
            // Configuration
            $dbFile = __DIR__ . '/database/documents.db';
            $uploadsDir = __DIR__ . '/storage/app/documents';
            
            // Create necessary directories
            if (!file_exists(dirname($dbFile))) {
                mkdir(dirname($dbFile), 0755, true);
            }
            if (!file_exists($uploadsDir)) {
                mkdir($uploadsDir, 0755, true);
            }
            
            // Initialize SQLite database
            try {
                $db = new PDO('sqlite:' . $dbFile);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Create tables if they don't exist
                $db->exec("CREATE TABLE IF NOT EXISTS categories (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL UNIQUE,
                    description TEXT,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )");
                
                $db->exec("CREATE TABLE IF NOT EXISTS documents (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title TEXT NOT NULL,
                    description TEXT,
                    filename TEXT NOT NULL,
                    original_filename TEXT NOT NULL,
                    file_size INTEGER,
                    mime_type TEXT,
                    category_id INTEGER,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (category_id) REFERENCES categories(id)
                )");
                
                // Insert default categories if empty
                $count = $db->query("SELECT COUNT(*) FROM categories")->fetchColumn();
                if ($count == 0) {
                    $db->exec("INSERT INTO categories (name, description) VALUES 
                        ('عقود', 'عقود العمل والاتفاقيات'),
                        ('فواتير', 'الفواتير والمستندات المالية'),
                        ('تقارير', 'التقارير والدراسات'),
                        ('مراسلات', 'المراسلات الرسمية'),
                        ('أخرى', 'وثائق متنوعة')
                    ");
                }
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                die("خطأ في قاعدة البيانات. يرجى المحاولة مرة أخرى لاحقاً.");
            }
            
            // Handle file upload
            $message = '';
            $messageType = '';
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
                if ($_POST['action'] === 'upload' && isset($_FILES['document'])) {
                    $title = $_POST['title'] ?? '';
                    $description = $_POST['description'] ?? '';
                    $category_id = $_POST['category_id'] ?? null;
                    
                    if (!empty($title) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
                        $file = $_FILES['document'];
                        
                        // Validate file type
                        $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'zip', 'rar'];
                        $allowedMimeTypes = [
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'text/plain',
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'application/zip',
                            'application/x-rar-compressed'
                        ];
                        
                        $originalFilename = basename($file['name']);
                        $fileExtension = strtolower(pathinfo($originalFilename, PATHINFO_EXTENSION));
                        $fileMimeType = mime_content_type($file['tmp_name']);
                        
                        // Validate file extension and MIME type
                        if (!in_array($fileExtension, $allowedExtensions) || !in_array($fileMimeType, $allowedMimeTypes)) {
                            $message = 'نوع الملف غير مسموح به! الأنواع المسموحة: PDF, DOC, DOCX, XLS, XLSX, TXT, JPG, PNG, GIF, ZIP, RAR';
                            $messageType = 'error';
                        } else {
                            $filename = uniqid() . '_' . time() . '.' . $fileExtension;
                            $destination = $uploadsDir . '/' . $filename;
                        
                        if (move_uploaded_file($file['tmp_name'], $destination)) {
                            $stmt = $db->prepare("INSERT INTO documents (title, description, filename, original_filename, file_size, mime_type, category_id) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
                            $stmt->execute([
                                $title,
                                $description,
                                $filename,
                                $originalFilename,
                                $file['size'],
                                $fileMimeType,
                                $category_id
                            ]);
                            $message = 'تم رفع الوثيقة بنجاح!';
                            $messageType = 'success';
                        } else {
                            $message = 'فشل رفع الملف!';
                            $messageType = 'error';
                        }
                        }
                    } else {
                        $message = 'يرجى ملء جميع الحقول المطلوبة!';
                        $messageType = 'error';
                    }
                } elseif ($_POST['action'] === 'delete' && isset($_POST['id'])) {
                    $id = (int)$_POST['id'];
                    $stmt = $db->prepare("SELECT filename FROM documents WHERE id = ?");
                    $stmt->execute([$id]);
                    $doc = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($doc) {
                        $filePath = $uploadsDir . '/' . $doc['filename'];
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                        $stmt = $db->prepare("DELETE FROM documents WHERE id = ?");
                        $stmt->execute([$id]);
                        $message = 'تم حذف الوثيقة بنجاح!';
                        $messageType = 'success';
                    }
                } elseif ($_POST['action'] === 'add_category') {
                    $name = $_POST['category_name'] ?? '';
                    $description = $_POST['category_description'] ?? '';
                    
                    if (!empty($name)) {
                        try {
                            $stmt = $db->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
                            $stmt->execute([$name, $description]);
                            $message = 'تم إضافة التصنيف بنجاح!';
                            $messageType = 'success';
                        } catch (PDOException $e) {
                            $message = 'التصنيف موجود مسبقاً!';
                            $messageType = 'error';
                        }
                    }
                }
            }
            
            // Handle document download
            if (isset($_GET['download'])) {
                $id = (int)$_GET['download'];
                $stmt = $db->prepare("SELECT * FROM documents WHERE id = ?");
                $stmt->execute([$id]);
                $doc = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($doc) {
                    $filePath = $uploadsDir . '/' . $doc['filename'];
                    if (file_exists($filePath)) {
                        // Sanitize filename for header
                        $safeFilename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $doc['original_filename']);
                        
                        // Validate MIME type
                        $allowedMimeTypes = [
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'text/plain',
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'application/zip',
                            'application/x-rar-compressed'
                        ];
                        
                        $mimeType = in_array($doc['mime_type'], $allowedMimeTypes) ? $doc['mime_type'] : 'application/octet-stream';
                        
                        header('Content-Type: ' . $mimeType);
                        header('Content-Disposition: attachment; filename="' . $safeFilename . '"');
                        header('Content-Length: ' . filesize($filePath));
                        readfile($filePath);
                        exit;
                    }
                }
            }
            
            // Display message
            if ($message) {
                echo "<div class='alert alert-{$messageType}'>{$message}</div>";
            }
            
            // Routing
            $page = $_GET['page'] ?? 'home';
            
            switch ($page) {
                case 'upload':
                    // Upload form
                    $categories = $db->query("SELECT * FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <h2>رفع وثيقة جديدة</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="upload">
                        
                        <div class="form-group">
                            <label>عنوان الوثيقة *</label>
                            <input type="text" name="title" required>
                        </div>
                        
                        <div class="form-group">
                            <label>الوصف</label>
                            <textarea name="description" rows="4"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>التصنيف</label>
                            <select name="category_id">
                                <option value="">-- اختر التصنيف --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>الملف *</label>
                            <input type="file" name="document" required>
                        </div>
                        
                        <button type="submit" class="btn">رفع الوثيقة</button>
                    </form>
                    <?php
                    break;
                    
                case 'categories':
                    // Categories management
                    $categories = $db->query("SELECT c.*, COUNT(d.id) as doc_count FROM categories c 
                        LEFT JOIN documents d ON c.id = d.category_id 
                        GROUP BY c.id ORDER BY c.name")->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <h2>إدارة التصنيفات</h2>
                    
                    <form method="POST" style="margin-bottom: 30px;">
                        <input type="hidden" name="action" value="add_category">
                        <div class="form-group">
                            <label>اسم التصنيف الجديد</label>
                            <input type="text" name="category_name" required>
                        </div>
                        <div class="form-group">
                            <label>الوصف</label>
                            <input type="text" name="category_description">
                        </div>
                        <button type="submit" class="btn">إضافة تصنيف</button>
                    </form>
                    
                    <div class="documents-list">
                        <?php foreach ($categories as $cat): ?>
                            <div class="document-card">
                                <div class="document-info">
                                    <h3><?= htmlspecialchars($cat['name']) ?></h3>
                                    <p><?= htmlspecialchars($cat['description'] ?? '') ?></p>
                                    <p style="color: #667eea; font-weight: bold;"><?= $cat['doc_count'] ?> وثيقة</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php
                    break;
                    
                case 'search':
                    // Search
                    $searchQuery = $_GET['q'] ?? '';
                    $categoryFilter = $_GET['category'] ?? '';
                    
                    $sql = "SELECT d.*, c.name as category_name FROM documents d 
                        LEFT JOIN categories c ON d.category_id = c.id WHERE 1=1";
                    $params = [];
                    
                    if ($searchQuery) {
                        $sql .= " AND (d.title LIKE ? OR d.description LIKE ? OR d.original_filename LIKE ?)";
                        $searchTerm = '%' . $searchQuery . '%';
                        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
                    }
                    
                    if ($categoryFilter) {
                        $sql .= " AND d.category_id = ?";
                        $params[] = $categoryFilter;
                    }
                    
                    $sql .= " ORDER BY d.created_at DESC";
                    
                    $stmt = $db->prepare($sql);
                    $stmt->execute($params);
                    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    $categories = $db->query("SELECT * FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <h2>البحث في الوثائق</h2>
                    
                    <form method="GET" style="margin-bottom: 30px;">
                        <input type="hidden" name="page" value="search">
                        <div class="form-group">
                            <label>البحث</label>
                            <input type="text" name="q" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="ابحث عن وثيقة...">
                        </div>
                        <div class="form-group">
                            <label>التصنيف</label>
                            <select name="category">
                                <option value="">-- جميع التصنيفات --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= $categoryFilter == $cat['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn">بحث</button>
                    </form>
                    
                    <h3>النتائج (<?= count($documents) ?>)</h3>
                    <div class="documents-list">
                        <?php foreach ($documents as $doc): ?>
                            <div class="document-card">
                                <div class="document-info">
                                    <h3><?= htmlspecialchars($doc['title']) ?></h3>
                                    <p><?= htmlspecialchars($doc['description'] ?? '') ?></p>
                                    <p><strong>الملف:</strong> <?= htmlspecialchars($doc['original_filename']) ?></p>
                                    <p><strong>التصنيف:</strong> <?= htmlspecialchars($doc['category_name'] ?? 'غير محدد') ?></p>
                                    <p><strong>الحجم:</strong> <?= round($doc['file_size'] / 1024, 2) ?> KB</p>
                                    <p><strong>التاريخ:</strong> <?= date('Y-m-d H:i', strtotime($doc['created_at'])) ?></p>
                                </div>
                                <div class="document-actions">
                                    <a href="?download=<?= $doc['id'] ?>">تحميل</a>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذه الوثيقة؟');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $doc['id'] ?>">
                                        <button type="submit" class="btn delete" style="border: none;">حذف</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if (empty($documents)): ?>
                            <p style="text-align: center; color: #666; padding: 40px;">لا توجد نتائج</p>
                        <?php endif; ?>
                    </div>
                    <?php
                    break;
                    
                default:
                    // Home page - Dashboard
                    $totalDocuments = $db->query("SELECT COUNT(*) FROM documents")->fetchColumn();
                    $totalCategories = $db->query("SELECT COUNT(*) FROM categories")->fetchColumn();
                    $totalSize = $db->query("SELECT SUM(file_size) FROM documents")->fetchColumn() ?? 0;
                    
                    $recentDocuments = $db->query("SELECT d.*, c.name as category_name FROM documents d 
                        LEFT JOIN categories c ON d.category_id = c.id 
                        ORDER BY d.created_at DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="stats">
                        <div class="stat-card">
                            <h2><?= $totalDocuments ?></h2>
                            <p>إجمالي الوثائق</p>
                        </div>
                        <div class="stat-card">
                            <h2><?= $totalCategories ?></h2>
                            <p>التصنيفات</p>
                        </div>
                        <div class="stat-card">
                            <h2><?= round($totalSize / (1024 * 1024), 2) ?> MB</h2>
                            <p>المساحة المستخدمة</p>
                        </div>
                    </div>
                    
                    <h2>آخر الوثائق المضافة</h2>
                    <div class="documents-list">
                        <?php foreach ($recentDocuments as $doc): ?>
                            <div class="document-card">
                                <div class="document-info">
                                    <h3><?= htmlspecialchars($doc['title']) ?></h3>
                                    <p><?= htmlspecialchars($doc['description'] ?? '') ?></p>
                                    <p><strong>الملف:</strong> <?= htmlspecialchars($doc['original_filename']) ?></p>
                                    <p><strong>التصنيف:</strong> <?= htmlspecialchars($doc['category_name'] ?? 'غير محدد') ?></p>
                                    <p><strong>التاريخ:</strong> <?= date('Y-m-d H:i', strtotime($doc['created_at'])) ?></p>
                                </div>
                                <div class="document-actions">
                                    <a href="?download=<?= $doc['id'] ?>">تحميل</a>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذه الوثيقة؟');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $doc['id'] ?>">
                                        <button type="submit" class="btn delete" style="border: none;">حذف</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if (empty($recentDocuments)): ?>
                            <p style="text-align: center; color: #666; padding: 40px;">
                                لا توجد وثائق بعد. <a href="?page=upload" style="color: #667eea;">قم برفع أول وثيقة!</a>
                            </p>
                        <?php endif; ?>
                    </div>
                    <?php
                    break;
            }
            ?>
        </div>
    </div>
</body>
</html>

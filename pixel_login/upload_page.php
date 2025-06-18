<?php include 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="css/upload.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Upload Your File</h2>
        <div class="upload-container">
            <form id="upload-form" action="upload.php" method="POST" enctype="multipart/form-data">
                <div id="drop-area">
                    <i class="fa-duotone fa-solid fa-upload fa-3x" style="margin-top:20px"></i> 
                    <p>Drag & Drop File Here</p>  
                    
                    <span>OR</span>
                    
                    <button type="button" id="chooseFile">Browse</button>
                    <input type="file" id="fileInput" name="file" accept=".pdf,.docx">
                    <p>Acceptable file types: DOCX & PDF</p>
                </div>
                <div id="progress-container">
                    <progress id="progress-bar" value="0" max="100"></progress>
                    <span id="upload-status"></span>
                </div>
                
            </form>
        </div>
        <div id="uploaded-files">
            <h3>Uploaded Files</h3>
            <ul id="fileList"></ul>
        </div>
    </div>
    <script src="js/upload.js"></script>
</body>
</html>

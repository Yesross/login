$(document).ready(function() {
    let dropArea = $("#drop-area");

    dropArea.on("dragover", function(e) {
        e.preventDefault();
        $(this).addClass("drag-over");
    });

    dropArea.on("dragleave", function() {
        $(this).removeClass("drag-over");
    });

    dropArea.on("drop", function(e) {
        e.preventDefault();
        $(this).removeClass("drag-over");
        let files = e.originalEvent.dataTransfer.files;
        handleFileUpload(files[0]);
    });

    $("#chooseFile").click(function() {
        $("#fileInput").click();
    });

    $("#fileInput").change(function() {
        let file = this.files[0];
        handleFileUpload(file);
    });

    function handleFileUpload(file) {
        if (!file) return;

        let allowedTypes = ["application/pdf", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];
        if (!allowedTypes.includes(file.type)) {
            alert("Only PDF and DOCX files are allowed.");
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert("File size must be less than 5MB.");
            return;
        }

        let formData = new FormData();
        formData.append("file", file);

        $.ajax({
            url: "upload.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            xhr: function() {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(e) {
                    if (e.lengthComputable) {
                        let percentComplete = (e.loaded / e.total) * 100;
                        $("#progress-bar").val(percentComplete);
                    }
                }, false);
                return xhr;
            },
            success: function (response) {
                $("#progress-bar").val(100);
                $("#progress-bar").addClass("success");

                if (response.trim() === "success") {
                    $("#upload-status").text("File uploaded successfully!");
                    setTimeout(function () {
                        alert("Resume uploaded successfully!");
                        loadFiles();
                    }, 500);
                } else {
                    $("#upload-status").text(response);
                }
            },
            error: function() {
                $("#upload-status").text("Upload failed.");
            }
        });
    }

    function loadFiles() {
        $.get("fetch_files.php", function(data) {
            $("#fileList").html(data);
        });
    }   

    $(document).on("click", ".delete-btn", function() {
        let fileId = $(this).data("id");
        let confirmDelete = confirm("Are you sure you want to delete this file?");
        
        if (confirmDelete) {
            $.post("delete_file.php", { id: fileId }, function(response) {
                alert(response);
                $("#upload-status").text("");
                loadFiles();
            });
        }
    });
    loadFiles();
});

$(document).ready(function () {
    let dropArea = $(".drop-section");
    let listSection = $(".list-section");
    let listContainer = $(".list");
    let fileSelector = $(".file-selector");
    let fileSelectorInput = $(".file-selector-input");

    // Upload files with browse button
    fileSelector.click(function () {
        fileSelectorInput.click();
    });

    fileSelectorInput.change(function () {
        let files = this.files;
        $.each(files, function (index, file) {
            if (typeValidation(file.type)) {
                uploadFile(file);
            }
        });
    });

    // Drag over effect
    dropArea.on("dragover", function (e) {
        e.preventDefault();
        let items = e.originalEvent.dataTransfer.items;
        $.each(items, function (index, item) {
            if (typeValidation(item.type)) {
                dropArea.addClass("drag-over-effect");
            }
        });
    });

    // Drag leave effect
    dropArea.on("dragleave", function () {
        dropArea.removeClass("drag-over-effect");
    });

    // Drop files
    dropArea.on("drop", function (e) {
        e.preventDefault();
        dropArea.removeClass("drag-over-effect");

        let files = e.originalEvent.dataTransfer.files;
        $.each(files, function (index, file) {
            if (typeValidation(file.type)) {
                uploadFile(file);
            }
        });
    });

    // Check the file type
    function typeValidation(type) {
        let allowedTypes = ["application/pdf", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];
        return allowedTypes.includes(type);
    }

    // Upload file function
    function uploadFile(file) {
        listSection.show();
        let fileSize = (file.size / (1024 * 1024)).toFixed(2) + " MB";

        let li = $(`
            <li class="in-prog">
                <div class="col">
                    <img src="icons/${iconSelector(file.type)}" alt="">
                </div>
                <div class="col">
                    <div class="file-name">
                        <div class="name">${file.name}</div>
                        <span>0%</span>
                    </div>
                    <div class="file-progress"><span></span></div>
                    <div class="file-size">${fileSize}</div>
                </div>
                <div class="col">
                    <svg class="cross" height="20" width="20">
                        <path d="m5.979 14.917-.854-.896 4-4.021-4-4.062.854-.896 4.042 4.062 4-4.062.854.896-4 4.062 4 4.021-.854.896-4-4.063Z"/>
                    </svg>
                    <svg class="tick" height="20" width="20">
                        <path d="m8.229 14.438-3.896-3.917 1.438-1.438 2.458 2.459 6-6L15.667 7Z"/>
                    </svg>
                </div>
            </li>
        `);
        listContainer.prepend(li);

        let formData = new FormData();
        formData.append("file", file);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "upload.php", true);

        xhr.upload.onprogress = function (e) {
            let percentComplete = (e.loaded / e.total) * 100;
            li.find("span").first().text(Math.round(percentComplete) + "%");
            li.find(".file-progress span").css("width", percentComplete + "%");
        };

        xhr.onload = function () {
            if (xhr.status === 200) {
                li.addClass("complete").removeClass("in-prog");
            }
        };

        li.find(".cross").click(function () {
            xhr.abort();
            li.remove();
        });

        xhr.send(formData);
    }

    // Find icon for file type
    function iconSelector(type) {
        let typeMap = {
            "application/pdf": "pdf.png",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document": "word.png"
        };
        return typeMap[type] || "file.png";
    }
});

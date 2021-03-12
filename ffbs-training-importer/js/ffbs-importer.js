var $ = jQuery;

let handleDrop = function (e) {
    var dt = e.dataTransfer;
    var files = dt.files;

    handleFiles(files);
}

// let initializeProgress = function (numFiles) {
//     let uploadProgress = []
//     let progressBar = $('#progress-bar')
//     progressBar.value = 0

//     for (let i = numFiles; i > 0; i--) {
//         uploadProgress.push(0)
//     }
// }

// let updateProgress = function (fileNumber, percent) {
//     uploadProgress[fileNumber] = percent
//     let total = uploadProgress.reduce((tot, curr) => tot + curr, 0) / uploadProgress.length
//     console.debug('update', fileNumber, percent, total)
//     progressBar.value = total
// }

let handleFiles = function (files) {
    files = [...files]
    // initializeProgress(files.length)
    files.forEach(uploadFile)
    // files.forEach(previewFile)
}

let readFileAsync = function (file) {
    return new Promise((resolve, reject) => {
        let reader = new FileReader();

        reader.onload = () => {
            resolve(reader.result);
        };

        reader.onerror = reject;

        reader.readAsText(file);
    })
}

let sendFileContent = async function (file) {
    let url = wpApiSettings.root + 'ffbs/v1/trainings';

    let content = await readFileAsync(file);

    let data = {
        content
    };

    $.ajax({
        type: 'POST',
        url: url,
        contentType: "application/json",
        data: JSON.stringify(data),
        dataType: 'json',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
        },
        success: function (data, textStatus, XMLHttpRequest) {
            // $('#message').show();
            // $('#message').fadeOut(5000);
        },
        error: function (MLHttpRequest, textStatus, errorThrown) {
            console.log(MLHttpRequest.status + ' ' + MLHttpRequest.responseText);
            // $('#message').html(MLHttpRequest.status + ' ' + MLHttpRequest.responseText).show();
        }
    });
}

let doDrop = function () {
    $("#drop-area").on("dragover", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('highlight');
    });

    $("#drop-area").on("dragleave", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('unhighlight');
    });

    $("#drop-area").on("dragenter", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('unhighlight');
    });

    $("#drop-area").on("drop", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('unhighlight');
        console.log("Dropped!");
        handleDrop(e.originalEvent)
    });
}

let handleFileInput = function () {
    $("#fileElem").on("change", function (e) {
        const fileList = e.originalEvent.target.files;
        sendFileContent(fileList[0])
    });
}

jQuery(document).ready(function ($) {
    doDrop();
    handleFileInput();
});

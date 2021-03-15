var $ = jQuery;

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
        $(this).removeClass('highlight');
    });

    $("#drop-area").on("dragenter", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('highlight');
    });

    $("#drop-area").on("drop", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('highlight');
        console.log("Dropped!");

        let dt = e.originalEvent.dataTransfer;
        let file = dt.files[0];
        sendFileContent(file)
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

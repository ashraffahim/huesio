let [uploadedFiles, uploadFiles] = [[], (files) => {
    uploadedFiles = files;
    updateUploadedFileList();
}];

$('#media-file-input').on('change', function() {
    uploadFiles([...uploadedFiles, ...Array.from(this.files)]);
});

$(document).on('blur', '.uploaded-file-name', function() {
    const index = $(this).data('index');
    const name = $(this).val();

    changeUploadedFileName(index, name);
});

$('#media-files-form').on('submit', async function(e) {
    e.preventDefault();

    const headers = new Headers();
    headers.append('X-Requested-With', 'fetch');

    const formData = new FormData(this);
    uploadedFiles.forEach((file, index) => {
        formData.append('file[' + index + ']', file);
    });

    try {
        const response = await fetch($(this).attr('action'), {
            headers,
            method: 'POST',
            body: formData
        });
    
        if (!response.ok) {
            throw new Error(await response.text());
        }

        window.location.reload();
    } catch(e) {
        console.log(e);
    }
});

const updateUploadedFileList = () => {
    $('#uploaded-media-files').html('');

    uploadedFiles.forEach((file, index) => {
        const fileNameParts = file.name.split('.');
        fileNameParts.splice(fileNameParts.length - 1, 1);

        $('#uploaded-media-files').append(
            '<div>'
                + '<input type="text" value="' + fileNameParts.join('.') + '" class="uploaded-file-name" data-index="' + index + '">'
            + '</div>'
        );
    });
}

const changeUploadedFileName = (index, name) => {
    const newUploadedFiles = uploadedFiles;
    const oldFileNameParts = uploadedFiles[index].name.split('.');

    newUploadedFiles[index] = new File([uploadedFiles[index]], name + '.' + oldFileNameParts[oldFileNameParts.length - 1]);
    uploadFiles(newUploadedFiles);
}
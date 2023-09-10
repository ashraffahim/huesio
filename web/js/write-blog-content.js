const textContent = $('.text-content');
const htmlContent = $('.html-content');
const backButton = $('.write-blog-back');
const nextButton = $('.write-blog-next');
const saveButton = $('.write-blog-save');

$(document).ready(function() {
    backButton.hide();
    saveButton.hide();
    textContent.val(htmlToText(htmlContent.val()));
});

backButton.on('click', function() {
    textContent.show();
    htmlContent.hide();
    backButton.hide();
    nextButton.show();
    saveButton.hide();
});

nextButton.on('click', function() {
    textContent.hide();
    htmlContent.show();
    nextButton.hide();
    backButton.show();
    saveButton.show();

    htmlContent.val(textToHtml(textContent.val()));
});

const textToHtml = (text) => {
    const lines = text.split("\n");
    let html = '';
    lines.forEach(line => {
        html += line.replaceAll(/\(img:(.+)\)\[(http(?:s|):\/\/.+)\]/ig, '<img src="$2" alt="$1">')
        .replaceAll(/\*(.+)\*/ig, '<b>$1</b>')
        .replaceAll(/_(.+)_/ig, '<i>$1</i>')
        .replaceAll(/\((.+)\)\[(http(?:s|):\/\/.+)\]/ig, '<a href="$2">$1</a>') + "\n";
    });
    return html;
}

const htmlToText = (html) => {
    const lines = html.split("\n");
    let text = '';
    lines.forEach(line => {
        text += line.replaceAll(/\<img.+src="(http(?:s|):\/\/.+)".+alt="(.+)"\>/ig, '(img:$2)[$1]')
        .replaceAll(/\<b\>(.+)\<\/b\>/ig, '*$1*')
        .replaceAll(/\<i\>(.+)\<\/i\>/ig, '_$1_')
        .replaceAll(/\<a.+href="(.+)"\>(.+)\<\/a\>/ig, '($2)[$1]') + "\n";
    });
    return text;
}
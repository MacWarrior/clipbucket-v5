function setOrUpdateParam(url, param, value) {
    const urlObj = new URL(url);
    urlObj.searchParams.set(param, value);
    return urlObj.toString();
}

$(function () {
    $('#template_dir').on('change',function(){
        const url = new URL(window.location.href);
        window.location.href = setOrUpdateParam(url, "dir", $(this).val());
    });
});
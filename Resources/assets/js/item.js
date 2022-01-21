var mainPic = $('input[name="main_picture"]');
var basImage = $(mainPic[0]).data('image');
console.log($(".file-preview").children(""));
if ($(mainPic[0]).data('image') != '') {
    $(".file-preview-thumbnails").html('<div class="file-preview-thumbnails clearfix"><div class="file-preview-frame krajee-default  kv-preview-thumb" data-fileindex="0" data-template="image" data-zoom=""><div class="kv-file-content"><img id="main_picture" src="' + basImage + '" class="file-preview-image kv-preview-data" style="width: auto; height: auto; max-width: 100%; max-height: 100%; image-orientation: from-image;"></div></div></div></div></div>');
}

var pic1 = $('input[name="picture_1"]');
//console.log($("#picture_1").find(".file-preview-thumbnails"));
var pic1Image = $(pic1[0]).data('image');
if ($(pic1[0]).data('image') != '') {
    $("#picture_1").find(".file-preview-thumbnails").html('<div class="file-preview-thumbnails clearfix"><div class="file-preview-frame krajee-default  kv-preview-thumb" data-fileindex="0" data-template="image" data-zoom=""><div class="kv-file-content"><img id="picture_1" src="' + pic1Image + '" class="file-preview-image kv-preview-data" style="width: auto; height: auto; max-width: 100%; max-height: 100%; image-orientation: from-image;"></div></div></div></div></div>');
}

var pic2 = $('input[name="picture_2"]');
//console.log($("#picture_2").find(".file-preview-thumbnails"));
var pic2Image = $(pic2[0]).data('image');
if ($(pic2[0]).data('image') != '') {
    $("#picture_2").find(".file-preview-thumbnails").html('<div class="file-preview-thumbnails clearfix"><div class="file-preview-frame krajee-default  kv-preview-thumb" data-fileindex="0" data-template="image" data-zoom=""><div class="kv-file-content"><img id="picture_2" src="' + pic2Image + '" class="file-preview-image kv-preview-data" style="width: auto; height: auto; max-width: 200%; max-height: 200%; image-orientation: from-image;"></div></div></div></div></div>');
}

var pic3 = $('input[name="picture_3"]');
//console.log($("#picture_3").find(".file-preview-thumbnails"));
var pic3Image = $(pic3[0]).data('image');
if ($(pic3[0]).data('image') != '') {
    $("#picture_3").find(".file-preview-thumbnails").html('<div class="file-preview-thumbnails clearfix"><div class="file-preview-frame krajee-default  kv-preview-thumb" data-fileindex="0" data-template="image" data-zoom=""><div class="kv-file-content"><img id="picture_3" src="' + pic3Image + '" class="file-preview-image kv-preview-data" style="width: auto; height: auto; max-width: 300%; max-height: 300%; image-orientation: from-image;"></div></div></div></div></div>');
}

var pic4 = $('input[name="picture_4"]');
//console.log($("#picture_4").find(".file-preview-thumbnails"));
var pic4Image = $(pic4[0]).data('image');
if ($(pic4[0]).data('image') != '') {
    $("#picture_4").find(".file-preview-thumbnails").html('<div class="file-preview-thumbnails clearfix"><div class="file-preview-frame krajee-default  kv-preview-thumb" data-fileindex="0" data-template="image" data-zoom=""><div class="kv-file-content"><img id="picture_4" src="' + pic4Image + '" class="file-preview-image kv-preview-data" style="width: auto; height: auto; max-width: 400%; max-height: 400%; image-orientation: from-image;"></div></div></div></div></div>');
}

var pic5 = $('input[name="picture_5"]');
//console.log($("#picture_5").find(".file-preview-thumbnails"));
var pic5Image = $(pic5[0]).data('image');
if ($(pic5[0]).data('image') != '') {
    $("#picture_5").find(".file-preview-thumbnails").html('<div class="file-preview-thumbnails clearfix"><div class="file-preview-frame krajee-default  kv-preview-thumb" data-fileindex="0" data-template="image" data-zoom=""><div class="kv-file-content"><img id="picture_5" src="' + pic5Image + '" class="file-preview-image kv-preview-data" style="width: auto; height: auto; max-width: 500%; max-height: 500%; image-orientation: from-image;"></div></div></div></div></div>');
}

var pic6 = $('input[name="picture_6"]');
//console.log($("#picture_6").find(".file-preview-thumbnails"));
var pic6Image = $(pic6[0]).data('image');
if ($(pic6[0]).data('image') != '') {
    $("#picture_6").find(".file-preview-thumbnails").html('<div class="file-preview-thumbnails clearfix"><div class="file-preview-frame krajee-default  kv-preview-thumb" data-fileindex="0" data-template="image" data-zoom=""><div class="kv-file-content"><img id="picture_6" src="' + pic6Image + '" class="file-preview-image kv-preview-data" style="width: auto; height: auto; max-width: 600%; max-height: 600%; image-orientation: from-image;"></div></div></div></div></div>');
}
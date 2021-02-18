$(document).ready(function() {
    $('#example').DataTable();
} );

var playing = false;
var initDone = false;

var audioElement = null;

$("#music").click(function() {
  if (playing) {
    // Stop playing
    audioElement.pause();
  } else {
    // Start playing
    if (!initDone) {
      initDone = true;

      audioElement = document.createElement('audio');
      audioElement.setAttribute('src', 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/665940/om_cut.mp3');

      audioElement.addEventListener('ended', function() {
        this.currentTime = 0;
        this.play();
      }, false);
    }

    audioElement.play();
  }

  $(this).find('i').toggleClass('fa-music fa-stop');
  playing = !playing;
});


// Dropzone
(function() {
  'use strict';

  if (typeof Dropzone !== 'undefined') {
    Dropzone.autoDiscover = false;

    $(initDropzone);

    function initDropzone() {
      // Dropzone settings
      var minImageWidth = 2551;
      var minImageHeight = 1819;

      Dropzone.options.dropzoneArea = {
        url: "/assets/php/save_leaflet_image.php",
        method: "post",
        timeout: 180000,
        maxFileSize: 1024,
        parallelUploads: 1,
        chunking: false,
        autoProcessQueue: true,
        uploadMultiple: false,
        parallelUploads: 1,
        maxFiles: 1,
        paramName: 'file', // The name that will be used to transfer the file
        maxFilesize: 2000, // MB
        timeout: 180000,
        addRemoveLinks: true,
        acceptedFiles: "image/*",
        thumbnailWidth: 250,
        thumbnailHeight: 250,
        createImageThumbnails: true,

        init: function() {
          var dzHandler = this;

          var agent_id = document.getElementById("agent_id").value;
          var header_id = document.getElementById("header_id").value;
          var lid = document.getElementById("lid").value;
          var leaflet_detail_id = document.getElementById("leaflet_detail_id").value;

          $.getJSON("/assets/php/save_leaflet_image?agent_id="+ agent_id + "&header_id="+ header_id + "&lid="+ lid + "&leaflet_detail_id="+ leaflet_detail_id + "", function(data) {
            $.each(data, function(index, val) {
              var mockFile = {
                name: val.name,
                size: val.size,
                type: val.filetype,
                url: val.file_url,
                accepted: true
              };
              //console.log('Posting file: ' + val.name);
              dzHandler.files.push(mockFile);    // add to files array
              dzHandler.emit("addedfile", mockFile);
              dzHandler.createThumbnailFromUrl(mockFile, val.url);
              dzHandler.emit("thumbnail", mockFile, val.name);
              dzHandler.emit("complete", mockFile);
              //dzHandler.options.addedfile.call(dzHandler, mockFile);
              //dzHandler.options.thumbnail.call(dzHandler, mockFile, val.name);
            });
          });
          this.on("maxfilesexceeded", function(file){
            swalert.fire({
              title: 'No more files please!',
              html: errorMessage,
              type: 'error'
            });
          });
          this.on('addedfile', function(file) {
            //console.log('Added file: ' + file.name);
            //console.log('Size of file: ' + file.size);
            dzHandler.removeEventListeners();
          });
          this.on('error', function(errorMessage) {
            //console.log('Errors: ' + errorMessage);
            if (errorMessage.toLowerCase().includes("big")) {
              errorMessage += "<br>Please upload a smaller file.";
            }
            swalert.fire({
              title: 'There was an error uploading the file',
              html: errorMessage,
              type: 'error'
            });
            this.removeFile(file);
          });
          this.on('removedfile', function(file) {
            //console.log('Removed file: ' + file.name);
            $.post("/assets/php/save_leaflet_image?action=delete&agent_id="+ agent_id + "&header_id="+ header_id + "&lid="+ lid + "&leaflet_detail_id="+ leaflet_detail_id + "");
            dzHandler.setupEventListeners();
            swalert.fire({
              title: 'The file was deleted.',
              type: 'success'
            });
          });
          this.on('sending', function() {
            swalert.fire({
              title: 'Uploading File',
              html : '<img alt="" src="/assets/images/loader.gif" width="200px">',
              showConfirmButton: false,
              allowOutsideClick: false,
            });
            dzHandler.removeEventListeners();
          });
          this.on("uploadprogress", function(file, progress) {
            //console.log("File progress", progress);
          });
          this.on("success", function() {
            swalert.fire({
              title: 'File Uploaded!',
              html: 'The file has been uploaded.<br/>Refresh the page to see its preview.',
              type: 'success'
            });
          });
          this.on('thumbnail', function(file) {
            if (file.width < minImageWidth || file.height < minImageHeight) {
              swalert.fire({
                title: 'Please upload an image 2551x1819 or bigger.',
                type: 'error'
              });
              this.removeFile(file);
            }else{
              $('.leaflet [data-dz-thumbnail]').css('height', 250);
      				$('.leaflet [data-dz-thumbnail]').css('object-fit', 'cover');
            }
          });
        }
      };

      if (location.pathname.substring(1) !== 'admin-agent' && location.pathname.substring(1) !== 'user-profile') {
        $('.dropzone').dropzone();
      }

      function createOpts(type, imgType) {
      	var prevImgHeight;
      	var prevImgWidth;
        var acceptedFiles;
      	if (imgType === 'letterhead') {
      		prevImgHeight = 217;
      		prevImgWidth = 150;
          acceptedFiles = "image/png";
      	} else if (imgType === 'logo') {
      		prevImgHeight = 150;
      		prevImgWidth = 'auto';
          acceptedFiles = "image/*";
      	}
      	var opts = {
      		url: '/assets/php/save-agent-image.php',
      		method: 'post',
      		timeout: 180000,
      		maxFilesize: 1,
          maxFiles: 1,
      		parallelUploads: 1,
      		chunking: false,
      		autoProcessQueue: true,
      		uploadMultiple: false,
      		parallelUploads: 1,
      		paramName: 'file', // The name that will be used to transfer the file
      		timeout: 180000,
      		addRemoveLinks: true,
      		acceptedFiles: acceptedFiles,
      		init: function() {
      			var dzHandler = this;
      			var admin_agent_id = document.getElementById("admin_agent_id").value;

      			$.getJSON("/assets/php/save-agent-image?admin_agent_id="+ admin_agent_id + "&type="+type + "&img_type="+imgType, function(data) {
      				$.each(data, function(index, val) {
      					var mockFile = { name: val.name, size: val.size, type: val.filetype, url: val.file_url, accepted: true };
      					//console.log('Posting file: ' + val.name);
      					dzHandler.files.push(mockFile);    // add to files array
      					dzHandler.emit("addedfile", mockFile);
      					dzHandler.createThumbnailFromUrl(mockFile, val.url);
      					dzHandler.emit("thumbnail", mockFile, val.name);
      					dzHandler.emit("complete", mockFile);
      				});
      			});
      			this.on("maxfilesexceeded", function(file){
      				swalert.fire({
                title: "No more files please!",
                type: 'error'
              });
      			});
      			this.on('addedfile', function(file) {
              dzHandler.removeEventListeners();
      			});
      			this.on('sending', function(file, xhr, formData) {
      				formData.append('admin_agent_id', $('#admin_agent_id').val());
      				formData.append('type', type);
      				formData.append('img_type', imgType);
              swalert.fire({
                title: 'Uploading File',
                html : '<img alt="" src="/assets/images/loader.gif" width="200px">',
                showConfirmButton: false,
                allowOutsideClick: false,
              });
              dzHandler.removeEventListeners();
      			});
      			this.on('error', function(file, errorMessage, xhr) {
              if (errorMessage.toLowerCase().includes("big")) {
                errorMessage += "<br>Please upload a smaller file.";
              }
              swalert.fire({
                title: 'There was an error uploading the file',
                html: errorMessage,
                type: 'error'
              });
      			});
      			this.on('removedfile', function(file) {
              $.post("/assets/php/save-agent-image?action=delete&admin_agent_id="+ admin_agent_id + "&type=" + type + "&img_type="+imgType);
              dzHandler.setupEventListeners();
              swalert.fire({
                title: 'The file was deleted.',
                type: 'success'
              });
      			});
      			this.on('sendingmultiple', function() {

      			});
      			this.on('successmultiple', function(/*files, response*/) {

      			});
      			this.on('errormultiple', function(/*files, response*/) {

      			});
      			this.on("uploadprogress", function(file, progress) {
      					//console.log("File progress", progress);
      			});
            this.on("success", function() {
              swalert.fire({
                title: 'File Uploaded!',
                html: 'The file has been uploaded.<br/>Refresh the page to see its preview.',
                type: 'success'
              });
            });
      			this.on('thumbnail', function(file) {
      				$('.' +imgType +' [data-dz-thumbnail]').css('height', prevImgHeight);
      				$('.' +imgType +' [data-dz-thumbnail]').css('width', prevImgWidth);
      				$('.' +imgType +' [data-dz-thumbnail]').css('object-fit', 'cover');
      			});
      		}
      	};
      	return opts;
      }
      if (location.pathname.substring(1) === 'admin-agent') {
        $('#sales-letterhead-upload').dropzone(createOpts('sales', 'letterhead'));
        $('#lettings-letterhead-upload').dropzone(createOpts('lettings', 'letterhead'));
        $('#c_sales-letterhead-upload').dropzone(createOpts('c_sales', 'letterhead'));
        $('#c_lettings-letterhead-upload').dropzone(createOpts('c_lettings', 'letterhead'));
        $('#logo-upload').dropzone(createOpts('', 'logo'));
      }

      function createUserOpts() {
      	var prevImgHeight = 100;
      	var prevImgWidth = 'auto';

      	var opts = {
      		url: '/assets/php/save-user-photo.php',
      		method: 'post',
      		timeout: 180000,
      		maxFilesize: 1,
          maxFiles: 1,
      		parallelUploads: 1,
      		chunking: false,
      		autoProcessQueue: true,
      		uploadMultiple: false,
      		parallelUploads: 1,
      		paramName: 'file', // The name that will be used to transfer the file
      		timeout: 180000,
      		addRemoveLinks: true,
      		acceptedFiles: "image/*",
      		init: function() {
      			var dzHandler = this;
      			var acc_id = document.getElementById("acc_id").value;

      			$.getJSON("/assets/php/save-user-photo?acc_id="+ acc_id, function(data) {
      				$.each(data, function(index, val) {
      					var mockFile = { name: val.name, size: val.size, type: val.filetype, url: val.file_url, accepted: true };
      					//console.log('Posting file: ' + val.name);
      					dzHandler.files.push(mockFile);    // add to files array
      					dzHandler.emit("addedfile", mockFile);
      					dzHandler.createThumbnailFromUrl(mockFile, val.url);
      					dzHandler.emit("thumbnail", mockFile, val.name);
      					dzHandler.emit("complete", mockFile);
      				});
      			});
      			this.on("maxfilesexceeded", function(file){
      				swalert.fire({
                title: "No more files please!",
                type: 'error'
              });
      			});
      			this.on('addedfile', function(file) {
      				dzHandler.removeEventListeners();
      			});
      			this.on('sending', function(file, xhr, formData) {
      				formData.append('acc_id', $('#acc_id').val());
      			});
      			this.on('error', function(file, errorMessage, xhr) {
              if (errorMessage.toLowerCase().includes("big")) {
                errorMessage += "<br>Please upload a smaller file.";
              }
              swalert.fire({
                title: 'There was an error uploading the file',
                html: errorMessage,
                type: 'error'
              });
      			});
      			this.on('removedfile', function(file) {
              $.post("/assets/php/save-user-photo?action=delete&acc_id="+ acc_id);
              dzHandler.setupEventListeners();
              swalert.fire({
                title: 'The file was deleted.',
                type: 'success'
              });
      			});
      			this.on('sendingmultiple', function() {

      			});
      			this.on('successmultiple', function(/*files, response*/) {

      			});
      			this.on('errormultiple', function(/*files, response*/) {

      			});
      			this.on("uploadprogress", function(file, progress) {
      					//console.log("File progress", progress);
      			});
            this.on("success", function() {
              swalert.fire({
                title: 'File Uploaded!',
                html: 'The file has been uploaded.<br/>Refresh the page to see its preview.',
                type: 'success'
              });
            });
      			this.on('thumbnail', function(file) {
      				$('.' +imgType +' [data-dz-thumbnail]').css('height', prevImgHeight);
      				$('.' +imgType +' [data-dz-thumbnail]').css('width', prevImgWidth);
      				$('.' +imgType +' [data-dz-thumbnail]').css('object-fit', 'cover');
      			});
      		}
      	};
      	return opts;
      }
      if (location.pathname.substring(1) === 'user-profile') {
        $('#user-photo-upload').dropzone(createUserOpts());
      }
    }
  }
})();

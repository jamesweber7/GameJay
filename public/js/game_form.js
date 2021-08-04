
function selectText(elem) {
    elem.setSelectionRange(0, elem.value.length);
}

function clickFileButton() {
    const trueGameFileButton = document.getElementById('game');
    trueGameFileButton.click();
}

function changeGameFile() {
    const trueGameFileButton = document.getElementById('game');
    const faceGameFileButton = document.getElementById('game_button');
    if (trueGameFileButton.value) {
        faceGameFileButton.innerHTML=trueGameFileButton.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
        displayResetButton();
    } else {
        resetGameFile();
    }
}

function resetGameFile() {
    const faceGameFileButton = document.getElementById('game_button');
    faceGameFileButton.innerHTML=faceGameFileButton.getAttribute("original-zip");
    const trueGameFileButton = document.getElementById('game');
    trueGameFileButton.value = null;
    hideResetButton();
}

function hideResetButton() {
    const resetFileBtn = document.getElementById('reset-file-button');
    resetFileBtn.style.display="none";
}

function displayResetButton() {
    const resetFileBtn = document.getElementById('reset-file-button');
    resetFileBtn.style.display="inline";
}

function resetValue(elem) {
    if (!elem.value) {
        elem.value = elem.getAttribute('originalvalue')
    }
}

function confirmDelete() {
    var nameTag = document.getElementById("name");
    var name = nameTag.getAttribute("originalvalue");
    var confirm = window.confirm("Are you sure you want to delete " + name + " FOREVER?");
    if (confirm) {
        var deleteForm = document.getElementById("delete");
        deleteForm.submit();
    }
}

// Tag Stuff

[].forEach.call(document.getElementsByClassName('cool-tag-container'), function(el) {

    let hiddenInput = document.createElement('input'),
        mainInput = document.createElement('input'),
        tags = [];

    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('id', 'tags');
    hiddenInput.setAttribute('name', el.getAttribute('data-name'));

    mainInput.setAttribute('id', 'tag-input');
    mainInput.setAttribute('type', 'text');
    mainInput.setAttribute('class', 'invisible-input jay-input-colors tag-text-input');
    mainInput.setAttribute('maxlength', '30');
    mainInput.setAttribute('placeholder', 'Add Tag...');
    mainInput.classList.add('main-input');

    mainInput.addEventListener('keydown', function(e) {
        let enteredTag = mainInput.value;
        if (e.key === 'Enter') {
            let filteredTag = filterTag(enteredTag);
            if (filteredTag.length > 0) {
                addTag(filteredTag);
            }
            mainInput.value='';
        } else if (tags.length && !enteredTag.length && e.key === 'Backspace') {
            removeTag(tags.length - 1);
        }
        mainInput.value = mainInput.value.replace(' ', '');
    });

    mainInput.addEventListener('keyup', function() {
        mainInput.value = mainInput.value.replace(' ', '');
    });

    el.appendChild(mainInput);
    el.appendChild(hiddenInput);

    function addTag(text) {
        let tag = {
            text: text,
            element: document.createElement('span')
        };

        tag.element.classList.add('cool-tag');
        tag.element.textContent = tag.text;

        let closeBtn = document.createElement('span');
        closeBtn.classList.add('close');
        closeBtn.addEventListener('click', function() {
            removeTag(tags.indexOf(tag));
        }); 
        tag.element.appendChild(closeBtn);
        
        tags.push(tag);

        el.insertBefore(tag.element, mainInput);

        refresh();

    }

    function removeTag(index) {
        let tag = tags[index];
        tags.splice(index, 1);
        el.removeChild(tag.element);
        refresh();
    }

    function refresh() {
        refreshTags();
        refreshInput();
    }

    function refreshTags() {
        let tagsList = [];
        tags.forEach(function(t) {
            tagsList.push(t.text);
        });
        hiddenInput.value = tagsList.join(',');
    }

    function refreshInput() {
        if (tags.length >= 10) {
            if (mainInput.type === 'text') {
                mainInput.type = 'hidden';
            }
        } else if (mainInput.type === 'hidden') {
            mainInput.type = 'text';
            mainInput.focus();
        }
    }

    function filterTag(tag) {
        let filteredTag = tag.replace(/[^\w -]/g, '').trim().replace(/\W+/g, '-');
        tags.forEach(function (t) {
            if (t.text.toUpperCase() === filteredTag.toUpperCase()) {
                mainInput.value = '';
                filteredTag = '';
            }
        })
        return filteredTag;
    }

});


// drag/drop area

const imgInputIds = ['input_image_1', 'input_image_2', 'input_image_3', 'input_image_4', 'input_image_5'];
var uploadedImgInputIds = [];

//selecting all required elements
const dropArea = document.querySelector(".drag-area"),
    mediaPort = document.getElementById("media_port"),
    dragText = dropArea.querySelector("header");
    // input = dropArea.querySelector("input");
var input = document.getElementById(imgInputIds[0]);

input.addEventListener("change", function(){
    //getting user select file and [0] this means if user select multiple files then we'll select only the first one
    file = this.files[0];
    dropArea.classList.add("active");
    showFile(); //calling function
});

let file; //this is a global variable and we'll use it inside multiple functions

var dragCount = 0;
// Increment dragcount on entering droparea
dropArea.addEventListener("dragenter", ()=>{
    dragCount++;
    dragCount = Math.min(2, (dragCount));
});

//If user removes dragged File from over DropArea
dropArea.addEventListener("dragleave", ()=>{
    dragCount--;
    dragCount = Math.max(0, dragCount);

    if (dragCount === 0) {
        dropArea.classList.remove("active");
        dragText.textContent = "Drag & Drop an Image\r\nor Click to Browse";
    }
});

//If user drags File over DropArea
dropArea.addEventListener("dragover", (event)=>{
    event.preventDefault(); //preventing from default behaviour
    dropArea.classList.add("active");
    dragText.textContent = "Release to Upload Media";
  });

//If user drops File on DropArea
dropArea.addEventListener("drop", (event)=>{
    event.preventDefault(); //preventing from default behaviour
    dragCount = 0;
    dropArea.classList.remove("active");
    file = event.dataTransfer.files[0];
    input.files=event.dataTransfer.files;
    showFile(); //calling function
});


function showFile(){
    
    if (dropArea.classList.contains("active")) {
        dropArea.classList.remove("active");
    }
    dragText.textContent = "Drag & Drop an Image\r\nor Click to Browse";

    let fileType = file.type; //getting selected file type
    let validExtensions = ["image/jpeg", "image/jpg", "image/png", "image/gif"]; //adding some valid image extensions in array
    if (validExtensions.includes(fileType)){ //if user selected file is an image file
        let fileReader = new FileReader(); //creating new FileReader object

        const imgBtnId = 'img' + input.id;

        fileReader.onload = ()=>{
        let fileURL = fileReader.result; //passing user file source in fileURL variable
        
        let xSpan = document.createElement('span');
        xSpan.setAttribute('class', 'close');
        xSpan.addEventListener('click', function() {
            deleteImg(imgBtnId);
        });
        xSpan.innerText = 'x';
        let imgTag = document.createElement('img');
        imgTag.setAttribute('class', 'img-card');
        imgTag.setAttribute('src', `${fileURL}`);
        imgTag.setAttribute('alt', 'image');
        imgTag.addEventListener('click', function() {
            selectImage(imgBtnId);
        });
        let imgBtn = document.createElement('button');
        imgBtn.setAttribute('class', 'media-card active img-btn');
        imgBtn.setAttribute('name', 'img-btn');
        imgBtn.setAttribute('id', imgBtnId);

        imgBtn.appendChild(xSpan);
        imgBtn.appendChild(imgTag);
        mediaPort.appendChild(imgBtn);

        let totalFiles = document.getElementsByName('img-btn');
        if (totalFiles.length >= 5) {
            dropArea.classList.add('hidden');
        } else {
            if (dropArea.classList.contains('hidden')) {
                dropArea.classList.remove('hidden');
            }
            if (totalFiles.length === 1) {
                selectImage(imgBtnId);
            }
        }
        switchInputs();
    }
    fileReader.readAsDataURL(file);

  } else{
    alert("Shoot! This type of file is not supported!");
  }
}

function browseMedia() {
    input.click();
}

function switchInputs() {
    uploadedImgInputIds.push(input.id);
    for (let i = 0; i < imgInputIds.length; i++) {
        if (!uploadedImgInputIds.includes(imgInputIds[i])) {
            input = document.getElementById(imgInputIds[i]);

            input.addEventListener("change", function(){
                //getting user select file and [0] this means if user select multiple files then we'll select only the first one
                file = this.files[0];
                dropArea.classList.add("active");
                showFile(); //calling function
            });

            return i = 100;
        }
    }
    
}

function selectImage(imgBtnId) {
    var image = document.getElementById(imgBtnId);

    if (image) {
        var selectedImg = document.getElementsByClassName('selected-image');
        if (selectedImg.length) {
            selectedImg[0].classList.remove('selected-image');
        }
        image.classList.add('selected-image');
        selected_image_input = document.getElementById('selected_image');
        selected_image_input.value = imgBtnId.replace('img', '');
    }

}

function deleteImg(imgBtnId) {
    let imgBtn = document.getElementById(imgBtnId);
    if (imgBtn) {
        imgBtn.remove();
        imgInputId = imgBtnId.replace('img', '');
        imgInput = document.getElementById(imgInputId);
        imgInput.value = null;
    }
    let totalFiles = document.getElementsByName('img-btn');
    if (totalFiles.length < 5) {
        if (dropArea.classList.contains('hidden')) {
            dropArea.classList.remove('hidden');
        }
    }
    if (totalFiles.length > 0) {
        let selectedFile = document.getElementsByClassName('selected-image');
        if (!selectedFile) {
            totalFiles[0].classList.add('selected-image');
        }
    }
    
}

// youtube stuff
const youtubeInput = document.getElementById("youtube-input");
youtubeInput.addEventListener('keyup', function() {
    youtubeInputChange(youtubeInput.value)
});
function youtubeInputChange(ytLink) {

    const watchLinkText = 'watch?v=';
    var startIndex = ytLink.indexOf(watchLinkText);
    if (startIndex > 0) {
        startIndex += watchLinkText.length;
    } else {
        startIndex = ytLink.lastIndexOf('/') + 1;
    }

    const videoID = ytLink.substring(startIndex);

    if (videoID.length) {
        runLink(videoID);
    } else if (!ytLink.length) {
        var noLinkDiv = document.getElementById('youtube-link-not-found');     
        if (!noLinkDiv.classList.contains('hidden')) {
            noLinkDiv.classList.add('hidden');
        }
    }
    
}

function loadVid(videoID) {

    const sourcePath = 'https://www.youtube-nocookie.com/embed/';

    var ytFrame = document.getElementById('youtube_iframe');

    var ytCase = document.getElementById('youtube-case');

    if (ytCase.hasAttribute('hidden')) {
        ytCase.removeAttribute('hidden');
    }

    var noLinkDiv = document.getElementById('youtube-link-not-found');     
    if (!noLinkDiv.classList.contains('hidden')) {
        noLinkDiv.classList.add('hidden');
    }

    var ytSource = sourcePath + videoID;

    ytFrame.setAttribute('src', ytSource);

    var ytLink = document.getElementById('youtube_link');
    ytLink.setAttribute('value', ytSource);
}

function runLink(videoID) {
    var img = new Image();
    img.src = "http://img.youtube.com/vi/" + videoID + "/mqdefault.jpg";
    img.onload = function () {
        if (thumbnailIsGood(this.width)) {
            loadVid(videoID);
        } else {
            var ytCase = document.getElementById('youtube-case');
            if (!ytCase.hasAttribute('hidden')) {
                ytCase.setAttribute('hidden', 'true');
            }

            var noLinkDiv = document.getElementById('youtube-link-not-found');     
            if (noLinkDiv.classList.contains('hidden')) {
                noLinkDiv.classList.remove('hidden');
            }
        }
    }
}

function thumbnailIsGood(width) {
    // mq thumbnail has width of 320.
    //if the video does not exist(therefore thumbnail don't exist), a default thumbnail of 120 width is returned.
    if (width === 120) {
        return false;
    }
    return true;
}

function checkVideo(videoID) {
    var img = new Image();
    img.src = "http://img.youtube.com/vi/" + videoID + "/mqdefault.jpg";
    img.onload = function () {
        return thumbnailIsGood(this.width);
    }
}

function docVideo(videoID) {
    var img = new Image();
    img.src = "http://img.youtube.com/vi/" + videoID + "/mqdefault.jpg";
    youtubeLinkIsGoodDeterminator = document.getElementsById('youtube_link_is_valid');
    img.onload = function () {
        youtubeLinkIsGoodDeterminator.value = thumbnailIsGood(this.width);
    }
}
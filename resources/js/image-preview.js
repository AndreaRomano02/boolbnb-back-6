const placeholder = 'https://marcolanci.it/utils/placeholder.jpg';
const imageField = document.getElementById('image');
const previewField = document.getElementById('image-preview');

let blobUrl = null;

imageField.addEventListener('change' , () => {
    if(imageField.files){
        const file = imageField.files[0];
        blobUrl = URL.createObjectURL(file);
        previewField.src = blobUrl;
    }else{
        previewField.src = placeholder;
    }
});

window.addEventListener('beforeunload' , () => {
    if(blobUrl) URL.revokeObjectURL(blobUrl);
});
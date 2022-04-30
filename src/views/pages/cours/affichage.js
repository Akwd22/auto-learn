//fonction qui convertie le lien de base en lien utilisable pour intégrer une vidéo youtube, et ajoute ce lien comme src de l'iframe
function addSrc(src){
    let startSrc='https://www.youtube.com/embed/';
    let srcConvert=startSrc + src.substr(17,src.length-17);
    
    let iframe=document.getElementById('iframeVideo');
    iframe.setAttribute("src",srcConvert); 
}



//fonction qui rempli la progressBar d'un certain pourcentage
function fillProgressBar(percent){   
    var styleElem = document.head.appendChild(document.createElement("style"));
    styleElem.innerHTML = "#progressBar:after {width:"+percent+"%;}";
}



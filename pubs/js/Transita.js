var time;
var sDir = "pubs/Fondo/";
var iCont = 0;
var sImg = [
    "office.jpg",
    "Juego.jpg\n",
    "Hora.jpg\n",
    "Dtapa.jpg\n",
    "Respon.jpg\n",
    "Tende.jpg\n",
    "bg.jpg\n"
];
var objS = $('#imgSup');
var objI = $('#imgInf');
function fadeIn() {
    $('#imgInf').attr( "src", $('#imgSup').attr("src") );
    $('#imgSup').fadeOut(0);
    $('#imgSup').attr( "src", sDir+sImg[iCont] );
    $('#imgSup').fadeIn(3000);
    
    iCont++;
    if (iCont > 6) {
        iCont = 0;
    }
};
window.onload = function() {
    time = setInterval('fadeIn()',5000);
};
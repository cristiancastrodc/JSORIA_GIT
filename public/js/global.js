/****** VARIABLES Y FUNCIONES GLOBALES ******/
/********************************/

/***** Debug mode *****/
const debugMode = true;
/*====================*/

/*** Function that shows the debug ***/
function debug (message, isString = true) {
  if (debugMode) {
    var current_timestamp = moment().format('DD/MM/YYYY hh:mm:ss');
    if (isString) {
      console.log(current_timestamp + ': ' + message);
    } else {
      console.log(current_timestamp);
      console.log(message);
    }
  }
}

/*** Function that throws a SweetAlert ***/
function sweet_alert (pTitle, pText, pType) {
  swal({
    title: pTitle,
    text: pText,
    type: pType
  });
}
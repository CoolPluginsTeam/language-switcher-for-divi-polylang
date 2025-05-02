document.addEventListener('DOMContentLoaded', function() {  

const thisModule = document.querySelector('.cpfd-wrapper.dropdown');
if(thisModule){
      const parentRow = thisModule.closest('.et_pb_row');
      if (parentRow) {
        parentRow.style.setProperty('z-index', '999');
      }
}
});
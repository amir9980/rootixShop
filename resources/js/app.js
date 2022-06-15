window.$ = window.jQuery = require("../assets/jquery-3.6.0.min");
require("../assets/jquery-ui.min");
require("../assets/plugins/bootstrap/js/bootstrap.bundle.min");
require("../assets/plugins/morris/morris.min");
require("../assets/plugins/sparkline/jquery.sparkline.min");
require("../assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min");
require("../assets/plugins/jvectormap/jquery-jvectormap-world-mill-en");
require("../assets/plugins/datepicker/bootstrap-datepicker");
require("../assets/plugins/slimScroll/jquery.slimscroll.min");
require("../assets/plugins/fastclick/fastclick");
require("../assets/dist/js/adminlte");
require("../assets/dist/js/demo");
require("../assets/dist/js/persian-date.min");
require("../assets/dist/js/persian-datepicker.min");
require("../assets/dist/js/jquery.number.min");
//
//
//
//
// $(document).ready(function () {
//
//
//
//     $("#accessSelectBox").on('change',function () {
//         if($(this).val()=='public'){
//             $("#userIdInput").prop('disabled',true);
//         }
//         else {
//             $("#userIdInput").prop('disabled',false);
//         }
//     });
//
//
//     $("#confirmDetailsForm .increaseButton").click(function () {
//         var val = parseInt(fixNumbers($(this).siblings("span").text()));
//         $(this).siblings("span").text(val+1);
//         $(this).siblings(".productCount").val(val+1);
//     });
//
//     $("#confirmDetailsForm .decreaseButton").click(function () {
//         var val = parseInt(fixNumbers($(this).siblings("span").text()));
//         if (val > 1){
//             $(this).siblings("span").text(val-1);
//             $(this).siblings(".productCount").val(val-1);
//
//         }else if(val <= 1){
//             $(this).closest("tr").remove();
//         }
//     });
//
//     $(".submitbtn").click(function (){
//         this.disabled=true;
//         this.innerHTML='<small>...</small>';
//         this.form.submit();
//     });
//
//
//     $(".jalaliDatePicker").pDatepicker({
//         initialValue: false,
//         autoClose: true,
//
//         format: 'YYYY/MM/DD',
//     });
//
//     $(".numberInput").keyup(function () {
//         var number = $(this).val();
//         $(this).val($.number(number));
//     });
//
//     $(".numberInput").keydown(function (evt) {
//         // var charCode = (e.which) ? e.which : event.keyCode;
//         // if (String.fromCharCode(charCode).match(/[^0-9]/g))
//         //     return false;
//         var charCode = (evt.which) ? evt.which : event.keyCode
//         if (charCode > 31 && (charCode < 48 || charCode > 57))
//             return false;
//         return true;
//     });
//
// });
//
// var
//     persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g],
//     arabicNumbers  = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];
//
// fixNumbers = function (str)
// {
//     if(typeof str === 'string')
//     {
//         for(var i=0; i<10; i++)
//         {
//             str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
//         }
//     }
//     return str;
// };
//

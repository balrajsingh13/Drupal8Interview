/*
* @file user_form.js
* Contains js functionality related to dlp
*/
(function (Drupal, $) {

Drupal.behaviors.user_form = {
attach: function (context, settings) {
// Code for dependent dropdown in DLP for AIATS fields.
$("body").on("keyup", "#edit-first-name", function () { 
console.log('balraj');
var aiats_mode_id = jQuery.trim($(this).val());


$.ajax({
type: "POST",
url: drupalSettings.path.baseUrl + "dlp-fetch-exam-center/" + aiats_mode_id,
dataType: 'json',
cache: false,
beforeSend: function () {
},
success: function (data) {
if (data) { 

} else {

}
},
error: function (error) {
}
});
});


}
};
})(Drupal, jQuery);
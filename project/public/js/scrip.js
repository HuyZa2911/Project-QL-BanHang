$(document).ready(function () {
    updateClock();
});
function updateClock() {
    var currentTime = new Date();
    $("#time").text(currentTime.getHours() + ':' + currentTime.getMinutes() + ':' + currentTime.getSeconds());
}
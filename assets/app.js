/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "./scss/Base.scss";

// start the Stimulus application
import "./bootstrap";
import $ from "jquery";

$(".custom-file-input").on("change", function (e) {
  let inputFile = e.currentTarget;
  document.getElementById("pin_title").value = inputFile.files[0].name.split('.')[0];
});

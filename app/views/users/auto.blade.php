<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>jQuery UI Autocomplete - Default functionality</title>
<link rel="stylesheet" href="file:///C:/xampp/htdocs/hapwork/laravel/public/css/jquery-ui-1.10.4.custom.min.css">
<script src="file:///C:/xampp/htdocs/hapwork/laravel/public/js/jquery.js"></script>
<script src="file:///C:/xampp/htdocs/hapwork/laravel/public/js/jquery-ui-1.10.4.custom.min.js"></script>
<script>
$(function() {
var availableTags = [
"ActionScript",
"AppleScript",
"Asp",
"BASIC",
"C",
"C++",
"Clojure",
"COBOL",
"ColdFusion",
"Erlang",
"Fortran",
"Groovy",
"Haskell",
"Java",
"JavaScript",
"Lisp",
"Perl",
"PHP",
"Python",
"Ruby",
"Scala",
"Scheme"
];
$( "#tags" ).autocomplete({
source: availableTags
});
});
</script>
</head>
<body>
<input id="tags" >

</body>
</html>
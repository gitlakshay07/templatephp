<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page:  https://www.creative-tim.com/product/material-dashboard 
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Material Dashboard 3 by Creative Tim
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="landing-page bg-gray-200">
    <?php 
        $header = BASEPATH . '/partials/frontend/header.php';
        $footer = BASEPATH . '/partials/frontend/footer.php';
    ?>
    <?php include_once($header); ?>
    <?php include_once($view); ?>
    <?php include_once($footer); ?>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <!--  Plugin for TypedJS, full documentation here: https://github.com/inorganik/CountUp.js -->
    <script src="../assets/js/plugins/countup.min.js"></script>
    <script type="text/javascript">
        if (document.getElementById('stats1')) {
            const countUp = new CountUp('stats1', document.getElementById("stats1").getAttribute("countTo"));
            if (!countUp.error) {
                countUp.start();
            } else {
                console.error(countUp.error);
            }
        }
        if (document.getElementById('stats2')) {
            const countUp1 = new CountUp('stats2', document.getElementById("stats2").getAttribute("countTo"));
            if (!countUp1.error) {
                countUp1.start();
            } else {
                console.error(countUp1.error);
            }
        }
        if (document.getElementById('stats3')) {
            const countUp2 = new CountUp('stats3', document.getElementById("stats3").getAttribute("countTo"));
            if (!countUp2.error) {
                countUp2.start();
            } else {
                console.error(countUp2.error);
            };
        }
        if (document.getElementById('stats4')) {
            const countUp3 = new CountUp('stats4', document.getElementById("stats4").getAttribute("countTo"));
            if (!countUp3.error) {
                countUp3.start();
            } else {
                console.error(countUp3.error);
            };
        }

        const copyButton = document.getElementById("copy-code");

        copyButton.addEventListener("click", function() {
            const textToCopy = copyButton.parentElement.textContent;
            navigator.clipboard.writeText(textToCopy)
                .then
                .catch(err => console.error("Error copying text: ", err));
        });
    </script>
    <!-- Control Center for Material UI Kit: parallax effects, scripts for the example pages etc -->
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTTfWur0PDbZWPr7Pmq8K3jiDp0_xUziI"></script>
    <script src="../assets/js/material-dashboard.min.js?v=3.2.0" type="text/javascript"></script>
</body>

</html>
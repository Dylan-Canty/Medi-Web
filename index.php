<?php
    @session_start();
    if(!$_SESSION['id']){
        header("Location: Login.php");
        die;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "includes/links.php";?>
</head>
<body>
    <?php require_once "includes/header.php";?>
    
    <div class='container content c2'>
        <br>
        <button class='btn-small green white-text section modal-trigger' href="#add-patient">Add Patient</button>
        <div>
            <ul class='tabs row'>
                <li class='tab col s4'>
                    <a href="#patients">My Patients</a>
                </li>
                <li class='tab col s4'>
                    <a href="#risk-levels">Risk Levels</a>
                </li>
                <li class='tab col s4'>
                    <a href="#category-levels">Category Risk</a>
                </li>
            </ul>
            <div id='patients' class='ct'>
                <table id='patients-table'>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div id='risk-levels' class='ct'>
                <table id='risk-levels-table'>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Heart</th>
                            <th>Cancer</th>
                            <th>Diabetes</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div id='category-levels' class='ct'>
            <div class="hide row" id='category-risk'>
                <h4 class='raleway-font'>Risk Level By Category</h4>
                <table>
                    <tr>
                        <th>Heart Risk</th>
                        <th>Cancer Risk</th>
                        <th>Diabetes Risk</th>
                    </tr>
                    <tr>
                        <td><span id="heart-risk"></span></td>
                        <td><span id="cancer-risk"></span></td>
                        <td><span id="diabetes-risk"></span></td>
                    </tr>
                </table>
            </div>
            <div class="chart">
                <h4 class="raleway-font">Risk Levels</h4>
                <canvas id="chart"></canvas>
            </div>
        </div>
    </div>
    <script src='Charts/Chart.min.js'></script>
    <?php require_once "includes/footer.php";?>
    <?php require_once "includes/addPatient.php";?>
    <script>
        $(document).ready(function(){
            $('.modal').modal();
            $('.tabs').tabs();
            getData();
            getUser();
            getRiskByCategory();
            fetchChartData();
        });
    </script>
</body>
</html>
<?php
    @session_start();
    if(!$_SESSION['admin']){
        header("Location: AdminLogin.php");
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
    <div class='container content'>
        <h4 class="center-align col s12">Admin Dashboard</h4>
        <div class="col s12">
            <form action="php/handler.php" method='post'>
                <button type='submit' name='exportData' class="btn-small blue white-text" >Export Data</button>
            </form>
        </div>
    
        <button class='btn-small green white-text section modal-trigger' href="#add-patient">Add Patient</button>
        <ul class='tabs row'>
            <li class='tab col s6'>
                <a href="#patients">Patients</a>
            </li>
            <li class='tab col s6'>
                <a href="#risk-levels">Risk Levels</a>
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
    <?php require_once "includes/footer.php";?>
    <?php require_once "includes/addPatient.php";?>
    <script>
        $(document).ready(function(){
            $('.modal').modal();
            $('.tabs').tabs();
            getData();
            getUser();
        });
    </script>
</body>
</html>
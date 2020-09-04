var debug = true;

function getPatients(){

    $("#patients-table").DataTable({
        "ajax":{
            "url":"php/getPatients.php",
            "dataSrc": ""
        },
        "columns":[
            {"data":"fname"},
            {"data":"lname"},
            {"data":"email"},
            {"data":"phone"}
        ]
    });
}

function getRiskLevels(){

    $("#risk-levels-table").DataTable({
        "ajax":{
            "url":"php/getRiskLevels.php",
            "dataSrc": ""
        },
        "columns":[
            {"data":"fname"},
            {"data":"lname"},
            {"data":"heart"},
            {"data":"cancer"},
            {"data":"diabetes"}
        ]
    });
}

function addPatient(form){
    var formData = new FormData(form);
    
    return true;
}

function register(form){
    $("#error").text("");

    if(form.pass.value.length < 6){
        $("#error").text("Password needs to be atleast 6 characters");
        return false;
    }

    if(form.pass.value != form.cpass.value){
        $("#error").text("Passwords do not match");
        return false;
    }

    return true;
}

function getData(){
    getRiskLevels();
    getPatients();
}

function getUser(){
    
    $.post("php/handler.php",{
        getUser: "set"
    },
    function(data, status){
        if(status == "success"){
            var response = JSON.parse(data);
            if(response.okay){
                var str = "Welcome "+response.name+".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='php/logout.php' class='white-text raleway-font'>Log Out</a>";
                document.getElementById("user-profile").innerHTML = str;
            }
        }
    }
    );
}

function getRiskByCategory(){
    $.post("php/handler.php",{
        getCategoryRiskLevel: "set"
    },
    function(data, status){
        if(status == "success"){
            var response = JSON.parse(data);
            if(response.okay){
                document.getElementById("category-risk").classList.remove("hide");
                document.getElementById("heart-risk").innerHTML = response.heart;
                document.getElementById("cancer-risk").innerHTML = response.cancer;
                document.getElementById("diabetes-risk").innerHTML = response.diabetes;
            }
        }
    }
    );
}

function fetchChartData(){
    $.post("php/handler.php",{
        getChartData: "set"
    },
    function(data, status){
        if(status == "success"){
            var response = JSON.parse(data);
            var dataLabels = ["Heart Risk","Cancer Risk", "Diabetes Risk"];
            var dataValues = [response.heart, response.cancer, response.diabetes];
            
            getDashBoardChart(dataLabels, dataValues);
        }
    }
    );
}

function getDashBoardChart(dataLabels, dataValues){
    var chart = document.getElementById("chart").getContext('2d');
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 14;
    Chart.defaults.global.defaultFontColor = '#000';
    
   
    var chartObject = new Chart(chart, {
        type: "pie",
        data:{
            labels: dataLabels,
            datasets: [ {
                label : "Risk Levels",
                data : dataValues,
                backgroundColor: ["green", "yellow", "blue"]
            } ]
        },
    });
}
function showCandidatesTable(Id, str) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        document.getElementById("get" + Id).innerHTML = "";
        document.getElementById("get" + Id).className = "loader";
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("get"  + Id).className = "";
            document.getElementById("get"  + Id).innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "../script/getvote.php?q="+ str + "&c="+ Id, true);
    xhttp.send();
}

function showCollegeCandidatesTable(Id, str) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        document.getElementById("get" + Id).innerHTML = "";
        document.getElementById("get" + Id).className = "loader";
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("get"  + Id).className = "";
            document.getElementById("get"  + Id).innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "../script/getCandidates.php?q="+ str + "&c="+ Id, true);
    xhttp.send();
}

function showCollegeCandidates(str) {
    var i, get = ["governor", "vicegovernor", "secretary", "assistantsecretary", "treasurer",
        "auditor", "mayor5yr", "vicemayor5yr", "mayor4yr", "vicemayor4yr", "mayor3yr",
        "vicemayor3yr", "mayor2yr", "vicemayor2yr", "mayor1yr", "vicemayor1yr", "archirep",
        "cerep", "cperep", "eerep", "merep"];
    if (str == "") {
        for (i = 0; i < get.length; i++)
            document.getElementById("get" + get[i]).innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
    } else for (i = 0; i < get.length; i++) showCollegeCandidatesTable(get[i], str);
}
        
function showCandidates(str) {
    var i, get = ["governor", "vicegovernor", "secretary", "assistantsecretary", "treasurer",
        "auditor", "mayor5yr", "vicemayor5yr", "mayor4yr", "vicemayor4yr", "mayor3yr",
        "vicemayor3yr", "mayor2yr", "vicemayor2yr", "mayor1yr", "vicemayor1yr", "archirep",
        "cerep", "cperep", "eerep", "merep"];
    if (str == "") {
        for (i = 0; i < get.length; i++)
            document.getElementById("get" + get[i]).innerHTML = "<b class='w3-container'>Person info will be listed here...</b>";
    } else for (i = 0; i < get.length; i++) showCandidatesTable(get[i], str);
}

        function logout() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                document.getElementById("logoutsuccess").innerHTML = "";
                document.getElementById("logoutsuccess").className = "loader";
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("logoutsuccess").className = "";
                    document.getElementById("logoutsuccess").innerHTML = this.responseText;
                    if (this.responseText == "Successfully Logout! Please come back soon!") {
                        setTimeout(function () {window.location.assign(window.location.href);} , 1000);
                    }
                }
            };
            xhttp.open("POST", "../script/logout.php?", true);
            xhttp.send();
        }

        function myTimer() {
            var d = new Date();
            document.getElementById("time").innerHTML = d.toLocaleTimeString();
        }